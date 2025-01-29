<?php

namespace App\Exceptions;

use Exception;

class CountryCodeErrorException extends Exception
{
    public function __construct($countryCode)
    {
        $this->message = "$countryCode is not a valid country code";
    }
}
