<?php

namespace App\Services\Packages;

use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use ImranDevBd\AttendanceHub\Facades\AttendanceHub;
use ImranDevBd\AttendanceHub\Models\AttendanceDevice;

class AttendanceService
{
    /**
     * @param  array<int, mixed>  $initialPunches
     */
    public function fake(array $initialPunches = []): void
    {
        AttendanceHub::fake($initialPunches);
    }

    public function sync(AttendanceDevice|int|string $device, ?CarbonInterface $since = null): Collection
    {
        return AttendanceHub::sync($device, $since);
    }
}
