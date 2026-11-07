<?php

namespace App\Modules\Intelligence\AiAssistant\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\User;
use App\Modules\Intelligence\AiAssistant\Database\Factories\AiUsageLogFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiUsageLog extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'ai_usage_logs';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'meta' => 'array',
            'cost_usd' => 'decimal:6',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory(): AiUsageLogFactory
    {
        return AiUsageLogFactory::new();
    }
}
