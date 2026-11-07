<?php

namespace App\Models\Concerns;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToOrganization
{
    public static function bootBelongsToOrganization(): void
    {
        static::addGlobalScope('organization', function (Builder $builder): void {
            $organizationId = organization_id();

            if ($organizationId === null) {
                return;
            }

            $builder->where(
                $builder->getModel()->qualifyColumn('organization_id'),
                $organizationId
            );
        });

        static::creating(function (Model $model): void {
            if (! $model->getAttribute('organization_id') && organization_id()) {
                $model->setAttribute('organization_id', organization_id());
            }
        });
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
