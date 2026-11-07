<?php

namespace App\Modules\Operations\Budgets\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Operations\Budgets\Database\Factories\BudgetAlertFactory;

class BudgetAlert extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'budget_alerts';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'triggered_at' => 'datetime',
);
    }

    protected static function newFactory(): BudgetAlertFactory
    {
        return BudgetAlertFactory::new();
    }
}
