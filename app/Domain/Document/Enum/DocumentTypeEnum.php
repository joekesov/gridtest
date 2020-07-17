<?php

namespace App\Domain\Document\Enum;


class DocumentTypeEnum
{
    const INVOICE = 1;
    const CREDIT_NOTE = 2;
    const DEBIT_NOTE = 3;

    private function __construct(){}
}
