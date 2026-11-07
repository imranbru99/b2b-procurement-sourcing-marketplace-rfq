<?php

namespace App\Modules\Platform\Helpdesk\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\Helpdesk\Database\Factories\SlaPolicyFactory;
use App\Models\Concerns\BelongsToOrganization;
use ImranDev\UniversalSlug\Attributes\Slug;
use ImranDev\UniversalSlug\Traits\HasUniversalSlug;

#[Slug(from: 'name')]
class SlaPolicy extends Model
{
    use HasFactory, BelongsToOrganization, HasUniversalSlug;

    protected $table = 'helpdesk_sla_policies';

    protected $guarded = [];

    protected static function newFactory(): SlaPolicyFactory
    {
        return SlaPolicyFactory::new();
    }
}
