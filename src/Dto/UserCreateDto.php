<?php

namespace App\Dto;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;


class UserCreateDto {
    private  $email;
    private  $password;

    public function __construct(Request $request)
    {
        $payload = json_decode($request->getContent(), false);

        if ($payload === null) {
            throw new HttpException(400, 'Invalid JSON payload');
        }

        $this->setEmail(isset($payload->email) ? $payload->email : null);
        $this->setPassword(isset($payload->password) ? $payload->password : null);
    }

    public function setEmail($value)
    {
        $this->email = $value ? trim($value) : '';
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($value)
    {
        $this->password = $value ?? '';
    }
}