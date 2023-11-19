<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CurrencyConvertService;
use App\Dto\CurrencyConvertRequestDto;


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


    #[Route('/currencies/convert', name: 'app_currencies_convert')]
    public function convert(Request $request): JsonResponse
    {   
        $currencyConvertRequestDto = new CurrencyConvertRequestDto($request);
        $convertResponse = $this->currencyConvertService->getConvert($currencyConvertRequestDto);
     
        return $this->json(['result' => $convertResponse->result]);
    }
}
