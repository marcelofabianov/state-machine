<?php

namespace App\Core\StateMachine\Contract;

use App\Core\StateMachine\EnforcementModeEnum;

interface TransactionOperatorInterface
{
  public function apply(TransactionInterface $transaction, StateInterface $nextState, EnforcementModeEnum $mode = false): void;
}
