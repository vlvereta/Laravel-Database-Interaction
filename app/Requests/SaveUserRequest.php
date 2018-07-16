<?php

namespace App\Requests;

class SaveUserRequest
{
    private $id;

    private $name;

    private $email;

    public function __construct($id, string $name, string $email) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
