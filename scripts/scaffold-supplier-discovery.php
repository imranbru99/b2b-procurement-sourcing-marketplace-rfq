<?php

declare(strict_types=1);

/**
 * One-off scaffold for Supplier Discovery module artifacts.
 */

$root = dirname(__DIR__);

$models = [
    'Directory' => [
        ['SupplierProfile', 'supplier_profiles', true, true, 'company_name'],
        ['SupplierCategory', 'supplier_categories', false, false, 'name'],
        ['SupplierCertification', 'supplier_certifications', false, false, null],
        ['SupplierFavorite', 'supplier_favorites', false, false, null],
        ['SavedSearch', 'saved_searches', true, false, null],
    ],
    'Storefronts' => [
        ['SupplierStorefront', 'supplier_storefronts', false, false, null],
        ['PortfolioItem', 'portfolio_items', false, true, null],
        ['SupplierFactory', 'supplier_factories', false, false, null],
        ['SupplierVideo', 'supplier_videos', false, false, null],
        ['SupplierDownload', 'supplier_downloads', false, true, null],
    ],
    'Catalog' => [
        ['Product', 'products', true, true, 'name'],
        ['ProductPriceTier', 'product_price_tiers', false, false, null],
        ['ProductSpecialPrice', 'product_special_prices', false, false, null],
    ],
    'KycOnboarding' => [
        ['KycApplication', 'kyc_applications', true, false, null],
        ['KycDocument', 'kyc_documents', false, true, null],
        ['SupplierBlacklist', 'supplier_blacklist', true, false, null],
    ],
    'ReviewsScorecards' => [
        ['SupplierReview', 'supplier_reviews', false, false, null],
        ['VendorKpi', 'vendor_kpis', false, false, null],
        ['VendorScorecard', 'vendor_scorecards', false, false, null],
    ],
    'RiskCompliance' => [
        ['RiskScore', 'risk_scores', false, false, null],
        ['ComplianceDocument', 'compliance_documents', false, true, null],
        ['EsgQuestionnaire', 'esg_questionnaires', false, false, null],
        ['ApprovedVendorList', 'approved_vendor_lists', false, false, null],
    ],
    'LeadsAdvertising' => [
        ['SponsoredListing', 'sponsored_listings', false, false, null],
        ['FeaturedSupplier', 'featured_suppliers', false, false, null],
        ['LeadUnlock', 'lead_unlocks', false, false, null],
        ['AdvertisingCoupon', 'advertising_coupons', false, false, null],
    ],
];

