<?php

namespace App\Adapter;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CurrencyConvertAdapter
{   
    private $client;
    
    public function __construct(HttpClientInterface $client) 
    {   
        $accessKey = $_ENV['CURRENCYLAYER_ACCESSKEY'];

        $this->client = $client->withOptions([
            'base_uri' => 'http://api.currencylayer.com/',
            'query' => [
                'access_key' => $accessKey
            ]
        ]);
    }

    public function getCurrencies()
    {
        $response = $this->client->request(
            'GET',
            'list'
        );

        return $response->getContent();
    }
}