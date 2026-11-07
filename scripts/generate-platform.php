<?php

declare(strict_types=1);

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
    file_put_contents($path, $content);
    echo 'Wrote '.str_replace(dirname(__DIR__).'/', '', $path).PHP_EOL;
}

function nextMigration(string $table): string
{
    global $migrationSeq;
    $file = sprintf('%s/app/Modules/Platform', dirname(__DIR__));
    unset($file);
    $name = sprintf('2026_11_07_%06d_create_%s_table.php', $migrationSeq, $table);
    $migrationSeq++;

    return $name;
}

/**
 * @param  array<string, array<string, mixed>>  $models
 */
function scaffoldModule(
    string $base,
    string $folder,
    string $key,
    string $name,
    string $description,
    string $icon,
    array $models,
    string $extraBoot = ''
): void {
    $ns = "App\\Modules\\Platform\\{$folder}";
    $path = "{$base}/app/Modules/Platform/{$folder}";

    writeFile("{$path}/Module.php", "<?php\n\nnamespace {$ns};\n\nuse App\\Modules\\AbstractModule;\n\nclass Module extends AbstractModule\n{\n}\n");

    writeFile("{$path}/module.json", json_encode([
        'key' => $key,
        'name' => $name,
        'description' => $description,
        'group' => 'Platform',
        'icon' => $icon,
        'dependencies' => ['core.organizations'],
        'is_core' => false,
        'default_enabled' => true,
        'permissions' => ['view', 'manage'],
        'provider' => "{$ns}\\ModuleServiceProvider",
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n");

    $resources = [];
    $policyLines = [];

    foreach ($models as $model => $cfg) {
        $table = $cfg['table'];
        $migName = nextMigration($table);
        $cols = implode("\n            ", $cfg['migration']);
        writeFile(
            "{$path}/Database/Migrations/{$migName}",
            "<?php\n\nuse Illuminate\\Database\\Migrations\\Migration;\nuse Illuminate\\Database\\Schema\\Blueprint;\nuse Illuminate\\Support\\Facades\\Schema;\n\nreturn new class extends Migration\n{\n    public function up(): void\n    {\n        Schema::create('{$table}', function (Blueprint \$table) {\n            \$table->id();\n            {$cols}\n            \$table->timestamps();\n        });\n    }\n\n    public function down(): void\n    {\n        Schema::dropIfExists('{$table}');\n    }\n};\n"
        );

        $uses = [
            'Illuminate\Database\Eloquent\Factories\HasFactory',
            'Illuminate\Database\Eloquent\Model',
            "{$ns}\\Database\\Factories\\{$model}Factory",
        ];
        $traitParts = ['HasFactory'];
        if (! empty($cfg['org'])) {
            $uses[] = 'App\Models\Concerns\BelongsToOrganization';
            $traitParts[] = 'BelongsToOrganization';
        }
        if (! empty($cfg['slug'])) {
            $uses[] = 'ImranDev\UniversalSlug\Attributes\Slug';
            $uses[] = 'ImranDev\UniversalSlug\Traits\HasUniversalSlug';
            $traitParts[] = 'HasUniversalSlug';
        }
        $slugAttr = ! empty($cfg['slug']) ? "#[Slug(from: '{$cfg['slug']}')]\n" : '';
        $casts = $cfg['casts_block'] ?? '';
        $useLines = implode(";\nuse ", $uses);
        $traits = implode(', ', $traitParts);

        writeFile(
            "{$path}/Models/{$model}.php",
            "<?php\n\nnamespace {$ns}\\Models;\n\nuse {$useLines};\n\n{$slugAttr}class {$model} extends Model\n{\n    use {$traits};\n\n    protected \$table = '{$table}';\n\n    protected \$guarded = [];\n{$casts}\n    protected static function newFactory(): {$model}Factory\n    {\n        return {$model}Factory::new();\n    }\n}\n"
        );

        $factoryDef = implode("\n            ", $cfg['factory']);
        writeFile(
            "{$path}/Database/Factories/{$model}Factory.php",
            "<?php\n\nnamespace {$ns}\\Database\\Factories;\n\nuse {$ns}\\Models\\{$model};\nuse Illuminate\\Database\\Eloquent\\Factories\\Factory;\n\n/** @extends Factory<{$model}> */\nclass {$model}Factory extends Factory\n{\n    protected \$model = {$model}::class;\n\n    public function definition(): array\n    {\n        return [\n            {$factoryDef}\n        ];\n    }\n}\n"
        );

        writeFile(
            "{$path}/Policies/{$model}Policy.php",
            "<?php\n\nnamespace {$ns}\\Policies;\n\nuse App\\Models\\User;\nuse {$ns}\\Models\\{$model};\n\nclass {$model}Policy\n{\n    public function viewAny(User \$user): bool { return true; }\n    public function view(User \$user, {$model} \$record): bool { return true; }\n    public function create(User \$user): bool { return true; }\n    public function update(User \$user, {$model} \$record): bool { return true; }\n    public function delete(User \$user, {$model} \$record): bool { return true; }\n}\n"
        );

        $slug = strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $model) ?? $model);
        $resNs = "{$ns}\\Filament\\Platform\\Resources";
        writeFile(
            "{$path}/Filament/Platform/Resources/{$model}Resource.php",
            "<?php\n\nnamespace {$resNs};\n\nuse {$ns}\\Models\\{$model};\nuse App\\Modules\\Platform\\Support\\Filament\\BasePlatformResource;\nuse Filament\\Forms;\nuse Filament\\Forms\\Form;\nuse Filament\\Tables;\nuse Filament\\Tables\\Table;\n\nclass {$model}Resource extends BasePlatformResource\n{\n    protected static ?string \$model = {$model}::class;\n    protected static ?string \$navigationIcon = 'heroicon-o-rectangle-stack';\n    protected static ?string \$navigationGroup = '{$name}';\n    protected static ?string \$slug = 'platform-{$slug}';\n\n    public static function form(Form \$form): Form\n    {\n        return \$form->schema([Forms\\Components\\TextInput::make('id')->disabled()]);\n    }\n\n    public static function table(Table \$table): Table\n    {\n        return \$table->columns([Tables\\Columns\\TextColumn::make('id')])->actions([Tables\\Actions\\EditAction::make()]);\n    }\n\n    public static function getPages(): array\n    {\n        return [\n            'index' => {$model}Resource\\Pages\\List{$model}s::route('/'),\n            'create' => {$model}Resource\\Pages\\Create{$model}::route('/create'),\n            'edit' => {$model}Resource\\Pages\\Edit{$model}::route('/{record}/edit'),\n        ];\n    }\n}\n"
        );

        foreach ([
            "List{$model}s" => 'ListRecords',
            "Create{$model}" => 'CreateRecord',
            "Edit{$model}" => 'EditRecord',
        ] as $page => $parent) {
            writeFile(
                "{$path}/Filament/Platform/Resources/{$model}Resource/Pages/{$page}.php",
                "<?php\n\nnamespace {$resNs}\\{$model}Resource\\Pages;\n\nuse {$resNs}\\{$model}Resource;\nuse Filament\\Resources\\Pages\\{$parent};\n\nclass {$page} extends {$parent}\n{\n    protected static string \$resource = {$model}Resource::class;\n}\n"
            );
        }

        $resources[] = "{$resNs}\\{$model}Resource::class";
        $policyLines[] = "Gate::policy({$ns}\\Models\\{$model}::class, {$ns}\\Policies\\{$model}Policy::class);";
    }

    $resList = implode(",\n                ", $resources);
    $polList = implode("\n        ", $policyLines);

    writeFile(
        "{$path}/ModuleServiceProvider.php",
        "<?php\n\nnamespace {$ns};\n\nuse App\\Modules\\Platform\\Support\\Concerns\\RegistersFilamentResources;\nuse App\\Modules\\Platform\\Support\\Concerns\\RegistersModuleMigrations;\nuse Illuminate\\Support\\Facades\\Gate;\nuse Illuminate\\Support\\ServiceProvider;\n\nclass ModuleServiceProvider extends ServiceProvider\n{\n    use RegistersFilamentResources, RegistersModuleMigrations;\n\n    public function register(): void {}\n\n    public function boot(): void\n    {\n        \$this->loadModuleMigrations();\n        \$this->registerPolicies();\n        \$this->registerFilamentForPanels([\n            'platform' => [\n                {$resList}\n            ],\n        ]);\n        {$extraBoot}\n    }\n\n    protected function registerPolicies(): void\n    {\n        {$polList}\n    }\n}\n"
    );
}

$jsonCast = <<<'JSON'


    protected function casts(): array
    {
        return [
            'content' => 'array',
        ];
    }

JSON;

$seoCols = [
    "\$table->string('meta_title')->nullable();",
    "\$table->text('meta_description')->nullable();",
    "\$table->string('og_image')->nullable();",
    "\$table->json('content')->nullable();",
];

scaffoldModule($base, 'Helpdesk', 'platform.helpdesk', 'Helpdesk', 'Tickets, SLA policies, and knowledge base.', 'heroicon-o-lifebuoy', [
    'SlaPolicy' => [
        'table' => 'helpdesk_sla_policies',
        'slug' => 'name',
        'org' => true,
        'migration' => [
            "\$table->foreignId('organization_id')->constrained()->cascadeOnDelete();",
            "\$table->string('name');",
            "\$table->string('slug')->unique();",
            "\$table->unsignedInteger('first_response_minutes')->default(60);",
            "\$table->unsignedInteger('resolution_minutes')->default(1440);",
        ],
        'factory' => ["'name' => fake()->words(3, true),", "'first_response_minutes' => 60,", "'resolution_minutes' => 1440,"],
    ],
    'Ticket' => [
        'table' => 'helpdesk_tickets',
        'slug' => 'subject',
        'org' => true,
        'migration' => [
            "\$table->foreignId('organization_id')->constrained()->cascadeOnDelete();",
            "\$table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();",
            "\$table->foreignId('sla_policy_id')->nullable()->constrained('helpdesk_sla_policies')->nullOnDelete();",
            "\$table->string('subject');",
            "\$table->string('slug')->unique();",
            "\$table->text('description')->nullable();",
            "\$table->string('status')->default('open');",
            "\$table->string('priority')->default('normal');",
        ],
        'factory' => ["'subject' => fake()->sentence(4),", "'description' => fake()->paragraph(),", "'status' => 'open',", "'priority' => 'normal',"],
    ],
    'TicketReply' => [
        'table' => 'helpdesk_ticket_replies',
        'org' => false,
        'migration' => [
            "\$table->foreignId('ticket_id')->constrained('helpdesk_tickets')->cascadeOnDelete();",
            "\$table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();",
            "\$table->text('body');",
            "\$table->boolean('is_internal')->default(false);",
        ],
        'factory' => ["'body' => fake()->paragraph(),", "'is_internal' => false,"],
    ],
    'KnowledgeBaseArticle' => [
        'table' => 'helpdesk_knowledge_base_articles',
        'slug' => 'title',
        'org' => true,
        'migration' => [
            "\$table->foreignId('organization_id')->constrained()->cascadeOnDelete();",
            "\$table->string('title');",
            "\$table->string('slug')->unique();",
            "\$table->text('content')->nullable();",
            "\$table->string('category')->nullable();",
            "\$table->timestamp('published_at')->nullable();",
        ],
        'factory' => ["'title' => fake()->sentence(3),", "'content' => fake()->paragraph(),", "'category' => 'general',"],
    ],
]);

$cmsModels = [
    'Page' => ['table' => 'cms_pages', 'slug' => 'title', 'org' => true, 'title' => 'title'],
    'BlogPost' => ['table' => 'cms_blog_posts', 'slug' => 'title', 'org' => true, 'title' => 'title'],
    'Faq' => ['table' => 'cms_faqs', 'slug' => 'question', 'org' => true, 'title' => 'question'],
    'Banner' => ['table' => 'cms_banners', 'slug' => 'title', 'org' => true, 'title' => 'title'],
];
$cmsScaffold = [];
foreach ($cmsModels as $model => $m) {
    $cmsScaffold[$model] = [
        'table' => $m['table'],
        'slug' => $m['slug'],
        'org' => true,
        'casts_block' => $jsonCast,
        'migration' => array_merge(
            ["\$table->foreignId('organization_id')->constrained()->cascadeOnDelete();", "\$table->string('{$m['title']}');", "\$table->string('slug')->unique();"],
            $seoCols,
            ["\$table->boolean('is_published')->default(false);"]
        ),
        'factory' => [
            "'{$m['title']}' => fake()->sentence(3),",
            "'meta_title' => fake()->sentence(4),",
            "'meta_description' => fake()->sentence(8),",
            "'content' => ['en' => fake()->paragraph()],",
            "'is_published' => true,",
        ],
    ];
}
scaffoldModule($base, 'CmsBlog', 'platform.cms-blog', 'CMS & Blog', 'Pages, blog, FAQs, and banners with SEO.', 'heroicon-o-document-text', $cmsScaffold);

scaffoldModule($base, 'ApiIntegrations', 'platform.api-integrations', 'API Integrations', 'Webhooks, API logs, and ERP connectors.', 'heroicon-o-globe-alt', [
    'WebhookEndpoint' => [
        'table' => 'api_webhook_endpoints',
        'org' => true,
        'migration' => [
            "\$table->foreignId('organization_id')->constrained()->cascadeOnDelete();",
            "\$table->string('name');",
            "\$table->string('url');",
            "\$table->string('secret')->nullable();",
            "\$table->json('events')->nullable();",
            "\$table->boolean('is_active')->default(true);",
        ],
        'casts_block' => "\n    protected function casts(): array\n    {\n        return ['events' => 'array'];\n    }\n",
        'factory' => ["'name' => fake()->words(2, true),", "'url' => fake()->url(),", "'events' => ['rfq.created'],", "'is_active' => true,"],
    ],
    'WebhookDelivery' => [
        'table' => 'api_webhook_deliveries',
        'org' => false,
        'migration' => [
            "\$table->foreignId('webhook_endpoint_id')->constrained('api_webhook_endpoints')->cascadeOnDelete();",
            "\$table->string('event');",
            "\$table->json('payload')->nullable();",
            "\$table->string('status')->default('pending');",
            "\$table->unsignedSmallInteger('response_code')->nullable();",
        ],
        'casts_block' => "\n    protected function casts(): array\n    {\n        return ['payload' => 'array'];\n    }\n",
        'factory' => ["'event' => 'rfq.created',", "'payload' => ['id' => 1],", "'status' => 'delivered',", "'response_code' => 200,"],
    ],
    'ApiLog' => [
        'table' => 'api_logs',
        'org' => true,
        'migration' => [
            "\$table->foreignId('organization_id')->nullable()->constrained()->nullOnDelete();",
            "\$table->string('method', 16);",
            "\$table->string('path');",
            "\$table->unsignedSmallInteger('status_code')->nullable();",
            "\$table->unsignedInteger('duration_ms')->nullable();",
            "\$table->json('request_body')->nullable();",
            "\$table->json('response_body')->nullable();",
        ],
        'casts_block' => "\n    protected function casts(): array\n    {\n        return ['request_body' => 'array', 'response_body' => 'array'];\n    }\n",
        'factory' => ["'method' => 'GET',", "'path' => '/api/v1/rfqs',", "'status_code' => 200,", "'duration_ms' => 12,"],
    ],
    'ErpConnector' => [
        'table' => 'api_erp_connectors',
        'org' => true,
        'migration' => [
            "\$table->foreignId('organization_id')->constrained()->cascadeOnDelete();",
            "\$table->string('provider');",
            "\$table->json('credentials')->nullable();",
            "\$table->boolean('is_active')->default(false);",
        ],
        'casts_block' => "\n    protected function casts(): array\n    {\n        return ['credentials' => 'array'];\n    }\n",
        'factory' => ["'provider' => 'quickbooks',", "'credentials' => [],", "'is_active' => false,"],
    ],
]);

scaffoldModule($base, 'SubscriptionsBilling', 'platform.subscriptions-billing', 'Subscriptions', 'Plans, subscriptions, invoices, and coupons.', 'heroicon-o-credit-card', [
    'Plan' => [
        'table' => 'subscription_plans',
        'slug' => 'name',
        'org' => false,
        'migration' => [
            "\$table->string('name');",
            "\$table->string('slug')->unique();",
            "\$table->json('modules')->nullable();",
            "\$table->boolean('is_active')->default(true);",
        ],
        'casts_block' => "\n    protected function casts(): array\n    {\n        return ['modules' => 'array'];\n    }\n",
        'factory' => ["'name' => fake()->words(2, true),", "'modules' => ['platform.helpdesk'],", "'is_active' => true,"],
    ],
    'PlanPrice' => [
        'table' => 'subscription_plan_prices',
        'org' => false,
        'migration' => [
            "\$table->foreignId('plan_id')->constrained('subscription_plans')->cascadeOnDelete();",
            "\$table->string('currency', 3)->default('USD');",
            "\$table->decimal('amount', 12, 2);",
            "\$table->string('interval')->default('month');",
        ],
        'factory' => ["'currency' => 'USD',", "'amount' => 49.00,", "'interval' => 'month',"],
    ],
    'Subscription' => [
        'table' => 'subscriptions',
        'org' => true,
        'migration' => [
            "\$table->foreignId('organization_id')->constrained()->cascadeOnDelete();",
            "\$table->foreignId('plan_id')->constrained('subscription_plans')->cascadeOnDelete();",
            "\$table->string('status')->default('active');",
            "\$table->timestamp('starts_at')->nullable();",
            "\$table->timestamp('ends_at')->nullable();",
        ],
        'factory' => ["'status' => 'active',", "'starts_at' => now(),", "'ends_at' => now()->addYear(),",
        ],
    ],
    'SubscriptionInvoice' => [
        'table' => 'subscription_invoices',
        'org' => false,
        'migration' => [
            "\$table->foreignId('subscription_id')->constrained('subscriptions')->cascadeOnDelete();",
            "\$table->string('number')->unique();",
            "\$table->decimal('amount', 12, 2);",
            "\$table->string('status')->default('open');",
            "\$table->timestamp('due_at')->nullable();",
            "\$table->timestamp('paid_at')->nullable();",
        ],
        'factory' => ["'number' => 'INV-'.fake()->unique()->numerify('######'),", "'amount' => 49.00,", "'status' => 'open',"],
    ],
    'UsageLimit' => [
        'table' => 'usage_limits',
        'org' => true,
        'migration' => [
            "\$table->foreignId('organization_id')->constrained()->cascadeOnDelete();",
            "\$table->string('metric');",
            "\$table->unsignedBigInteger('limit_value')->default(0);",
            "\$table->unsignedBigInteger('current_value')->default(0);",
        ],
        'factory' => ["'metric' => 'api_calls',", "'limit_value' => 10000,", "'current_value' => 0,"],
    ],
    'CouponPlatform' => [
        'table' => 'coupons_platform',
        'org' => false,
        'migration' => [
            "\$table->string('code')->unique();",
            "\$table->unsignedTinyInteger('discount_percent')->nullable();",
            "\$table->decimal('discount_amount', 12, 2)->nullable();",
            "\$table->unsignedInteger('max_uses')->nullable();",
            "\$table->timestamp('expires_at')->nullable();",
        ],
        'factory' => ["'code' => strtoupper(fake()->bothify('SAVE##??')),", "'discount_percent' => 10,", "'max_uses' => 100,"],
    ],
]);

scaffoldModule($base, 'SecurityCenter', 'platform.security-center', 'Security Center', 'IP allowlists, sessions, and GDPR.', 'heroicon-o-shield-check', [
    'IpAllowlist' => [
        'table' => 'security_ip_allowlists',
        'org' => true,
        'migration' => [
            "\$table->foreignId('organization_id')->constrained()->cascadeOnDelete();",
            "\$table->string('cidr');",
            "\$table->string('label')->nullable();",
            "\$table->boolean('is_active')->default(true);",
        ],
        'factory' => ["'cidr' => '192.168.0.0/24',", "'label' => 'Office',", "'is_active' => true,"],
    ],
    'UserSessionTracking' => [
        'table' => 'security_user_sessions_tracking',
        'org' => false,
        'migration' => [
            "\$table->foreignId('user_id')->constrained()->cascadeOnDelete();",
            "\$table->string('ip', 45)->nullable();",
            "\$table->text('user_agent')->nullable();",
            "\$table->timestamp('last_activity_at')->nullable();",
            "\$table->timestamp('logged_out_at')->nullable();",
        ],
        'factory' => ["'ip' => '127.0.0.1',", "'user_agent' => 'Pest',", "'last_activity_at' => now(),",],
    ],
    'GdprRequest' => [
        'table' => 'security_gdpr_requests',
        'org' => true,
        'migration' => [
            "\$table->foreignId('organization_id')->constrained()->cascadeOnDelete();",
            "\$table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();",
            "\$table->string('type');",
            "\$table->string('status')->default('pending');",
            "\$table->json('payload')->nullable();",
        ],
        'casts_block' => "\n    protected function casts(): array\n    {\n        return ['payload' => 'array'];\n    }\n",
        'factory' => ["'type' => 'export',", "'status' => 'pending',", "'payload' => [],",],
    ],
    'SecuritySetting' => [
        'table' => 'security_settings',
        'org' => true,
        'migration' => [
            "\$table->foreignId('organization_id')->constrained()->cascadeOnDelete();",
            "\$table->json('settings')->nullable();",
            "\$table->unique('organization_id');",
        ],
        'casts_block' => "\n    protected function casts(): array\n    {\n        return ['settings' => 'array'];\n    }\n",
        'factory' => ["'settings' => ['mfa_required' => false],",],
    ],
]);

scaffoldModule($base, 'DataImportExport', 'platform.data-import-export', 'Import / Export', 'Import jobs, exports, and backup logs.', 'heroicon-o-arrow-down-tray', [
    'ImportJob' => [
        'table' => 'data_import_jobs',
        'org' => true,
        'migration' => [
            "\$table->foreignId('organization_id')->constrained()->cascadeOnDelete();",
            "\$table->string('type');",
            "\$table->string('file_path')->nullable();",
            "\$table->string('status')->default('pending');",
            "\$table->json('stats')->nullable();",
        ],
        'casts_block' => "\n    protected function casts(): array\n    {\n        return ['stats' => 'array'];\n    }\n",
        'factory' => ["'type' => 'suppliers',", "'status' => 'pending',", "'stats' => [],",],
    ],
    'ExportJob' => [
        'table' => 'data_export_jobs',
        'org' => true,
        'migration' => [
            "\$table->foreignId('organization_id')->constrained()->cascadeOnDelete();",
            "\$table->string('type');",
            "\$table->string('file_path')->nullable();",
            "\$table->string('status')->default('pending');",
            "\$table->json('stats')->nullable();",
        ],
        'casts_block' => "\n    protected function casts(): array\n    {\n        return ['stats' => 'array'];\n    }\n",
        'factory' => ["'type' => 'rfqs',", "'status' => 'pending',", "'stats' => [],",],
    ],
    'BackupLog' => [
        'table' => 'data_backup_logs',
        'org' => true,
        'migration' => [
            "\$table->foreignId('organization_id')->constrained()->cascadeOnDelete();",
            "\$table->string('path');",
            "\$table->unsignedBigInteger('size_bytes')->default(0);",
            "\$table->string('status')->default('completed');",
        ],
        'factory' => ["'path' => 'backups/'.fake()->uuid().'.zip',", "'size_bytes' => 1024,", "'status' => 'completed',",],
    ],
]);

scaffoldModule($base, 'MultiLanguagePdf', 'platform.multi-language-pdf', 'PDF Templates', 'Multi-language PDF document templates.', 'heroicon-o-document', [
    'DocumentTemplate' => [
        'table' => 'document_templates',
        'org' => true,
        'migration' => [
            "\$table->foreignId('organization_id')->constrained()->cascadeOnDelete();",
            "\$table->string('type');",
            "\$table->text('letterhead')->nullable();",
            "\$table->longText('body_html')->nullable();",
            "\$table->string('locale', 12)->default('en');",
        ],
        'factory' => ["'type' => 'invoice',", "'letterhead' => '<h1>Company</h1>',", "'body_html' => '<p>Hello</p>',", "'locale' => 'en',",],
    ],
], "\$this->app->singleton(\\App\\Modules\\Platform\\MultiLanguagePdf\\Services\\DocumentPdfService::class);");

// ERP adapters
$erpPath = "{$base}/app/Modules/Platform/ApiIntegrations";
$adapterNs = 'App\\Modules\\Platform\\ApiIntegrations\\Contracts';
writeFile("{$erpPath}/Contracts/ErpConnectorAdapterInterface.php", "<?php\n\nnamespace {$adapterNs};\n\ninterface ErpConnectorAdapterInterface\n{\n    /**\n     * @return array<int, mixed>\n     */\n    public function syncInvoices(): array;\n}\n");
foreach (['Quickbooks', 'Xero', 'Odoo'] as $erp) {
    writeFile("{$erpPath}/Adapters/{$erp}Adapter.php", "<?php\n\nnamespace App\\Modules\\Platform\\ApiIntegrations\\Adapters;\n\nuse App\\Modules\\Platform\\ApiIntegrations\\Contracts\\ErpConnectorAdapterInterface;\n\nclass {$erp}Adapter implements ErpConnectorAdapterInterface\n{\n    public function syncInvoices(): array\n    {\n        return [];\n    }\n}\n");
}

// MultiLanguagePdf service
$pdfNs = 'App\\Modules\\Platform\\MultiLanguagePdf\\Services';
writeFile("{$base}/app/Modules/Platform/MultiLanguagePdf/Services/DocumentPdfService.php", "<?php\n\nnamespace {$pdfNs};\n\nuse App\\Modules\\Platform\\MultiLanguagePdf\\Models\\DocumentTemplate;\nuse App\\Services\\Packages\\UnicodePdfService;\nuse Symfony\\Component\\HttpFoundation\\Response as SymfonyResponse;\n\nclass DocumentPdfService\n{\n    public function __construct(\n        private UnicodePdfService \$unicodePdf\n    ) {}\n\n    /**\n     * @param  array<string, mixed>  $data\n     */\n    public function renderTemplate(DocumentTemplate \$template, array \$data = [], ?string \$filename = null): SymfonyResponse\n    {\n        \$filename ??= \$template->type.'-'.\$template->locale.'.pdf';\n\n        return \$this->unicodePdf->stream('pdf.document', array_merge(\$data, [\n            'letterhead' => \$template->letterhead,\n            'body_html' => \$template->body_html,\n            'locale' => \$template->locale,\n        ]), \$filename);\n    }\n}\n");

echo "Done. Last migration seq: {$migrationSeq}\n";
