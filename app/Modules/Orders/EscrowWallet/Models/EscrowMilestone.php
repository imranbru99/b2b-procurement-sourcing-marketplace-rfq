<?php

namespace App\Modules\Orders\EscrowWallet\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Orders\EscrowWallet\Database\Factories\EscrowMilestoneFactory;

class EscrowMilestone extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'escrow_milestones';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'amount' => 'decimal:2',
  'released_at' => 'datetime',
);
    }

    protected static function newFactory(): EscrowMilestoneFactory
    {
        return EscrowMilestoneFactory::new();
    }
}