foreach ($models as $module => $entries) {
    foreach ($entries as [$class, $table, $belongsToOrg, $hasMedia, $slugFrom]) {
        $modelPath = "$root/app/Modules/Suppliers/$module/Models/$class.php";
        $factoryPath = "$root/app/Modules/Suppliers/$module/Database/Factories/{$class}Factory.php";
        $policyPath = "$root/app/Modules/Suppliers/$module/Policies/{$class}Policy.php";

        @mkdir(dirname($modelPath), 0777, true);
        @mkdir(dirname($factoryPath), 0777, true);
        @mkdir(dirname($policyPath), 0777, true);

        $uses = [
            'use Illuminate\\Database\\Eloquent\\Factories\\HasFactory;',
            'use Illuminate\\Database\\Eloquent\\Model;',
        ];
        $traits = ['HasFactory'];

        if ($belongsToOrg) {
            $uses[] = 'use App\\Models\\Concerns\\BelongsToOrganization;';
            $traits[] = 'BelongsToOrganization';
        }

        if ($slugFrom) {
            $uses[] = 'use ImranDev\\UniversalSlug\\Attributes\\Slug;';
            $uses[] = 'use ImranDev\\UniversalSlug\\Traits\\HasUniversalSlug;';
            $traits[] = 'HasUniversalSlug';
        }

        if ($hasMedia) {
            $uses[] = 'use Spatie\\MediaLibrary\\HasMedia;';
            $uses[] = 'use Spatie\\MediaLibrary\\InteractsWithMedia;';
            $traits[] = 'InteractsWithMedia';
        }

        $implements = $hasMedia ? ' implements HasMedia' : '';
        $slugAttr = $slugFrom ? "#[Slug(from: '$slugFrom')]\n" : '';
        $mediaMethods = $hasMedia ? "\n    public function registerMediaCollections(): void\n    {\n        \$this->addMediaCollection('default')->useDisk(config('filesystems.default'));\n    }\n" : '';

        $factoryFqn = "App\\Modules\\Suppliers\\$module\\Database\\Factories\\{$class}Factory";
        $newFactory = "    protected static function newFactory(): {$class}Factory\n    {\n        return {$class}Factory::new();\n    }\n\n";

        $modelBody = "<?php\n\nnamespace App\\Modules\\Suppliers\\$module\\Models;\n\n".implode("\n", $uses)."\nuse App\\Modules\\Suppliers\\$module\\Database\\Factories\\{$class}Factory;\n\n{$slugAttr}class $class extends Model{$implements}\n{\n    /** @use HasFactory<{$class}Factory> */\n    use ".implode(', ', $traits).";\n\n    protected \$table = '$table';\n\n    protected \$guarded = [];\n\n{$newFactory}\n    protected function casts(): array\n    {\n        return [\n            'verified_at' => 'datetime',\n            'variants' => 'array',\n            'filters' => 'array',\n            'theme' => 'array',\n            'seo' => 'array',\n            'checklist' => 'array',\n            'responses' => 'array',\n            'dimensions' => 'array',\n            'factors' => 'array',\n            'is_active' => 'boolean',\n            'is_published' => 'boolean',\n            'is_featured' => 'boolean',\n            'is_verified' => 'boolean',\n            'is_primary' => 'boolean',\n            'notify_on_match' => 'boolean',\n            'requires_lead_unlock' => 'boolean',\n        ];\n    }{$mediaMethods}\n}\n";

        file_put_contents($modelPath, $modelBody);

        $factoryBody = "<?php\n\nnamespace App\\Modules\\Suppliers\\$module\\Database\\Factories;\n\nuse App\\Modules\\Suppliers\\$module\\Models\\$class;\nuse Illuminate\\Database\\Eloquent\\Factories\\Factory;\n\n/**\n * @extends Factory<$class>\n */\nclass {$class}Factory extends Factory\n{\n    protected \$model = $class::class;\n\n    public function definition(): array\n    {\n        return [];\n    }\n}\n";
        file_put_contents($factoryPath, $factoryBody);

        $policyBody = "<?php\n\nnamespace App\\Modules\\Suppliers\\$module\\Policies;\n\nuse App\\Models\\User;\nuse App\\Modules\\Suppliers\\$module\\Models\\$class;\n\nclass {$class}Policy\n{\n    public function viewAny(User \$user): bool\n    {\n        return true;\n    }\n\n    public function view(User \$user, $class \$record): bool\n    {\n        return true;\n    }\n\n    public function create(User \$user): bool\n    {\n        return true;\n    }\n\n    public function update(User \$user, $class \$record): bool\n    {\n        return true;\n    }\n\n    public function delete(User \$user, $class \$record): bool\n    {\n        return true;\n    }\n}\n";
        file_put_contents($policyPath, $policyBody);

        // Filament resource skeleton for key models
        if (in_array($class, ['SupplierProfile', 'Product', 'KycApplication', 'SupplierReview', 'RiskScore', 'SponsoredListing', 'SupplierCategory'], true)) {
            foreach (['Supplier' => 'supplier', 'Buyer' => 'buyer', 'Platform' => 'platform'] as $panelDir => $panelId) {
                $filamentBase = "$root/app/Modules/Suppliers/$module/Filament/$panelDir/Resources";
                $resourceClass = "{$class}Resource";
                @mkdir("$filamentBase/{$resourceClass}/Pages", 0777, true);
                $resourceNs = "App\\Modules\\Suppliers\\$module\\Filament\\$panelDir\\Resources";
                $modelFqn = "App\\Modules\\Suppliers\\$module\\Models\\$class";

                $slug = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $class));
                $resourcePath = "$filamentBase/{$resourceClass}.php";

                $resourceBody = "<?php\n\nnamespace $resourceNs;\n\nuse $modelFqn;\nuse App\\Modules\\Suppliers\\Support\\Filament\\BaseSupplierResource;\nuse Filament\\Forms;\nuse Filament\\Forms\\Form;\nuse Filament\\Tables;\nuse Filament\\Tables\\Table;\n\nclass $resourceClass extends BaseSupplierResource\n{\n    protected static ?string \$model = $class::class;\n\n    protected static ?string \$navigationIcon = 'heroicon-o-rectangle-stack';\n\n    protected static ?string \$slug = '{$slug}-{$panelId}';\n\n    public static function form(Form \$form): Form\n    {\n        return \$form->schema([\n            Forms\\Components\\TextInput::make('id')->disabled(),\n        ]);\n    }\n\n    public static function table(Table \$table): Table\n    {\n        return \$table\n            ->columns([\n                Tables\\Columns\\TextColumn::make('id'),\n            ])\n            ->actions([\n                Tables\\Actions\\EditAction::make(),\n            ]);\n    }\n\n    public static function getPages(): array\n    {\n        return [\n            'index' => {$resourceClass}\\Pages\\List{$class}s::route('/'),\n            'create' => {$resourceClass}\\Pages\\Create{$class}::route('/create'),\n            'edit' => {$resourceClass}\\Pages\\Edit{$class}::route('/{record}/edit'),\n        ];\n    }\n}\n";
                file_put_contents($resourcePath, $resourceBody);

                foreach (['List' => 'ListRecords', 'Create' => 'CreateRecord', 'Edit' => 'EditRecord'] as $prefix => $base) {
                    $pageClass = $prefix === 'List' ? "List{$class}s" : "{$prefix}{$class}";
                    $pageBase = $prefix === 'List' ? 'ListRecords' : ($prefix === 'Create' ? 'CreateRecord' : 'EditRecord');
                    $pagePath = "$filamentBase/{$resourceClass}/Pages/{$pageClass}.php";
                    $pageBody = "<?php\n\nnamespace $resourceNs\\{$resourceClass}\\Pages;\n\nuse $resourceNs\\{$resourceClass};\nuse Filament\\Resources\\Pages\\{$pageBase};\n\nclass $pageClass extends {$pageBase}\n{\n    protected static string \$resource = {$resourceClass}::class;\n}\n";
                    file_put_contents($pagePath, $pageBody);
                }
            }
        }
    }
}

echo "Generated models, factories, policies, and Filament stubs.\n";
