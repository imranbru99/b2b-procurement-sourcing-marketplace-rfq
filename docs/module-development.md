# Module development

## 1. Scaffold

Create a directory under `app/Modules/{Group}/{Name}/` with:

- `module.json` — key (dot notation), dependencies, permissions, `ModuleServiceProvider` class
- `Module.php` — class extending `App\Modules\AbstractModule`
- `ModuleServiceProvider.php` — migrations, routes, policies, Filament resources

Use existing modules (e.g. `app/Modules/Sourcing/Rfqs/`) as templates.

## 2. Manifest example

```json
{
    "key": "sourcing.example",
    "name": "Example",
    "dependencies": ["core.organizations"],
    "is_core": false,
    "default_enabled": false,
    "permissions": ["example.view", "example.manage"],
    "provider": "App\\Modules\\Sourcing\\Example\\ModuleServiceProvider"
}
```

## 3. Register data layer

- Migrations in `Database/Migrations/`
- Models using `BelongsToOrganization` when data is tenant-scoped
- Factories for tests

## 4. Wire Filament

Place buyer/supplier/platform resources under the module's `Filament/{Panel}/` tree and register them in the module service provider using the same pattern as sibling modules.

## 5. Enable for an organization

```php
app(ModuleManager::class)->enable($organization, 'sourcing.example');
```

Run `php artisan db:seed --class=ModuleSeeder` after adding a new manifest so the `modules` table stays in sync.

## 6. Tests

Add a Pest feature test under `tests/Feature/Modules/` that seeds `ModuleSeeder`, enables the module, and asserts core behavior.
