<?php

namespace App\Models;

use App\Models\Accounting\Address;
use App\Models\Accounting\Invoice;
use App\Models\Accounting\InvoicePosition;
use Exception;

class Accounting
{
    const VAT = 21;

    const ACCOUNT_UNKNOWN = 'Nevím';
    const ACCOUNT_RESERVATION = 'AirRes';
    const ACCOUNT_CLEANING_FEE = 'AirClea';
    const ACCOUNT_PORTAL_FEE = 'AirFee';

    const INVOICE_TYPE_HOST = 'HOST';
    const INVOICE_TYPE_PAYOUT = 'PAYOUT';
    const INVOICE_TYPE_CUSTOMER = 'CUSTOMER';
    const INVOICE_TYPE_RESOLUTION = 'RESOLUTION';

    public $invoices;

    public static function getPaymentTypesByInvoiceType($invoiceType)
    {
        switch ($invoiceType) {
            case self::INVOICE_TYPE_CUSTOMER:
                return [PaymentType::ID_RESERVATION, PaymentType::ID_CLEANING];
                break;
            case self::INVOICE_TYPE_HOST:
                return [PaymentType::ID_HOST];
                break;
            case self::INVOICE_TYPE_PAYOUT:
                return [PaymentType::ID_PAYOUT];
                break;
            case self::INVOICE_TYPE_RESOLUTION:
                return [PaymentType::ID_RESOLUTION];
                break;
            default:
                throw new Exception('Unrecognised invoice type');
        }
    }

    private function getAccountingCoding($type)
    {
        switch ($type) {
            case PaymentType::ID_RESERVATION:
                return self::ACCOUNT_RESERVATION;
                break;
            case PaymentType::ID_HOST:
                return self::ACCOUNT_PORTAL_FEE;
                break;
            case PaymentType::ID_CLEANING:
                return self::ACCOUNT_CLEANING_FEE;
                break;
            case PaymentType::ID_RESOLUTION:
                return self::ACCOUNT_RESERVATION;   #TODO set from ACCOUNT_UNKNOWN to ACCOUNT_RESERVATION
                break;
            default:
                return self::ACCOUNT_UNKNOWN;
        }
    }

    public function addPayoutInvoice(Booking $booking)
    {
        $internalDocuments = Payment::where('booking_id', $booking->id)
            ->whereNotNull('internal_document_number')
            ->groupBy('internal_document_number')
            ->get();
        if (!$internalDocuments->count()) {
            return;
        }

        foreach ($internalDocuments as $internalDocument) {
            $invoice = new Invoice();

            $invoice->id = $booking->id . '_' . self::INVOICE_TYPE_PAYOUT . '_' . $internalDocument->internal_document_number;
            $invoice->type = $internalDocument->internal_document_number;
            $invoice->vatClassification = 'nonSubsume';
            $invoice->documentDate = $booking->arrival_date;
            $invoice->taxDate = $booking->arrival_date;
            $invoice->accountingDate = $booking->arrival_date;
            $invoice->reference = $booking->confirmation_code;
            $invoice->accountingCoding = $this->getAccountingCoding($internalDocument->type_id) . optional($booking->listing->account)->accounting_suffix;
            $invoice->text = $booking->confirmation_code . ', Provize ' . $booking->platform->name . ', ' . $booking->nights . 'n, ' . $booking->guest_name;

            $address = new Address();
            $address->name = 'Airbnb Ireland UC, private unlimited company';
            $address->city = 'Dublin 4';
            $address->street = 'The Watermarque Building, South Lotts Road';
            $invoice->partner = $address;

            $costCenters = $booking->listing->getCostCenters();

            $paymentsWithDocumentAssigned = Payment::where('booking_id', $booking->id)
                ->where('internal_document_number', $internalDocument->internal_document_number)
                ->get();

            foreach ($costCenters as $costCenter => $splitPercent) {
                $invoice->costCenter = $costCenter;

                foreach ($paymentsWithDocumentAssigned as $payment) {

                    $position = new InvoicePosition();
                    $position->text = 'Úhrada OP č. ' . $payment->internal_document_number;
                    $position->quantity = 1;
                    $position->accountingCoding = $this->getAccountingCoding($payment->type_id) . optional($booking->listing->account)->accounting_suffix;
                    $price = $this->calculatePrice($payment->amount, $splitPercent, false);
                    $position->price = $price['price'];
                    $position->priceVat = $price['vat'];
                    $position->note = '';
                    $position->costCenter = $costCenter;

                    $invoice->positions[] = $position;
                }

                $this->invoices[] = $invoice;

                $invoice = clone $invoice;
                $invoice->positions = [];
            }
        }
    }

