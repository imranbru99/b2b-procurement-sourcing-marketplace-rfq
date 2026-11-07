<?php

namespace App\Modules\Suppliers\LeadsAdvertising\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Suppliers\LeadsAdvertising\Database\Factories\LeadUnlockFactory;

class LeadUnlock extends Model
{
    /** @use HasFactory<LeadUnlockFactory> */
    use HasFactory;

    protected $table = 'lead_unlocks';

    protected $guarded = [];

    protected static function newFactory(): LeadUnlockFactory
    {
        return LeadUnlockFactory::new();
    }


    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
            'variants' => 'array',
            'filters' => 'array',
            'theme' => 'array',
            'seo' => 'array',
            'checklist' => 'array',
            'responses' => 'array',
            'dimensions' => 'array',
            'factors' => 'array',
            'is_active' => 'boolean',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'is_verified' => 'boolean',
            'is_primary' => 'boolean',
            'notify_on_match' => 'boolean',
            'requires_lead_unlock' => 'boolean',
        ];
    }
}
