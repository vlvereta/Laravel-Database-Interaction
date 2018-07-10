<?php

namespace App\Services;

use App\Entity\Money;
use App\Requests\CreateMoneyRequest;

class MoneyService implements MoneyServiceInterface
{
    public function create(CreateMoneyRequest $request): Money
    {
        $money = new Money();
        $money->currency_id = $request->getCurrencyId();
        $money->wallet_id = $request->getWalletId();
        $money->amount = $request->getAmount();
        $money->save();
        return $money;
    }

    public function maxAmount(): float
    {
        return Money::max('amount');
    }
}