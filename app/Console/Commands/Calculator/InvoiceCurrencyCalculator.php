<?php

namespace App\Console\Commands\Calculator;

use Illuminate\Console\Command;
use App\Domain\Document\Service\InvoiceCalculatorService;
use App\Domain\Document\Exception\AbstractDocumentCalculatorException;
use App\Domain\Currency\Currency;

class InvoiceCurrencyCalculator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:csv
                            {path_to_file : The path to the file which should be imported}
                            {currencies_and_rates}
                            {output_currency}
                            {--vat= : Filter the calculation to a specific customer}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command takes the CSV file as an input, a list of currency and exchnage rates, an output currency, an optional param to specify and filter a specific customer and return the sum of all the documents.';


    private $service;


    public function __construct(InvoiceCalculatorService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Preparing...');

        $this->info('Get params...');

        $pathToFile = $this->argument('path_to_file');
        $currenciesAndRates = $this->argument('currencies_and_rates');
        $outputCurrency = $this->argument('output_currency');
        $vatNumber = $this->option('vat');

        $currencies = [];
        $currenciesRates = explode(',', $currenciesAndRates); // TODO: Validation
        foreach ($currenciesRates as $currencyRate) {
            $currencyData = explode(':', $currencyRate);
            $currency = new Currency($currencyData[0], $currencyData[1]);

            $currencies[] = $currency;
        }

        try {
            $this->service->setFilePath($pathToFile);
            $this->service->setCurrencies($currencies);
            $this->service->setOutputCurrency($outputCurrency);
            $customers = $this->service->getTotals($vatNumber);

            foreach ($customers as $customer) {
                $customerName = $customer['customer']->name;
                $total = number_format($customer['total'], 2, '.', '');

                $this->line(sprintf('Customer %s - %s %s', $customerName, $total, $outputCurrency));
            }

        } catch (AbstractDocumentCalculatorException $e) {
            $this->error(sprintf('Error: %s', $e->getMessage()));
        }

    }
}
