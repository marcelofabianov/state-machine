<?php

namespace App\Core\StateMachine\Contract;

interface ActionInterface
{
  public function getName(): string;

  public function execute(): void;
}
