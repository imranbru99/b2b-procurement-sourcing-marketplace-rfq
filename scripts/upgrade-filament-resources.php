<?php

/**
 * Upgrade stub Filament Resource form/table schemas from live DB columns.
 * Usage: php scripts/upgrade-filament-resources.php
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$skipColumns = ['id', 'created_at', 'updated_at', 'deleted_at'];
$preferTableColumns = ['id', 'number', 'title', 'name', 'company_name', 'status', 'total', 'currency', 'slug', 'subject', 'email', 'created_at'];

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__.'/../app/Modules'));
$resources = [];

foreach ($iterator as $file) {
    if (! $file->isFile() || ! str_ends_with($file->getFilename(), 'Resource.php')) {
        continue;
    }
    if (str_contains($file->getPathname(), '/Pages/')) {
        continue;
    }
    $resources[] = $file->getPathname();
}

$upgraded = 0;
$skipped = 0;

foreach ($resources as $path) {
    $code = file_get_contents($path);
    if ($code === false) {
        continue;
    }

    if (! preg_match('/protected static \?string \$model = ([\\\\A-Za-z0-9_]+)::class;/', $code, $m)) {
        $skipped++;
        continue;
    }

    $modelRef = $m[1];
    $modelClass = resolveModelClass($code, $modelRef);
    if ($modelClass === null || ! class_exists($modelClass)) {
        echo "SKIP missing model {$modelRef} => ".($modelClass ?? 'null')." in {$path}\n";
        $skipped++;
        continue;
    }

    try {
        $model = new $modelClass;
        $table = $model->getTable();
    } catch (Throwable $e) {
        echo "SKIP instantiate {$modelClass}: {$e->getMessage()}\n";
        $skipped++;
        continue;
    }

    if (! Schema::hasTable($table)) {
        echo "SKIP no table {$table}\n";
        $skipped++;
        continue;
    }

    $columns = Schema::getColumnListing($table);
    $formFields = [];
    $tableColumns = [];

    foreach ($columns as $column) {
        if (in_array($column, $skipColumns, true) && $column !== 'id') {
            if ($column === 'created_at') {
                $tableColumns[] = "Tables\\Columns\\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)";
            }
            continue;
        }

        if ($column === 'id') {
            $tableColumns[] = "Tables\\Columns\\TextColumn::make('id')->sortable()";
            continue;
        }

        $type = Schema::getColumnType($table, $column);
        $formFields[] = filamentFormComponent($column, $type);
        if (in_array($column, $preferTableColumns, true) || count($tableColumns) < 8) {
            $tableColumns[] = filamentTableColumn($column, $type);
        }
    }

    if ($formFields === []) {
        $skipped++;
        continue;
    }

    $formSchema = implode(",\n                ", $formFields);
    $tableSchema = implode(",\n                ", array_unique($tableColumns));

    $newForm = <<<PHP
    public static function form(Form \$form): Form
    {
        return \$form
            ->schema([
                {$formSchema},
            ]);
    }
PHP;

    $hasActions = str_contains($code, 'Tables\\Actions\\EditAction');
    $actionsBlock = $hasActions
        ? "->actions([\n                Tables\\Actions\\EditAction::make(),\n            ])"
        : "->actions([\n                Tables\\Actions\\EditAction::make(),\n                Tables\\Actions\\ViewAction::make(),\n            ])";

    $newTable = <<<PHP
    public static function table(Table \$table): Table
    {
        return \$table
            ->columns([
                {$tableSchema},
            ])
            ->filters([])
            {$actionsBlock};
    }
PHP;

    $updated = preg_replace(
        '/public static function form\(Form \$form\): Form\s*\{.*?\n    \}/s',
        $newForm,
        $code,
        1,
        $countForm
    );

    if ($countForm === 0 || $updated === null) {
        echo "SKIP form replace failed: {$path}\n";
        $skipped++;
        continue;
    }

    $updated = preg_replace(
        '/public static function table\(Table \$table\): Table\s*\{.*?\n    \}/s',
        $newTable,
        $updated,
        1,
        $countTable
    );

    if ($countTable === 0 || $updated === null) {
        echo "SKIP table replace failed: {$path}\n";
        $skipped++;
        continue;
    }

    // Ensure Forms import exists
    if (! str_contains($updated, 'use Filament\\Forms;') && str_contains($updated, 'Forms\\Components\\')) {
        $updated = preg_replace('/use Filament\\\\Forms\\\\Form;/', "use Filament\\Forms;\nuse Filament\\Forms\\Form;", $updated, 1) ?? $updated;
    }

    if (! str_contains($updated, 'use Filament\\Tables;') && str_contains($updated, 'Tables\\Columns\\')) {
        $updated = preg_replace('/use Filament\\\\Tables\\\\Table;/', "use Filament\\Tables;\nuse Filament\\Tables\\Table;", $updated, 1) ?? $updated;
    }

    // Add canAccess if module key can be inferred and missing
    if (! str_contains($updated, 'function canAccess')) {
        $moduleKey = inferModuleKey($path);
        if ($moduleKey !== null) {
            $canAccess = <<<PHP

    public static function canAccess(): bool
    {
        return module_enabled('{$moduleKey}');
    }

PHP;
            $updated = preg_replace(
                '/(protected static \?string \$navigationGroup = .*?;\n)/',
                "$1{$canAccess}",
                $updated,
                1
            ) ?? $updated;
        }
    }

    file_put_contents($path, $updated);
    $upgraded++;
    echo "OK {$path}\n";
}

echo "\nUpgraded: {$upgraded}, Skipped: {$skipped}\n";

function resolveModelClass(string $code, string $modelRef): ?string
{
    $modelRef = ltrim($modelRef, '\\');

    if (str_contains($modelRef, '\\')) {
        return $modelRef;
    }

    // use Foo\Bar\Model as Alias;
    if (preg_match('/use\\s+([\\\\\\w]+\\\\'.$modelRef.')\\s*;/', $code, $um)) {
        return ltrim($um[1], '\\');
    }

    if (preg_match('/use\\s+([\\\\\\w]+)\\s+as\\s+'.$modelRef.'\\s*;/', $code, $um)) {
        return ltrim($um[1], '\\');
    }

    if (preg_match('/namespace\\s+([^;]+);/', $code, $nm)) {
        $fqcn = trim($nm[1]).'\\'.$modelRef;
        if (class_exists($fqcn)) {
            return $fqcn;
        }
    }

    return class_exists($modelRef) ? $modelRef : null;
}

function inferModuleKey(string $path): ?string
{
    if (preg_match('#app/Modules/([^/]+)/([^/]+)/#', $path, $m)) {
        $group = Str::kebab($m[1]);
        $name = Str::kebab($m[2]);
        // Core modules use core.*
        $map = [
            'sourcing' => 'sourcing',
            'suppliers' => 'suppliers',
            'orders' => 'orders',
            'operations' => 'operations',
            'intelligence' => 'intelligence',
            'platform' => 'platform',
            'marketplace' => 'marketplace',
            'core' => 'core',
        ];
        $prefix = $map[strtolower($m[1])] ?? Str::kebab($m[1]);

        // Prefer reading module.json
        $dir = dirname($path);
        while ($dir !== '/' && ! is_file($dir.'/module.json')) {
            $parent = dirname($dir);
            if ($parent === $dir) {
                break;
            }
            $dir = $parent;
            if (basename(dirname($dir)) === 'Modules' || basename(dirname(dirname($dir))) === 'Modules') {
                if (is_file($dir.'/module.json')) {
                    break;
                }
            }
        }
        if (is_file($dir.'/module.json')) {
            $json = json_decode((string) file_get_contents($dir.'/module.json'), true);
            if (is_array($json) && isset($json['key'])) {
                return (string) $json['key'];
            }
        }

        return $prefix.'.'.$name;
    }

    return null;
}

function filamentFormComponent(string $column, string $type): string
{
    $label = null;
    if (str_ends_with($column, '_id') && $column !== 'organization_id') {
        return "Forms\\Components\\TextInput::make('{$column}')->numeric()->nullable()";
    }

    if ($column === 'organization_id') {
        return "Forms\\Components\\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required()";
    }

    return match (true) {
        in_array($type, ['text', 'longtext', 'mediumtext'], true) => "Forms\\Components\\Textarea::make('{$column}')->columnSpanFull()",
        in_array($type, ['boolean', 'bool', 'tinyint'], true) && (str_starts_with($column, 'is_') || str_starts_with($column, 'has_') || $column === 'notify_on_match') => "Forms\\Components\\Toggle::make('{$column}')",
        in_array($type, ['json', 'jsonb'], true) => "Forms\\Components\\Textarea::make('{$column}')->json()->columnSpanFull()",
        in_array($type, ['date'], true) => "Forms\\Components\\DatePicker::make('{$column}')",
        in_array($type, ['datetime', 'timestamp'], true) => "Forms\\Components\\DateTimePicker::make('{$column}')",
        in_array($type, ['decimal', 'float', 'double', 'real'], true) => "Forms\\Components\\TextInput::make('{$column}')->numeric()",
        in_array($type, ['integer', 'bigint', 'smallint', 'mediumint'], true) => "Forms\\Components\\TextInput::make('{$column}')->numeric()",
        $column === 'status' => "Forms\\Components\\Select::make('{$column}')->options(['draft' => 'Draft', 'open' => 'Open', 'published' => 'Published', 'submitted' => 'Submitted', 'awarded' => 'Awarded', 'closed' => 'Closed', 'cancelled' => 'Cancelled', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'paid' => 'Paid', 'active' => 'Active', 'completed' => 'Completed'])->searchable()",
        $column === 'currency' => "Forms\\Components\\TextInput::make('{$column}')->maxLength(3)->default('USD')",
        $column === 'visibility' => "Forms\\Components\\Select::make('{$column}')->options(['public' => 'Public', 'private' => 'Private', 'invited' => 'Invited only'])",
        $column === 'type' => "Forms\\Components\\TextInput::make('{$column}')->maxLength(32)",
        $column === 'slug' => "Forms\\Components\\TextInput::make('{$column}')->maxLength(255)->unique(ignoreRecord: true)",
        default => "Forms\\Components\\TextInput::make('{$column}')->maxLength(255)",
    };
}

function filamentTableColumn(string $column, string $type): string
{
    return match (true) {
        in_array($type, ['boolean', 'bool'], true) => "Tables\\Columns\\IconColumn::make('{$column}')->boolean()",
        in_array($type, ['date'], true) => "Tables\\Columns\\TextColumn::make('{$column}')->date()->sortable()",
        in_array($type, ['datetime', 'timestamp'], true) => "Tables\\Columns\\TextColumn::make('{$column}')->dateTime()->sortable()",
        in_array($type, ['decimal', 'float', 'double'], true) => "Tables\\Columns\\TextColumn::make('{$column}')->money(fn (\$record) => \$record->currency ?? 'USD')->sortable()",
        $column === 'status' => "Tables\\Columns\\BadgeColumn::make('{$column}')",
        in_array($column, ['title', 'name', 'company_name', 'number', 'subject'], true) => "Tables\\Columns\\TextColumn::make('{$column}')->searchable()->sortable()",
        default => "Tables\\Columns\\TextColumn::make('{$column}')->searchable()->toggleable()",
    };
}