    public function addHostInvoice(Booking $booking)
    {
        $invoice = new Invoice();

        $invoice->id = $booking->id . '_' . self::INVOICE_TYPE_HOST;
        $invoice->type = 'commitment';
        $invoice->vatClassification = 'none';
        $invoice->documentDate = $booking->arrival_date;
        $invoice->taxDate = $booking->arrival_date;
        $invoice->accountingDate = $booking->arrival_date;
        $invoice->reference = $booking->confirmation_code;
        $invoice->accountingCoding = $this->getAccountingCoding(PaymentType::ID_HOST) . optional($booking->listing->account)->accounting_suffix;
        $invoice->text = $booking->confirmation_code . ', Provize ' . $booking->platform->name . ', ' . $booking->nights . 'n, ' . $booking->guest_name;

        $address = new Address();
        $address->name = 'Airbnb Ireland UC, private unlimited company';
        $address->city = 'Dublin 4';
        $address->street = 'The Watermarque Building, South Lotts Road';
        $invoice->partner = $address;

        $costCenters = $booking->listing->getCostCenters();

        foreach ($costCenters as $costCenter => $splitPercent) {
            $invoice->costCenter = $costCenter;

            $position = new InvoicePosition();
            $position->text = $booking->confirmation_code . ', ' . $booking->nights . 'n, ' . $booking->guest_name;
            $position->quantity = 1;
            $position->payVat = 'false';
            $position->rateVat = 'none';
            $position->accountingCoding = $this->getAccountingCoding(PaymentType::ID_HOST) . optional($booking->listing->account)->accounting_suffix;
            $payment = $booking->paymentHost;
            if (empty($payment)) {
                return;
            }
            $price = $this->calculatePrice($payment->amount, $splitPercent, false);
            $position->price = $price['price'];
            $position->priceVat = $price['vat'];
            $position->note = 'Provize ' . $booking->platform->name;
            $position->costCenter = $costCenter;

            $invoice->positions[] = $position;

            $this->invoices[] = $invoice;

            $invoice = clone $invoice;
            $invoice->positions = [];
        }
    }

    public function addCustomerInvoice(Booking $booking)
    {
        $invoice = new Invoice();

        $invoice->id = $booking->id . '_' . self::INVOICE_TYPE_CUSTOMER;
        $invoice->type = 'receivable';
        $invoice->vatClassification = 'nonSubsume';
        $invoice->documentDate = $booking->arrival_date;
        $invoice->taxDate = $booking->arrival_date;
        $invoice->accountingDate = $booking->arrival_date;
        $invoice->reference = $booking->confirmation_code;
        $invoice->accountingCoding = $this->getAccountingCoding(PaymentType::ID_RESERVATION) . optional($booking->listing->account)->accounting_suffix;
        $invoice->text = $booking->confirmation_code . ', ' . $booking->nights . 'n, ' . $booking->guest_name;
        $invoice->hasVat = $this->vatIncluded($booking->nights);

        $address = new Address();
        $address->name = $booking->guest_name;
        $invoice->partner = $address;

        $costCenters = $booking->listing->getCostCenters();

        foreach ($costCenters as $costCenter => $splitPercent) {
            $invoice->costCenter = $costCenter;

            $position = new InvoicePosition();
            $position->text = $booking->confirmation_code . ', ' . $booking->nights . 'n, ' . $booking->guest_name;
            $position->quantity = 1;
            $position->payVat = $invoice->hasVat ? 'true' : 'false';
            $position->rateVat = $invoice->hasVat ? 'low' : 'none';
            $position->accountingCoding = $this->getAccountingCoding(PaymentType::ID_RESERVATION) . optional($booking->listing->account)->accounting_suffix;
            $payment = $booking->paymentReservation;
            if (empty($payment)){
                return;
            }
            $price = $this->calculatePrice($payment->amount, $splitPercent, $position->payVat);
            $position->price = $price['price'];
            $position->priceVat = $price['vat'];
            $position->note = $booking->confirmation_code;
            $position->costCenter = $costCenter;

            $invoice->positions[] = $position;


            $position = new InvoicePosition();
            $position->text = $booking->confirmation_code . ', ' . $booking->nights . 'n, ' . $booking->guest_name;
            $position->quantity = 1;
            $hasVat = $this->vatIncluded($booking->nights);
            $position->payVat = $invoice->hasVat ? 'true' : 'false';
            $position->rateVat = $invoice->hasVat ? 'low' : 'none';
            $position->accountingCoding = $this->getAccountingCoding(PaymentType::ID_CLEANING) . optional($booking->listing->account)->accounting_suffix;
            $payment = $booking->paymentCleaning;
            if (empty($payment)){
                return;
            }
            $price = $this->calculatePrice($payment->amount, $splitPercent, $hasVat);
            $position->price = $price['price'];
            $position->priceVat = $price['vat'];
            $position->note = $booking->confirmation_code;
            $position->costCenter = $costCenter;

            $invoice->positions[] = $position;


            $this->invoices[] = $invoice;

            $invoice = clone $invoice;
            $invoice->positions = [];
        }
    }

