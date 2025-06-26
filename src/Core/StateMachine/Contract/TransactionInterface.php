<?php

namespace App\Core\StateMachine\Contract;

interface TransactionInterface
{
  public function getDescription(): string;

  public function getRules(): array;

  public function getFromState(): StateInterface;

  public function getToState(): StateInterface;

  public function getBeforeTransactionActions(): array;

  public function getAfterTransactionActions(): array;
}
