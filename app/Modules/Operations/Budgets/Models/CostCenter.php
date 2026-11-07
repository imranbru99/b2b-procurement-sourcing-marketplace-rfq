<?php

namespace App\Modules\Operations\Budgets\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Operations\Budgets\Database\Factories\CostCenterFactory;

class CostCenter extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'cost_centers';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
);
    }

    protected static function newFactory(): CostCenterFactory
    {
        return CostCenterFactory::new();
    }
}
