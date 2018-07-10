<?php

namespace App\Services;

use App\Entity\Currency;
use App\Requests\CreateCurrencyRequest;

class CurrencyService implements CurrencyServiceInterface
{
    public function create(CreateCurrencyRequest $request): Currency
    {
        $currency = new Currency();
        $currency->name = $request->getName();
        $currency->save();
        return $currency;
    }
}