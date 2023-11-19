<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

use App\Adapter\CurrencyConvertAdapter;
use App\Adapter\SerializeAdapter;
use App\Dto\CurrencyResponseDto;
use App\Dto\CurrencyResponseErrorDto;

use Symfony\Component\HttpKernel\Exception\HttpException;


class CurrencyConvertService
{   
    private $client;
    private $serializer;
    private $currencyErrorService;
    
    
    public function __construct(
        CurrencyConvertAdapter $client, 
        SerializeAdapter $serializer,
        CurrencyConvertErrorService $currencyErrorService
    ) 
    {   
        $this->client = $client;
        $this->serializer = $serializer;
        $this->currencyErrorService = $currencyErrorService;
    }

    public function getCurrencies()
    {   
        $response = $this->client->getCurrencies();
        $jsonResponse = json_decode($response);

        if (!$jsonResponse->success) {
            $currencyErrorDto = $this->serializer->deserializeJson($response, CurrencyResponseErrorDto::class);
            $this->currencyErrorService->handleError($currencyErrorDto);
        } 
        
        $currencyResponseDto = $this->serializer->deserializeJson($response, CurrencyResponseDto::class);
        
        return $currencyResponseDto;
    }
}