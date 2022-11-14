<?php

namespace CbrConverter;

class Exchange
{
    const URL_CURRENCY_RATE_XML = 'https://www.cbr.ru/scripts/XML_daily.asp';

    private string $originalCurrency;

    private string $targetCurrency;

    private int $amount;

    private float $currencyRate;

    private float $result;

    public function __construct(string $originalCurrency, string $targetCurrency, int $amount)
    {
        $this->originalCurrency = $originalCurrency;
        $this->targetCurrency = $targetCurrency;
        $this->amount = $amount;
    }

    public function getResult() // #TODO change to private
    {
        $xml = simplexml_load_file(self::URL_CURRENCY_RATE_XML);
    }

    public function toDecimal(): float
    {
        return ($this->result);
    }
}