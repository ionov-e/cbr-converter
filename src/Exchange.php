<?php

namespace CbrConverter;

class Exchange
{
    const URL_CURRENCY_RATE_XML = 'https://www.cbr.ru/scripts/XML_daily.asp';

    private int $amount;
    private string $originalCurrencyName;
    private string $targetCurrencyName;
    private float $originalCurrencyRateToRub;
    private float $targetCurrencyRateToRub;
    private float $result;

    /** @throws \Exception */
    public function __construct(string $originalCurrencyName, string $targetCurrencyName, int $amount)
    {
        $this->originalCurrencyName = $originalCurrencyName;
        $this->targetCurrencyName = $targetCurrencyName;
        $this->amount = $amount;
        $this->setCurrencyRates();
        $this->result = $this->getResult();
    }

    /** @throws \Exception */
    private function setCurrencyRates(): void
    {
        $xml = simplexml_load_file(self::URL_CURRENCY_RATE_XML);

        if (!$xml) {
            throw new \Exception("Couldn't access XML with currency rates: " . self::URL_CURRENCY_RATE_XML);
        }

        foreach ($xml->Valute as $currency) {
            if ($currency->CharCode == $this->originalCurrencyName) {
                $currency->Value = (float)str_replace(',', '.', $currency->Value);
                $currency->Nominal = (float)str_replace(',', '.', $currency->Nominal);
                $this->originalCurrencyRateToRub = $currency->Value / $currency->Nominal;
            } elseif ($currency->CharCode == $this->targetCurrencyName) {
                $currency->Value = (float)str_replace(',', '.', $currency->Value);
                $currency->Nominal = (float)str_replace(',', '.', $currency->Nominal);
                $this->targetCurrencyRateToRub = $currency->Value / $currency->Nominal;
            };
        };

        if (empty($this->originalCurrencyRateToRub) || empty($this->targetCurrencyRateToRub)) {
            throw new \Exception("Couldn't find at least one of the provided currencies ('$this->originalCurrencyName' & '$this->targetCurrencyName')");
        }
    }

    private function getResult(): float
    {
        return $this->amount * $this->originalCurrencyRateToRub / $this->targetCurrencyRateToRub;
    }

    public function toDecimal(): string
    {
        return number_format($this->result, 2);
    }
}