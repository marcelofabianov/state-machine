<?php

namespace App\Core\StateMachine;

enum EnforcementModeEnum: string
{
  case STRICT = 'strict';
  case PERMISSIVE = 'permissive';
}
