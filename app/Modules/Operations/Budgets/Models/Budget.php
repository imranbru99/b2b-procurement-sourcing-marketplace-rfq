<?php

namespace App\Modules\Operations\Budgets\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Operations\Budgets\Database\Factories\BudgetFactory;

class Budget extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'budgets';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'allocated' => 'decimal:2',
  'spent' => 'decimal:2',
);
    }

    protected static function newFactory(): BudgetFactory
    {
        return BudgetFactory::new();
    }
}
