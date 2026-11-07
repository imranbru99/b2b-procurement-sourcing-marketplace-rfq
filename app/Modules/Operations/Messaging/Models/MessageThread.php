<?php

namespace App\Modules\Operations\Messaging\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Operations\Messaging\Database\Factories\MessageThreadFactory;

class MessageThread extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'message_threads';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
);
    }

    protected static function newFactory(): MessageThreadFactory
    {
        return MessageThreadFactory::new();
    }
}
