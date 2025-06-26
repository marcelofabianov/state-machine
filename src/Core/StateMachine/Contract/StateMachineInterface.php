<?php

namespace App\Core\StateMachine\Contract;

interface StateMachineInterface
{
  public function getName(): string;

  public function can(TransactionInterface $transaction, StateInterface $nextState): bool;

  public function apply(TransactionInterface $transaction, StateInterface $nextState): void;
}
