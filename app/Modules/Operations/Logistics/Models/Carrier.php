<?php

namespace App\Modules\Operations\Logistics\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Operations\Logistics\Database\Factories\CarrierFactory;

class Carrier extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'carriers';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
);
    }

    protected static function newFactory(): CarrierFactory
    {
        return CarrierFactory::new();
    }
}
