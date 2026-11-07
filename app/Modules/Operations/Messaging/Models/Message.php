<?php

namespace App\Modules\Operations\Messaging\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Operations\Messaging\Database\Factories\MessageFactory;

class Message extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'messages';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'sent_at' => 'datetime',
);
    }

    protected static function newFactory(): MessageFactory
    {
        return MessageFactory::new();
    }
}
