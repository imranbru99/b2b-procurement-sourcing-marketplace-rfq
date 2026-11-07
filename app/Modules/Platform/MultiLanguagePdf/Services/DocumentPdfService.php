<?php

namespace App\Modules\Platform\MultiLanguagePdf\Services;

use App\Modules\Platform\MultiLanguagePdf\Models\DocumentTemplate;
use App\Services\Packages\UnicodePdfService;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class DocumentPdfService
{
    public function __construct(
        private UnicodePdfService $unicodePdf
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public function renderTemplate(DocumentTemplate $template, array $data = [], ?string $filename = null): SymfonyResponse
    {
        $filename ??= $template->type.'-'.$template->locale.'.pdf';

        return $this->unicodePdf->stream('pdf.document', array_merge($data, [
            'letterhead' => $template->letterhead,
            'body_html' => $template->body_html,
            'locale' => $template->locale,
        ]), $filename);
    }
}
