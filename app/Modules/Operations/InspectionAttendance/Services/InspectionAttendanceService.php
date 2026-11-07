<?php

namespace App\Modules\Operations\InspectionAttendance\Services;

use ImranDevBd\AttendanceHub\Facades\AttendanceHub;

class InspectionAttendanceService
{
    public function syncDeviceAttendance(int|string $deviceId, ?\Carbon\CarbonInterface $since = null)
    {
        return AttendanceHub::sync($deviceId, $since);
    }

    public function useFakeDriver(array $initialPunches = []): void
    {
        AttendanceHub::fake($initialPunches);
    }
}
