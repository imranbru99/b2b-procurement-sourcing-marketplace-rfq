<?php

namespace App\Services\Packages;

use App\Modules\Intelligence\AiAssistant\Models\AiUsageLog;
use ImranDevBd\AiHub\Data\AiResponse;
use ImranDevBd\AiHub\Facades\AIHub;
use ImranDevBd\AiHub\Testing\AIHubFake;

class AiHubService
{
    /**
     * @param  array<int, mixed>  $responses
     */
    public function fake(array|string $responses = []): AIHubFake
    {
        return AIHub::fake($responses);
    }

    public function draftRfq(string $plainText): string
    {
        $response = $this->prompt(
            "Convert the following procurement notes into a structured RFQ draft with line items, quantities, delivery terms, and evaluation criteria.\n\n{$plainText}",
            'draft_rfq',
        );

        return $response->content;
    }

    /**
     * @param  array<int, array<string, mixed>>  $bids
     */
    public function summarizeBids(array $bids): string
    {
        $payload = json_encode($bids, JSON_THROW_ON_ERROR);

        $response = $this->prompt(
            "Summarize these supplier bids for a buyer decision table. Highlight price spread, lead times, and risks.\n\n{$payload}",
            'summarize_bids',
        );

        return $response->content;
    }

    /**
     * @param  array<string, mixed>  $criteria
     */
    public function recommendSuppliers(array $criteria): string
    {
        $payload = json_encode($criteria, JSON_THROW_ON_ERROR);

        $response = $this->prompt(
            "Recommend suppliers matching these sourcing criteria with rationale.\n\n{$payload}",
            'recommend_suppliers',
        );

        return $response->content;
    }

    /**
     * @param  array<int, array<string, mixed>>  $prices
     */
    public function detectPriceAnomalies(array $prices): string
    {
        $payload = json_encode($prices, JSON_THROW_ON_ERROR);

        $response = $this->prompt(
            "Detect statistical price anomalies and flag outliers with brief explanations.\n\n{$payload}",
            'price_anomalies',
        );

        return $response->content;
    }

    public function translate(string $text, string $locale): string
    {
        $response = $this->prompt(
            "Translate the following procurement text into locale \"{$locale}\" while preserving units and incoterms.\n\n{$text}",
            'translate',
        );

        return $response->content;
    }

    public function chat(string $message): string
    {
        $response = AIHub::chat()
            ->system('You are a B2B procurement copilot for RFQs, bids, contracts, and supplier discovery.')
            ->reply($message);

        $this->logUsage('chat', $response);

        return $response->content;
    }

    public function reviewContractClause(string $clause): string
    {
        $response = $this->prompt(
            "Review this contract clause for procurement risk, ambiguous language, and suggested redlines.\n\n{$clause}",
            'review_contract_clause',
        );

        return $response->content;
    }

    protected function prompt(string $prompt, string $feature): AiResponse
    {
        $response = AIHub::prompt($prompt)->generate();

        $this->logUsage($feature, $response);

        return $response;
    }

    protected function logUsage(string $feature, AiResponse $response): void
    {
        AiUsageLog::query()->create([
            'organization_id' => organization_id(),
            'user_id' => auth()->id(),
            'feature' => $feature,
            'provider' => $response->provider,
            'model' => $response->model,
            'tokens_in' => $response->promptTokens,
            'tokens_out' => $response->completionTokens,
            'cost_usd' => $response->costUsd,
            'meta' => [
                'latency_ms' => $response->latencyMs,
                'success' => $response->success,
            ],
        ]);
    }
}
