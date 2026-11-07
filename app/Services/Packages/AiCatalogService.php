<?php

namespace App\Services\Packages;

use App\Modules\Intelligence\MarketDataCatalog\Models\ScrapedCatalogItem;
use ImranDevBd\AiCatalog\Facades\AiCatalog;
use ImranDevBd\AiCatalog\Models\CatalogGeneration;

class AiCatalogService
{
    public function fromUrl(string $url, ?int $organizationId = null, bool $async = true): ScrapedCatalogItem
    {
        $pending = AiCatalog::fromUrl($url);

        $generation = $async
            ? $pending->generateAsync()
            : $pending->generate();

        return $this->storeScrapedItem(
            sourceUrl: $url,
            title: $this->resolveTitle($generation, $url),
            generation: $generation,
            organizationId: $organizationId,
        );
    }

    public function fromKeyword(string $keyword, ?int $organizationId = null, bool $async = true): ScrapedCatalogItem
    {
        $pending = AiCatalog::fromKeyword($keyword);

        $generation = $async
            ? $pending->generateAsync()
            : $pending->generate();

        return $this->storeScrapedItem(
            sourceUrl: null,
            title: $this->resolveTitle($generation, $keyword),
            generation: $generation,
            organizationId: $organizationId,
        );
    }

    public function approve(ScrapedCatalogItem $item, ?int $actorId = null): ScrapedCatalogItem
    {
        if ($item->catalog_generation_id !== null) {
            AiCatalog::approve($item->catalog_generation_id, $actorId);
        }

        $item->update(['status' => 'approved']);

        return $item->fresh();
    }

    public function reject(ScrapedCatalogItem $item, ?string $reason = null, ?int $actorId = null): ScrapedCatalogItem
    {
        if ($item->catalog_generation_id !== null) {
            AiCatalog::reject($item->catalog_generation_id, $reason, $actorId);
        }

        $item->update([
            'status' => 'rejected',
            'raw' => array_merge((array) $item->raw, ['rejection_reason' => $reason]),
        ]);

        return $item->fresh();
    }

    protected function storeScrapedItem(
        ?string $sourceUrl,
        string $title,
        CatalogGeneration $generation,
        ?int $organizationId,
    ): ScrapedCatalogItem {
        $listing = is_array($generation->payload) ? $generation->payload : [];

        return ScrapedCatalogItem::query()->create([
            'organization_id' => $organizationId,
            'catalog_generation_id' => $generation->id,
            'source_url' => $sourceUrl,
            'title' => $title,
            'price' => $listing['price'] ?? null,
            'currency' => $listing['currency'] ?? 'USD',
            'status' => 'pending',
            'raw' => [
                'generation_uuid' => $generation->uuid,
                'input_mode' => $generation->input_mode?->value,
                'payload' => $generation->payload,
            ],
        ]);
    }

    protected function resolveTitle(CatalogGeneration $generation, string $fallback): string
    {
        $payload = is_array($generation->payload) ? $generation->payload : [];

        return (string) ($payload['title'] ?? $payload['seo_title'] ?? $fallback);
    }
}
