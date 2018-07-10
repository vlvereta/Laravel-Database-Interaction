<?php

namespace App\Services;

use App\Entity\Money;
use App\Requests\CreateMoneyRequest;

interface MoneyServiceInterface
{
    public function create(CreateMoneyRequest $request): Money;

    public function maxAmount(): float;
}