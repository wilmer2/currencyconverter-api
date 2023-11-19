<?php

namespace App\Service;

use App\Dto\CurrencyResponseErrorDto;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CurrencyConvertErrorService {

    public function handleError(CurrencyResponseErrorDto $currencyResponseErrorDto)
    {   
        $defaultMessage = 'Internal server error. Please check the system logs for details.';
        $code = $this->generateExceptionCode($currencyResponseErrorDto->getCode());
        $info = $currencyResponseErrorDto->getInfo() ?? $defaultMessage;

        throw new HttpException($code , $info);
    }

    private  function generateExceptionCode($code)
    {
        if ($code === null) return 500;
        if ($code < 400) return 400;

        return $code;
    }
}