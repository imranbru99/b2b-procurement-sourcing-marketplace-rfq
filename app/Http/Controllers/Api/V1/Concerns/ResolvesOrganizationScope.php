<?php

namespace App\Http\Controllers\Api\V1\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait ResolvesOrganizationScope
{
    protected function scopedQuery(string $modelClass): Builder
    {
        $query = $modelClass::query();

        if ($orgId = auth()->user()?->current_organization_id) {
            $query->withoutGlobalScope('organization')
                ->where($query->getModel()->getTable().'.organization_id', $orgId);
        }

        return $query;
    }
}
