<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CurrencyConvertService;
use App\Dto\CurrencyConvertRequestDto;
use App\Dto\GuestIdRequestDto;
use App\Service\GuestService;
use App\Service\UserService;


class CurrencyConvertController extends AbstractController
{   
    private $currencyConvertService;
    private $guestService;
    private $userService;

    public function __construct(
        CurrencyConvertService $currencyConvertService, 
        GuestService $guestService,
        UserService $userService 
    ) {
        $this->currencyConvertService = $currencyConvertService;
        $this->guestService = $guestService;
        $this->userService = $userService;
    }

    #[Route('api/currencies', name: 'app_currencies')]
    public function index(): JsonResponse
    {   
        $currencyResponse = $this->currencyConvertService->getCurrencyResponse();
     
        return $this->json(['currencies' => $currencyResponse->currencies]);
    }


    #[Route('api/currencies/convert', name: 'app_currencies_convert')]
    public function convert(Request $request): JsonResponse
    {   
        $user = $this->userService->getCurrentUser();
        $currencyConvertRequestDto = new CurrencyConvertRequestDto($request);
        $guestIdRequestDto = new GuestIdRequestDto($request, $user);

        $this->guestService->trackGuest($guestIdRequestDto, $user);

        $convertResponse = $this->currencyConvertService->getConvert($currencyConvertRequestDto);

        return $this->json(['result' => $convertResponse->result]);
    }
}
