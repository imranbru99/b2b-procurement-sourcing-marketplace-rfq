<?php

namespace App\Modules\Operations\Messaging\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Operations\Messaging\Database\Factories\MessageMentionFactory;

class MessageMention extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'message_mentions';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
);
    }

    protected static function newFactory(): MessageMentionFactory
    {
        return MessageMentionFactory::new();
    }
}
