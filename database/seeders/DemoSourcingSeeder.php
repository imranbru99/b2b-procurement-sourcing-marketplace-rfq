<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Sourcing\AwardsContracts\Models\Award;
use App\Modules\Sourcing\AwardsContracts\Models\Contract;
use App\Modules\Sourcing\Bidding\Models\Bid;
use App\Modules\Sourcing\Negotiation\Models\Negotiation;
use App\Modules\Sourcing\PurchaseRequisitions\Models\PurchaseRequisition;
use App\Modules\Sourcing\ReverseAuctions\Models\ReverseAuction;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Database\Seeder;

class DemoSourcingSeeder extends Seeder
{
    public function run(): void
    {
        $buyer = DemoContext::organization(DemoContext::BUYER_GARMENT);
        $supplier = DemoContext::organization(DemoContext::PRIMARY_SUPPLIER);
        $supplierTwo = DemoContext::organization(DemoContext::supplierSlug(2));

        $requester = User::query()->where('email', 'requester@demo.test')->first()
            ?? User::query()->where('email', 'buyer.admin@demo.test')->first();

        $requisition = PurchaseRequisition::query()->updateOrCreate(
            [
                'organization_id' => $buyer->id,
                'budget_code' => 'DEMO-REQ-001',
            ],
            [
                'department' => 'Production',
                'requester_id' => $requester->id,
                'status' => 'approved',
                'amount' => 45000,
                'currency' => 'USD',
                'approval_level' => 2,
                'notes' => 'Seeded demo requisition for garment lines.',
            ]
        );

        $openRfq = Rfq::withoutGlobalScope('organization')->updateOrCreate(
            [
                'organization_id' => $buyer->id,
                'slug' => 'demo-open-fabric-rfq',
            ],
            [
                'purchase_requisition_id' => $requisition->id,
                'type' => 'rfq',
                'title' => 'Open fabric RFQ (demo)',
                'visibility' => 'public',
                'status' => 'open',
                'deadline' => now()->addWeeks(2),
                'version' => 1,
            ]
        );

        $closedRfq = Rfq::withoutGlobalScope('organization')->updateOrCreate(
            [
                'organization_id' => $buyer->id,
                'slug' => 'demo-closed-uniform-rfq',
            ],
            [
                'type' => 'rfq',
                'title' => 'Closed uniform RFQ (demo)',
                'visibility' => 'private',
                'status' => 'closed',
                'deadline' => now()->subWeek(),
                'version' => 1,
            ]
        );

        $awardedRfq = Rfq::withoutGlobalScope('organization')->updateOrCreate(
            [
                'organization_id' => $buyer->id,
                'slug' => 'demo-awarded-packaging-rfq',
            ],
            [
                'type' => 'rfq',
                'title' => 'Awarded packaging RFQ (demo)',
                'visibility' => 'private',
                'status' => 'awarded',
                'deadline' => now()->subDays(3),
                'version' => 2,
            ]
        );

        $openBid = Bid::withoutGlobalScope('organization')->updateOrCreate(
            [
                'organization_id' => $buyer->id,
                'rfq_id' => $openRfq->id,
                'supplier_organization_id' => $supplier->id,
            ],
            [
                'status' => 'submitted',
                'total' => 38250.75,
                'currency' => 'USD',
                'lead_time_days' => 21,
                'is_sealed' => true,
                'submitted_at' => now()->subDay(),
            ]
        );

        Bid::withoutGlobalScope('organization')->updateOrCreate(
            [
                'organization_id' => $buyer->id,
                'rfq_id' => $openRfq->id,
                'supplier_organization_id' => $supplierTwo->id,
            ],
            [
                'status' => 'submitted',
                'total' => 39500,
                'currency' => 'USD',
                'lead_time_days' => 18,
                'is_sealed' => true,
                'submitted_at' => now()->subHours(6),
            ]
        );

        $awardedBid = Bid::withoutGlobalScope('organization')->updateOrCreate(
            [
                'organization_id' => $buyer->id,
                'rfq_id' => $awardedRfq->id,
                'supplier_organization_id' => $supplier->id,
            ],
            [
                'status' => 'submitted',
                'total' => 12800,
                'currency' => 'USD',
                'lead_time_days' => 14,
                'is_sealed' => false,
                'submitted_at' => now()->subDays(4),
            ]
        );

        ReverseAuction::withoutGlobalScope('organization')->updateOrCreate(
            [
                'organization_id' => $buyer->id,
                'title' => 'Demo reverse auction — thread cones',
            ],
            [
                'rfq_id' => $openRfq->id,
                'status' => 'live',
                'starting_price' => 50000,
                'current_price' => 41750,
                'decrement' => 250,
                'starts_at' => now()->subHour(),
                'ends_at' => now()->addHours(3),
                'currency' => 'USD',
            ]
        );

        Negotiation::withoutGlobalScope('organization')->updateOrCreate(
            [
                'organization_id' => $buyer->id,
                'rfq_id' => $openRfq->id,
                'supplier_organization_id' => $supplier->id,
            ],
            [
                'bid_id' => $openBid->id,
                'status' => 'open',
                'subject' => 'MOQ adjustment for demo fabric lot',
            ]
        );

        $award = Award::withoutGlobalScope('organization')->updateOrCreate(
            [
                'organization_id' => $buyer->id,
                'rfq_id' => $awardedRfq->id,
                'bid_id' => $awardedBid->id,
            ],
            [
                'supplier_organization_id' => $supplier->id,
                'awarded_amount' => 12800,
                'award_percentage' => 100,
                'currency' => 'USD',
                'status' => 'awarded',
                'awarded_at' => now()->subDays(2),
            ]
        );

        Contract::withoutGlobalScope('organization')->updateOrCreate(
            [
                'organization_id' => $buyer->id,
                'slug' => 'demo-packaging-contract',
            ],
            [
                'award_id' => $award->id,
                'supplier_organization_id' => $supplier->id,
                'title' => 'Demo packaging supply contract',
                'status' => 'active',
                'effective_from' => now()->subDays(2),
                'effective_until' => now()->addYear(),
                'contract_value' => 12800,
                'currency' => 'USD',
            ]
        );

        Rfq::withoutGlobalScope('organization')->updateOrCreate(
            [
                'organization_id' => DemoContext::organization(DemoContext::BUYER_HOSPITAL)->id,
                'slug' => 'demo-hospital-supplies-rfq',
            ],
            [
                'type' => 'rfq',
                'title' => 'Hospital consumables RFQ (demo)',
                'visibility' => 'private',
                'status' => 'open',
                'deadline' => now()->addDays(10),
            ]
        );
    }
}
