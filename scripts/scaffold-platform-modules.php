<?php

declare(strict_types=1);

/**
 * One-off scaffold for Platform modules. Run: php scripts/scaffold-platform-modules.php
 */

$base = dirname(__DIR__);
$migrationSeq = 194001;

function ensureDir(string $path): void
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

function writeFile(string $path, string $content): void
{
    ensureDir(dirname($path));
    if (! file_exists($path)) {
        file_put_contents($path, $content);
        echo "Wrote {$path}\n";
    }
}

function nextMigration(): string
{
    global $migrationSeq;
    $name = sprintf('2026_11_07_%06d', $migrationSeq);
    $migrationSeq++;

    return $name;
}

function modulePhp(string $ns): string
{
    return <<<PHP
<?php

namespace {$ns};

use App\Modules\AbstractModule;

class Module extends AbstractModule
{
}

PHP;
}

function policyPhp(string $ns, string $modelShort): string
{
    return <<<PHP
<?php

namespace {$ns}\\Policies;

use App\Models\User;
use {$ns}\\Models\\{$modelShort};

class {$modelShort}Policy
{
    public function viewAny(User \$user): bool
    {
        return true;
    }

    public function view(User \$user, {$modelShort} \$record): bool
    {
        return true;
    }

    public function create(User \$user): bool
    {
        return true;
    }

    public function update(User \$user, {$modelShort} \$record): bool
    {
        return true;
    }

    public function delete(User \$user, {$modelShort} \$record): bool
    {
        return true;
    }
}

PHP;
}

function factoryPhp(string $ns, string $modelShort, string $table, array $definitionLines): string
{
    $def = implode(",\n            ", $definitionLines);

    return <<<PHP
<?php

namespace {$ns}\\Database\\Factories;

use {$ns}\\Models\\{$modelShort};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<{$modelShort}>
 */
class {$modelShort}Factory extends Factory
{
    protected \$model = {$modelShort}::class;

    public function definition(): array
    {
        return [
            {$def}
        ];
    }
}

PHP;
}

function filamentResourcePhp(string $ns, string $modelShort, string $group, string $slug): string
{
    $pagesNs = "{$ns}\\Filament\\Platform\\Resources\\{$modelShort}Resource";

    return <<<PHP
<?php

namespace {$ns}\\Filament\\Platform\\Resources;

use {$ns}\\Models\\{$modelShort};
use App\Modules\Platform\Support\Filament\BasePlatformResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class {$modelShort}Resource extends BasePlatformResource
{
    protected static ?string \$model = {$modelShort}::class;

    protected static ?string \$navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string \$navigationGroup = '{$group}';

    protected static ?string \$slug = '{$slug}';

    public static function form(Form \$form): Form
    {
        return \$form->schema([
            Forms\Components\TextInput::make('id')->disabled(),
        ]);
    }

    public static function table(Table \$table): Table
    {
        return \$table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => {$pagesNs}\\Pages\\List{$modelShort}s::route('/'),
            'create' => {$pagesNs}\\Pages\\Create{$modelShort}::route('/create'),
            'edit' => {$pagesNs}\\Pages\\Edit{$modelShort}::route('/{record}/edit'),
        ];
    }
}

PHP;
}

function filamentPages(string $ns, string $modelShort): void
{
    $resource = "{$ns}\\Filament\\Platform\\Resources\\{$modelShort}Resource";
    $base = str_replace('\\', '/', $ns)."/Filament/Platform/Resources/{$modelShort}Resource/Pages";

    writeFile(dirname(__DIR__)."/app/Modules/Platform/".substr($base, strlen('App/Modules/Platform/')), <<<PHP
<?php

namespace {$resource}\\Pages;

use {$resource};
use Filament\Resources\Pages\ListRecords;

class List{$modelShort}s extends ListRecords
{
    protected static string \$resource = {$modelShort}Resource::class;
}

PHP);

    // Fix path - need correct approach
}

$platformSupport = <<<'PHP'
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

PHP;

writeFile("{$base}/app/Modules/Platform/Support/Concerns/RegistersModuleMigrations.php", $platformSupport);

$regFilament = <<<'PHP'
<?php

namespace App\Modules\Platform\Support\Concerns;

