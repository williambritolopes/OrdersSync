<?php

namespace App\Enums;

enum SyncAttemptStatus: string
{
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case FAILED = 'failed';
}
