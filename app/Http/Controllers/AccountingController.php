<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use App\Models\Booking;
use App\Models\BookingStatus;
use App\Models\Listing;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Platform;
use App\Models\Resolution;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use PHPExcel_IOFactory;
use Validator;

class AccountingController extends Controller {

    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            session()->put('accounting_filters', $request->input('filter'));
        }

        $filters = session('accounting_filters');

        $bookings = Booking::filter($filters)
            ->orderBy('arrival_date', 'ASC')
            ->paginate(50);

        $listings = Listing::orderBy('name', 'ASC')
            ->pluck('name', 'id')
            ->prepend('[Not assigned]', 'null');

        return view('accouting.index', compact('bookings', 'filters', 'listings'));
    }

    public function xmlExport(Request $request)
    {
        $filters = session('accounting_filters');

        $bookings = Booking::filter($filters)
            ->with('listing.account')
            ->orderBy('arrival_date', 'ASC')
            ->get();
        if (!$bookings->count()) {
            return redirect()->back()->with('error', 'Nothing to export')->withInput();
        }

        $accounting = new Accounting();
        foreach ($bookings as $booking) {
            $accounting->addHostInvoice($booking);
            $accounting->addCustomerInvoice($booking);
            $accounting->addResolutionInvoice($booking);
        }

        if (empty($accounting->invoices)) {
            return redirect()->route('accounting')->with('error', 'No items were exported');
        }

        $xml = view('accouting.xml_invoice', [
            'invoices' => $accounting->invoices,
        ])->render();

        $file = storage_path('app/' . uniqid() . '.xml');
        File::put($file, $xml);

        return response()->download($file, 'accounting_' . date('Y-m-d_H_i_s') . '.xml')->deleteFileAfterSend(true);
    }

    public function payoutXmlExport(Request $request)
    {
        $filters = session('accounting_filters');

        $bookings = Booking::filter($filters)
            ->orderBy('arrival_date', 'ASC')
            ->get();
        if (!$bookings->count()) {
            return redirect()->back()->with('error', 'Nothing to export')->withInput();
        }

        $accounting = new Accounting();
        foreach ($bookings as $booking) {
            $accounting->addPayoutInvoice($booking);
        }

        if (empty($accounting->invoices)) {
            return redirect()->route('accounting')->with('error', 'No items were exported');
        }

        $xml = view('accouting.xml_payout_invoice', [
            'invoices' => $accounting->invoices,
        ])->render();

        $file = storage_path('app/' . uniqid() . '.xml');
        File::put($file, $xml);

        return response()->download($file, 'accounting_payout_' . date('Y-m-d_H_i_s') . '.xml')->deleteFileAfterSend(true);
    }

    public function xmlImport(Request $request)
    {
        if ($request->isMethod('post')) {
            Validator::make($request->all(), [
                'xml' => 'required|file',
            ])->validate();

            $xml = File::get($request->file('xml')->getRealPath());

            //get rid of namespaces
            $xml = preg_replace('/(<\/?)[a-zA-Z]+:/', '$1', $xml);
            $xml = simplexml_load_string($xml, 'SimpleXMLElement');

            $json = json_encode($xml);
            $data = json_decode($json, true);

            $recordsUpdated = 0;
            $errors = [];
            if (array_has($data, 'responsePackItem')) {
                foreach ($this->getMultiArray(array_get($data, 'responsePackItem')) as $item) {

                    list($bookingId, $invoiceType) = explode("_", array_get($item, '@attributes.id'));
                    $assignedDocument = array_get($item, 'invoiceResponse.producedDetails.number');

                    $booking = Booking::find($bookingId);
                    if (empty($booking)) {
                        $errors[] = trans('accounting.error_xml_import_can_not_match_booking', ['number' => $assignedDocument]);
                        continue;
                    }

                    foreach (Accounting::getPaymentTypesByInvoiceType($invoiceType) as $typeId) {
                        Payment::where('booking_id', $booking->id)
                            ->where('type_id', $typeId)
                            ->update(['internal_document_number' => $assignedDocument]);
                    }
                    $recordsUpdated++;
                }
            }

            return redirect()
                ->route('accounting')
                ->with('success', trans('accounting.success_rows_processed', ['total' => $recordsUpdated]))
                ->with('error', $errors);
        }

        return view('accouting.accouting_xml_import');
    }

    private function getMultiArray($array)
    {
        if (is_null($array)) {
            return null;
        }

        if (is_array($array) && !empty($array[0])) {
            return $array;
        }

        return ['0' => $array];
    }

    public function airbnbImport(Request $request)
    {
        if ($request->isMethod('post')) {
            Validator::make($request->all(), [
                'csv' => 'required|file',
            ])->validate();

            $columns = [
                'date'              => 'A',
                'type'              => 'B',
                'confirmation_code' => 'C',
                'start_date'        => 'D',
                'nights'            => 'E',
                'guest'             => 'F',
                'listing'           => 'G',
                'details'           => 'H',
                'reference'         => 'I',
                'currency'          => 'J',
                'amount'            => 'K',
                'paid_out'          => 'L',
                'host_fee'          => 'M',
                'cleaning_fee'      => 'N',
            ];

            $inputFileType = 'CSV';
            $inputFileName = $request->file('csv')->getRealPath();

            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);

            $worksheet = $objPHPExcel->getActiveSheet();

            $recordsUpdated = 0;
            $warnings = $errors = [];
            $lastPayout = null;

            foreach ($worksheet->getRowIterator() as $row) {
                $rowNumber = $row->getRowIndex();
                if ($rowNumber == 1) {
                    continue;
                }

                try {
                    $entryDate = Carbon::createFromFormat('m/d/Y', $worksheet->getCell($columns['date'] . $rowNumber)->getValue())->toDateString();
                } catch (InvalidArgumentException  $e) {
                    $errors[] = trans('accounting.text_line', ['line' => $rowNumber]) . ': ' . trans('accounting.error_invalid_date_format');
                    continue;
                }

                switch ($worksheet->getCell($columns['type'] . $rowNumber)->getValue()) {
                    case 'Adjustment':
                    case 'Reservation':
                        $listing = Listing::where('airbnb_name', $worksheet->getCell($columns['listing'] . $rowNumber)->getValue())->first();
                        if (empty($listing)) {
                            $errors[] = trans('accounting.text_line', ['line' => $rowNumber]) . ': ' . trans('accounting.error_listing_not_matched');
                            continue;
                        }

                        if (empty($lastPayout)) {
                            $warnings[] = trans('accounting.text_line', ['line' => $rowNumber]) . ': ' . trans('accounting.warning_no_payout_found');
                        }

                        $startDate = Carbon::createFromFormat('m/d/Y', $worksheet->getCell($columns['start_date'] . $rowNumber)->getValue());
                        $nights = $worksheet->getCell($columns['nights'] . $rowNumber)->getValue();

                        $booking = Booking::updateOrCreate(
                            [
                                'confirmation_code' => $worksheet->getCell($columns['confirmation_code'] . $rowNumber)->getValue(),
                            ],
                            [
                                'listing_id'     => (!empty($listing) ? $listing->id : null),
                                'guest_name'     => $worksheet->getCell($columns['guest'] . $rowNumber)->getValue(),
                                'platform_id'    => Platform::ID_AIRBNB,
                                'booking_status' => BookingStatus::ID_valid,
                                'arrival_date'   => $startDate->toDateString(),
                                'departure_date' => $startDate->addDays($nights)->toDateString(),
                                'nights'         => $nights,
                            ]);

                        $amount = str_replace(",", ".", $worksheet->getCell($columns['amount'] . $rowNumber)->getValue());
                        Payment::updateOrCreate([
                            'type_id'    => PaymentType::ID_RESERVATION,
                            'booking_id' => $booking->id,
                            'entry_date' => $entryDate,
                            'payout_id'  => optional($lastPayout)->id,
                        ], [
                            'amount' => $amount,
                        ]);
                        $lastPayout->totalCalculated += (float)$amount;

                        $amount = str_replace(",", ".", $worksheet->getCell($columns['host_fee'] . $rowNumber)->getValue());
                        Payment::updateOrCreate([
                            'type_id'    => PaymentType::ID_HOST,
                            'booking_id' => $booking->id,
                            'entry_date' => $entryDate,
                            'payout_id'  => optional($lastPayout)->id,
                        ], [
                            'amount' => $amount,
                        ]);

                        $amount = str_replace(",", ".", $worksheet->getCell($columns['cleaning_fee'] . $rowNumber)->getValue());
                        Payment::updateOrCreate([
                            'type_id'    => PaymentType::ID_CLEANING,
                            'booking_id' => $booking->id,
                            'entry_date' => $entryDate,
                            'payout_id'  => optional($lastPayout)->id,
                        ], [
                            'amount' => $amount,
                        ]);

                        $recordsUpdated++;
                        break;
                    case 'Resolution Payout':
                    case 'Resolution Adjustment':
                        if (empty($lastPayout)) {
                            $warnings[] = trans('accounting.text_line', ['line' => $rowNumber]) . ': ' . trans('accounting.warning_no_payout_found');
                        }

                        $code = $worksheet->getCell($columns['details'] . $rowNumber)->getValue();
                        preg_match('/\d+/', $code, $matches);
                        $code = $matches[0];

                        $resolution = Resolution::updateOrCreate([
                            'code' => $code,
                            'date' => $entryDate,
                        ]);

                        $amount = str_replace(",", ".", $worksheet->getCell($columns['amount'] . $rowNumber)->getValue());
                        Payment::updateOrCreate([
                            'type_id'       => PaymentType::ID_RESOLUTION,
                            'resolution_id' => $resolution->id,
                            'entry_date'    => $entryDate,
                            'payout_id'     => optional($lastPayout)->id,
                        ], [
                            'amount' => $amount,
                        ]);

                        $lastPayout->totalCalculated += (float)$amount;

                        $recordsUpdated++;
                        break;
                    case 'Payout':
                        preg_match("/\**\d+/", $worksheet->getCell($columns['details'] . $rowNumber)->getValue(), $matches);

                        if (empty($matches[0])) {
                            $warnings[] = trans('accounting.text_line', ['line' => $rowNumber]) . ': ' . trans('accounting.warning_can_not_extract_payout_account_number');
                            $accountNumber = '';
                        } else {
                            $accountNumber = $matches[0];
                        }

                        if (!empty($lastPayout) && number_format($lastPayout->amount, 2) != number_format($lastPayout->totalCalculated, 2)) {
                            $warnings[] = trans('accounting.text_line', ['line' => $lastPayout->line]) . ': ' . trans('accounting.payout_amounts_do_not_match', [
                                    'amount'          => $lastPayout->amount,
                                    'totalCalculated' => $lastPayout->totalCalculated,
                                    'payout_id'       => $lastPayout->id,
                                ]);
                        }

                        $lastPayout = Payment::updateOrCreate([
                            'type_id'        => PaymentType::ID_PAYOUT,
                            'entry_date'     => $entryDate,
                            'amount'         => str_replace(",", ".", $worksheet->getCell($columns['paid_out'] . $rowNumber)->getValue()),
                            'account_number' => $accountNumber,
                        ]);

                        $lastPayout->totalCalculated = 0;   //assign new variable to calculate totals
                        $lastPayout->line = $rowNumber;

                        $recordsUpdated++;
                        break;
                    default:
                        $errors[] = trans('accounting.text_line', ['line' => $rowNumber]) . ': ' . trans('accounting.error_unknown_type');
                }
            }

            return redirect()
                ->route('accounting')
                ->with('success', trans('accounting.success_rows_processed', ['total' => $recordsUpdated]))
                ->with('warning', $warnings)
                ->with('error', $errors);
        }

        return view('accouting.airbnb_import');
    }
}
