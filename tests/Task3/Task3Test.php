<?php

namespace Tests\Task3;

use App\Requests\CreateCurrencyRequest;
use App\Requests\CreateMoneyRequest;
use App\Requests\CreateWalletRequest;
use App\Requests\SaveUserRequest;
use App\Services\CurrencyServiceInterface;
use App\Services\MoneyServiceInterface;
use App\Services\UserServiceInterface;
use App\Services\WalletServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Task3Test extends TestCase
{
    use RefreshDatabase;

    private $moneyService;
    private $currencyService;
    private $walletService;
    private $userService;

    protected function setUp()
    {
        parent::setUp();

        $this->moneyService = $this->app->make(MoneyServiceInterface::class);
        $this->currencyService = $this->app->make(CurrencyServiceInterface::class);
        $this->walletService = $this->app->make(WalletServiceInterface::class);
        $this->userService = $this->app->make(UserServiceInterface::class);
    }

    public function test_create()
    {
        $user = $this->userService->save(
            new SaveUserRequest(
                null,
                'Alex Black',
                'black@gmail.com'
            )
        );

        $currency = $this->currencyService->create(
            new CreateCurrencyRequest(
                'bitcoin'
            )
        );

        $wallet = $this->walletService->create(
            new CreateWalletRequest(
                $user->id
            )
        );

        $money = $this->moneyService->create(
            new CreateMoneyRequest(
                $currency->id,
                $wallet->id,
                100
            )
        );

        $this->assertNotNull($money->id);
        $this->assertEquals($money->currency_id, $currency->id);
        $this->assertEquals($money->wallet_id, $wallet->id);
        $this->assertEquals($money->amount, 100);
    }

    public function test_max_amount()
    {
        $user = $this->userService->save(
            new SaveUserRequest(
                null,
                'Alex Black',
                'black@gmail.com'
            )
        );

        $currency = $this->currencyService->create(
            new CreateCurrencyRequest(
                'bitcoin'
            )
        );

        $wallet = $this->walletService->create(
            new CreateWalletRequest(
                $user->id
            )
        );

        $this->moneyService->create(
            new CreateMoneyRequest(
                $currency->id,
                $wallet->id,
                100
            )
        );

        $this->moneyService->create(
            new CreateMoneyRequest(
                $currency->id,
                $wallet->id,
                200
            )
        );

        $this->assertEquals(200, $this->moneyService->maxAmount());
    }
}