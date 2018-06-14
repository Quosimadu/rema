<?php

namespace App\Models;

use App\Models\Accounting\Address;
use App\Models\Accounting\Invoice;
use App\Models\Accounting\InvoicePosition;

class Accounting
{
    const VAT = 21;

    const ACCOUNT_UNKNOWN = '90000';
    const ACCOUNT_RESERVATION = 'AiRBnB';
    const ACCOUNT_CLEANING_FEE = 'AirClean';
    const ACCOUNT_PORTAL_FEE = 'PoplAir';

    public $invoices;

    public function addInvoices($bookings)
    {
        if (empty($bookings)) {
            return;
        }

        foreach ($bookings as $booking) {
            $this->addPlatformInvoice($booking);
            $this->addCustomerInvoice($booking);
        }
    }

    private function addPlatformInvoice(Booking $booking)
    {
        $invoice = new Invoice();

        $invoice->type = 'commitment';
        $invoice->vatClassification = 'inland';
        $invoice->documentDate = $booking->arrival_date;
        $invoice->taxDate = $booking->arrival_date;
        $invoice->accountingDate = $booking->arrival_date;
        $invoice->reference = $booking->confirmation_code;
        $invoice->accountingCoding = self::ACCOUNT_PORTAL_FEE . optional($booking->listing->account)->accounting_suffix;
        $invoice->text = $booking->confirmation_code . ', Provize ' . $booking->platform->name . ', ' . $booking->nights . 'n, ' . $booking->guest_name;

        $address = new Address();
        $address->name = $booking->platform->name;
        $invoice->partner = $address;

        $costCenters = $booking->listing->getCostCenters();

        foreach ($costCenters as $costCenter => $splitPercent) {
            $invoice->costCenter = $costCenter;
            $invoice->positions[] = $this->getHostFeePosition($booking, $costCenter, $splitPercent);

            $this->invoices[] = $invoice;

            $invoice = clone $invoice;
            $invoice->positions = [];
        }
    }

    private function addCustomerInvoice(Booking $booking)
    {
        $invoice = new Invoice();

        $invoice->type = 'receivable';
        $invoice->vatClassification = 'nonSubsume';
        $invoice->documentDate = $booking->arrival_date;
        $invoice->taxDate = $booking->arrival_date;
        $invoice->accountingDate = $booking->arrival_date;
        $invoice->reference = $booking->confirmation_code;
        $invoice->accountingCoding = self::ACCOUNT_RESERVATION . optional($booking->listing->account)->accounting_suffix;
        $invoice->text = $booking->confirmation_code . ', ' . $booking->nights . 'n, ' . $booking->guest_name;

        $address = new Address();
        $address->name = $booking->guest_name;
        $invoice->partner = $address;

        $costCenters = $booking->listing->getCostCenters();

        foreach ($costCenters as $costCenter => $splitPercent) {
            $invoice->costCenter = $costCenter;
            $invoice->positions[] = $this->getReservationPosition($booking, $costCenter, $splitPercent);
            $invoice->positions[] = $this->getCleaningPosition($booking, $costCenter, $splitPercent);

            $this->invoices[] = $invoice;

            $invoice = clone $invoice;
            $invoice->positions = [];
        }
    }

    private function getHostFeePosition(Booking $booking, $costCenter, $splitPercent = null)
    {
        $position = new InvoicePosition();
        $position->text = $booking->confirmation_code . ', ' . $booking->nights . 'n, ' . $booking->guest_name;
        $position->quantity = 1;
        $position->vatClassification = 'inland';
        $position->accountingCoding = self::ACCOUNT_PORTAL_FEE;
        $price = $this->calculatePrice($booking->paymentHost->amount, $splitPercent, false);
        $position->price = $price['price'];
        $position->priceVat = $price['vat'];
        $position->note = 'Provize ' . $booking->platform->name;
        $position->costCenter = $costCenter;

        return $position;
    }

    private function getReservationPosition(Booking $booking, $costCenter, $splitPercent = null)
    {
        $position = new InvoicePosition();
        $position->text = $booking->confirmation_code . ', ' . $booking->nights . 'n, ' . $booking->guest_name;
        $position->quantity = 1;
        $hasVat = $this->vatIncluded($booking->nights);
        $position->vatClassification = $hasVat ? 'nonSubsume' : 'inland';
        $position->accountingCoding = self::ACCOUNT_RESERVATION . optional($booking->listing->account)->accounting_suffix;
        $price = $this->calculatePrice($booking->paymentReservation->amount, $splitPercent, $hasVat);
        $position->price = $price['price'];
        $position->priceVat = $price['vat'];
        $position->note = $booking->confirmation_code;
        $position->costCenter = $costCenter;

        return $position;
    }

    private function getCleaningPosition(Booking $booking, $costCenter, $splitPercent = null)
    {
        $position = new InvoicePosition();
        $position->text = $booking->confirmation_code . ', ' . $booking->nights . 'n, ' . $booking->guest_name;
        $position->quantity = 1;
        $hasVat = $this->vatIncluded($booking->nights);
        $position->vatClassification = 'inland';
        $position->accountingCoding = self::ACCOUNT_CLEANING_FEE . optional($booking->listing->account)->accounting_suffix;
        $price = $this->calculatePrice($booking->paymentCleaning->amount, $splitPercent, $hasVat);
        $position->price = $price['price'];
        $position->priceVat = $price['vat'];
        $position->note = $booking->confirmation_code;
        $position->costCenter = $costCenter;

        return $position;
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
