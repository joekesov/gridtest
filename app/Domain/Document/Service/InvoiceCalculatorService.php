<?php

namespace App\Domain\Document\Service;

use App\Application\Model\Service\AbstractModelService;
use App\Domain\Document\Exception\DocumentPathException;
use App\Domain\Document\Exception\DocumentCurrencyException;
use App\Domain\Document\Exception\DocumentFieldException;
use App\Domain\Document\Exception\DocumentException;
use App\Domain\Document\Enum\DocumentFieldEnum;
use App\Domain\Document\Enum\DocumentTypeEnum;
use App\Domain\Customer\Customer;
use App\Domain\Document\DocumentRow;
use App\Domain\Document\Document\Invoice\Invoice;
use App\Domain\Document\Document\DebitNote\DebitNote;
use App\Domain\Document\Document\CreditNote\CreditNote;


class InvoiceCalculatorService
{
    private $filePath = null;
    private $currencies = [];
    private $outputCurrency = null;
    private $defaultCurrency = null;

    public function setFilePath(string $filePath)
    {
        $realPath = realpath($filePath);
        if (empty($realPath)) {
            throw new DocumentPathException('Not a valid file path!');
        }

        $this->filePath = $realPath;

        return $this;
    }

    public function setCurrencies(array $currencies)
    {
        foreach ($currencies as $currency) {
            $this->currencies[$currency->code] = $currency;
            if (1 == $currency->rate) {
                $this->defaultCurrency = $currency->code;
            }
        }

        return $this;
    }

    public function setOutputCurrency(string $currency)
    {
        $this->outputCurrency = $currency;

        return $this;
    }

