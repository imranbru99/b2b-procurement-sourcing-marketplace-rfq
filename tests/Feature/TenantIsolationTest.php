<?php

use App\Models\Organization;
use App\Models\User;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Database\Seeders\ModuleSeeder;

beforeEach(function () {
    $this->seed(ModuleSeeder::class);
});

it('prevents buyer organization A from seeing organization B RFQs via global scope', function () {
    $orgA = Organization::factory()->create(['type' => 'buyer']);
    $orgB = Organization::factory()->create(['type' => 'buyer']);

    $userA = User::factory()->create(['current_organization_id' => $orgA->id]);
    $userA->organizations()->attach($orgA->id, ['role' => 'admin', 'is_primary' => true, 'joined_at' => now()]);

    $rfqA = Rfq::withoutGlobalScope('organization')->create([
        'organization_id' => $orgA->id,
        'type' => 'rfq',
        'title' => 'Org A RFQ',
        'slug' => 'org-a-isolation-rfq',
        'visibility' => 'private',
        'status' => 'open',
        'deadline' => now()->addWeek(),
    ]);

    $rfqB = Rfq::withoutGlobalScope('organization')->create([
        'organization_id' => $orgB->id,
        'type' => 'rfq',
        'title' => 'Org B RFQ',
        'slug' => 'org-b-isolation-rfq',
        'visibility' => 'private',
        'status' => 'open',
        'deadline' => now()->addWeek(),
    ]);

    $this->actingAs($userA);

    $visibleIds = Rfq::query()->pluck('id');

    expect($visibleIds)->toContain($rfqA->id)
        ->and($visibleIds)->not->toContain($rfqB->id);
});
