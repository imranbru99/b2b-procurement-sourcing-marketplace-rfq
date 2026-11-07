<?php

use App\Modules\Intelligence\AiAssistant\Models\AiUsageLog;
use App\Services\Packages\AiHubService;
use ImranDevBd\AiHub\Facades\AIHub;

it('uses ai hub fake driver through ai hub service', function () {
    $service = app(AiHubService::class);

    $service->fake('Structured RFQ draft');

    $draft = $service->draftRfq('Need 500 tons rebar, CIF Chittagong');

    expect($draft)->toBe('Structured RFQ draft')
        ->and(AiUsageLog::query()->where('feature', 'draft_rfq')->exists())->toBeTrue();
});

it('supports multi turn chat via ai hub facade', function () {
    AIHub::fake(['Hello buyer']);

    $reply = app(AiHubService::class)->chat('Status of my open RFQs?');

    expect($reply)->toBe('Hello buyer');
});
