<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->demoUsers() as $definition) {
            $organization = $definition['organization_slug']
                ? DemoContext::organization($definition['organization_slug'])
                : null;

            $user = User::query()->updateOrCreate(
                ['email' => $definition['email']],
                [
                    'name' => $definition['name'],
                    'password' => 'password',
                    'email_verified_at' => now(),
                    'locale' => 'en',
                    'timezone' => 'UTC',
                    'is_platform_user' => $definition['is_platform_user'],
                    'current_organization_id' => $organization?->id,
                ]
            );

            if ($organization) {
                $user->organizations()->syncWithoutDetaching([
                    $organization->id => [
                        'role' => $definition['organization_role'],
                        'is_primary' => true,
                        'joined_at' => now(),
                    ],
                ]);
            }

            $user->syncRoles([$definition['spatie_role']]);
        }
    }

    /**
     * @return list<array{
     *     email: string,
     *     name: string,
     *     spatie_role: string,
     *     is_platform_user: bool,
     *     organization_slug: ?string,
     *     organization_role: string,
     *     panel: string,
     *     path: string,
     *     label: string
     * }>
     */
    public function demoUsers(): array
    {
        return [
            $this->user('superadmin@demo.test', 'Super Admin', 'superadmin', true, DemoContext::PLATFORM_ORG, 'owner', 'superadmin', '/platform', 'Super administrator'),
            $this->user('platform.manager@demo.test', 'Platform Manager', 'platform.manager', true, DemoContext::PLATFORM_ORG, 'manager', 'platform-manager', '/platform', 'Platform manager'),
            $this->user('support@demo.test', 'Support Agent', 'support', true, DemoContext::PLATFORM_ORG, 'support', 'support', '/platform', 'Support'),
            $this->user('finance@demo.test', 'Finance Operator', 'finance', true, DemoContext::PLATFORM_ORG, 'finance', 'finance', '/platform', 'Finance'),
            $this->user('kyc@demo.test', 'KYC Reviewer', 'kyc', true, DemoContext::PLATFORM_ORG, 'kyc', 'kyc', '/platform', 'KYC'),
            $this->user('buyer.admin@demo.test', 'Buyer Admin', 'buyer.admin', false, DemoContext::BUYER_GARMENT, 'admin', 'buyer-admin', '/buyer', 'Buyer admin'),
            $this->user('procurement@demo.test', 'Procurement Lead', 'procurement', false, DemoContext::BUYER_GARMENT, 'procurement', 'procurement', '/buyer', 'Procurement'),
            $this->user('requester@demo.test', 'Requisition Requester', 'requester', false, DemoContext::BUYER_GARMENT, 'requester', 'requester', '/buyer', 'Requester'),
            $this->user('approver@demo.test', 'Spend Approver', 'approver', false, DemoContext::BUYER_HOSPITAL, 'approver', 'approver', '/buyer', 'Approver'),
            $this->user('ap@demo.test', 'Accounts Payable', 'ap', false, DemoContext::BUYER_HOSPITAL, 'ap', 'ap', '/buyer', 'Accounts payable'),
            $this->user('receiver@demo.test', 'Goods Receiver', 'receiver', false, DemoContext::BUYER_GOVERNMENT, 'receiver', 'receiver', '/buyer', 'Receiver'),
            $this->user('auditor@demo.test', 'Procurement Auditor', 'auditor', false, DemoContext::BUYER_GOVERNMENT, 'auditor', 'auditor', '/buyer', 'Auditor'),
            $this->user('supplier.admin@demo.test', 'Supplier Admin', 'supplier.admin', false, DemoContext::PRIMARY_SUPPLIER, 'admin', 'supplier-admin', '/supplier', 'Supplier admin'),
            $this->user('supplier.sales@demo.test', 'Supplier Sales', 'supplier.sales', false, DemoContext::PRIMARY_SUPPLIER, 'sales', 'supplier-sales', '/supplier', 'Supplier sales'),
            $this->user('supplier.catalog@demo.test', 'Catalog Manager', 'supplier.catalog', false, DemoContext::supplierSlug(2), 'catalog', 'supplier-catalog', '/supplier', 'Catalog manager'),
            $this->user('supplier.finance@demo.test', 'Supplier Finance', 'supplier.finance', false, DemoContext::supplierSlug(3), 'finance', 'supplier-finance', '/supplier', 'Supplier finance'),
            $this->user('logistics@demo.test', 'Logistics Coordinator', 'logistics', false, DemoContext::LOGISTICS_ORG, 'coordinator', 'logistics', '/logistics', 'Logistics'),
            $this->user('inspector@demo.test', 'Site Inspector', 'inspector', false, DemoContext::LOGISTICS_ORG, 'inspector', 'inspector', '/logistics', 'Inspector'),
        ];
    }

    /**
     * @return array{
     *     email: string,
     *     name: string,
     *     spatie_role: string,
     *     is_platform_user: bool,
     *     organization_slug: ?string,
     *     organization_role: string,
     *     panel: string,
     *     path: string,
     *     label: string
     * }
     */
    protected function user(
        string $email,
        string $name,
        string $spatieRole,
        bool $platformUser,
        ?string $orgSlug,
        string $orgRole,
        string $panel,
        string $path,
        string $label,
    ): array {
        return [
            'email' => $email,
            'name' => $name,
            'spatie_role' => $spatieRole,
            'is_platform_user' => $platformUser,
            'organization_slug' => $orgSlug,
            'organization_role' => $orgRole,
            'panel' => $panel,
            'path' => $path,
            'label' => $label,
        ];
    }

    public static function panelKeyFromEmail(string $email): string
    {
        $local = Str::before($email, '@');

        return str_replace('.', '-', $local);
    }
}
