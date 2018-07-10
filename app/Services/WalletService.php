<?php

namespace App\Services;

use App\Entity\Currency;
use App\Entity\Money;
use Illuminate\Support\Collection;
use App\Entity\Wallet;
use App\Requests\CreateWalletRequest;

class WalletService implements WalletServiceInterface
{
    public function findByUser(int $userId): ?Wallet
    {
        return Wallet::where('user_id', $userId)->first();
    }

    public function create(CreateWalletRequest $request): Wallet
    {
        if (($id = $request->getUserId()) && $this->findByUser($id))
            throw new \LogicException('Only one wallet for every \'user_id\' possible!');
        $wallet = new Wallet();
        $wallet->setAttribute('user_id', $request->getUserId());
        $wallet->save();
        return $wallet;
    }

    public function findCurrencies(int $walletId): Collection
    {
        $currency = array();
        $wallet = Money::where('wallet_id', $walletId)->get();
        foreach ($wallet as $w) {
            $currency[] = Currency::find($w->currency_id);
        }
        return collect($currency);
    }
}
