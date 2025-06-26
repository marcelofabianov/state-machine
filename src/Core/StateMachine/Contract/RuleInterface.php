<?php

namespace App\Core\StateMachine\Contract;

interface RuleInterface
{
  public function getName(): string;

  public function isValid(): bool;
}
