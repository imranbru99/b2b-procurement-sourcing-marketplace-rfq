<?php

use App\Models\Organization;
use App\Models\User;
use App\Modules\ModuleManager;
use App\Modules\Sourcing\Rfqs\Filament\Buyer\Resources\RfqResource;
use App\Modules\Sourcing\Rfqs\Policies\RfqPolicy;
use Database\Seeders\ModuleSeeder;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    $this->seed(ModuleSeeder::class);
});

it('hides rfq access when the rfqs module is disabled', function () {
    $buyer = Organization::factory()->create(['type' => 'buyer']);
    $manager = app(ModuleManager::class);

    $manager->enable($buyer, 'core.organizations');
    $manager->enable($buyer, 'sourcing.purchase-requisitions');
    $manager->enable($buyer, 'sourcing.rfqs');

    $user = User::factory()->create(['current_organization_id' => $buyer->id]);
    Permission::findOrCreate('rfqs.view');
    $user->givePermissionTo('rfqs.view');

    $this->actingAs($user);

    expect(RfqResource::canAccess())->toBeTrue()
        ->and(app(RfqPolicy::class)->viewAny($user))->toBeTrue();

    $manager->disable($buyer, 'sourcing.rfqs');

    expect(module_enabled('sourcing.rfqs', $buyer->id))->toBeFalse()
        ->and(RfqResource::canAccess())->toBeFalse()
        ->and(app(RfqPolicy::class)->viewAny($user))->toBeFalse();
});
