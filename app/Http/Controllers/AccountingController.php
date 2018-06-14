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
            ->orderBy('arrival_date', 'ASC')
            ->get();

        $accounting = new Accounting();
        $accounting->addInvoices($bookings);

        $xml = view('accouting.xml_invoice', [
            'invoices' => $accounting->invoices,
        ])->render();

        $file = storage_path('app/' . uniqid() . '.xml');
        File::put($file, $xml);

        return response()->download($file, 'accounting_' . date('Y-m-d_H_i_s') . '.xml')->deleteFileAfterSend(true);
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
            foreach ($worksheet->getRowIterator() as $row) {
                $rowNumber = $row->getRowIndex();
                //ignore first 2 rows
                if ($rowNumber < 3) {
                    continue;
                }

                switch ($worksheet->getCell($columns['type'] . $rowNumber)->getValue()) {
                    case 'Reservation':
                        $listing = Listing::where('airbnb_name', $worksheet->getCell($columns['listing'] . $rowNumber)->getValue())->first();

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

                        $entryDate = Carbon::createFromFormat('m/d/Y', $worksheet->getCell($columns['date'] . $rowNumber)->getValue())->toDateString();
                        Payment::updateOrCreate([
                            'type_id'    => PaymentType::ID_RESERVATION,
                            'booking_id' => $booking->id,
                            'entry_date' => $entryDate,
                        ], [
                            'amount' => str_replace(",", ".", $worksheet->getCell($columns['amount'] . $rowNumber)->getValue()),
                        ]);

                        Payment::updateOrCreate([
                            'type_id'    => PaymentType::ID_HOST,
                            'booking_id' => $booking->id,
                            'entry_date' => $entryDate,
                        ], [
                            'amount' => str_replace(",", ".", $worksheet->getCell($columns['host_fee'] . $rowNumber)->getValue()),
                        ]);

                        Payment::updateOrCreate([
                            'type_id'    => PaymentType::ID_CLEANING,
                            'booking_id' => $booking->id,
                            'entry_date' => $entryDate,
                        ], [
                            'amount' => str_replace(",", ".", $worksheet->getCell($columns['cleaning_fee'] . $rowNumber)->getValue()),
                        ]);

                        $recordsUpdated++;
                        break;
                    case 'Payout':
                        Payment::updateOrCreate([
                            'type_id'    => PaymentType::ID_PAYOUT,
                            'entry_date' => Carbon::createFromFormat('m/d/Y', $worksheet->getCell($columns['date'] . $rowNumber)->getValue())->toDateString(),
                            'amount'     => str_replace(",", ".", $worksheet->getCell($columns['paid_out'] . $rowNumber)->getValue()),
                        ]);
                        $recordsUpdated++;
                        break;
                    case 'Resolution Adjustment':
                        $code = $worksheet->getCell($columns['details'] . $rowNumber)->getValue();
                        preg_match('/\d+/', $code, $matches);
                        $code = $matches[0];

                        $resolution = Resolution::updateOrCreate([
                            'code' => $code,
                            'date' => Carbon::createFromFormat('m/d/Y', $worksheet->getCell($columns['date'] . $rowNumber)->getValue())->toDateString(),
                        ]);

                        Payment::updateOrCreate([
                            'type_id'       => PaymentType::ID_RESOLUTION,
                            'resolution_id' => $resolution->id,
                            'entry_date'    => Carbon::createFromFormat('m/d/Y', $worksheet->getCell($columns['date'] . $rowNumber)->getValue())->toDateString(),
                        ], [
                            'amount' => str_replace(",", ".", $worksheet->getCell($columns['amount'] . $rowNumber)->getValue()),
                        ]);

                        $recordsUpdated++;
                        break;
                }
            }

            return redirect()->route('accounting')->with('success', trans('accounting.success_rows_processed', ['total' => $recordsUpdated]));
        }

        return view('accouting.airbnb_import');
    }
}
