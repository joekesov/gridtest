<?php


namespace App\Domain\Document\Enum;


class DocumentFieldEnum
{
    const CUSTOMER_FIELD = 'Customer';
    const VAT_NUMBER_FIELD = 'Vat number';
    const DOCUMENT_NUMBER_FIELD = 'Document number';
    const TYPE_NUMBER_FIELD = 'Type';
    const PARENT_DOCUMENT_FIELD = 'Parent document';
    const CURRENCY_FIELD = 'Currency';
    const TOTAL_FIELD = 'Total';

    const DOCUMENT_FIELDS = [
        self::CUSTOMER_FIELD,
        self::VAT_NUMBER_FIELD,
        self::DOCUMENT_NUMBER_FIELD,
        self::TYPE_NUMBER_FIELD,
        self::PARENT_DOCUMENT_FIELD,
        self::CURRENCY_FIELD,
        self::TOTAL_FIELD,
    ];


    private function __construct() {}
}
