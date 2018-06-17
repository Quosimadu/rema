<?php

namespace App\Models;

use App\Models\Accounting\Address;
use App\Models\Accounting\Invoice;
use App\Models\Accounting\InvoicePosition;
use Exception;

class Accounting {

    const VAT = 15;

    const ACCOUNT_UNKNOWN = 'Nevím';
    const ACCOUNT_RESERVATION = 'AirRes';
    const ACCOUNT_CLEANING_FEE = 'AirClea';
    const ACCOUNT_PORTAL_FEE = 'AirFee';
    const ACCOUNT_PAYMENT_FEE = 'AirPO';
    const ACCOUNT_PAYMENT_OTHERS = 'AirPay';

    const INVOICE_TYPE_HOST = 'HOST';
    const INVOICE_TYPE_PAYOUT = 'PAYOUT';
    const INVOICE_TYPE_CUSTOMER = 'CUSTOMER';
    const INVOICE_TYPE_RESOLUTION = 'RESOLUTION';

    public $invoices;

    public $receivablesNumberPrefix = '1800';
    public $receivablesIncrementalDocumentNumber = 149;
    public $commitmentsNumberPrefix = '18AIR';
    public $commitmentsIncrementalDocumentNumber = 216;
    public $payoutNumberPrefix = 'AIR100';
    public $payoutIncrementalDocumentNumber = 3;

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

