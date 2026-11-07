<?php

use App\Services\Packages\AttendanceService;
use ImranDevBd\AttendanceHub\Facades\AttendanceHub;
use ImranDevBd\AttendanceHub\Models\AttendanceDevice;

it('uses attendance hub fake driver through attendance service', function () {
    $service = app(AttendanceService::class);

    $service->fake();

    expect(AttendanceHub::isFake())->toBeTrue();

    $device = AttendanceDevice::query()->create([
        'name' => 'Site inspection terminal',
        'provider' => 'zkteco',
        'ip' => '192.168.10.50',
    ]);

    $collection = $service->sync($device);

    expect($collection)->toBeInstanceOf(\Illuminate\Support\Collection::class);
});
