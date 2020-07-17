<?php

namespace App\Domain\Document;

abstract class AbstractDocument
{
    public $number = null;
//    protected $type = null;
    public $parent = null;
    public $currency = null;
    public $total = null;

//    public function setNumber(string $number)
//    {
//        $this->number = $number;
//
//        return $this;
//    }
//
//    public function getNumber()
//    {
//        return $this->number;
//    }
//
//    public function getType()
//    {
//        return $this->type;
//    }
}