use Filament\Panel;

trait RegistersFilamentResources
{
    /**
     * @param  array<string, list<class-string>>  $resourcesByPanel
     */
    protected function registerFilamentForPanels(array $resourcesByPanel): void
    {
        if (! class_exists(Panel::class)) {
            return;
        }

        foreach ($resourcesByPanel as $panelId => $resources) {
            Panel::configureUsing(function (Panel $panel) use ($panelId, $resources): void {
                if ($panel->getId() !== $panelId) {
                    return;
                }

                $panel->resources($resources);
            });
        }
    }
}

PHP;

writeFile("{$base}/app/Modules/Platform/Support/Concerns/RegistersFilamentResources.php", $regFilament);

writeFile("{$base}/app/Modules/Platform/Support/Filament/BasePlatformResource.php", <<<'PHP'
<?php

namespace App\Modules\Platform\Support\Filament;

use Filament\Resources\Resource;

abstract class BasePlatformResource extends Resource
{
    protected static ?string $navigationGroup = 'Platform';
}

PHP);

// Module definitions
$modules = [
    'Helpdesk' => [
        'key' => 'platform.helpdesk',
        'name' => 'Helpdesk',
        'description' => 'Support tickets, SLA policies, and knowledge base.',
        'icon' => 'heroicon-o-lifebuoy',
        'group' => 'Platform',
        'nav' => 'Helpdesk',
        'models' => [
            'Ticket' => [
                'table' => 'helpdesk_tickets',
                'slug_from' => 'subject',
                'org' => true,
                'columns' => [
                    "\$table->foreignId('organization_id')->constrained()->cascadeOnDelete();",
                    "\$table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();",
                    "\$table->foreignId('sla_policy_id')->nullable()->constrained('helpdesk_sla_policies')->nullOnDelete();",
                    "\$table->string('subject');",
                    "\$table->string('slug')->unique();",
                    "\$table->text('description')->nullable();",
                    "\$table->string('status')->default('open');",
                    "\$table->string('priority')->default('normal');",
                ],
                'factory' => [
                    "'subject' => fake()->sentence(4),",
                    "'description' => fake()->paragraph(),",
                    "'status' => 'open',",
                    "'priority' => 'normal',",
                ],
            ],
            'SlaPolicy' => [
                'table' => 'helpdesk_sla_policies',
                'slug_from' => 'name',
                'org' => true,
                'columns' => [
                    "\$table->foreignId('organization_id')->constrained()->cascadeOnDelete();",
                    "\$table->string('name');",
                    "\$table->string('slug')->unique();",
                    "\$table->unsignedInteger('first_response_minutes')->default(60);",
                    "\$table->unsignedInteger('resolution_minutes')->default(1440);",
                ],
                'factory' => [
                    "'name' => fake()->words(3, true),",
                    "'first_response_minutes' => 60,",
                    "'resolution_minutes' => 1440,",
                ],
            ],
            'TicketReply' => [
                'table' => 'helpdesk_ticket_replies',
                'slug_from' => null,
                'org' => false,
                'columns' => [
                    "\$table->foreignId('ticket_id')->constrained('helpdesk_tickets')->cascadeOnDelete();",
                    "\$table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();",
                    "\$table->text('body');",
                    "\$table->boolean('is_internal')->default(false);",
                ],
                'factory' => [
                    "'body' => fake()->paragraph(),",
                    "'is_internal' => false,",
                ],
            ],
            'KnowledgeBaseArticle' => [
                'table' => 'helpdesk_knowledge_base_articles',
                'slug_from' => 'title',
                'org' => true,
                'columns' => [
                    "\$table->foreignId('organization_id')->constrained()->cascadeOnDelete();",
                    "\$table->string('title');",
                    "\$table->string('slug')->unique();",
                    "\$table->text('content')->nullable();",
                    "\$table->string('category')->nullable();",
                    "\$table->timestamp('published_at')->nullable();",
                ],
                'factory' => [
                    "'title' => fake()->sentence(3),",
                    "'content' => fake()->paragraphs(2, true),",
                    "'category' => fake()->word(),",
                ],
            ],
        ],
    ],
];

echo "Scaffold partial - use full implementation\n";
