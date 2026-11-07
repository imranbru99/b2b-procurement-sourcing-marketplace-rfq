# Architecture

## Multi-tenancy

Organizations are the tenant boundary. Users belong to one or more organizations through `organization_user`, with a `current_organization_id` on `users` driving request context.

Eloquent models that include `BelongsToOrganization` apply a global `organization` scope keyed off `organization_id()` (authenticated user's current organization). Platform operators (`is_platform_user`) use dedicated Filament panels without buyer/supplier scoping on public marketing routes.

## Modules

Each feature lives under `app/Modules/{Group}/{Name}/` with a `module.json` manifest (key, dependencies, permissions, default enabled flag). `ModuleRegistry` discovers manifests; `ModuleManager` persists entitlements per organization in `organization_modules`.

When an organization has **no** module rows, all `default_enabled` modules are treated as on. After the first explicit row, only `enabled = true` keys are active—demo seeders set the full matrix per tenant.

## Panels

| Panel | Path | Audience |
|-------|------|----------|
| Platform | `/platform` | Operators, support, finance, KYC |
| Buyer | `/buyer` | Buyer organizations |
| Supplier | `/supplier` | Supplier organizations |
| Logistics | `/logistics` | Logistics & inspection partners |
| Admin | `/admin` | Technical console (`laravel-admin-panel`) |

Filament panel providers live in `app/Providers/Filament/`. Module Filament resources register through module service providers when the module is enabled for the active organization.

## Packages

| Package | Role |
|---------|------|
| `spatie/laravel-permission` | RBAC roles synced from module permissions |
| `imrandevbd/laravel-ai-hub` | AI routing, budgets, logging |
| `imrandevbd/laravel-ai-catalog` | Catalog generation |
| `imrandevbd/laravel-attendance-hub` | Device punches & inspection adjacency |
| `imrandevbd/drutogoti` | Request/query performance telemetry |
| `imrandevbd/laravel-universal-slug` | Slugs on RFQs, tickets, CMS entities |
| `laravel/reverb` | WebSockets for live sourcing (with Redis) |
