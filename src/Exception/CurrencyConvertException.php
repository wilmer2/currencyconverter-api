<?php

namespace App\Exception;

use App\Dto\CurrencyResponseErrorDto;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class CurrencyConvertException extends HttpException {

    public function __construct(CurrencyResponseErrorDto $currencyResponseErrorDto)
    {
        $defaultMessage = 'Internal server error. Please check the system logs for details.';
        $code = $this->generateExceptionCode($currencyResponseErrorDto->getCode());
        $info = $currencyResponseErrorDto->getInfo() ?? $defaultMessage;

        parent::__construct($code, $info);
    }

    private  function generateExceptionCode($code)
    {
        if ($code === null) return 500;
        if ($code < 400) return 400;

        return $code;
    }
}