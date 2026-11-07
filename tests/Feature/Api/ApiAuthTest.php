<?php

use App\Models\Organization;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('rejects unauthenticated API requests', function () {
    $this->getJson('/api/v1/me')->assertUnauthorized();
});

it('returns the authenticated user on me endpoint', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $this->getJson('/api/v1/me')
        ->assertOk()
        ->assertJsonPath('data.email', $user->email);
});

it('lists rfqs for the current organization via sanctum token', function () {
    $organization = Organization::query()->create([
        'name' => 'Buyer Org',
        'type' => 'buyer',
    ]);

    $user = User::factory()->create([
        'current_organization_id' => $organization->id,
    ]);

    $token = $user->createToken('api')->plainTextToken;

    $this->withToken($token)
        ->getJson('/api/v1/rfqs')
        ->assertOk()
        ->assertJsonStructure(['data', 'links', 'meta']);
});
