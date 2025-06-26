<?php

namespace App\Core\StateMachine;

use App\Core\StateMachine\Contract\StateInterface;
use App\Core\StateMachine\Contract\TransactionInterface;
use App\Core\StateMachine\Contract\StateMachineInterface;

class StateMachine implements StateMachineInterface
{
  public function __construct(
    private readonly string $name,
    private readonly StateInterface $initialState,
    private readonly array $transactions,
  )
  {
    foreach ($transactions as $transaction) {
      if (!$transaction instanceof StateInterface) {
        throw new \InvalidArgumentException("Transaction must be an instance of ". StateInterface::class);
      }
    }
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function can(TransactionInterface $transaction, StateInterface $nextState): bool
  {
    foreach ($this->transactions as $transaction) {
      $toStates = $transaction->getToStates();
      foreach ($toStates as $toState) {
        if ($toState === $nextState) {
          return true;
        }
      }
    }

    return false;
  }

  public function apply(TransactionInterface $transaction, StateInterface $nextState): void
  {
    if (!$this->can($transaction, $nextState)) {
      return;
    }

    $transaction->commit($nextState);
  }
}
