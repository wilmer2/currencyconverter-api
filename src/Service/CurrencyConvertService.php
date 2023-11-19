<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

use App\Adapter\CurrencyConvertAdapter;
use App\Adapter\SerializeAdapter;
use App\Dto\CurrencyResponseDto;
use App\Dto\CurrencyResponseErrorDto;
use App\Exception\CurrencyConvertException;
use App\Dto\CurrencyConvertRequestDto;
use App\Dto\CurrencyConvertResponseDto;


class CurrencyConvertService
{   
    private $client;
    private $serializer;
    
    
    public function __construct(CurrencyConvertAdapter $client, SerializeAdapter $serializer) 
    {   
        $this->client = $client;
        $this->serializer = $serializer;
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

    public function getConvert(CurrencyConvertRequestDto $currencyConertRequestDto)
    {
        $response = $this->client->getConvert(
            $currencyConertRequestDto->getTo(),
            $currencyConertRequestDto->getFrom(),
            $currencyConertRequestDto->getAmount(),
        );

        $jsonResponse = json_decode($response);

        if (!$jsonResponse->success) {
            $currencyErrorDto = $this->serializer->deserializeJson($response, CurrencyResponseErrorDto::class);
            throw new CurrencyConvertException($currencyErrorDto);
        }

        $convertResponseDto = $this->serializer->deserializeJson($response, CurrencyConvertResponseDto::class);

        return $convertResponseDto;
    }
}