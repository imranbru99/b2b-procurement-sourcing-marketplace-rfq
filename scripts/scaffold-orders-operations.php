<?php

/**
 * One-time scaffold for Orders & Operations modules.
 * Run: php scripts/scaffold-orders-operations.php
 */

declare(strict_types=1);

$root = dirname(__DIR__);

$modules = [
    'Orders' => [
        'PurchaseOrders' => [
            'key' => 'orders.purchase-orders',
            'name' => 'Purchase Orders',
            'description' => 'Purchase order lifecycle, line items, revisions, and supplier acknowledgment.',
            'icon' => 'heroicon-o-document-text',
            'dependencies' => ['core.organizations', 'sourcing.purchase-requisitions'],
            'permissions' => ['purchase_orders.view', 'purchase_orders.manage'],
            'primary_model' => 'PurchaseOrder',
            'tables' => [
                'purchase_orders' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'supplier_organization_id|foreignId|nullable|constrained:organizations|nullOnDelete',
                    'number|string|unique',
                    'status|string|32|default:draft',
                    'currency|string|3|default:USD',
                    'subtotal|decimal:15,2|default:0',
                    'tax_total|decimal:15,2|default:0',
                    'total|decimal:15,2|default:0',
                    'issued_at|timestamp|nullable',
                    'expected_delivery_at|timestamp|nullable',
                    'notes|text|nullable',
                ],
                'po_items' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'purchase_order_id|foreignId|constrained:purchase_orders|cascadeOnDelete',
                    'sku|string|nullable',
                    'description|string',
                    'quantity|decimal:12,3|default:1',
                    'unit_price|decimal:15,4|default:0',
                    'line_total|decimal:15,2|default:0',
                ],
                'po_revisions' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'purchase_order_id|foreignId|constrained:purchase_orders|cascadeOnDelete',
                    'revision_number|unsignedInteger|default:1',
                    'snapshot|json|nullable',
                    'created_by|foreignId|nullable|constrained:users|nullOnDelete',
                ],
                'po_acknowledgments' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'purchase_order_id|foreignId|constrained:purchase_orders|cascadeOnDelete',
                    'acknowledged_at|timestamp|nullable',
                    'acknowledged_by|foreignId|nullable|constrained:users|nullOnDelete',
                    'status|string|32|default:pending',
                    'comments|text|nullable',
                ],
            ],
        ],
        'GoodsReceipt' => [
            'key' => 'orders.goods-receipt',
            'name' => 'Goods Receipt',
            'description' => 'GRN processing, QC inspections, and returns.',
            'icon' => 'heroicon-o-truck',
            'dependencies' => ['orders.purchase-orders'],
            'permissions' => ['goods_receipt.view', 'goods_receipt.manage'],
            'primary_model' => 'Grn',
            'tables' => [
                'grns' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'purchase_order_id|foreignId|nullable|constrained:purchase_orders|nullOnDelete',
                    'number|string',
                    'status|string|32|default:draft',
                    'received_at|timestamp|nullable',
                    'warehouse|string|nullable',
                ],
                'grn_items' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'grn_id|foreignId|constrained:grns|cascadeOnDelete',
                    'po_item_id|foreignId|nullable|constrained:po_items|nullOnDelete',
                    'description|string',
                    'quantity_received|decimal:12,3|default:0',
                    'quantity_accepted|decimal:12,3|default:0',
                ],
                'qc_inspections' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'grn_id|foreignId|constrained:grns|cascadeOnDelete',
                    'inspector_id|foreignId|nullable|constrained:users|nullOnDelete',
                    'status|string|32|default:pending',
                    'passed|boolean|default:false',
                    'notes|text|nullable',
                    'inspected_at|timestamp|nullable',
                ],
                'goods_returns' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'grn_id|foreignId|constrained:grns|cascadeOnDelete',
                    'reason|string|nullable',
                    'status|string|32|default:open',
                    'quantity|decimal:12,3|default:0',
                ],
            ],
        ],
        'Invoicing' => [
            'key' => 'orders.invoicing',
            'name' => 'Invoicing',
            'description' => 'Supplier invoices, line items, credit notes, and tax fields.',
            'icon' => 'heroicon-o-receipt-percent',
            'dependencies' => ['orders.goods-receipt'],
            'permissions' => ['invoicing.view', 'invoicing.manage'],
            'primary_model' => 'Invoice',
            'tables' => [
                'invoices' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'purchase_order_id|foreignId|nullable|constrained:purchase_orders|nullOnDelete',
                    'grn_id|foreignId|nullable|constrained:grns|nullOnDelete',
                    'number|string',
                    'status|string|32|default:draft',
                    'currency|string|3|default:USD',
                    'subtotal|decimal:15,2|default:0',
                    'tax_type|string|16|nullable',
                    'tax_rate|decimal:8,4|default:0',
                    'tax_total|decimal:15,2|default:0',
                    'total|decimal:15,2|default:0',
                    'issued_at|timestamp|nullable',
                    'due_at|timestamp|nullable',
                ],
                'invoice_items' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'invoice_id|foreignId|constrained:invoices|cascadeOnDelete',
                    'description|string',
                    'quantity|decimal:12,3|default:1',
                    'unit_price|decimal:15,4|default:0',
                    'line_total|decimal:15,2|default:0',
                ],
                'credit_notes' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'invoice_id|foreignId|constrained:invoices|cascadeOnDelete',
                    'number|string',
                    'amount|decimal:15,2|default:0',
                    'reason|text|nullable',
                    'issued_at|timestamp|nullable',
                ],
            ],
        ],
        'Payments' => [
            'key' => 'orders.payments',
            'name' => 'Payments',
            'description' => 'Payments, schedules, proofs, and gateway transactions.',
            'icon' => 'heroicon-o-banknotes',
            'dependencies' => ['orders.invoicing'],
            'permissions' => ['payments.view', 'payments.manage'],
            'primary_model' => 'Payment',
            'extra' => 'payments',
            'tables' => [
                'payments' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'invoice_id|foreignId|nullable|constrained:invoices|nullOnDelete',
                    'reference|string|nullable',
                    'status|string|32|default:pending',
                    'method|string|32|default:bank_transfer',
                    'gateway|string|32|nullable',
                    'currency|string|3|default:USD',
                    'amount|decimal:15,2|default:0',
                    'paid_at|timestamp|nullable',
                ],
                'payment_schedules' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'payment_id|foreignId|constrained:payments|cascadeOnDelete',
                    'due_at|timestamp|nullable',
                    'amount|decimal:15,2|default:0',
                    'status|string|32|default:scheduled',
                ],
                'payment_proofs' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'payment_id|foreignId|constrained:payments|cascadeOnDelete',
                    'file_path|string|nullable',
                    'uploaded_at|timestamp|nullable',
                ],
                'gateway_transactions' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'payment_id|foreignId|constrained:payments|cascadeOnDelete',
                    'gateway|string|32',
                    'external_id|string|nullable',
                    'status|string|32|default:initiated',
                    'payload|json|nullable',
                ],
            ],
        ],
        'EscrowWallet' => [
            'key' => 'orders.escrow-wallet',
            'name' => 'Escrow Wallet',
            'description' => 'Escrow wallets, milestones, fees, and ledger transactions.',
            'icon' => 'heroicon-o-wallet',
            'dependencies' => ['orders.payments'],
            'permissions' => ['escrow.view', 'escrow.manage'],
            'primary_model' => 'EscrowWallet',
            'tables' => [
                'escrow_wallets' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'purchase_order_id|foreignId|nullable|constrained:purchase_orders|nullOnDelete',
                    'currency|string|3|default:USD',
                    'balance|decimal:15,2|default:0',
                    'status|string|32|default:active',
                ],
                'wallet_transactions' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'escrow_wallet_id|foreignId|constrained:escrow_wallets|cascadeOnDelete',
                    'type|string|32',
                    'amount|decimal:15,2|default:0',
                    'balance_after|decimal:15,2|default:0',
                    'reference|string|nullable',
                ],
                'escrow_milestones' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'escrow_wallet_id|foreignId|constrained:escrow_wallets|cascadeOnDelete',
                    'title|string',
                    'amount|decimal:15,2|default:0',
                    'status|string|32|default:pending',
                    'released_at|timestamp|nullable',
                ],
                'escrow_fees' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'escrow_wallet_id|foreignId|constrained:escrow_wallets|cascadeOnDelete',
                    'fee_type|string|32|default:commission',
                    'rate|decimal:8,4|default:0',
                    'amount|decimal:15,2|default:0',
                ],
            ],
        ],
        'Disputes' => [
            'key' => 'orders.disputes',
            'name' => 'Disputes',
            'description' => 'Order disputes, evidence, and resolutions.',
            'icon' => 'heroicon-o-scale',
            'dependencies' => ['orders.payments'],
            'permissions' => ['disputes.view', 'disputes.manage'],
            'primary_model' => 'Dispute',
            'tables' => [
                'disputes' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'purchase_order_id|foreignId|nullable|constrained:purchase_orders|nullOnDelete',
                    'payment_id|foreignId|nullable|constrained:payments|nullOnDelete',
                    'subject|string',
                    'status|string|32|default:open',
                    'opened_at|timestamp|nullable',
                ],
                'dispute_evidence' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'dispute_id|foreignId|constrained:disputes|cascadeOnDelete',
                    'file_path|string|nullable',
                    'description|text|nullable',
                    'submitted_by|foreignId|nullable|constrained:users|nullOnDelete',
                ],
                'dispute_resolutions' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'dispute_id|foreignId|constrained:disputes|cascadeOnDelete',
                    'resolution|string|32|default:pending',
                    'notes|text|nullable',
                    'resolved_at|timestamp|nullable',
                    'resolved_by|foreignId|nullable|constrained:users|nullOnDelete',
                ],
            ],
        ],
    ],
    'Operations' => [
        'Logistics' => [
            'key' => 'operations.logistics',
            'name' => 'Logistics',
            'description' => 'Shipments, carriers, tracking, freight quotes, and delivery proof.',
            'icon' => 'heroicon-o-map',
            'dependencies' => ['core.organizations', 'orders.purchase-orders'],
            'permissions' => ['logistics.view', 'logistics.manage'],
            'primary_model' => 'Shipment',
            'tables' => [
                'carriers' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'name|string',
                    'code|string|nullable',
                    'tracking_url_template|string|nullable',
                ],
                'shipments' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'purchase_order_id|foreignId|nullable|constrained:purchase_orders|nullOnDelete',
                    'carrier_id|foreignId|nullable|constrained:carriers|nullOnDelete',
                    'tracking_number|string|nullable',
                    'status|string|32|default:planned',
                    'shipped_at|timestamp|nullable',
                    'delivered_at|timestamp|nullable',
                ],
                'tracking_events' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'shipment_id|foreignId|constrained:shipments|cascadeOnDelete',
                    'event_code|string|nullable',
                    'description|string|nullable',
                    'occurred_at|timestamp|nullable',
                    'location|string|nullable',
                ],
                'freight_quotes' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'shipment_id|foreignId|nullable|constrained:shipments|nullOnDelete',
                    'carrier_id|foreignId|nullable|constrained:carriers|nullOnDelete',
                    'amount|decimal:15,2|default:0',
                    'currency|string|3|default:USD',
                    'valid_until|timestamp|nullable',
                ],
                'delivery_proofs' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'shipment_id|foreignId|constrained:shipments|cascadeOnDelete',
                    'file_path|string|nullable',
                    'signed_by|string|nullable',
                    'delivered_at|timestamp|nullable',
                ],
            ],
        ],
        'InspectionAttendance' => [
            'key' => 'operations.inspection-attendance',
            'name' => 'Inspection & Attendance',
            'description' => 'Inspector assignments, site audits, and AttendanceHub integration.',
            'icon' => 'heroicon-o-clipboard-document-check',
            'dependencies' => ['core.organizations'],
            'permissions' => ['inspection.view', 'inspection.manage'],
            'primary_model' => 'SiteAudit',
            'tables' => [
                'inspector_assignments' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'user_id|foreignId|constrained:users|cascadeOnDelete',
                    'site_name|string',
                    'starts_at|timestamp|nullable',
                    'ends_at|timestamp|nullable',
                    'status|string|32|default:assigned',
                ],
                'site_audits' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'inspector_assignment_id|foreignId|nullable|constrained:inspector_assignments|nullOnDelete',
                    'title|string',
                    'status|string|32|default:scheduled',
                    'audited_at|timestamp|nullable',
                    'score|unsignedTinyInteger|nullable',
                ],
                'audit_checklists' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'site_audit_id|foreignId|constrained:site_audits|cascadeOnDelete',
                    'item|string',
                    'passed|boolean|default:false',
                    'notes|text|nullable',
                ],
            ],
        ],
        'Budgets' => [
            'key' => 'operations.budgets',
            'name' => 'Budgets',
            'description' => 'Budgets, cost centers, and spend alerts.',
            'icon' => 'heroicon-o-chart-pie',
            'dependencies' => ['core.organizations'],
            'permissions' => ['budgets.view', 'budgets.manage'],
            'primary_model' => 'Budget',
            'tables' => [
                'cost_centers' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'code|string',
                    'name|string',
                    'description|text|nullable',
                ],
                'budgets' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'cost_center_id|foreignId|nullable|constrained:cost_centers|nullOnDelete',
                    'name|string',
                    'currency|string|3|default:USD',
                    'allocated|decimal:15,2|default:0',
                    'spent|decimal:15,2|default:0',
                    'period_start|date|nullable',
                    'period_end|date|nullable',
                ],
                'budget_alerts' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'budget_id|foreignId|constrained:budgets|cascadeOnDelete',
                    'threshold_percent|unsignedTinyInteger|default:80',
                    'triggered_at|timestamp|nullable',
                    'message|text|nullable',
                ],
            ],
        ],
        'InventoryLite' => [
            'key' => 'operations.inventory-lite',
            'name' => 'Inventory Lite',
            'description' => 'Lightweight inventory items, stock levels, and reorder points.',
            'icon' => 'heroicon-o-cube',
            'dependencies' => ['orders.goods-receipt'],
            'permissions' => ['inventory.view', 'inventory.manage'],
            'primary_model' => 'InventoryItem',
            'tables' => [
                'inventory_items' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'sku|string',
                    'name|string',
                    'unit|string|32|default:ea',
                ],
                'stock_levels' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'inventory_item_id|foreignId|constrained:inventory_items|cascadeOnDelete',
                    'location|string|nullable',
                    'quantity_on_hand|decimal:12,3|default:0',
                ],
                'reorder_points' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'inventory_item_id|foreignId|constrained:inventory_items|cascadeOnDelete',
                    'minimum_quantity|decimal:12,3|default:0',
                    'reorder_quantity|decimal:12,3|default:0',
                ],
            ],
        ],
        'Messaging' => [
            'key' => 'operations.messaging',
            'name' => 'Messaging',
            'description' => 'Threaded messages with polymorphic subjects and mentions.',
            'icon' => 'heroicon-o-chat-bubble-left-right',
            'dependencies' => ['core.organizations'],
            'permissions' => ['messaging.view', 'messaging.manage'],
            'primary_model' => 'MessageThread',
            'tables' => [
                'message_threads' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'subject_type|string|nullable',
                    'subject_id|unsignedBigInteger|nullable',
                    'title|string|nullable',
                    'status|string|32|default:open',
                ],
                'messages' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'message_thread_id|foreignId|constrained:message_threads|cascadeOnDelete',
                    'user_id|foreignId|nullable|constrained:users|nullOnDelete',
                    'body|text',
                    'sent_at|timestamp|nullable',
                ],
                'message_mentions' => [
                    'organization_id|foreignId|constrained|cascadeOnDelete',
                    'message_id|foreignId|constrained:messages|cascadeOnDelete',
                    'user_id|foreignId|constrained:users|cascadeOnDelete',
                ],
            ],
        ],
    ],
];

