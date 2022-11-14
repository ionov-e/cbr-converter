# Simple currency converter (CBR)

## Short description

The whole point was to publish a library on packagist: https://packagist.org/packages/ioncurly/cbr-converter
It uses CBR's XML file with currency rates

This XML file (updated daily) is used: https://www.cbr.ru/scripts/XML_daily.asp

## Installation

Run this command in your project

`composer require ioncurly/cbr-converter:dev-main`

## Usage

`$exchange = new Exchange("USD", "UAH", 100);`

`echo $exchange->toDecimal();`

It would print some number like "**3,693.18**"

* First parameter: short abbreviation (3 letters) of currency being converted from;
* First parameter: short abbreviation (3 letters) of currency being converted to;
* Third parameter: amount of money to be converted