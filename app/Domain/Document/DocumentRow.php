<?php


namespace App\Domain\Document;


class DocumentRow
{
    protected $customerName = null;
    protected $vatNumber = null;
    protected $documentNumber = null;
    protected $type = null;
    protected $parentDocument = null;
    protected $currencyCode = null;
    protected $total = null;


    public function getCustomerName(): string
    {
        return $this->customerName;
    }

    public function setCustomerName(string $customerName): void
    {
        $this->customerName = $customerName;
    }


    public function getVatNumber(): string
    {
        return $this->vatNumber;
    }

    public function setVatNumber(string $vatNumber): void
    {
        $this->vatNumber = $vatNumber;
    }

    public function getDocumentNumber(): string
    {
        return $this->documentNumber;
    }

    public function setDocumentNumber(string $documentNumber): void
    {
        $this->documentNumber = $documentNumber;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }

    public function getParentDocument(): string
    {
        return $this->parentDocument;
    }

    public function setParentDocument(string $parentDocument): void
    {
        $this->parentDocument = $parentDocument;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(string $currencyCode): void
    {
        $this->currencyCode = $currencyCode;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): void
    {
        $this->total = $total;
    }


}
