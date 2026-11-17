<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case SYNCED = 'synced';
    case FAILED = 'failed';
}
