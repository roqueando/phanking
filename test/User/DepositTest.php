<?php

namespace Test\User;

use PHPUnit\Framework\TestCase;
use Phanking\Actions\User\Deposit;
use Phanking\Entities\User;
use Phanking\Infra\Bank;
use Phanking\ValueObjects\Currency;

final class DepositTest extends TestCase
{
    public User $user;
    public function setUp(): void
    {
        parent::setUp();
        $this->user = new User(name: "User Deposit", currency: "brl");
        Bank::getInstance()->createUser($this->user);
    }

    public function testShouldDepositAmount(): void
    {
        $deposit = (new Deposit(user: $this->user->getName(), amount: 30.0, currency: "brl"))->call();

        $this->assertInstanceOf(Currency::class, $deposit);
        $this->assertEquals(30.0, $deposit->amount);
        $this->assertEquals("brl", $deposit->type);
    }
}
