<?php

namespace Phanking\Actions\User;

use Phanking\Entities\User;
use Phanking\Infra\Bank;

final class Add
{
    public function __construct(
        protected string $name,
        protected string $initialCurrency,
    ) {
    }

    public function call(): User
    {
        $user = new User(name: $this->name, currency: $this->initialCurrency);

        Bank::getInstance()->createUser($user);
        return $user;
    }
}
