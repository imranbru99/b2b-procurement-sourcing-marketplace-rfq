<?php

use App\Models\Organization;
use App\Models\User;
use App\Modules\ModuleManager;
use App\Modules\Sourcing\AwardsContracts\Models\Award;
use App\Modules\Sourcing\AwardsContracts\Services\RfqAwardWorkflow;
use App\Modules\Sourcing\Bidding\Models\Bid;
use App\Modules\Sourcing\Bidding\Services\BidSubmissionService;
use App\Modules\Sourcing\BidScoring\Models\BidScore;
use App\Modules\Sourcing\BidScoring\Models\ScoringCriterion;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Database\Seeders\ModuleSeeder;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    $this->seed(ModuleSeeder::class);
});

function enableSourcingStack(ModuleManager $manager, Organization $buyer): void
{
    foreach ([
        'core.organizations',
        'sourcing.purchase-requisitions',
        'sourcing.rfqs',
        'sourcing.bidding',
        'sourcing.bid-scoring',
        'sourcing.awards-contracts',
    ] as $key) {
        $manager->enable($buyer, $key);
    }
}

it('runs rfq lifecycle from creation through bid scoring to award', function () {
    $buyer = Organization::factory()->create(['type' => 'buyer']);
    $supplier = Organization::factory()->create(['type' => 'supplier']);

    $manager = app(ModuleManager::class);
    enableSourcingStack($manager, $buyer);

    $evaluator = User::factory()->create(['current_organization_id' => $buyer->id]);
    foreach (['rfqs.view', 'bids.view', 'bid_scoring.evaluate', 'awards.create'] as $permission) {
        Permission::findOrCreate($permission);
        $evaluator->givePermissionTo($permission);
    }

    $rfq = Rfq::withoutGlobalScope('organization')->create([
        'organization_id' => $buyer->id,
        'type' => 'rfq',
        'title' => 'Office supplies RFQ',
        'slug' => 'office-supplies-rfq-1001',
        'visibility' => 'private',
        'status' => 'open',
        'deadline' => now()->addWeek(),
        'version' => 1,
    ]);

    $bid = Bid::withoutGlobalScope('organization')->create([
        'organization_id' => $buyer->id,
        'rfq_id' => $rfq->id,
        'supplier_organization_id' => $supplier->id,
        'status' => 'draft',
        'total' => 12500.50,
        'currency' => 'USD',
        'lead_time_days' => 14,
        'is_sealed' => true,
    ]);

    $bid = app(BidSubmissionService::class)->submit($bid);
    expect($bid->status)->toBe('submitted');

    $workflow = app(RfqAwardWorkflow::class);
    $criterion = $workflow->ensureCriterion($rfq, 'Price competitiveness', 0.6, 100);

    BidScore::withoutGlobalScope('organization')->create([
        'organization_id' => $buyer->id,
        'bid_id' => $bid->id,
        'scoring_criterion_id' => $criterion->id,
        'evaluator_id' => $evaluator->id,
        'score' => 88,
        'weighted_score' => 52.8,
    ]);

    expect($workflow->totalWeightedScore($bid))->toBe(52.8);

    $award = $workflow->awardTopScoredBid($rfq->fresh(), $bid);

    expect($award)->toBeInstanceOf(Award::class)
        ->and($award->status)->toBe('awarded')
        ->and($rfq->fresh()->status)->toBe('awarded');
});
