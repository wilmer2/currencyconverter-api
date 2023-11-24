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

        $this->setEmail($payload->email);
        $this->setPassword($payload->password);
        $this->validateData();
    }

    private function validateData()
    {
        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL) ) {
            throw new HttpException(400, 'email is required and must be a valid value');

        }

        if (empty($this->password) || strlen($this->password) < 8|| !is_string($this->password) ) {
            throw new HttpException(400, 'password is required and must be at least 8 characters long');
        }
    }



    public function setEmail($value)
    {
        $this->email = trim($value);
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
        $this->password = $value;
    }
}