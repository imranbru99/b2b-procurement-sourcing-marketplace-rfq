<?php

namespace App\Modules\Orders\Disputes\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Orders\Disputes\Database\Factories\DisputeResolutionFactory;

class DisputeResolution extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'dispute_resolutions';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'resolved_at' => 'datetime',
);
    }

    protected static function newFactory(): DisputeResolutionFactory
    {
        return DisputeResolutionFactory::new();
    }
}
