<?php

namespace App\Modules;

use App\Modules\Contracts\ModuleInterface;
use Illuminate\Support\Arr;

abstract class AbstractModule implements ModuleInterface
{
    protected string $basePath;

    /**
     * @var array<string, mixed>
     */
    protected array $manifest;

    public function __construct()
    {
        $this->basePath = dirname((new \ReflectionClass(static::class))->getFileName());
        $path = $this->basePath.'/module.json';

        if (! is_file($path)) {
            throw new \RuntimeException("Module manifest not found: {$path}");
        }

        $decoded = json_decode((string) file_get_contents($path), true);

        if (! is_array($decoded)) {
            throw new \RuntimeException("Invalid module manifest: {$path}");
        }

        $this->manifest = $decoded;
    }

    public function key(): string
    {
        return (string) $this->manifest['key'];
    }

    public function name(): string
    {
        return (string) $this->manifest['name'];
    }

    public function description(): string
    {
        return (string) Arr::get($this->manifest, 'description', '');
    }

    public function group(): string
    {
        return (string) Arr::get($this->manifest, 'group', 'General');
    }

    public function icon(): string
    {
        return (string) Arr::get($this->manifest, 'icon', 'heroicon-o-puzzle-piece');
    }

    public function dependencies(): array
    {
        $deps = Arr::get($this->manifest, 'dependencies', []);

        return is_array($deps) ? array_values(array_map('strval', $deps)) : [];
    }

    public function isCore(): bool
    {
        return (bool) Arr::get($this->manifest, 'is_core', false);
    }

    public function defaultEnabled(): bool
    {
        return (bool) Arr::get($this->manifest, 'default_enabled', true);
    }

    public function permissions(): array
    {
        $permissions = Arr::get($this->manifest, 'permissions', []);

        return is_array($permissions) ? array_values(array_map('strval', $permissions)) : [];
    }

    public function migrationPaths(): array
    {
        $paths = Arr::get($this->manifest, 'migrations', []);
        if (is_array($paths) && $paths !== []) {
            return array_values($paths);
        }

        $default = $this->basePath.'/Database/Migrations';

        return is_dir($default) ? [$default] : [];
    }

    public function serviceProviderClass(): ?string
    {
        $provider = Arr::get($this->manifest, 'provider');

        return is_string($provider) && $provider !== '' ? $provider : null;
    }

    public function basePath(): string
    {
        return $this->basePath;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'key' => $this->key(),
            'name' => $this->name(),
            'description' => $this->description(),
            'group' => $this->group(),
            'icon' => $this->icon(),
            'dependencies' => $this->dependencies(),
            'is_core' => $this->isCore(),
            'default_enabled' => $this->defaultEnabled(),
            'permissions' => $this->permissions(),
        ];
    }
}
