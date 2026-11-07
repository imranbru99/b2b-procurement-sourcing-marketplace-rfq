<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Hash;

it('seeds demo users that can authenticate with password', function () {
    $this->seed(DatabaseSeeder::class);

    $emails = [
        'superadmin@demo.test',
        'buyer.admin@demo.test',
        'supplier.admin@demo.test',
        'logistics@demo.test',
    ];

    foreach ($emails as $email) {
        $user = User::query()->where('email', $email)->first();

        expect($user)->not->toBeNull()
            ->and(Hash::check('password', $user->password))->toBeTrue();
    }

    expect(User::query()->where('email', 'like', '%@demo.test')->count())->toBeGreaterThanOrEqual(18);
});
