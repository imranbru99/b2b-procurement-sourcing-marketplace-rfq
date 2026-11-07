<?php

namespace App\Modules\Contracts;

interface ModuleInterface
{
    public function key(): string;

    public function name(): string;

    public function description(): string;

    public function group(): string;

    public function icon(): string;

    /**
     * @return list<string>
     */
    public function dependencies(): array;

    public function isCore(): bool;

    public function defaultEnabled(): bool;

    /**
     * @return list<string>
     */
    public function permissions(): array;

    /**
     * @return list<string>
     */
    public function migrationPaths(): array;

    public function serviceProviderClass(): ?string;

    public function basePath(): string;
}
