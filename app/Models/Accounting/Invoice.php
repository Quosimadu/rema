<?php

namespace App\Models\Accounting;

use App\Models\Booking;

class Invoice
{
    public $taxDate;
    public $documentDate;

    /** @var  string  commitment / receivable **/
    public $type;

    public $vatClassification;

    public $accountingDate;
    public $accountingCoding;
    public $text;
    public $costCenter;
    public $note = 'XML Import';
    public $internalNote = 'XML imported as outgoing invoice';

    /**
     * @var Address
     */
    public $partner;

    /**
     * @var array
     */
    public $positions;

    public $reference;

}