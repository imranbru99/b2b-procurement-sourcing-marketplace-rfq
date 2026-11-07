<?php

namespace App\Modules\Operations\Budgets\Filament\Resources\BudgetResource\Pages;

use App\Modules\Operations\Budgets\Filament\Resources\BudgetResource;
use Filament\Resources\Pages\ListRecords;

class ListBudgets extends ListRecords
{
    protected static string $resource = BudgetResource::class;
}