    public function addPayoutInvoice(Payment $payout)
    {
        $payoutPayments = Payment::where('payout_id', $payout->id)->get();

        if (!$payoutPayments->count()) {
            return;
        }

        $invoice = new Invoice();

        $invoice->id = $payout->id . '_' . self::INVOICE_TYPE_PAYOUT;
        $invoice->type = 'internal';
        $invoice->vatClassification = 'nonSubsume';
        $invoice->documentDate = $payout->entry_date;
        $invoice->taxDate = $payout->entry_date;
        $invoice->accountingDate = $payout->entry_date;
        $invoice->reference = 'TODO';

        $invoice->number = $this->payoutNumberPrefix . sprintf('%04d', $this->payoutIncrementalDocumentNumber);
        $this->payoutIncrementalDocumentNumber++;

        $address = new Address();
        $address->name = 'AirBnB, Inc.';
        $address->city = 'San Francisco';
        $address->street = '888 Brannan Street';
        $address->countryCode = 'US';
        $invoice->partner = $address;



        $confirmationCodes = [];
        foreach ($payoutPayments as $payment) {
            $booking = $payment->booking;
            if (empty($booking) && $payment->type_id == PaymentType::ID_RESOLUTION) {
                $booking = $payment->resolution->booking;
            }
            if (empty($booking)) {
                throw new Exception('Payment ' . $payment->id .' does npot have assigned booking!');
            }

            $costCenters = $booking->listing->getCostCenters();

            $confirmationCodes [] = $booking->confirmation_code;

            foreach ($costCenters as $costCenter => $splitPercent) {
                $position = new InvoicePosition();
                $position->text = 'Úhrada OP č. ' . $payment->internal_document_number;
                $position->quantity = 1;
                $position->accountingCoding = $this->getAccountingCoding($payment->type_id) . optional($booking->listing->account)->accounting_suffix;
                $price = $this->calculatePrice($payment->amount, $splitPercent, false);
                $position->priceGross = $price['price_gross'];
                $position->priceNet = $price['price_net'];
                $position->priceVat = $price['vat'];
                $position->note = '';
                $position->costCenter = $costCenter;

                $invoice->positions[] = $position;
            }
        }
        $confirmationCodes = array_unique($confirmationCodes);
        $invoice->text = implode(",", $confirmationCodes) . ', ' . $payout->amount . 'Kc';

        $this->invoices[] = $invoice;
        $invoice->accountingCoding = self::ACCOUNT_PAYMENT_OTHERS .  optional($booking->listing->account)->accounting_suffix;
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
        $invoice->vatClassificationId = 'PN';

        $invoice->number = $this->commitmentsNumberPrefix . sprintf('%04d', $this->commitmentsIncrementalDocumentNumber);
        $this->commitmentsIncrementalDocumentNumber++;

        $address = new Address();
        $address->name = 'AirBnB, Inc.';
        $address->city = 'San Francisco';
        $address->street = '888 Brannan Street';
        $address->countryCode = 'US';
        $invoice->partner = $address;

        $costCenters = $booking->listing->getCostCenters();

        foreach ($costCenters as $costCenter => $splitPercent) {
            $invoice->costCenter = $costCenter;

            $payments = $booking->paymentHost;
            if (!$payments->count()) {
                return;
            }
            foreach ($payments as $payment) {
                $position = new InvoicePosition();
                $position->text = $booking->confirmation_code . ', ' . $booking->nights . 'n, ' . $booking->guest_name;
                $position->quantity = 1;
                $position->payVat = 'false';
                $position->rateVat = 'none';
                $position->accountingCoding = $this->getAccountingCoding(PaymentType::ID_HOST) . optional($booking->listing->account)->accounting_suffix;

                $price = $this->calculatePrice($payment->amount, $splitPercent, false);
                $position->priceGross = $price['price_gross'];
                $position->priceNet = $price['price_net'];
                $position->priceVat = $price['vat'];
                $position->note = 'Provize ' . $booking->platform->name;
                $position->costCenter = $costCenter;

                $invoice->positions[] = $position;
            }

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
        $invoice->hasVat = $this->vatIncluded($booking->nights, $invoice->taxDate);
        $invoice->vatClassificationId = $invoice->hasVat ? 'UD' : 'UN';

        $invoice->number = $this->receivablesNumberPrefix . sprintf('%04d', $this->receivablesIncrementalDocumentNumber);
        $this->receivablesIncrementalDocumentNumber++;

        $address = new Address();
        $address->name = $booking->guest_name;
        $invoice->partner = $address;

        $costCenters = $booking->listing->getCostCenters();

        foreach ($costCenters as $costCenter => $splitPercent) {
            $invoice->costCenter = $costCenter;

            $payments = $booking->paymentReservation;
            if (!$payments->count()) {
                return;
            }
            foreach ($payments as $payment) {
                $position = new InvoicePosition();
                $position->text = $booking->confirmation_code . ', ' . $booking->nights . 'n, ' . $booking->guest_name;
                $position->quantity = 1;
                $position->payVat = $invoice->hasVat ? 'true' : 'false';
                $position->rateVat = $invoice->hasVat ? 'low' : 'none';
                $position->accountingCoding = $this->getAccountingCoding(PaymentType::ID_RESERVATION) . optional($booking->listing->account)->accounting_suffix;
                $price = $this->calculatePrice($payment->amount, $splitPercent, $invoice->hasVat);
                $position->priceGross = $price['price_gross'];
                $position->priceNet = $price['price_net'];
                $position->priceVat = $price['vat'];
                $position->note = $booking->confirmation_code;
                $position->costCenter = $costCenter;

                $invoice->positions[] = $position;
            }

            $payments = $booking->paymentCleaning;
            if (!$payments->count()) {
                return;
            }
            foreach ($payments as $payment) {
                $position = new InvoicePosition();
                $position->text = $booking->confirmation_code . ', ' . $booking->nights . 'n, ' . $booking->guest_name;
                $position->quantity = 1;
                $position->payVat = $invoice->hasVat ? 'true' : 'false';
                $position->rateVat = $invoice->hasVat ? 'low' : 'none';
                $position->accountingCoding = $this->getAccountingCoding(PaymentType::ID_CLEANING) . optional($booking->listing->account)->accounting_suffix;
                $price = $this->calculatePrice($payment->amount, $splitPercent, $invoice->hasVat);
                $position->priceGross = $price['price_gross'];
                $position->priceNet = $price['price_net'];
                $position->priceVat = $price['vat'];
                $position->note = $booking->confirmation_code;
                $position->costCenter = $costCenter;

                $invoice->positions[] = $position;
            }

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
        $invoice->documentDate = $booking->arrival_date;
        $invoice->taxDate = $booking->arrival_date;
        $invoice->hasVat = $this->vatIncluded($booking->nights, $invoice->taxDate);
        $invoice->accountingDate = $booking->arrival_date;
        $invoice->reference = 'R' . $booking->confirmation_code;
        $invoice->accountingCoding = $this->getAccountingCoding(PaymentType::ID_RESOLUTION) . optional($booking->listing->account)->accounting_suffix;
        $invoice->text = 'Resolution ' . $booking->confirmation_code . ', ' . $booking->nights . 'n, ' . $booking->guest_name;
        $invoice->vatClassificationId = $invoice->hasVat ? 'UD' : 'UN';

        $invoice->number = $this->receivablesNumberPrefix . sprintf('%04d', $this->receivablesIncrementalDocumentNumber);
        $this->receivablesIncrementalDocumentNumber++;

        $address = new Address();
        $address->name = $booking->guest_name;
        $invoice->partner = $address;

        $costCenters = $booking->listing->getCostCenters();

        foreach ($costCenters as $costCenter => $splitPercent) {
            $invoice->costCenter = $costCenter;

            $payments = $booking->paymentResolution;
            if (!$payments->count()) {
                return;
            }
            foreach ($payments as $payment) {
                $position = new InvoicePosition();
                $position->text = 'Resolution ' . $booking->confirmation_code . ', ' . $booking->nights . 'n, ' . $booking->guest_name; #TODO
                $position->quantity = 1;
                $hasVat = $invoice->hasVat;
                $position->payVat = $invoice->hasVat ? 'true' : 'false';
                $position->rateVat = $invoice->hasVat ? 'low' : 'none';
                $position->accountingCoding = $this->getAccountingCoding(PaymentType::ID_RESOLUTION) . optional($booking->listing->account)->accounting_suffix;
                $price = $this->calculatePrice($payment->amount, $splitPercent, $hasVat);
                $position->priceGross = $price['price_gross'];
                $position->priceNet = $price['price_net'];
                $position->priceVat = $price['vat'];
                $position->note = $booking->confirmation_code;
                $position->costCenter = $costCenter;

                $invoice->positions[] = $position;
            }

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
            $priceWithoutVat = round(($price / 100 ) * (100 - self::VAT), 2);
            #$test = round ( 2168.44 / ( 1 + 15 / 100), 2);
            $vat = $price - $priceWithoutVat;
        } else {
            $priceWithoutVat = $price;
            $vat = 0;
        }

        return [
            'price_gross' => $price,
            'price_net' => number_format($priceWithoutVat, 2, '.', ''),
            'vat'   => (empty($vat) ? 0 : number_format($vat, 2, '.', '')),
        ];
    }

    private function vatIncluded($nights, string $documentDate)
    {
        return $nights <= 2 && $documentDate > '2018-02-28';
    }
}
