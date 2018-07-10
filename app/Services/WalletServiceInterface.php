<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Entity\Wallet;
use App\Requests\CreateWalletRequest;

interface WalletServiceInterface
{
    public function findByUser(int $userId): ?Wallet;

    public function create(CreateWalletRequest $request): Wallet;

    public function findCurrencies(int $walletId): Collection;
}