function writeFile(string $path, string $content): void
{
    $dir = dirname($path);
    if (! is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
    file_put_contents($path, $content);
}

function tableToModel(string $table): string
{
    $singular = str_replace('_', ' ', $table);
    $singular = rtrim($singular, 's');
    $parts = explode(' ', $singular);
    $model = implode('', array_map(fn ($p) => ucfirst($p), $parts));
    if ($table === 'grns') {
        return 'Grn';
    }
    if ($table === 'grn_items') {
        return 'GrnItem';
    }
    if ($table === 'po_items') {
        return 'PoItem';
    }
    if ($table === 'po_revisions') {
        return 'PoRevision';
    }
    if ($table === 'po_acknowledgments') {
        return 'PoAcknowledgment';
    }
    if ($table === 'goods_returns') {
        return 'GoodsReturn';
    }
    if ($table === 'escrow_wallets') {
        return 'EscrowWallet';
    }
    if ($table === 'qc_inspections') {
        return 'QcInspection';
    }

    return $model;
}

function migrationColumnPhp(string $def): string
    {
        $parts = explode('|', $def);
        $name = array_shift($parts);
        $type = array_shift($parts);
        $lines = [];

        if ($type === 'foreignId') {
            $line = "\$table->foreignId('{$name}')";
            foreach ($parts as $part) {
                if (str_starts_with($part, 'constrained')) {
                    if (str_contains($part, ':')) {
                        $tableName = explode(':', $part, 2)[1];
                        $line .= "->constrained('{$tableName}')";
                    } else {
                        $line .= '->constrained()';
                    }
                } elseif ($part === 'nullable') {
                    $line .= '->nullable()';
                } elseif ($part === 'cascadeOnDelete') {
                    $line .= '->cascadeOnDelete()';
                } elseif ($part === 'nullOnDelete') {
                    $line .= '->nullOnDelete()';
                }
            }
            $lines[] = $line.';';
        } elseif (str_starts_with($type, 'decimal:')) {
            [$precision, $scale] = explode(',', substr($type, 8));
            $line = "\$table->decimal('{$name}', {$precision}, {$scale})";
            foreach ($parts as $part) {
                if (str_starts_with($part, 'default:')) {
                    $line .= '->default('.explode(':', $part, 2)[1].')';
                } elseif ($part === 'nullable') {
                    $line .= '->nullable()';
                }
            }
            $lines[] = $line.';';
        } elseif (str_starts_with($type, 'unsigned')) {
            $line = "\$table->{$type}('{$name}')";
            foreach ($parts as $part) {
                if (str_starts_with($part, 'default:')) {
                    $val = explode(':', $part, 2)[1];
                    $val = is_numeric($val) ? $val : "'{$val}'";
                    $line .= "->default({$val})";
                } elseif ($part === 'nullable') {
                    $line .= '->nullable()';
                }
            }
            $lines[] = $line.';';
        } else {
            $line = "\$table->{$type}('{$name}'";
            if ($type === 'string' && isset($parts[0]) && is_numeric($parts[0])) {
                $line .= ', '.$parts[0];
                $parts = array_slice($parts, 1);
            }
            $line .= ')';
            foreach ($parts as $part) {
                if (str_starts_with($part, 'default:')) {
                    $val = explode(':', $part, 2)[1];
                    if (in_array($val, ['true', 'false'], true)) {
                        $line .= '->default('.($val === 'true' ? 'true' : 'false').')';
                    } elseif (is_numeric($val)) {
                        $line .= "->default({$val})";
                    } else {
                        $line .= "->default('{$val}')";
                    }
                } elseif ($part === 'nullable') {
                    $line .= '->nullable()';
                } elseif ($part === 'unique') {
                    $line .= '->unique()';
                }
            }
            $lines[] = $line.';';
        }

        return implode("\n            ", $lines);
    }

$timestamp = strtotime('2026-11-07 19:20:01');

foreach ($modules as $group => $groupModules) {
    $groupNs = "App\\Modules\\{$group}";
    $concernPath = "{$root}/app/Modules/{$group}/Concerns/BootsModuleResources.php";
    if (! is_file($concernPath)) {
        $concern = <<<PHP
<?php

namespace {$groupNs}\\Concerns;

use Illuminate\Support\Facades\Gate;

trait BootsModuleResources
{
    protected function bootModuleMigrations(): void
    {
        \$path = dirname((new \\ReflectionClass(static::class))->getFileName()).'/Database/Migrations';

        if (is_dir(\$path)) {
            \$this->loadMigrationsFrom(\$path);
        }
    }

    /**
     * @param  array<class-string, class-string>  \$policies
     */
    protected function bootModulePolicies(array \$policies): void
    {
        foreach (\$policies as \$model => \$policy) {
            Gate::policy(\$model, \$policy);
        }
    }

    /**
     * @param  list<class-string>  \$resources
     */
    protected function registerBuyerFilamentResources(array \$resources): void
    {
        if (! class_exists(\\Filament\\Facades\\Filament::class)) {
            return;
        }

        \\Filament\\Facades\\Filament::serving(function () use (\$resources): void {
            \$panel = \\Filament\\Facades\\Filament::getPanel('buyer');

            if (\$panel === null) {
                return;
            }

            foreach (\$resources as \$resource) {
                if (! \$panel->hasResource(\$resource)) {
                    \$panel->registerResources([\$resource]);
                }
            }
        });
    }
}

PHP;
        writeFile($concernPath, $concern);
    }

    foreach ($groupModules as $moduleName => $config) {
        $modulePath = "{$root}/app/Modules/{$group}/{$moduleName}";
        $moduleNs = "{$groupNs}\\{$moduleName}";
        $providerClass = "{$moduleNs}\\ModuleServiceProvider";

        $manifest = [
            'key' => $config['key'],
            'name' => $config['name'],
            'description' => $config['description'],
            'group' => $group,
            'icon' => $config['icon'],
            'dependencies' => $config['dependencies'],
            'is_core' => false,
            'default_enabled' => true,
            'permissions' => $config['permissions'],
            'provider' => $providerClass,
        ];
        writeFile("{$modulePath}/module.json", json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n");

        $modulePhp = <<<PHP
<?php

namespace {$moduleNs};

use App\\Modules\\AbstractModule;

class Module extends AbstractModule
{
}

PHP;
        writeFile("{$modulePath}/Module.php", $modulePhp);

        $models = [];
        $policies = [];
        $policyImports = '';
        $policyMap = '';

        foreach ($config['tables'] as $table => $columns) {
            $modelName = tableToModel($table);
            $models[$table] = $modelName;

            $fillable = [];
            foreach ($columns as $colDef) {
                $colName = explode('|', $colDef)[0];
                if ($colName !== 'organization_id') {
                    $fillable[] = $colName;
                }
            }

            $casts = [];
            foreach ($fillable as $field) {
                if (str_contains($field, '_at') || $field === 'issued_at' || $field === 'due_at' || $field === 'received_at') {
                    $casts[$field] = 'datetime';
                }
                if ($field === 'snapshot' || $field === 'payload') {
                    $casts[$field] = 'array';
                }
                if (str_contains($field, 'passed') || $field === 'passed') {
                    $casts[$field] = 'boolean';
                }
                if (in_array($field, ['subtotal', 'tax_total', 'total', 'amount', 'line_total', 'unit_price', 'quantity', 'quantity_received', 'quantity_accepted', 'balance', 'balance_after', 'allocated', 'spent', 'tax_rate', 'rate', 'minimum_quantity', 'reorder_quantity', 'quantity_on_hand'], true)) {
                    $casts[$field] = 'decimal:2';
                }
            }

            $fillableExport = var_export($fillable, true);
            $castsExport = var_export($casts, true);

            $modelPhp = <<<PHP
<?php

namespace {$moduleNs}\\Models;

use App\\Models\\Concerns\\BelongsToOrganization;
use Illuminate\\Database\\Eloquent\\Factories\\HasFactory;
use Illuminate\\Database\\Eloquent\\Model;
use {$moduleNs}\\Database\\Factories\\{$modelName}Factory;

class {$modelName} extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected \$table = '{$table}';

    protected \$fillable = {$fillableExport};

    protected function casts(): array
    {
        return {$castsExport};
    }

    protected static function newFactory(): {$modelName}Factory
    {
        return {$modelName}Factory::new();
    }
}

PHP;
            writeFile("{$modulePath}/Models/{$modelName}.php", $modelPhp);

            $factoryPhp = <<<PHP
<?php

namespace {$moduleNs}\\Database\\Factories;

use {$moduleNs}\\Models\\{$modelName};
use App\\Models\\Organization;
use Illuminate\\Database\\Eloquent\\Factories\\Factory;

/**
 * @extends Factory<{$modelName}>
 */
class {$modelName}Factory extends Factory
{
    protected \$model = {$modelName}::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}

PHP;
            // Organization::factory may not exist - we'll fix factories after
            writeFile("{$modulePath}/Database/Factories/{$modelName}Factory.php", $factoryPhp);

            $policyPhp = <<<PHP
<?php

namespace {$moduleNs}\\Policies;

use App\\Models\\User;
use {$moduleNs}\\Models\\{$modelName};
use {$moduleNs}\\Policies\\Concerns\\AuthorizesOrganizationEntity;

class {$modelName}Policy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User \$user): bool
    {
        return true;
    }

    public function view(User \$user, {$modelName} \$model): bool
    {
        return \$this->sameOrganization(\$user, \$model);
    }

    public function create(User \$user): bool
    {
        return true;
    }

    public function update(User \$user, {$modelName} \$model): bool
    {
        return \$this->sameOrganization(\$user, \$model);
    }

    public function delete(User \$user, {$modelName} \$model): bool
    {
        return \$this->sameOrganization(\$user, \$model);
    }
}

PHP;
            writeFile("{$modulePath}/Policies/{$modelName}Policy.php", $policyPhp);
            $policies["{$moduleNs}\\Models\\{$modelName}"] = "{$moduleNs}\\Policies\\{$modelName}Policy";

            $migrationName = "create_{$table}_table";
            $ts = date('Y_m_d_His', $timestamp);
            $timestamp++;

            $columnLines = migrationColumnPhp('organization_id|foreignId|constrained|cascadeOnDelete');
            foreach ($columns as $colDef) {
                if (str_starts_with($colDef, 'organization_id|')) {
                    continue;
                }
                $columnLines .= "\n            ".migrationColumnPhp($colDef);
            }

            $migrationPhp = <<<PHP
<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('{$table}', function (Blueprint \$table) {
            \$table->id();
            {$columnLines}
            \$table->timestamps();

            \$table->index('organization_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('{$table}');
    }
};

PHP;
            writeFile("{$modulePath}/Database/Migrations/{$ts}_{$migrationName}.php", $migrationPhp);
        }

        $policyConcernPath = "{$modulePath}/Policies/Concerns/AuthorizesOrganizationEntity.php";
        if (! is_file($policyConcernPath)) {
            $policyConcern = <<<PHP
<?php

namespace {$moduleNs}\\Policies\\Concerns;

use App\\Models\\User;
use Illuminate\\Database\\Eloquent\\Model;

trait AuthorizesOrganizationEntity
{
    protected function sameOrganization(User \$user, Model \$model): bool
    {
        if (! \$user->current_organization_id) {
            return false;
        }

        return (int) \$model->getAttribute('organization_id') === (int) \$user->current_organization_id;
    }
}

PHP;
            writeFile($policyConcernPath, $policyConcern);
        }

        $primaryModel = $config['primary_model'];
        $resourcePhp = <<<PHP
<?php

namespace {$moduleNs}\\Filament\\Resources;

use {$moduleNs}\\Filament\\Resources\\{$primaryModel}Resource\\Pages;
use {$moduleNs}\\Models\\{$primaryModel};
use Filament\\Forms;
use Filament\\Forms\\Form;
use Filament\\Resources\\Resource;
use Filament\\Tables;
use Filament\\Tables\\Table;

class {$primaryModel}Resource extends Resource
{
    protected static ?string \$model = {$primaryModel}::class;

    protected static ?string \$navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string \$navigationGroup = '{$group}';

    public static function form(Form \$form): Form
    {
        return \$form->schema([
            Forms\\Components\\TextInput::make('organization_id')->numeric()->required(),
        ]);
    }

    public static function table(Table \$table): Table
    {
        return \$table
            ->columns([
                Tables\\Columns\\TextColumn::make('id')->sortable(),
                Tables\\Columns\\TextColumn::make('created_at')->dateTime(),
            ])
            ->actions([
                Tables\\Actions\\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\\List{$primaryModel}s::route('/'),
            'create' => Pages\\Create{$primaryModel}::route('/create'),
            'edit' => Pages\\Edit{$primaryModel}::route('/{record}/edit'),
        ];
    }
}

PHP;
        writeFile("{$modulePath}/Filament/Resources/{$primaryModel}Resource.php", $resourcePhp);

        foreach (['List', 'Create', 'Edit'] as $pageType) {
            $pageClass = $pageType === 'List' ? "List{$primaryModel}s" : "{$pageType}{$primaryModel}";
            $baseClass = $pageType === 'List' ? 'ListRecords' : ($pageType === 'Create' ? 'CreateRecord' : 'EditRecord');
            $pagePhp = <<<PHP
<?php

namespace {$moduleNs}\\Filament\\Resources\\{$primaryModel}Resource\\Pages;

use {$moduleNs}\\Filament\\Resources\\{$primaryModel}Resource;
use Filament\\Resources\\Pages\\{$baseClass};

class {$pageClass} extends {$baseClass}
{
    protected static string \$resource = {$primaryModel}Resource::class;
}

PHP;
            writeFile("{$modulePath}/Filament/Resources/{$primaryModel}Resource/Pages/{$pageClass}.php", $pagePhp);
        }

        $policyArray = var_export($policies, true);
        $resourceClass = "{$moduleNs}\\Filament\\Resources\\{$primaryModel}Resource";

        $bootExtra = '';
        if (($config['extra'] ?? '') === 'payments') {
            $bootExtra = <<<'PHP'

        foreach ([
            \App\Modules\Orders\Payments\Contracts\PaymentGatewayAdapterInterface::class => \App\Modules\Orders\Payments\Services\PaymentGatewayManager::class,
        ] as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }
PHP;
            $bootExtra = str_replace('$this', '\$this', $bootExtra);
            $bootExtra = str_replace('$abstract', '\$abstract', $bootExtra);
            $bootExtra = str_replace('$concrete', '\$concrete', $bootExtra);
        }

        if ($moduleName === 'InspectionAttendance') {
            $bootExtra .= <<<'PHP'

        $this->app->singleton(
            \App\Modules\Operations\InspectionAttendance\Services\InspectionAttendanceService::class
        );
PHP;
            $bootExtra = str_replace('$this', '\$this', $bootExtra);
        }

        $providerPhp = <<<PHP
<?php

namespace {$moduleNs};

use {$groupNs}\\Concerns\\BootsModuleResources;
use Illuminate\\Support\\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    use BootsModuleResources;

    public function register(): void
    {
        {$bootExtra}
    }

    public function boot(): void
    {
        \$this->bootModuleMigrations();

        \$policies = {$policyArray};

        \$this->bootModulePolicies(\$policies);

        \$this->registerBuyerFilamentResources([
            \\{$resourceClass}::class,
        ]);
    }
}

PHP;
        writeFile("{$modulePath}/ModuleServiceProvider.php", $providerPhp);
    }
}