    public function addResolutionInvoice(Booking $booking)
    {
        $invoice = new Invoice();

        $invoice->id = $booking->id . '_' . self::INVOICE_TYPE_RESOLUTION;
        $invoice->type = 'receivable';                  #TODO resolution might be also negative. Is it still receivable?
        $invoice->vatClassification = 'nonSubsume';
        $invoice->hasVat = $this->vatIncluded($booking->nights);
        $invoice->documentDate = $booking->arrival_date;
        $invoice->taxDate = $booking->arrival_date;
        $invoice->accountingDate = $booking->arrival_date;
        $invoice->reference = 'R'.$booking->confirmation_code;
        $invoice->accountingCoding = $this->getAccountingCoding(PaymentType::ID_RESOLUTION) . optional($booking->listing->account)->accounting_suffix;
        $invoice->text = 'Resolution ' . $booking->confirmation_code . ', ' . $booking->nights . 'n, ' . $booking->guest_name;
        $invoice->hasVat = $this->vatIncluded($booking->nights);

        $address = new Address();
        $address->name = $booking->guest_name;
        $invoice->partner = $address;

        $costCenters = $booking->listing->getCostCenters();

        foreach ($costCenters as $costCenter => $splitPercent) {
            $invoice->costCenter = $costCenter;

            $position = new InvoicePosition();
            $position->text = 'Resolution ' . $booking->confirmation_code . ', ' . $booking->nights . 'n, ' . $booking->guest_name; #TODO
            $position->quantity = 1;
            $position->payVat = $invoice->hasVat ? 'true' : 'false';
            $position->rateVat = $invoice->hasVat ? 'low' : 'none';
            $position->accountingCoding = $this->getAccountingCoding(PaymentType::ID_RESOLUTION) . optional($booking->listing->account)->accounting_suffix;
            $payment = $booking->paymentResolution;
            if (empty($payment)) {
                return;
            }
            $price = $this->calculatePrice($payment->amount, $splitPercent, $hasVat);
            $position->price = $price['price'];
            $position->priceVat = $price['vat'];
            $position->note = $booking->confirmation_code;
            $position->costCenter = $costCenter;

            $invoice->positions[] = $position;

            $this->invoices[] = $invoice;

            $invoice = clone $invoice;
            $invoice->positions = [];
        }
    }

    private function calculatePrice($price, $splitPercent = null, $exludeVat = false)
    {
        if (!empty($splitPercent)) {
            $price = ($price * $splitPercent) / 100;
        }

        if ($exludeVat) {
            $priceWithoutVat = round($price / (1 + self::VAT / 100), 2);
            $vat = $price - $priceWithoutVat;
        } else {
            $priceWithoutVat = $price;
            $vat = 0;
        }

        return [
            'price' => number_format($priceWithoutVat, 2, '.', ''),
            'vat'   => (empty($vat) ? 0 : number_format($vat, 2, '.', '')),
        ];
    }

    private function vatIncluded($nights)
    {
        return $nights <= 2;
    }
}
