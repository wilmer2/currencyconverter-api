<?php

namespace App\Dto;

class CurrencyResponseErrorDto {
    public bool $success;
	public array $error;

    public function getError()
    {
        return $this->error;
    }

    public function getCode(): ?int
    {
        $error = $this->getError();
        
        return $error['code'] ?? null;
    }

    public function getInfo(): ?string
    {
        $error = $this->getError();

        return $error['info'] ?? null;
    }
}