// Payment gateway contracts and adapters
$paymentsPath = "{$root}/app/Modules/Orders/Payments";
$gatewayInterface = <<<'PHP'
<?php

namespace App\Modules\Orders\Payments\Contracts;

interface PaymentGatewayAdapterInterface
{
    public function charge(array $payload): array;

    public function refund(string $externalId, float $amount): array;

    public function name(): string;
}

PHP;
writeFile("{$paymentsPath}/Contracts/PaymentGatewayAdapterInterface.php", $gatewayInterface);

foreach (['Stripe', 'PayPal', 'SslCommerz', 'Bkash', 'Nagad'] as $gw) {
    $adapter = <<<PHP
<?php

namespace App\\Modules\\Orders\\Payments\\Adapters;

use App\\Modules\\Orders\\Payments\\Contracts\\PaymentGatewayAdapterInterface;

class {$gw}Adapter implements PaymentGatewayAdapterInterface
{
    public function name(): string
    {
        return strtolower('{$gw}');
    }

    public function charge(array \$payload): array
    {
        return [
            'status' => 'authorized',
            'gateway' => \$this->name(),
            'reference' => \$payload['reference'] ?? null,
        ];
    }

    public function refund(string \$externalId, float \$amount): array
    {
        return [
            'status' => 'refunded',
            'gateway' => \$this->name(),
            'external_id' => \$externalId,
            'amount' => \$amount,
        ];
    }
}

PHP;
    writeFile("{$paymentsPath}/Adapters/{$gw}Adapter.php", $adapter);
}

