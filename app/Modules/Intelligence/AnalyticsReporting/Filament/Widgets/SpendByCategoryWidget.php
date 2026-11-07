<?php

namespace App\Modules\Intelligence\AnalyticsReporting\Filament\Widgets;

use App\Modules\Intelligence\AnalyticsReporting\Services\SpendAnalyticsService;
use Filament\Widgets\ChartWidget;

class SpendByCategoryWidget extends ChartWidget
{
    protected static ?string $heading = 'Spend by category';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $rows = app(SpendAnalyticsService::class)->spendByCategory();

        return [
            'datasets' => [
                [
                    'label' => 'Spend',
                    'data' => array_values($rows),
                ],
            ],
            'labels' => array_keys($rows),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
