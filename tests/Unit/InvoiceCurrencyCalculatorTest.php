<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class InvoiceCurrencyCalculatorTest extends TestCase
{
    const CORRECT_CSV_FILE = 'data.csv';
    const MISSING_FILED_CSV_FILE = 'missing_fields_data.csv';

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);


        $correctFilePath = $this->getFilePath(self::CORRECT_CSV_FILE);
        dd($correctFilePath);

        $currency = 'USD';

        $command = sprintf('import:csv %s %s', $correctFilePath, $currency);


        $this->artisan($command);

        dd($correctFilePath); exit;

//        dd($directory);
    }

    private function getFilePath($fileName)
    {
        $path = realpath(getcwd() .'/tests/Unit/InvoiceTest/'. $fileName);

        return $path;
    }
}
