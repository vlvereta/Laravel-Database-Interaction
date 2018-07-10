<?php

namespace App\Requests;

class CreateWalletRequest
{
    private $userId;

    public function __construct(int $id) {
    	$this->userId = $id;
    }

    public function getUserId(): int
    {
    	return $this->userId;
    }
}

