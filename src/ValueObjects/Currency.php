<?php

namespace Phanking\ValueObjects;

use Exception;

class Currency
{
  public function __construct(
    public string $type,
    public float $amount
  ) {
    if (!$this->validate()) {
      throw new Exception("Error on creating currency");
    }
  }

  private function validate(): bool
  {
    return
      is_numeric($this->amount) && $this->amount >= 0.0;
  }
}
