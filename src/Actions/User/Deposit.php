<?php

namespace Phanking\Actions\User;

use Phanking\Entities\User;
use Phanking\Infra\Bank;
use Phanking\ValueObjects\Currency;

final class Deposit
{
    public function __construct(
        protected string $user,
        protected float $amount,
        protected string $currency,
    ) {
    }

    public function call(): Currency
    {
        /** @var User $user */
        $user = Bank::getInstance()->getUser($this->user);
        $balance = $user->getBalance($this->currency);
        $currency = $user->setCurrency(type: $this->currency, amount: $balance->amount + $this->amount);

        // will store that user in our Bank state
        Bank::getInstance()->updateUser(userName: $this->user, resource: $user);
        return $currency;
    }
}
