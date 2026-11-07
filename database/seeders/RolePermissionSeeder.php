<?php

namespace Database\Seeders;

use App\Modules\ModuleRegistry;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = $this->collectModulePermissions();
        foreach ($permissions as $name) {
            Permission::findOrCreate($name, 'web');
        }

        foreach ($this->roleDefinitions($permissions) as $roleName => $rolePermissions) {
            $role = Role::findOrCreate($roleName, 'web');
            $role->syncPermissions($rolePermissions);
        }
    }

    /**
     * @return list<string>
     */
    protected function collectModulePermissions(): array
    {
        $registry = app(ModuleRegistry::class);
        $names = [];

        foreach ($registry->all() as $module) {
            foreach ($module->permissions() as $permission) {
                $names[$permission] = true;
            }
        }

        foreach (['platform.access', 'buyer.access', 'supplier.access', 'logistics.access'] as $extra) {
            $names[$extra] = true;
        }

        ksort($names);

        return array_keys($names);
    }

    /**
     * @param  list<string>  $permissions
     * @return array<string, list<string>>
     */
    protected function roleDefinitions(array $permissions): array
    {
        $all = $permissions;

        $sourcing = $this->matching($permissions, '/^(rfqs|bids|bid_scoring|purchase_requisitions|awards|contracts|negotiations|reverse_auctions|supplier_invitations)\./');
        $orders = $this->matching($permissions, '/^(purchase_orders|goods_receipt|invoicing|payments|disputes|escrow)\./');
        $operationsBuyer = $this->matching($permissions, '/^(budgets|messaging|inventory)\./');
        $platformGeneric = ['view', 'manage'];
        $intelligence = $this->matching($permissions, '/^(ai-assistant|analytics|market-data)\./');
        $logistics = $this->matching($permissions, '/^(logistics)\./');
        $inspection = $this->matching($permissions, '/^(inspection)\./');
        $supplierModules = ['view', 'manage'];

        return [
            'superadmin' => $all,
            'platform.manager' => array_values(array_unique(array_merge($platformGeneric, $intelligence, ['platform.access']))),
            'support' => array_values(array_unique(array_merge($platformGeneric, ['platform.access']))),
            'finance' => array_values(array_unique(array_merge($platformGeneric, $this->matching($permissions, '/^(payments|invoicing|escrow)\./'), ['platform.access']))),
            'kyc' => array_values(array_unique(array_merge($supplierModules, ['platform.access']))),
            'buyer.admin' => array_values(array_unique(array_merge($sourcing, $orders, $operationsBuyer, ['buyer.access']))),
            'procurement' => array_values(array_unique(array_merge(
                $this->matching($permissions, '/^(rfqs|bids|bid_scoring|purchase_requisitions|awards|negotiations)\./'),
                ['buyer.access']
            ))),
            'requester' => ['purchase_requisitions.view', 'purchase_requisitions.create', 'rfqs.view', 'buyer.access'],
            'approver' => ['purchase_requisitions.view', 'purchase_requisitions.approve', 'awards.view', 'awards.create', 'purchase_orders.view', 'buyer.access'],
            'ap' => ['invoicing.view', 'invoicing.manage', 'payments.view', 'payments.manage', 'buyer.access'],
            'receiver' => ['goods_receipt.view', 'goods_receipt.manage', 'purchase_orders.view', 'buyer.access'],
            'auditor' => array_values(array_unique(array_merge(
                ['analytics.view', 'rfqs.view', 'bids.view', 'purchase_orders.view', 'buyer.access'],
                $this->matching($permissions, '/^analytics\./')
            ))),
            'supplier.admin' => array_values(array_unique(array_merge($supplierModules, $this->matching($permissions, '/^bids\./'), ['rfqs.view', 'supplier.access']))),
            'supplier.sales' => array_values(array_unique(array_merge($this->matching($permissions, '/^bids\./'), ['negotiations.view', 'negotiations.message', 'rfqs.view', 'supplier.access']))),
            'supplier.catalog' => array_values(array_unique(array_merge($supplierModules, ['supplier.access']))),
            'supplier.finance' => ['invoicing.view', 'payments.view', 'supplier.access'],
            'logistics' => array_values(array_unique(array_merge($logistics, ['logistics.access']))),
            'inspector' => array_values(array_unique(array_merge($inspection, ['logistics.access']))),
        ];
    }

    /**
     * @param  list<string>  $permissions
     * @return list<string>
     */
    protected function matching(array $permissions, string $pattern): array
    {
        return array_values(array_filter($permissions, fn (string $p) => (bool) preg_match($pattern, $p)));
    }
}
