<?php


namespace App\Domain\Currency;


class Currency
{
    public $code = null;
    public $rate = null;

    public function __construct(string $code, float $rate)
    {
        $this->code = $code;
        $this->rate = $rate;
    }
}
