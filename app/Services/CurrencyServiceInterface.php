<?php

namespace App\Services;

use App\Entity\Currency;
use App\Requests\CreateCurrencyRequest;

interface CurrencyServiceInterface
{
    public function create(CreateCurrencyRequest $request): Currency;
}