<?php

namespace Phanking\Entities;

use Phanking\ValueObjects\Currency;

final class User
{
  protected array $balances;
  protected string $id;

  public function __construct(
    protected string $name,
    public string $currency
  ) {
    $this->id = uniqid();
    $this->balances[] = new Currency(type: $this->currency, amount: (float) 0.0);
  }

  public function getId(): string
  {
    return $this->id;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getBalance(string $currency): Currency
  {
    $filtered = array_filter($this->balances, fn ($item) => $item->type == $currency);
    $balance = array_shift($filtered);
    return $balance;
  }

  public function setCurrency(string $type, float $amount): Currency
  {
    $currency = $this->getBalance($type);
    $balanceIndex = array_search($currency, $this->balances);
    $currency->amount = $amount;
    $this->balances[$balanceIndex] = $currency;

    return $this->balances[$balanceIndex];
  }
}
