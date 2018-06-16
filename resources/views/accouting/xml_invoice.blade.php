<?xml version = "1.0" encoding = "Windows-1250" ?>
<dat:dataPack version="2.0" id="int002" ico="06632637" application="StwTest" note="Import Interních dokladů"
              xmlns:dat="http://www.stormware.cz/schema/version_2/data.xsd"
              xmlns:int="http://www.stormware.cz/schema/version_2/invoice.xsd"
              xmlns:typ="http://www.stormware.cz/schema/version_2/type.xsd">
    @foreach ($invoices as $invoice)
        <dat:dataPackItem version="2.0" id="{{ $invoice->id }}">
            <int:invoice version="2.0">
                <int:invoiceHeader>
                    <int:invoiceType>{{ $invoice->type }}</int:invoiceType>
                    <int:symVar>{{ $invoice->reference }}</int:symVar>
                    <int:originalDocument>{{ $invoice->reference }}</int:originalDocument>
                    <int:date>{{ $invoice->documentDate->toDateString() }}</int:date>
                    <int:dateTax>{{ $invoice->taxDate->toDateString() }}</int:dateTax>
                    <int:dateAccounting>{{ $invoice->accountingDate->toDateString() }}</int:dateAccounting>
                    <int:accounting>
                        <typ:ids>{{ $invoice->accountingCoding }}</typ:ids>
                    </int:accounting>
                    @if ($invoice->hasVat)
                        <int:classificationVAT>
                            <typ:ids>PN</typ:ids>
                            <typ:classificationVATType>{{ $invoice->vatClassification }}</typ:classificationVATType>
                        </int:classificationVAT>
                    @endif
                    <int:text>{{ $invoice->text }}</int:text>
                    <int:partnerIdentity>
                        <typ:address>
                            <typ:name>{{ $invoice->partner->name }}</typ:name>
                            <typ:city>{{ $invoice->partner->city }}</typ:city>
                            <typ:street>{{ $invoice->partner->street }}</typ:street>
                            <typ:zip>{{ $invoice->partner->postalCode }}</typ:zip>
                        </typ:address>
                    </int:partnerIdentity>
                    <int:centre>
                        <typ:ids>{{ $invoice->costCenter }}</typ:ids>
                    </int:centre>
                    <int:activity>
                        <typ:ids>TEST</typ:ids>
                    </int:activity>
                    <int:note>{{ $invoice->note }}</int:note>
                    <int:intNote>{{ $invoice->internalNote }}
                    </int:intNote>
                </int:invoiceHeader>
                <int:invoiceDetail>
                    @foreach ($invoice->positions as $invoicePosition)
                        <int:invoiceItem>
                            <int:text>{{ $invoicePosition->text }}</int:text>
                            <int:quantity>{{ $invoicePosition->quantity }}</int:quantity>
                            <int:payVAT>{{ $invoicePosition->payVat }}</int:payVAT>
                            <int:rateVAT>{{ $invoicePosition->rateVat }}</int:rateVAT>
                            <int:homeCurrency>
                                <typ:unitPrice>{{ $invoicePosition->price }}</typ:unitPrice>
                                <typ:priceVAT>{{ $invoicePosition->priceVat }}</typ:priceVAT>
                            </int:homeCurrency>
                            <int:note>{{ $invoicePosition->note }}</int:note>
                            <int:accounting>
                                <typ:ids>{{ $invoicePosition->accountingCoding }}</typ:ids>
                            </int:accounting>
                            <int:centre>
                                <typ:ids>{{ $invoicePosition->costCenter }}</typ:ids>
                            </int:centre>
                        </int:invoiceItem>
                    @endforeach
                </int:invoiceDetail>
            </int:invoice>
        </dat:dataPackItem>
    @endforeach
</dat:dataPack>
