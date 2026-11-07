<?php

namespace App\Modules\Platform\Support\Concerns;

trait RegistersModuleMigrations
{
    protected function loadModuleMigrations(?string $path = null): void
    {
        $path ??= dirname((new \ReflectionClass(static::class))->getFileName()).'/Database/Migrations';

        if (is_dir($path)) {
            $this->loadMigrationsFrom($path);
        }
    }
}
