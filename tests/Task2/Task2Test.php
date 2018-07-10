<?php

namespace Tests\Unit;

use App\Entity\Currency;
use App\Requests\CreateCurrencyRequest;
use App\Requests\CreateMoneyRequest;
use App\Requests\SaveUserRequest;
use App\Services\CurrencyServiceInterface;
use App\Services\MoneyServiceInterface;
use App\Services\UserServiceInterface;
use App\Services\WalletServiceInterface;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Requests\CreateWalletRequest;

class Task2Test extends TestCase
{
    use RefreshDatabase;

    private $walletService;
    private $userService;
    private $moneyService;
    private $currencyService;

    protected function setUp()
    {
        parent::setUp();

        $this->walletService = $this->app->make(WalletServiceInterface::class);
        $this->userService = $this->app->make(UserServiceInterface::class);
        $this->moneyService = $this->app->make(MoneyServiceInterface::class);
        $this->currencyService = $this->app->make(CurrencyServiceInterface::class);
    }

    public function test_instance()
    {
        $this->assertInstanceOf(
            WalletServiceInterface::class,
            $this->app->make(WalletServiceInterface::class)
        );
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

        $wallet = $this->walletService->create(
            new CreateWalletRequest(
                $user->id
            )
        );

        $this->assertNotNull($wallet->id);
        $this->assertEquals($wallet->user_id, $user->id);
    }

    public function test_create_duplicate()
    {
        $user = $this->userService->save(
            new SaveUserRequest(
                null,
                'Alex Black',
                'black@gmail.com'
            )
        );

        $this->walletService->create(
            new CreateWalletRequest(
                $user->id
            )
        );

        $this->expectException(\LogicException::class);

        $this->walletService->create(
            new CreateWalletRequest(
                $user->id
            )
        );
    }

    public function test_find_by_user()
    {
        $user = $this->userService->save(
            new SaveUserRequest(
                null,
                'Alex Black',
                'black@gmail.com'
            )
        );

        $this->walletService->create(
            new CreateWalletRequest(
                $user->id
            )
        );

        $wallet = $this->walletService->findByUser($user->id);

        $this->assertNotNull($wallet);
        $this->assertNotNull($wallet->id);
        $this->assertEquals($user->id, $wallet->user_id);
    }

    public function test_find_by_user_not_found()
    {
        $wallet = $this->walletService->findByUser(9999);

        $this->assertNull($wallet);
    }

    public function test_find_currencies()
    {
        $user = $this->userService->save(
            new SaveUserRequest(
                null,
                'Alex Black',
                'black@gmail.com'
            )
        );

        $wallet = $this->walletService->create(
            new CreateWalletRequest(
                $user->id
            )
        );

        $currency = $this->currencyService->create(
            new CreateCurrencyRequest(
                'bitcoin'
            )
        );

        $this->moneyService->create(
            new CreateMoneyRequest(
                $currency->id,
                $wallet->id,
                100
            )
        );

        $currencies = $this->walletService->findCurrencies($wallet->id);

        $this->assertTrue($currencies->isNotEmpty());

        $search = $currencies->first();

        $this->assertInstanceOf(Currency::class, $search);
        $this->assertEquals('bitcoin', $search->name);
    }
}
