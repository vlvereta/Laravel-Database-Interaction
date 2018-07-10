<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Entity\User;
use App\Requests\SaveUserRequest;

class UserService implements UserServiceInterface
{
    public function findAll(): Collection
    {
        return User::all();
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function save(SaveUserRequest $request): User
    {
        if (!($id = $request->getId()) || !($user = $this->findById($id)))
            $user = new User();
        $user->setAttribute('name', $request->getName());
        $user->setAttribute('email', $request->getEmail());
        $user->save();
        return $user;
    }

    public function delete(int $id): void
    {
        if ($id && ($user = $this->findById($id)))
            User::destroy($id);
    }
}