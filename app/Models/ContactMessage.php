<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'type',
        'name',
        'email',
        'company',
        'phone',
        'subject',
        'message',
        'ip',
        'user_agent',
    ];
}
