<?php

namespace App\Modules\Sourcing\SupplierInvitations\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierBroadcastProfile extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'supplier_broadcast_profiles';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'certifications' => 'array',
            'min_rating' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    protected static function newFactory(): \App\Modules\Sourcing\SupplierInvitations\Database\Factories\SupplierBroadcastProfileFactory
    {
        return \App\Modules\Sourcing\SupplierInvitations\Database\Factories\SupplierBroadcastProfileFactory::new();
    }
}
