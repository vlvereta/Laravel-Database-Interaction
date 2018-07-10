<?php

namespace Tests\Task0;

use App\Requests\CreateCurrencyRequest;
use App\Services\CurrencyServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Task0Test extends TestCase
{
    use RefreshDatabase;

    private $currencyService;

    protected function setUp()
    {
        parent::setUp();

        $this->currencyService = $this->app->make(CurrencyServiceInterface::class);
    }

    public function test_create()
    {
        $currency = $this->currencyService->create(
            new CreateCurrencyRequest(
                'bitcoin'
            )
        );

        $this->assertNotNull($currency->id);
        $this->assertEquals('bitcoin', $currency->name);
    }
}