<?php

namespace Domain\Subscriber\Enums;

enum SubscriberStatus: string
{
    case InProgress = 'in_progress';
    case Completed = 'completed';
}
