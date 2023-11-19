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

    #[Route('/currencies', name: 'app_currencies')]
    public function index(): JsonResponse
    {   
        $currencyResponse = $this->currencyConvertService->getCurrencyResponse();
     
        return $this->json(['currencies' => $currencyResponse->currencies]);
    }
}
