<?php

namespace App\Models;

use App\Enums\SyncAttemptStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SyncAttempt extends Model
{
    protected $fillable = [
        'order_id',
        'integration_id',
        'attempt_number',
        'status',
        'request_payload',
        'response_payload',
        'error_message',
        'started_at',
        'finished_at',
    ];

    protected function casts(): array
    {
        return [
            'attempt_number' => 'integer',
            'status' => SyncAttemptStatus::class,
            'request_payload' => 'array',
            'response_payload' => 'array',
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function integration(): BelongsTo
    {
        return $this->belongsTo(Integration::class);
    }
}
