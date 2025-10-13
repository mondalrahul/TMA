<?php
namespace App\Http\Utils;

class StringDatabase
{
    /**
     * Execute string from database
     *
     * @param string $string
     * @return string
     * @author vduong daiduongptit090@gmail.com
     */
    public static function executeStringToHtml($string)
    {
        $newString = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
        return urldecode($newString);
    }

    /**
     * Execute string from database
     *
     * @param number $price
     * @return string
     * @author vduong daiduongptit090@gmail.com
     */
    public static function executeNiceNumber($price)
    {
        $price = str_replace(",", "", $price);

        /*if (strlen($price) >= 8) {
            return round(($price / 1000), 1) . 'K';
        }*/
        return number_format($price);
    }
}
