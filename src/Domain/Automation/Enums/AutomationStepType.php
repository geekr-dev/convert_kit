<?php

namespace Domain\Automation\Enums;

enum AutomationStepType: string
{
    case EVENT = 'event';
    case ACTION = 'action';
}