    public function getTotals(string $vat = null) :array
    {
        $this->validate();


        if (($handle = fopen($this->filePath, "r")) !== false) {
            $customers = [];
            $documentColumns = [];
            $row = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $row++;
                if ($row === 1) {
                    $documentColumns = array_flip($data);

                    $missingColumns = [];
                    foreach (DocumentFieldEnum::DOCUMENT_FIELDS as $field) {
                        if (!array_key_exists($field, $documentColumns)) {
                            $missingColumns[] = $field;
                        }
                    }

                    if (count($missingColumns) > 0) {
                        throw new DocumentFieldException(sprintf('There are some missing fields in the file: %s', implode(', ', $missingColumns)));
                    }

                    continue;
                }

                $documentRow = new DocumentRow();
                $documentRow->setCustomerName($data[$documentColumns[DocumentFieldEnum::CUSTOMER_FIELD]]);
                $documentRow->setVatNumber($data[$documentColumns[DocumentFieldEnum::VAT_NUMBER_FIELD]]);
                $documentRow->setDocumentNumber($data[$documentColumns[DocumentFieldEnum::DOCUMENT_NUMBER_FIELD]]);
                $documentRow->setType($data[$documentColumns[DocumentFieldEnum::TYPE_NUMBER_FIELD]]);
                $documentRow->setParentDocument($data[$documentColumns[DocumentFieldEnum::PARENT_DOCUMENT_FIELD]]);
                $documentRow->setCurrencyCode($data[$documentColumns[DocumentFieldEnum::CURRENCY_FIELD]]);
                $documentRow->setTotal($data[$documentColumns[DocumentFieldEnum::TOTAL_FIELD]]);

                if (!empty($vat) && $documentRow->getVatNumber() != $vat) {
                    continue;
                }

                if (!array_key_exists($documentRow->getVatNumber(), $customers)) {
                    $customer = new Customer();
                    $customer->name = $documentRow->getCustomerName();
                    $customer->vatNumber = $documentRow->getVatNumber();

                    $customers[$documentRow->getVatNumber()]['customer'] = $customer;
                }

                $invoiceNumber = (DocumentTypeEnum::INVOICE === $documentRow->getType()) ? $documentRow->getDocumentNumber() : $documentRow->getParentDocument();

                switch ($documentRow->getType()) {
                    case DocumentTypeEnum::INVOICE:
                        $document = new Invoice();
                        $document->number = $documentRow->getDocumentNumber();
                        $document->currency = $documentRow->getCurrencyCode();
                        $document->total = $documentRow->getTotal();
                        $customers[$documentRow->getVatNumber()]['documents'][$documentRow->getDocumentNumber()]['invoice'] = $document;

                        break;
                    case DocumentTypeEnum::CREDIT_NOTE:
                        $document = new CreditNote();
                        $document->number = $documentRow->getDocumentNumber();
                        $document->parent = $documentRow->getParentDocument();
                        $document->currency = $documentRow->getCurrencyCode();
                        $document->total = $documentRow->getTotal();
                        $customers[$documentRow->getVatNumber()]['documents'][$documentRow->getParentDocument()]['credit_notes'][] = $document;

                        break;
                    case DocumentTypeEnum::DEBIT_NOTE:
                        $document = new DebitNote();
                        $document->number = $documentRow->getDocumentNumber();
                        $document->parent = $documentRow->getParentDocument();
                        $document->currency = $documentRow->getCurrencyCode();
                        $document->total = $documentRow->getTotal();
                        $customers[$documentRow->getVatNumber()]['documents'][$documentRow->getParentDocument()]['debit_notes'][] = $document;

                        break;
                }

            }
            fclose($handle);



            $outputCurrency = $this->getOutputCurrency();

            foreach ($customers as $vatNumber => $customer) {
                $total = 0;

                foreach ($customer['documents'] as $documentNumber => $invoice) {
                    if (!array_key_exists('invoice', $invoice)) {
                        throw new DocumentException(sprintf('Invoice with number %s does not exist!', $documentNumber));
                    }


                    $this->currencyExists($invoice['invoice']->currency);
                    $currency = $this->currencies[$invoice['invoice']->currency];


                    $invoiceSum = $invoice['invoice']->total * $currency->rate;
                    $creditNotesSum = 0;
                    $debitNotesSum = 0;

                    if (array_key_exists('credit_notes', $invoice)) {
                        foreach ($invoice['credit_notes'] as $creditNote) {
                            $this->currencyExists($creditNote->currency);
                            $currency = $this->currencies[$creditNote->currency];
                            $creditNotesSum += $creditNote->total * $currency->rate;
                        }
                    }

                    if (array_key_exists('debit_notes', $invoice)) {
                        foreach ($invoice['debit_notes'] as $debitNote) {
                            $this->currencyExists($debitNote->currency);
                            $currency = $this->currencies[$debitNote->currency];
                            $debitNotesSum += $debitNote->total * $currency->rate;
                        }
                    }

                    if ($invoiceSum < $creditNotesSum) {
                        throw new DocumentException(sprintf('the total of all the credit notes (%f) is bigger than the sum of the invoice (%f)', $creditNotesSum, $invoiceSum));
                    }

                    $total += $invoiceSum + $debitNotesSum - $creditNotesSum;
                }

                $customer['total'] = $total / $outputCurrency->rate;

                $customers[$vatNumber] = $customer;
            }
        }

        return $customers;
    }

    private function validate()
    {
        if (count($this->currencies) == 0) {
            throw new DocumentCurrencyException('There are no currencies with rate');
        }

        $isCorrectOutputCurrency = false;
        foreach($this->currencies as $currency) {
            if (empty($this->outputCurrency) && 1 === $currency->rate) {
                $this->outputCurrency = $currency->code;
            }

            if ($currency->code === $this->outputCurrency) {
                $isCorrectOutputCurrency = true;
            }
        }

        if (!$isCorrectOutputCurrency) {
            throw new DocumentCurrencyException('There is no output currency');
        }

        return true;
    }

    private function currencyExists($currencyCode)
    {
        if (!array_key_exists($currencyCode, $this->currencies)) {
            throw new DocumentCurrencyException('There is an unsupported currency in the file: %s!', $currencyCode);
        }
    }

    private function getOutputCurrency()
    {
        if (!array_key_exists($this->outputCurrency, $this->currencies)) {
            throw new DocumentCurrencyException(sprintf('You are trying to output total sum with unsupported currency (%s)', $this->outputCurrency));
        }

        return $this->currencies[$this->outputCurrency];
    }
}
