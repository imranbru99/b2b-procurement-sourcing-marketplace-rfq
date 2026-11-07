<?php

namespace App\Modules\Intelligence\MarketDataCatalog\Jobs;

use App\Services\Packages\AiCatalogService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScrapeCatalogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $source,
        public string $mode = 'keyword',
        public ?int $organizationId = null,
    ) {}

    public function handle(AiCatalogService $catalog): void
    {
        if ($this->mode === 'url') {
            $catalog->fromUrl($this->source, $this->organizationId);

            return;
        }

        $catalog->fromKeyword($this->source, $this->organizationId);
    }
}