$manager = <<<'PHP'
<?php

namespace App\Modules\Orders\Payments\Services;

use App\Modules\Orders\Payments\Adapters\BkashAdapter;
use App\Modules\Orders\Payments\Adapters\NagadAdapter;
use App\Modules\Orders\Payments\Adapters\PayPalAdapter;
use App\Modules\Orders\Payments\Adapters\SslCommerzAdapter;
use App\Modules\Orders\Payments\Adapters\StripeAdapter;
use App\Modules\Orders\Payments\Contracts\PaymentGatewayAdapterInterface;
use InvalidArgumentException;

class PaymentGatewayManager implements PaymentGatewayAdapterInterface
{
    /**
     * @var array<string, PaymentGatewayAdapterInterface>
     */
    protected array $adapters;

    public function __construct()
    {
        $this->adapters = [
            'stripe' => new StripeAdapter,
            'paypal' => new PayPalAdapter,
            'sslcommerz' => new SslCommerzAdapter,
            'bkash' => new BkashAdapter,
            'nagad' => new NagadAdapter,
        ];
    }

    public function driver(?string $name = null): PaymentGatewayAdapterInterface
    {
        $name ??= 'stripe';
        $name = strtolower($name);

        if (! isset($this->adapters[$name])) {
            throw new InvalidArgumentException("Unknown payment gateway [{$name}].");
        }

        return $this->adapters[$name];
    }

    public function name(): string
    {
        return 'manager';
    }

    public function charge(array $payload): array
    {
        $gateway = $payload['gateway'] ?? 'stripe';

        return $this->driver((string) $gateway)->charge($payload);
    }

    public function refund(string $externalId, float $amount): array
    {
        return $this->driver('stripe')->refund($externalId, $amount);
    }
}

PHP;
writeFile("{$paymentsPath}/Services/PaymentGatewayManager.php", $manager);

$inspectionService = <<<'PHP'
<?php

namespace App\Modules\Operations\InspectionAttendance\Services;

use ImranDevBd\AttendanceHub\Facades\AttendanceHub;

class InspectionAttendanceService
{
    public function syncDeviceAttendance(int|string $deviceId, ?\Carbon\CarbonInterface $since = null)
    {
        return AttendanceHub::sync($deviceId, $since);
    }

    public function useFakeDriver(array $initialPunches = []): void
    {
        AttendanceHub::fake($initialPunches);
    }
}

PHP;
writeFile("{$root}/app/Modules/Operations/InspectionAttendance/Services/InspectionAttendanceService.php", $inspectionService);

echo "Scaffold complete.\n";
