<?php

namespace App\Core;

use App\Core\StateMachine\Contract\ActionInterface;

class ActionLogger implements ActionInterface
{
  private readonly string $name;

  public function __construct(){
    $this->name = "ActionLogger";
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function execute(): void
  {
    //...
  }
}
