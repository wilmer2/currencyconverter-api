<?php

namespace App\Dto;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GuestIdRequestDto {
    private string $guestId;
    
    public function __construct(Request $request) {
        $this->setGuestId($request->headers->get('X-Guest-ID'));
        $this->validateData();
    }

    private function validateData()
    {
        if (empty($this->guestId) || strlen($this->guestId) < 4 || !is_string($this->guestId)) {
            throw new HttpException(400, 'X-Guest-ID is required and must be at least 4 characters long');
        }
    }

    public function setGuestId($value)
    {
        $this->guestId = $value;
    }

    public function getGuestId()
    {
        return $this->guestId;
    }
}