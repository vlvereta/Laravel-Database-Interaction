<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Entity\User;
use App\Requests\SaveUserRequest;

interface UserServiceInterface
{
    public function findAll(): Collection;

    public function findById(int $id): ?User;

    public function save(SaveUserRequest $request): User;

    public function delete(int $id): void;
}