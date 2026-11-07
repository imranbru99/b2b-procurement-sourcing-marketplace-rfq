<?php

namespace App\Modules\Platform\CmsBlog\Filament\Platform\Resources\BannerResource\Pages;

use App\Modules\Platform\CmsBlog\Filament\Platform\Resources\BannerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBanner extends CreateRecord
{
    protected static string $resource = BannerResource::class;
}
