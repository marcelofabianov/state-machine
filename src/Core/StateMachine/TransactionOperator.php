<?php

namespace App\Core\StateMachine;

use App\Core\StateMachine\EnforcementModeEnum;
use App\Core\StateMachine\Contract\StateInterface;
use App\Core\StateMachine\Contract\TransactionInterface;
use App\Core\StateMachine\Contract\StateMachineInterface;
use App\Core\StateMachine\Contract\TransactionOperatorInterface;

class TransactionOperator implements TransactionOperatorInterface
{
  public function __construct(
    private readonly StateMachineInterface $stateMachine
  ){}

  public function apply(
    TransactionInterface $transaction,
    StateInterface $nextState,
    EnforcementModeEnum $canMode = EnforcementModeEnum::STRICT,
    EnforcementModeEnum $actionMode = EnforcementModeEnum::PERMISSIVE,
  ): void
  {
    if ($canMode == EnforcementModeEnum::STRICT && !$this->stateMachine->can($transaction, $nextState)) {
      throw new \RuntimeException("Transaction is not allowed in current state");
    }
    if ($canMode == EnforcementModeEnum::PERMISSIVE && !$this->stateMachine->can($transaction, $nextState)) {
      return;
    }

    $this->before($transaction, $actionMode);

    $this->stateMachine->apply($transaction, $nextState);

    $this->after($transaction, $actionMode);
  }

  private function before(TransactionInterface $transaction, EnforcementModeEnum $mode): void
  {
    if (!empty($transaction->getBeforeTransactionActions())) {
      return;
    }

    foreach ($transaction->getBeforeTransactionActions() as $action) {
      $action->execute();
    }
  }

  private function after(TransactionInterface $transaction, EnforcementModeEnum $mode): void
  {
    if (!empty($transaction->getAfterTransactionActions())) {
      return;
    }

    foreach ($transaction->getAfterTransactionActions() as $action) {
      $action->execute();
    }
  }
}
