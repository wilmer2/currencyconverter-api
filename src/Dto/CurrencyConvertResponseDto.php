<?php

namespace App\Dto;

class CurrencyConvertResponseDto 
{
	public bool $success;
	public string $terms;
	public string $privacy;
	public Query $query;
	public Info $info;
	public float $result;

	public function __construct(
		bool $success,
		string $terms,
		string $privacy,
		Query $query,
		Info $info,
		float $result
	) {
		$this->success = $success;
		$this->terms = $terms;
		$this->privacy = $privacy;
		$this->query = $query;
		$this->info = $info;
		$this->result = $result;
	}
}

class Query
{
	public string $from;
	public string $to;
	public int $amount;

	public function __construct(
		string $from,
		string $to,
		int $amount
	) {
		$this->from = $from;
		$this->to = $to;
		$this->amount = $amount;
	}
}

class Info
{
	public int $timestamp;
	public float $quote;

	public function __construct(int $timestamp, float $quote)
	{
		$this->timestamp = $timestamp;
		$this->quote = $quote;
	}
}