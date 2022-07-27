<?php

namespace Test\User;

use PHPUnit\Framework\TestCase;
use Phanking\Actions\User\Deposit;
use Phanking\Actions\User\Withdraw;
use Phanking\Entities\User;
use Phanking\Infra\Bank;
use Phanking\ValueObjects\Currency;
use Exception;

final class WithdrawTest extends TestCase
{
    public User $user;
    public function setUp(): void
    {
        parent::setUp();
        $this->user = new User(name: "User Deposit", currency: "brl");
        Bank::getInstance()->createUser($this->user);
        $this->depositValue(amount: 30.0, currency: "brl");
    }

    public function testShouldWithdrawAmount(): void
    {
        $withdraw = (new Withdraw(user: $this->user->getName(), amount: 15.0, currency: "brl"))->call();

        $this->assertInstanceOf(Currency::class, $withdraw);
        $this->assertEquals(15.0, $withdraw->amount);
        $this->assertEquals("brl", $withdraw->type);
     }
    
     

    public function testShouldNotWithdrawAmountWithInsufficientFunds(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Insufficient funds");

        $newUser = new User(name: "New User", currency: "brl");
        Bank::getInstance()->createUser($newUser);
        (new Withdraw(user: $newUser->getName(), amount: 15.0, currency: "brl"))->call();
    }

    private function depositValue(float $amount, string $currency): void
    {
        (new Deposit(user: $this->user->getName(), amount: $amount, currency: $currency))
            ->call();
    }
}
