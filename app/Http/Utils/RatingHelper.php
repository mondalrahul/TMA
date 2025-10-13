<?php

namespace App\Http\Utils;

class RatingHelper 
{
    public static function generateRatingStar($number)
    {
        $number = floor($number);
        $str = '';
        for ($i=1; $i <= $number; $i++) { 
            $str .= sprintf('<img src="%s" />&nbsp;&nbsp;', asset('images/product-detail/anchor/1.png'));
        }

        for ($i=$number+1; $i <= 5; $i++) { 
            $str .= sprintf('<img src="%s" />&nbsp;', asset('images/product-detail/anchor/0.png'));
        }

        return $str;
    }
}
