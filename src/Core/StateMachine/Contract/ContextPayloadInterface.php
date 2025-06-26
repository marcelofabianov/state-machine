<?php

namespace App\Core\StateMachine\Contract;

interface ContextPayloadInterface
{
  public function setStatus(StateInterface $state): void;
}
