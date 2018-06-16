<?xml version = "1.0" encoding = "Windows-1250"?>
<dat:dataPack version="2.0" id="Usr01" ico="06632637" programVersion="11901.7 SQL (4.6.2018)" application="Transformace"
              note="Uživatelský export" xmlns:dat="http://www.stormware.cz/schema/version_2/data.xsd">
    @foreach ($invoices as $invoice)
        <dat:dataPackItem version="2.0" id="Usr01 (001)">
            <int:intDoc version="2.0" xmlns:int="http://www.stormware.cz/schema/version_2/intDoc.xsd">
                <int:intDocHeader xmlns:rsp="http://www.stormware.cz/schema/version_2/response.xsd"
                                  xmlns:rdc="http://www.stormware.cz/schema/version_2/documentresponse.xsd"
                                  xmlns:typ="http://www.stormware.cz/schema/version_2/type.xsd"
                                  xmlns:lst="http://www.stormware.cz/schema/version_2/list.xsd"
                                  xmlns:lStk="http://www.stormware.cz/schema/version_2/list_stock.xsd"
                                  xmlns:lAdb="http://www.stormware.cz/schema/version_2/list_addBook.xsd"
                                  xmlns:acu="http://www.stormware.cz/schema/version_2/accountingunit.xsd"
                                  xmlns:inv="http://www.stormware.cz/schema/version_2/invoice.xsd"
                                  xmlns:vch="http://www.stormware.cz/schema/version_2/voucher.xsd"
                                  xmlns:stk="http://www.stormware.cz/schema/version_2/stock.xsd"
                                  xmlns:ord="http://www.stormware.cz/schema/version_2/order.xsd"
                                  xmlns:ofr="http://www.stormware.cz/schema/version_2/offer.xsd"
                                  xmlns:enq="http://www.stormware.cz/schema/version_2/enquiry.xsd"
                                  xmlns:vyd="http://www.stormware.cz/schema/version_2/vydejka.xsd"
                                  xmlns:pri="http://www.stormware.cz/schema/version_2/prijemka.xsd"
                                  xmlns:bal="http://www.stormware.cz/schema/version_2/balance.xsd"
                                  xmlns:pre="http://www.stormware.cz/schema/version_2/prevodka.xsd"
                                  xmlns:vyr="http://www.stormware.cz/schema/version_2/vyroba.xsd"
                                  xmlns:pro="http://www.stormware.cz/schema/version_2/prodejka.xsd"
                                  xmlns:con="http://www.stormware.cz/schema/version_2/contract.xsd"
                                  xmlns:adb="http://www.stormware.cz/schema/version_2/addressbook.xsd"
                                  xmlns:prm="http://www.stormware.cz/schema/version_2/parameter.xsd"
                                  xmlns:lCon="http://www.stormware.cz/schema/version_2/list_contract.xsd"
                                  xmlns:ctg="http://www.stormware.cz/schema/version_2/category.xsd"
                                  xmlns:ipm="http://www.stormware.cz/schema/version_2/intParam.xsd"
                                  xmlns:str="http://www.stormware.cz/schema/version_2/storage.xsd"
                                  xmlns:idp="http://www.stormware.cz/schema/version_2/individualPrice.xsd"
                                  xmlns:sup="http://www.stormware.cz/schema/version_2/supplier.xsd"
                                  xmlns:prn="http://www.stormware.cz/schema/version_2/print.xsd"
                                  xmlns:sEET="http://www.stormware.cz/schema/version_2/sendEET.xsd"
                                  xmlns:act="http://www.stormware.cz/schema/version_2/accountancy.xsd"
                                  xmlns:bnk="http://www.stormware.cz/schema/version_2/bank.xsd"
                                  xmlns:sto="http://www.stormware.cz/schema/version_2/store.xsd"
                                  xmlns:grs="http://www.stormware.cz/schema/version_2/groupStocks.xsd"
                                  xmlns:acp="http://www.stormware.cz/schema/version_2/actionPrice.xsd"
                                  xmlns:csh="http://www.stormware.cz/schema/version_2/cashRegister.xsd"
                                  xmlns:bka="http://www.stormware.cz/schema/version_2/bankAccount.xsd"
                                  xmlns:ilt="http://www.stormware.cz/schema/version_2/inventoryLists.xsd"
                                  xmlns:nms="http://www.stormware.cz/schema/version_2/numericalSeries.xsd"
                                  xmlns:pay="http://www.stormware.cz/schema/version_2/payment.xsd"
                                  xmlns:mKasa="http://www.stormware.cz/schema/version_2/mKasa.xsd"
                                  xmlns:gdp="http://www.stormware.cz/schema/version_2/GDPR.xsd"
                                  xmlns:ftr="http://www.stormware.cz/schema/version_2/filter.xsd">
                    <int:number>
                        <typ:numberRequested>{{ $invoice->type }}</typ:numberRequested>
                    </int:number>
                    <int:symVar>{{ $invoice->reference }}</int:symVar>
                    <int:date>{{ $invoice->documentDate->toDateString() }}</int:date>
                    <int:dateTax>{{ $invoice->taxDate->toDateString() }}</int:dateTax>
                    <int:dateAccounting>{{ $invoice->accountingDate->toDateString() }}</int:dateAccounting>
                    <int:accounting>
                        <typ:ids>{{ $invoice->accountingCoding }}</typ:ids>
                    </int:accounting>
                    <int:classificationVAT>
                        <typ:ids>UN</typ:ids>
                        <typ:classificationVATType>{{ $invoice->vatClassification }}</typ:classificationVATType>
                    </int:classificationVAT>
                    <int:text>{{ $invoice->text }}</int:text>
                    <int:partnerIdentity>
                        <typ:address>
                            <typ:company>{{ $invoice->partner->name }}</typ:company>
                            <typ:city>{{ $invoice->partner->city }}</typ:city>
                            <typ:street>{{ $invoice->partner->street }}</typ:street>
                        </typ:address>
                        <typ:shipToAddress>
                            <typ:company></typ:company>
                            <typ:city></typ:city>
                            <typ:street></typ:street>
                        </typ:shipToAddress>
                    </int:partnerIdentity>
                    <int:myIdentity>
                        <typ:address>
                            <typ:company>Home For Prague s.r.o.</typ:company>
                            <typ:city>Praha 1</typ:city>
                            <typ:street>Jeruzalémská</typ:street>
                            <typ:number>1283/9</typ:number>
                            <typ:zip>110 00</typ:zip>
                            <typ:ico>06632637</typ:ico>
                            <typ:dic>CZ06632637</typ:dic>
                            <typ:phone>778001155</typ:phone>
                            <typ:email>wehle.paul@gmail.com</typ:email>
                        </typ:address>
                    </int:myIdentity>
                    <int:liquidation>true</int:liquidation>
                    <int:centre>
                        <typ:ids>{{ $invoice->costCenter }}</typ:ids>
                    </int:centre>
                    <int:activity>
                        <typ:ids>TEST</typ:ids>
                    </int:activity>
                    <int:markRecord>false</int:markRecord>
                </int:intDocHeader>
                <int:intDocDetail xmlns:rsp="http://www.stormware.cz/schema/version_2/response.xsd"
                                  xmlns:rdc="http://www.stormware.cz/schema/version_2/documentresponse.xsd"
                                  xmlns:typ="http://www.stormware.cz/schema/version_2/type.xsd"
                                  xmlns:lst="http://www.stormware.cz/schema/version_2/list.xsd"
                                  xmlns:lStk="http://www.stormware.cz/schema/version_2/list_stock.xsd"
                                  xmlns:lAdb="http://www.stormware.cz/schema/version_2/list_addBook.xsd"
                                  xmlns:acu="http://www.stormware.cz/schema/version_2/accountingunit.xsd"
                                  xmlns:inv="http://www.stormware.cz/schema/version_2/invoice.xsd"
                                  xmlns:vch="http://www.stormware.cz/schema/version_2/voucher.xsd"
                                  xmlns:stk="http://www.stormware.cz/schema/version_2/stock.xsd"
                                  xmlns:ord="http://www.stormware.cz/schema/version_2/order.xsd"
                                  xmlns:ofr="http://www.stormware.cz/schema/version_2/offer.xsd"
                                  xmlns:enq="http://www.stormware.cz/schema/version_2/enquiry.xsd"
                                  xmlns:vyd="http://www.stormware.cz/schema/version_2/vydejka.xsd"
                                  xmlns:pri="http://www.stormware.cz/schema/version_2/prijemka.xsd"
                                  xmlns:bal="http://www.stormware.cz/schema/version_2/balance.xsd"
                                  xmlns:pre="http://www.stormware.cz/schema/version_2/prevodka.xsd"
                                  xmlns:vyr="http://www.stormware.cz/schema/version_2/vyroba.xsd"
                                  xmlns:pro="http://www.stormware.cz/schema/version_2/prodejka.xsd"
                                  xmlns:con="http://www.stormware.cz/schema/version_2/contract.xsd"
                                  xmlns:adb="http://www.stormware.cz/schema/version_2/addressbook.xsd"
                                  xmlns:prm="http://www.stormware.cz/schema/version_2/parameter.xsd"
                                  xmlns:lCon="http://www.stormware.cz/schema/version_2/list_contract.xsd"
                                  xmlns:ctg="http://www.stormware.cz/schema/version_2/category.xsd"
                                  xmlns:ipm="http://www.stormware.cz/schema/version_2/intParam.xsd"
                                  xmlns:str="http://www.stormware.cz/schema/version_2/storage.xsd"
                                  xmlns:idp="http://www.stormware.cz/schema/version_2/individualPrice.xsd"
                                  xmlns:sup="http://www.stormware.cz/schema/version_2/supplier.xsd"
                                  xmlns:prn="http://www.stormware.cz/schema/version_2/print.xsd"
                                  xmlns:sEET="http://www.stormware.cz/schema/version_2/sendEET.xsd"
                                  xmlns:act="http://www.stormware.cz/schema/version_2/accountancy.xsd"
                                  xmlns:bnk="http://www.stormware.cz/schema/version_2/bank.xsd"
                                  xmlns:sto="http://www.stormware.cz/schema/version_2/store.xsd"
                                  xmlns:grs="http://www.stormware.cz/schema/version_2/groupStocks.xsd"
                                  xmlns:acp="http://www.stormware.cz/schema/version_2/actionPrice.xsd"
                                  xmlns:csh="http://www.stormware.cz/schema/version_2/cashRegister.xsd"
                                  xmlns:bka="http://www.stormware.cz/schema/version_2/bankAccount.xsd"
                                  xmlns:ilt="http://www.stormware.cz/schema/version_2/inventoryLists.xsd"
                                  xmlns:nms="http://www.stormware.cz/schema/version_2/numericalSeries.xsd"
                                  xmlns:pay="http://www.stormware.cz/schema/version_2/payment.xsd"
                                  xmlns:mKasa="http://www.stormware.cz/schema/version_2/mKasa.xsd"
                                  xmlns:gdp="http://www.stormware.cz/schema/version_2/GDPR.xsd"
                                  xmlns:ftr="http://www.stormware.cz/schema/version_2/filter.xsd">
                    @foreach ($invoice->positions as $invoicePosition)
                        <int:intDocItem>
                            <int:text>{{ $invoicePosition->text }}</int:text>
                            <int:quantity>{{ $invoicePosition->quantity }}</int:quantity>
                            <int:coefficient>1.0</int:coefficient>
                            <int:payVAT>false</int:payVAT>
                            <int:rateVAT>{{ $invoicePosition->vatClassification }}</int:rateVAT>
                            <int:discountPercentage>0.0</int:discountPercentage>
                            <int:homeCurrency>
                                <typ:unitPrice>{{ $invoicePosition->price }}</typ:unitPrice>
                                <?php /*<typ:price>{{ $invoicePosition->price }}</typ:price>*/ ?>
                                <typ:priceVAT>{{ $invoicePosition->priceVat }}</typ:priceVAT>
                                <?php /*<typ:priceSum></typ:priceSum>*/ ?>
                            </int:homeCurrency>
                            <int:symPar>{{ $invoice->reference }}</int:symPar>
                            <int:accounting>
                                <typ:ids>{{ $invoice->accountingCoding }}</typ:ids>
                            </int:accounting>
                            <int:PDP>false</int:PDP>
                        </int:intDocItem>
                    @endforeach
                </int:intDocDetail>
                <?php /*
                <int:intDocSummary xmlns:rsp="http://www.stormware.cz/schema/version_2/response.xsd" xmlns:rdc="http://www.stormware.cz/schema/version_2/documentresponse.xsd" xmlns:typ="http://www.stormware.cz/schema/version_2/type.xsd" xmlns:lst="http://www.stormware.cz/schema/version_2/list.xsd" xmlns:lStk="http://www.stormware.cz/schema/version_2/list_stock.xsd" xmlns:lAdb="http://www.stormware.cz/schema/version_2/list_addBook.xsd" xmlns:acu="http://www.stormware.cz/schema/version_2/accountingunit.xsd" xmlns:inv="http://www.stormware.cz/schema/version_2/invoice.xsd" xmlns:vch="http://www.stormware.cz/schema/version_2/voucher.xsd" xmlns:stk="http://www.stormware.cz/schema/version_2/stock.xsd" xmlns:ord="http://www.stormware.cz/schema/version_2/order.xsd" xmlns:ofr="http://www.stormware.cz/schema/version_2/offer.xsd" xmlns:enq="http://www.stormware.cz/schema/version_2/enquiry.xsd" xmlns:vyd="http://www.stormware.cz/schema/version_2/vydejka.xsd" xmlns:pri="http://www.stormware.cz/schema/version_2/prijemka.xsd" xmlns:bal="http://www.stormware.cz/schema/version_2/balance.xsd" xmlns:pre="http://www.stormware.cz/schema/version_2/prevodka.xsd" xmlns:vyr="http://www.stormware.cz/schema/version_2/vyroba.xsd" xmlns:pro="http://www.stormware.cz/schema/version_2/prodejka.xsd" xmlns:con="http://www.stormware.cz/schema/version_2/contract.xsd" xmlns:adb="http://www.stormware.cz/schema/version_2/addressbook.xsd" xmlns:prm="http://www.stormware.cz/schema/version_2/parameter.xsd" xmlns:lCon="http://www.stormware.cz/schema/version_2/list_contract.xsd" xmlns:ctg="http://www.stormware.cz/schema/version_2/category.xsd" xmlns:ipm="http://www.stormware.cz/schema/version_2/intParam.xsd" xmlns:str="http://www.stormware.cz/schema/version_2/storage.xsd" xmlns:idp="http://www.stormware.cz/schema/version_2/individualPrice.xsd" xmlns:sup="http://www.stormware.cz/schema/version_2/supplier.xsd" xmlns:prn="http://www.stormware.cz/schema/version_2/print.xsd" xmlns:sEET="http://www.stormware.cz/schema/version_2/sendEET.xsd" xmlns:act="http://www.stormware.cz/schema/version_2/accountancy.xsd" xmlns:bnk="http://www.stormware.cz/schema/version_2/bank.xsd" xmlns:sto="http://www.stormware.cz/schema/version_2/store.xsd" xmlns:grs="http://www.stormware.cz/schema/version_2/groupStocks.xsd" xmlns:acp="http://www.stormware.cz/schema/version_2/actionPrice.xsd" xmlns:csh="http://www.stormware.cz/schema/version_2/cashRegister.xsd" xmlns:bka="http://www.stormware.cz/schema/version_2/bankAccount.xsd" xmlns:ilt="http://www.stormware.cz/schema/version_2/inventoryLists.xsd" xmlns:nms="http://www.stormware.cz/schema/version_2/numericalSeries.xsd" xmlns:pay="http://www.stormware.cz/schema/version_2/payment.xsd" xmlns:mKasa="http://www.stormware.cz/schema/version_2/mKasa.xsd" xmlns:gdp="http://www.stormware.cz/schema/version_2/GDPR.xsd" xmlns:ftr="http://www.stormware.cz/schema/version_2/filter.xsd">
                    <int:roundingDocument>none</int:roundingDocument>
                    <int:roundingVAT>none</int:roundingVAT>
                    <int:homeCurrency>
                        <typ:priceNone>163.36</typ:priceNone>
                        <typ:priceLow>0</typ:priceLow>
                        <typ:priceLowVAT>0</typ:priceLowVAT>
                        <typ:priceLowSum>0</typ:priceLowSum>
                        <typ:priceHigh>0</typ:priceHigh>
                        <typ:priceHighVAT>0</typ:priceHighVAT>
                        <typ:priceHighSum>0</typ:priceHighSum>
                        <typ:price3>0</typ:price3>
                        <typ:price3VAT>0</typ:price3VAT>
                        <typ:price3Sum>0</typ:price3Sum>
                        <typ:round>
                            <typ:priceRound>0</typ:priceRound>
                        </typ:round>
                    </int:homeCurrency>
                </int:intDocSummary> */ ?>
            </int:intDoc>
        </dat:dataPackItem>
    @endforeach
</dat:dataPack>