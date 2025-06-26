<?php

namespace App\Core\StateMachine\Contract;

interface TransactionInterface
{
  public function getDescription(): string;

  public function getRules(): array;

  public function getFromState(): StateInterface;

  public function getToStates(): array;

  public function getBeforeTransactionActions(): array;

  public function getAfterTransactionActions(): array;

  public function commit(StateInterface $nextState): ContextPayloadInterface;
}
