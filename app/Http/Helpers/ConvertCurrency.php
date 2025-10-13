<?php
namespace App\Http\Helpers;

/**
 * Created by PhpStorm.
 * User: SANGNQ
 * Date: 12/16/17
 * Time: 10:26 PM
 */
class ConvertCurrency
{
    public function __construct($currencyDataFilePath)
    {
        $this->currenciesDataFilePath = $currencyDataFilePath;
        $this->currenciesData = $this->loadCurrenciesData();
        $this->defaultCurrencyName = 'sgd';
    }

    private function loadCurrenciesData()
    {
        // load currencyData
        $currenciesData = json_decode(file_get_contents($this->currenciesDataFilePath), true);
        // return result
        return $currenciesData;
    }

    public function convertToSGD($currencyValue, $currencyName)
    {
        $currencyName = strtolower($currencyName);
        if ($currencyName == $this->defaultCurrencyName)
            return $currencyValue;
        else {
            $currencyName = strtolower($currencyName);
            if (isset($this->currenciesData[$currencyName])) {
                $currencyData = $this->currenciesData[$currencyName];
                $rate = $currencyData['rate'];
                // return the value
                return $currencyValue / $rate;
            } else {
                return false;
            }
        }
    }
}

;