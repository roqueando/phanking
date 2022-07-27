<?php

namespace Test\User;

use PHPUnit\Framework\TestCase;
use Phanking\Actions\User\Add;

final class AddTest extends TestCase
{
    public function testShouldCreateAnUser(): void
    {
        $user = (new Add(name: "John Doe", initialCurrency: "brl"))->call();
        $balance = $user->getBalance(currency: "brl");

        $this->assertEquals("John Doe", $user->getName());
        $this->assertEquals(0.0, $balance->amount);
    }
}
