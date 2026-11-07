<?php

namespace App\Modules\Platform\MultiLanguagePdf\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\MultiLanguagePdf\Database\Factories\DocumentTemplateFactory;
use App\Models\Concerns\BelongsToOrganization;

class DocumentTemplate extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $table = 'document_templates';

    protected $guarded = [];

    protected static function newFactory(): DocumentTemplateFactory
    {
        return DocumentTemplateFactory::new();
    }
}
