<?php

namespace App\Dto;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;



class CurrencyConvertRequestDto {
    private $amount;
    private  $from;
    private $to;
    
    public function __construct(Request $request)
    {
        $this->setAmount($request->get('amount'));
        $this->setFrom($request->get('from'));
        $this->setTo($request->get('to'));

        $this->validateData();
    }

    private function validateData()
    {
        if (!is_numeric($this->amount) || $this->amount < 0 ) {
            throw new HttpException(400, 'amount is required and must be a valid value');
        }

        if (empty($this->to) || !is_string($this->to) ) {
            throw new HttpException(400, 'to is required and must be a valid value');
        }

        if (empty($this->from) || !is_string($this->from) ) {
            throw new HttpException(400, 'from is required and must be a valid value');
        }
    }

    public function setAmount($value)
    {   
        if (is_string($value) && preg_match('/^-?[0-9]+$/', $value)) {
            $this->amount = (int) $value;
        } else {
            $this->amount = $value;
        }
    }

    public function getAmount()
    {
        return $this->amount;
    }


    public function setFrom($value)
    {   
        $this->from = $value;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function setTo($to)
    {   
        $this->to = $to;
    }

    public function getTo()
    {
        return $this->to;
    }

}