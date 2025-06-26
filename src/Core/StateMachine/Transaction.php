<?php

namespace App\Core\StateMachine;

use App\Core\StateMachine\Contract\RuleInterface;
use App\Core\StateMachine\Contract\StateInterface;
use App\Core\StateMachine\Contract\ActionInterface;
use App\Core\StateMachine\Contract\ContextPayloadInterface;
use App\Core\StateMachine\Contract\TransactionInterface;

class Transaction implements TransactionInterface
{
  public function __construct(
    private readonly string $description,
    private readonly array $rules,
    private readonly StateInterface $fromState,
    private readonly array $toStates,
    private readonly ContextPayloadInterface $context,
    private readonly array $beforeTransactionActions = [],
    private readonly array $afterTransactionActions = [],
  ){
    foreach ($rules as $rule) {
      if (! $rule instanceof RuleInterface) {
        throw new \InvalidArgumentException("Rule must be an instance of ". RuleInterface::class);
      }
    }

    foreach ($toStates as $toState) {
      if (! $toState instanceof StateInterface) {
        throw new \InvalidArgumentException("To state must be an instance of ". StateInterface::class);
      }
    }

    if (!empty($this->beforeTransactionActions)) {
      foreach ($beforeTransactionActions as $action) {
        if (!$action instanceof ActionInterface) {
          throw new \InvalidArgumentException("Action must be an instance of ". ActionInterface::class);
        }
        $this->beforeTransactionActions[] = $action;
      }
    }

    if (!empty($this->afterTransactionActions)) {
      foreach ($afterTransactionActions as $action) {
        if (!$action instanceof ActionInterface) {
          throw new \InvalidArgumentException("Action must be an instance of ". ActionInterface::class);
        }
        $this->afterTransactionActions[] = $action;
      }
    }
  }

  public function getBeforeTransactionActions(): array {
    return $this->beforeTransactionActions;
  }

  public function getAfterTransactionActions(): array {
    return $this->afterTransactionActions;
  }

  public function getDescription(): string {
    return $this->description;
  }

  public function getRules(): array {
    return $this->rules;
  }

  public function getFromState(): StateInterface {
    return $this->fromState;
  }

  public function getToStates(): array {
    return $this->toStates;
  }

  public function commit(StateInterface $nextState): ContextPayloadInterface
  {
    $this->context->setStatus($nextState);
    return $this->context;
  }
}
