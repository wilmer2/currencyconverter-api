<?php

namespace App\Service;


use App\Adapter\CurrencyConvertAdapter;
use App\Adapter\SerializeAdapter;
use App\Dto\CurrencyResponseDto;
use App\Dto\CurrencyResponseErrorDto;
use App\Exception\CurrencyConvertException;
use App\Dto\CurrencyConvertRequestDto;
use App\Dto\CurrencyConvertResponseDto;
use App\Adapter\TranslateAdapter;
use Symfony\Component\HttpKernel\Exception\HttpException;


class CurrencyConvertService
{   
    private $client;
    private $serializer;
    private $translate;
    
    public function __construct(
        CurrencyConvertAdapter $client,
        SerializeAdapter $serializer,
        TranslateAdapter $translate
    )
    {   
        $this->client = $client;
        $this->serializer = $serializer;
        $this->translate = $translate;
    }

    public function getCurrencyResponse(): CurrencyResponseDto
    {   
        $response = $this->client->getCurrencies();
        $jsonResponse = json_decode($response);

        if (!$jsonResponse->success) {
            $currencyErrorDto = $this->serializer->deserializeJson($response, CurrencyResponseErrorDto::class);
            throw new CurrencyConvertException($currencyErrorDto);
        }

        $currencyResponseDto = $this->serializer->deserializeJson($response, CurrencyResponseDto::class);
        
        return $currencyResponseDto;
    }

    public function getConvert(CurrencyConvertRequestDto $currencyConvertRequestDto)
    {
        $response = $this->client->getConvert(
            $currencyConvertRequestDto->getFrom(),
            $currencyConvertRequestDto->getTo(),
            $currencyConvertRequestDto->getAmount(),
        );

        $jsonResponse = json_decode($response);

        if (!$jsonResponse->success) {
            throw new HttpException(
                400,
                $this->translate->translateException('currency.limit_time')
            );
        }

        return $this->serializer->deserializeJson($response, CurrencyConvertResponseDto::class);
    }
}