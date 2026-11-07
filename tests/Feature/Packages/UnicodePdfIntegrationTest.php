<?php

use App\Services\Packages\UnicodePdfService;
use ImranDev\UnicodePdf\Facades\UnicodePdf;

it('generates purchase order pdf via unicode pdf service', function () {
    UnicodePdf::fake();

    $service = app(UnicodePdfService::class);

    $response = $service->download('pdf.po', [
        'number' => 'PO-TEST-001',
        'currency' => 'USD',
        'total' => 500,
    ], 'po.pdf');

    expect($response)->not->toBeNull();

    UnicodePdf::assertDownloaded('po.pdf');
});
