<?php

use App\Modules\Intelligence\MarketDataCatalog\Models\ScrapedCatalogItem;
use App\Services\Packages\AiCatalogService;
use Illuminate\Support\Facades\Queue;

it('queues market catalog ingest from keyword via ai catalog service', function () {
    Queue::fake();

    $item = app(AiCatalogService::class)->fromKeyword('industrial valve DN50');

    expect($item)->toBeInstanceOf(ScrapedCatalogItem::class)
        ->and($item->status)->toBe('pending')
        ->and($item->catalog_generation_id)->not->toBeNull();
});

it('approves and rejects scraped catalog items locally', function () {
    $item = ScrapedCatalogItem::factory()->create([
        'status' => 'pending',
        'catalog_generation_id' => null,
    ]);

    $service = app(AiCatalogService::class);

    $service->approve($item);
    expect($item->fresh()->status)->toBe('approved');

    $service->reject($item, 'Incomplete specifications');
    expect($item->fresh()->status)->toBe('rejected');
});
