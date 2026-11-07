<?php

namespace App\Modules\Platform\MultiLanguagePdf\Database\Factories;

use App\Modules\Platform\MultiLanguagePdf\Models\DocumentTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<DocumentTemplate> */
class DocumentTemplateFactory extends Factory
{
    protected $model = DocumentTemplate::class;

    public function definition(): array
    {
        return [
            'type' => 'invoice',
            'letterhead' => '<h1>Company</h1>',
            'body_html' => '<p>Hello</p>',
            'locale' => 'en',
        ];
    }
}
