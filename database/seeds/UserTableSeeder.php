<?php

use App\Entity\User;
use App\Entity\Money;
use App\Entity\Wallet;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 10)->create()->each(
            function ($user) {
                factory(Wallet::class)->create(['user_id' => $user->id]);
            }
        );
    }
}
