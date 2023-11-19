<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

use App\Adapter\CurrencyConvertAdapter;
use App\Adapter\SerializeAdapter;
use App\Dto\CurrencyResponseDto;
use App\Dto\CurrencyResponseErrorDto;
use App\Exception\CurrencyConvertException;

class CurrencyConvertService
{   
    private $client;
    private $serializer;
    
    
    public function __construct(CurrencyConvertAdapter $client, SerializeAdapter $serializer) 
    {   
        $this->client = $client;
        $this->serializer = $serializer;
    }

    public function getCurrencies()
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
}