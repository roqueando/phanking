<?php

namespace Phanking\Infra;

use Phanking\Entities\User;

final class Bank
{
    private static $instance;

    public function __construct(
        protected array $users = []
    ) {
    }

    public static function getInstance(): Bank
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }


    public function getUsers(): array
    {
        return $this->users;
    }

    public function createUser(User $user): User
    {
        $this->users[$this->normalizeUser($user->getName())] = $user;
        return $user;
    }

    public function getUser(string $userName): User
    {
        return $this->users[$this->normalizeUser($userName)];
    }

    public function updateUser(string $userName, User $resource): User
    {
        $normalized = $this->normalizeUser($userName);
        $this->users[$normalized] = $resource;
        return $this->users[$normalized];
    }

    private function normalizeUser(string $userName): string
    {
        $userName = strtolower($userName);
        return preg_replace('/\s+/', '_', $userName);
    }
}
