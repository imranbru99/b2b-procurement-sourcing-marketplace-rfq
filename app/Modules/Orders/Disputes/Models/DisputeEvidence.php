<?php

namespace App\Modules\Orders\Disputes\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Orders\Disputes\Database\Factories\DisputeEvidenceFactory;

class DisputeEvidence extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'dispute_evidence';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
);
    }

    protected static function newFactory(): DisputeEvidenceFactory
    {
        return DisputeEvidenceFactory::new();
    }
}
