<?php

namespace App\Dto;

class CurrencyResponseDto {
    public bool $success;
	public string $terms;
	public string $privacy;
    public array $currencies; 
}