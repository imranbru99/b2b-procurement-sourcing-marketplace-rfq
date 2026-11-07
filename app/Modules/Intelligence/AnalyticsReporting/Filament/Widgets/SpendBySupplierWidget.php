<?php

namespace App\Modules\Intelligence\AnalyticsReporting\Filament\Widgets;

use App\Modules\Intelligence\AnalyticsReporting\Services\SpendAnalyticsService;
use Filament\Widgets\ChartWidget;

class SpendBySupplierWidget extends ChartWidget
{
    protected static ?string $heading = 'Spend by supplier';

    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $rows = app(SpendAnalyticsService::class)->spendBySupplier();

        $labels = array_map(
            fn ($supplierId) => 'Supplier #'.$supplierId,
            array_keys($rows),
        );

        return [
            'datasets' => [
                [
                    'label' => 'Spend',
                    'data' => array_values($rows),
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
