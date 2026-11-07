<?php

namespace App\Modules;

use App\Modules\Contracts\ModuleInterface;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ModuleRegistry
{
    /**
     * @var Collection<string, ModuleInterface>|null
     */
    protected ?Collection $modules = null;

    public function __construct(
        protected Filesystem $files,
    ) {}

    /**
     * @return Collection<string, ModuleInterface>
     */
    public function all(): Collection
    {
        if ($this->modules !== null) {
            return $this->modules;
        }

        $this->modules = collect();

        $base = app_path('Modules');

        if (! $this->files->isDirectory($base)) {
            return $this->modules;
        }

        foreach ($this->files->allFiles($base) as $file) {
            if ($file->getFilename() !== 'module.json') {
                continue;
            }

            $directory = $file->getPath();
            $moduleClass = $this->resolveModuleClass($directory);

            if ($moduleClass === null || ! class_exists($moduleClass)) {
                continue;
            }

            $instance = app($moduleClass);

            if (! $instance instanceof ModuleInterface) {
                continue;
            }

            $this->modules->put($instance->key(), $instance);
        }

        return $this->modules;
    }

    public function get(string $key): ?ModuleInterface
    {
        return $this->all()->get($key);
    }

    public function has(string $key): bool
    {
        return $this->all()->has($key);
    }

    /**
     * @return list<string>
     */
    public function keys(): array
    {
        return $this->all()->keys()->values()->all();
    }

    protected function resolveModuleClass(string $directory): ?string
    {
        $moduleFile = $directory.'/Module.php';

        if (! $this->files->exists($moduleFile)) {
            return null;
        }

        $relative = Str::after($directory, app_path().DIRECTORY_SEPARATOR);

        return 'App\\'.str_replace(DIRECTORY_SEPARATOR, '\\', $relative).'\\Module';
    }
}
