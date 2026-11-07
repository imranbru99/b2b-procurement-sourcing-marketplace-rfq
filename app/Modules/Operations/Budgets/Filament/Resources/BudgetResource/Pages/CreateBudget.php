<?php

namespace App\Modules\Operations\Budgets\Filament\Resources\BudgetResource\Pages;

use App\Modules\Operations\Budgets\Filament\Resources\BudgetResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBudget extends CreateRecord
{
    protected static string $resource = BudgetResource::class;
}
