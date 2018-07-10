<?php

namespace Tests\Unit;

use App\Requests\SaveUserRequest;
use App\Services\WalletServiceInterface;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\UserServiceInterface;
use App\Entity\User;

class Task1Test extends TestCase
{
    use RefreshDatabase;

    private $userService;
    private $walletService;

    protected function setUp()
    {
        parent::setUp();

        $this->userService = $this->app->make(UserServiceInterface::class);
        $this->walletService = $this->app->make(WalletServiceInterface::class);
    }

    public function test_instance()
    {
        $this->assertInstanceOf(
            UserServiceInterface::class,
            $this->app->make(UserServiceInterface::class)
        );
    }

    public function test_save()
    {
        $user = $this->userService->save(
            new SaveUserRequest(
                null,
                'John Smith',
                'smith@gmail.com'
            )
        );
        
        $this->assertNotNull($user->id);
        $this->assertEquals('John Smith', $user->name);
        $this->assertEquals('smith@gmail.com', $user->email);

        $userUpdated = $this->userService->save(
            new SaveUserRequest(
                $user->id,
                'David Black',
                'black@gmail.com'
            )
        );

        $search = $this->userService->findById($user->id);

        $this->assertNotNull($search);
        $this->assertEquals($userUpdated->toArray(), $search->toArray());
    }

    public function test_find_all()
    {
        $userF = $this->userService->save(
            new SaveUserRequest(
                null,
                'John Smith',
                'smith@gmail.com'
            )
        );

        $userS = $this->userService->save(
            new SaveUserRequest(
                null,
                'Alex Black',
                'black@gmail.com'
            )
        );

        $collection = $this->userService->findAll();

        $this->assertTrue($collection->isNotEmpty());

        foreach ($collection as $item) {
            $this->assertInstanceOf(User::class, $item);
        }

        $this->assertEquals($collection->first()->toArray(), $userF->toArray());
        $this->assertEquals($collection->last()->toArray(), $userS->toArray());
    }

    public function test_find_by_id()
    {
        $user = $this->userService->save(
            new SaveUserRequest(
                null,
                'Alex Black',
                'black@gmail.com'
            )
        );

        $search = $this->userService->findById($user->id);

        $this->assertNotNull($search);
        $this->assertEquals($user->toArray(), $search->toArray());
    }

    public function test_find_by_id_not_found()
    {
        $this->assertNull($this->userService->findById(9999));
    }

    public function test_delete()
    {
        $user = $this->userService->save(
            new SaveUserRequest(
                null,
                'Alex Black',
                'black@gmail.com'
            )
        );

        $this->userService->delete($user->id);

        $this->assertNull($this->userService->findById($user->id));

        $wallet = $this->walletService->findByUser($user->id);

        $this->assertNull($wallet);
    }
}
