<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Intelligence\AiAssistant\Models\AiUsageLog;
use App\Modules\Intelligence\MarketDataCatalog\Models\ScrapedCatalogItem;
use App\Modules\Operations\InspectionAttendance\Models\InspectorAssignment;
use App\Modules\Operations\InspectionAttendance\Models\SiteAudit;
use App\Modules\Platform\CmsBlog\Models\BlogPost;
use App\Modules\Platform\CmsBlog\Models\Faq;
use App\Modules\Platform\CmsBlog\Models\Page;
use App\Modules\Platform\Helpdesk\Models\Ticket;
use Illuminate\Database\Seeder;
use ImranDevBd\AttendanceHub\Models\AttendanceDevice;
use ImranDevBd\AttendanceHub\Models\AttendanceLog;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $platformOrg = DemoContext::organization(DemoContext::PLATFORM_ORG);
        $buyer = DemoContext::organization(DemoContext::BUYER_GARMENT);
        $supportUser = User::query()->where('email', 'support@demo.test')->first();
        $buyerUser = User::query()->where('email', 'buyer.admin@demo.test')->first();
        $inspector = User::query()->where('email', 'inspector@demo.test')->first();

        BlogPost::query()->updateOrCreate(
            ['slug' => 'demo-welcome-to-marketplace'],
            [
                'organization_id' => $platformOrg->id,
                'title' => 'Welcome to the procurement marketplace demo',
                'content' => ['en' => '<p>Explore RFQs, bids, and order-to-pay flows with seeded tenants.</p>'],
                'is_published' => true,
            ]
        );

        Page::query()->updateOrCreate(
            ['slug' => 'demo-about-platform'],
            [
                'organization_id' => $platformOrg->id,
                'title' => 'About the demo platform',
                'content' => ['en' => '<p>Platform-operated CMS page for demo tours.</p>'],
                'is_published' => true,
            ]
        );

        Faq::query()->updateOrCreate(
            ['slug' => 'demo-how-to-login'],
            [
                'organization_id' => $platformOrg->id,
                'question' => 'How do I try demo accounts?',
                'content' => ['en' => 'Visit /try-demo and pick a panel. All demo passwords are `password`.'],
                'is_published' => true,
            ]
        );

        Ticket::query()->updateOrCreate(
            ['slug' => 'demo-supplier-verification'],
            [
                'organization_id' => $platformOrg->id,
                'user_id' => $buyerUser?->id,
                'subject' => 'Demo supplier verification question',
                'description' => 'Seeded helpdesk ticket for support workflow demos.',
                'status' => 'open',
                'priority' => 'normal',
            ]
        );

        AiUsageLog::query()->updateOrCreate(
            [
                'organization_id' => $buyer->id,
                'feature' => 'rfq_draft_assist',
                'provider' => 'openai',
                'model' => 'gpt-demo',
            ],
            [
                'user_id' => $buyerUser?->id,
                'tokens_in' => 480,
                'tokens_out' => 220,
                'cost_usd' => 0.0125,
                'meta' => ['demo' => true],
            ]
        );

        ScrapedCatalogItem::query()->updateOrCreate(
            [
                'organization_id' => $buyer->id,
                'title' => 'Benchmark safety glove SKU',
            ],
            [
                'source_url' => 'https://example.test/catalog/glove-100',
                'price' => 4.25,
                'currency' => 'USD',
                'status' => 'indexed',
                'raw' => ['country' => 'US', 'category' => 'PPE'],
            ]
        );

        $device = AttendanceDevice::query()->updateOrCreate(
            ['serial_number' => 'DEMO-DEVICE-001'],
            [
                'tenant_id' => (string) $buyer->id,
                'name' => 'Garment floor terminal',
                'provider' => 'virtual',
                'status' => 'online',
                'last_seen_at' => now(),
            ]
        );

        AttendanceLog::query()->updateOrCreate(
            ['punch_hash' => 'demo-punch-hash-001'],
            [
                'tenant_id' => (string) $buyer->id,
                'device_id' => $device->id,
                'device_user_id' => 'demo-inspector',
                'employee_id' => 'EMP-DEMO-001',
                'punched_at' => now()->subHours(2),
                'verify_mode' => 'fingerprint',
                'punch_type' => 'check_in',
            ]
        );

        if ($inspector) {
            $assignment = InspectorAssignment::query()->updateOrCreate(
                [
                    'organization_id' => DemoContext::organization(DemoContext::LOGISTICS_ORG)->id,
                    'user_id' => $inspector->id,
                    'site_name' => 'Dhaka production unit',
                ],
                [
                    'starts_at' => now()->addDays(4),
                    'ends_at' => now()->addDays(5),
                    'status' => 'assigned',
                ]
            );

            SiteAudit::query()->updateOrCreate(
                [
                    'organization_id' => $buyer->id,
                    'title' => 'Demo garment floor audit',
                ],
                [
                    'inspector_assignment_id' => $assignment->id,
                    'status' => 'scheduled',
                    'audited_at' => null,
                ]
            );
        }

        unset($supportUser);
    }
}
