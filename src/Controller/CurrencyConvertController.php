<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CurrencyConvertService;


class CurrencyConvertController extends AbstractController
{   
    private $currencyConvertService;
    
    public function __construct(CurrencyConvertService $currencyConvertService) {
        $this->currencyConvertService = $currencyConvertService;
    }

    #[Route('/currency/convert', name: 'app_currency_convert')]
    public function index(): JsonResponse
    {   

        // var_dump(
        //     $this->currencyConvertService->getCurrencies()
        // );
        // var_dump($response->getContent());
        $response = $this->currencyConvertService->getCurrencies();
     
        
        return $this->json([
            'message' => 'Welcome to your new controller!'. $_ENV['CURRENCYLAYER_ACCESSKEY'],
            'path' => 'src/Controller/CurrencyConvertController.php',
        ]);
    }
}
