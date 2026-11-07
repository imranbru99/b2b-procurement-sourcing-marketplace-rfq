<?php

namespace App\Services\Packages;

use Illuminate\Http\Response;
use ImranDev\UnicodePdf\Facades\UnicodePdf;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class UnicodePdfService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function download(string $view, array $data, string $filename): SymfonyResponse|Response
    {
        return UnicodePdf::view($view, $data)->download($filename);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function stream(string $view, array $data, string $filename): SymfonyResponse|Response
    {
        return UnicodePdf::view($view, $data)->stream($filename);
    }
}
