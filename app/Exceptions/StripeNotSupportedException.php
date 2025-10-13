<?php

namespace App\Exceptions;

use Exception;

class StripeNotSupportedException extends Exception
{
    protected $message = 'Stripe PHP is no longer supported in Laravel versions 5.3 and below.';
}
