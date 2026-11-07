<?php

namespace App\Modules\Platform\SecurityCenter\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\SecurityCenter\Database\Factories\UserSessionTrackingFactory;

class UserSessionTracking extends Model
{
    use HasFactory;

    protected $table = 'security_user_sessions_tracking';

    protected $guarded = [];

    protected static function newFactory(): UserSessionTrackingFactory
    {
        return UserSessionTrackingFactory::new();
    }
}
