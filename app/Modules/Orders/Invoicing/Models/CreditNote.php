<?php

namespace App\Modules\Orders\Invoicing\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Orders\Invoicing\Database\Factories\CreditNoteFactory;

class CreditNote extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'credit_notes';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'amount' => 'decimal:2',
  'issued_at' => 'datetime',
);
    }

    protected static function newFactory(): CreditNoteFactory
    {
        return CreditNoteFactory::new();
    }
}
