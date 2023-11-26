<?php

namespace App\Dto;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GuestIdRequestDto {
    private $guestId;
    
    public function __construct(Request $request) {
        $this->setGuestId($request->headers->get('X-Guest-ID'));
    }

    public function setGuestId($value)
    {
        $this->guestId = $value ? trim($value) : '';
    }

    public function getGuestId()
    {
        return $this->guestId;
    }
}