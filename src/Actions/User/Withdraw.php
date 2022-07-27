<?php

namespace Phanking\Actions\User;

use Exception;
use Phanking\Entities\User;
use Phanking\Infra\Bank;
use Phanking\ValueObjects\Currency;

final class Withdraw
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
        if ($this->hasSufficientAmount($balance)) {
            $currency = $user->setCurrency(type: $this->currency, amount: $balance->amount - $this->amount);
        } else {
            throw new Exception("Insufficient funds");
        }

        Bank::getInstance()->updateUser(userName: $this->user, resource: $user);
        return $currency;
    }

    /**
    Check if that balance has sufficient amount to withdraw
    @param Currency $balance
    @returns bool
    **/
    private function hasSufficientAmount(Currency $balance): bool
    {
        return $balance->amount >= $this->amount;
    }
}
