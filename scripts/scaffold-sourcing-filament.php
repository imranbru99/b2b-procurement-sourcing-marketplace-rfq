<?php

declare(strict_types=1);

$base = dirname(__DIR__).'/app/Modules/Sourcing';

function put(string $path, string $contents): void
{
    $dir = dirname($path);
    if (! is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    file_put_contents($path, $contents);
    echo 'WROTE '.$path.PHP_EOL;
}

function resourcePages(string $resourceDir, string $resourceFqcn, string $resourceShort, array $pages): void
{
    foreach ($pages as $class => $extends) {
        $ns = $resourceFqcn.'\\Pages';
        $header = match ($extends) {
            'ListRecords' => <<<'PHP'

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
PHP,
            'EditRecord' => <<<'PHP'

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
PHP,
            'ViewRecord' => <<<'PHP'

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
PHP,
            default => '',
        };

        $usesActions = $header !== '' ? "use Filament\\Actions;\n" : '';

        put("{$resourceDir}/Pages/{$class}.php", <<<PHP
<?php

namespace {$ns};

use {$resourceFqcn};
{$usesActions}use Filament\\Resources\\Pages\\{$extends};

class {$class} extends {$extends}
{
    protected static string \$resource = {$resourceShort}::class;
{$header}
}

PHP);
    }
}

// ===================== MODELS =====================

put("{$base}/Rfqs/Models/Rfq.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\Rfqs\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Modules\Sourcing\AwardsContracts\Models\Award;
use App\Modules\Sourcing\Bidding\Models\Bid;
use App\Modules\Sourcing\BidScoring\Models\ScoringCriterion;
use App\Modules\Sourcing\Negotiation\Models\Negotiation;
use App\Modules\Sourcing\PurchaseRequisitions\Models\PurchaseRequisition;
use App\Modules\Sourcing\ReverseAuctions\Models\ReverseAuction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use ImranDev\UniversalSlug\SlugOptions;
use ImranDev\UniversalSlug\Traits\HasUniversalSlug;

class Rfq extends Model
{
    use BelongsToOrganization;
    use HasFactory;
    use HasUniversalSlug;

    protected $table = 'rfqs';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function purchaseRequisition(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequisition::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(RfqItem::class)->orderBy('sort_order');
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(RfqInvitation::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(RfqQuestion::class);
    }

    public function addenda(): HasMany
    {
        return $this->hasMany(RfqAddendum::class);
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

    public function awards(): HasMany
    {
        return $this->hasMany(Award::class);
    }

    public function scoringCriteria(): HasMany
    {
        return $this->hasMany(ScoringCriterion::class);
    }

    public function reverseAuctions(): HasMany
    {
        return $this->hasMany(ReverseAuction::class);
    }

    public function negotiations(): HasMany
    {
        return $this->hasMany(Negotiation::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\Rfqs\Database\Factories\RfqFactory
    {
        return \App\Modules\Sourcing\Rfqs\Database\Factories\RfqFactory::new();
    }
}

PHP);

put("{$base}/Rfqs/Models/RfqItem.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\Rfqs\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RfqItem extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'rfq_items';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:4',
            'estimated_unit_price' => 'decimal:2',
        ];
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\Rfqs\Database\Factories\RfqItemFactory
    {
        return \App\Modules\Sourcing\Rfqs\Database\Factories\RfqItemFactory::new();
    }
}

PHP);

put("{$base}/Rfqs/Models/RfqInvitation.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\Rfqs\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RfqInvitation extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'rfq_invitations';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
            'responded_at' => 'datetime',
        ];
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    public function supplierOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'supplier_organization_id');
    }

    protected static function newFactory(): \App\Modules\Sourcing\Rfqs\Database\Factories\RfqInvitationFactory
    {
        return \App\Modules\Sourcing\Rfqs\Database\Factories\RfqInvitationFactory::new();
    }
}

PHP);

put("{$base}/Rfqs/Models/RfqQuestion.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\Rfqs\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RfqQuestion extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'rfq_questions';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    public function askedByOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'asked_by_organization_id');
    }

    public function askedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asked_by_user_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(RfqAnswer::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\Rfqs\Database\Factories\RfqQuestionFactory
    {
        return \App\Modules\Sourcing\Rfqs\Database\Factories\RfqQuestionFactory::new();
    }
}

PHP);

put("{$base}/Rfqs/Models/RfqAnswer.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\Rfqs\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RfqAnswer extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'rfq_answers';

    protected $guarded = [];

    protected function casts(): array
    {
        return [];
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(RfqQuestion::class, 'rfq_question_id');
    }

    public function answeredByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'answered_by_user_id');
    }

    protected static function newFactory(): \App\Modules\Sourcing\Rfqs\Database\Factories\RfqAnswerFactory
    {
        return \App\Modules\Sourcing\Rfqs\Database\Factories\RfqAnswerFactory::new();
    }
}

PHP);

put("{$base}/Rfqs/Models/RfqAddendum.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\Rfqs\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RfqAddendum extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'rfq_addenda';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\Rfqs\Database\Factories\RfqAddendumFactory
    {
        return \App\Modules\Sourcing\Rfqs\Database\Factories\RfqAddendumFactory::new();
    }
}

PHP);

put("{$base}/Bidding/Models/Bid.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\Bidding\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Organization;
use App\Modules\Sourcing\AwardsContracts\Models\Award;
use App\Modules\Sourcing\BidScoring\Models\BidScore;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bid extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'bids';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'valid_until' => 'datetime',
            'submitted_at' => 'datetime',
            'is_sealed' => 'boolean',
            'total' => 'decimal:2',
        ];
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    public function supplierOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'supplier_organization_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(BidItem::class);
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(BidRevision::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(BidScore::class);
    }

    public function awards(): HasMany
    {
        return $this->hasMany(Award::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\Bidding\Database\Factories\BidFactory
    {
        return \App\Modules\Sourcing\Bidding\Database\Factories\BidFactory::new();
    }
}

PHP);

put("{$base}/Bidding/Models/BidItem.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\Bidding\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Modules\Sourcing\Rfqs\Models\RfqItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BidItem extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'bid_items';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:4',
            'unit_price' => 'decimal:2',
            'line_total' => 'decimal:2',
        ];
    }

    public function bid(): BelongsTo
    {
        return $this->belongsTo(Bid::class);
    }

    public function rfqItem(): BelongsTo
    {
        return $this->belongsTo(RfqItem::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\Bidding\Database\Factories\BidItemFactory
    {
        return \App\Modules\Sourcing\Bidding\Database\Factories\BidItemFactory::new();
    }
}

PHP);

put("{$base}/Bidding/Models/BidRevision.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\Bidding\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BidRevision extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'bid_revisions';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
            'snapshot' => 'array',
            'revised_at' => 'datetime',
        ];
    }

    public function bid(): BelongsTo
    {
        return $this->belongsTo(Bid::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\Bidding\Database\Factories\BidRevisionFactory
    {
        return \App\Modules\Sourcing\Bidding\Database\Factories\BidRevisionFactory::new();
    }
}

PHP);

put("{$base}/PurchaseRequisitions/Models/PurchaseRequisition.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\PurchaseRequisitions\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\User;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseRequisition extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'purchase_requisitions';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function lineItems(): HasMany
    {
        return $this->hasMany(PurchaseRequisitionLineItem::class);
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(RequisitionApproval::class);
    }

    public function rfqs(): HasMany
    {
        return $this->hasMany(Rfq::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\PurchaseRequisitions\Database\Factories\PurchaseRequisitionFactory
    {
        return \App\Modules\Sourcing\PurchaseRequisitions\Database\Factories\PurchaseRequisitionFactory::new();
    }
}

PHP);

put("{$base}/PurchaseRequisitions/Models/PurchaseRequisitionLineItem.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\PurchaseRequisitions\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseRequisitionLineItem extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'purchase_requisition_line_items';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:4',
            'unit_price' => 'decimal:2',
            'line_total' => 'decimal:2',
        ];
    }

    public function purchaseRequisition(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequisition::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\PurchaseRequisitions\Database\Factories\PurchaseRequisitionLineItemFactory
    {
        return \App\Modules\Sourcing\PurchaseRequisitions\Database\Factories\PurchaseRequisitionLineItemFactory::new();
    }
}

PHP);

put("{$base}/PurchaseRequisitions/Models/RequisitionApproval.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\PurchaseRequisitions\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequisitionApproval extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'requisition_approvals';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'acted_at' => 'datetime',
        ];
    }

    public function purchaseRequisition(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequisition::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    protected static function newFactory(): \App\Modules\Sourcing\PurchaseRequisitions\Database\Factories\RequisitionApprovalFactory
    {
        return \App\Modules\Sourcing\PurchaseRequisitions\Database\Factories\RequisitionApprovalFactory::new();
    }
}

PHP);

put("{$base}/AwardsContracts/Models/Award.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\AwardsContracts\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Organization;
use App\Modules\Sourcing\Bidding\Models\Bid;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Award extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'awards';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'awarded_amount' => 'decimal:2',
            'award_percentage' => 'decimal:4',
            'awarded_at' => 'datetime',
        ];
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    public function bid(): BelongsTo
    {
        return $this->belongsTo(Bid::class);
    }

    public function supplierOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'supplier_organization_id');
    }

    public function contract(): HasOne
    {
        return $this->hasOne(Contract::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\AwardsContracts\Database\Factories\AwardFactory
    {
        return \App\Modules\Sourcing\AwardsContracts\Database\Factories\AwardFactory::new();
    }
}

PHP);

put("{$base}/AwardsContracts/Models/Contract.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\AwardsContracts\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use ImranDev\UniversalSlug\SlugOptions;
use ImranDev\UniversalSlug\Traits\HasUniversalSlug;

class Contract extends Model
{
    use BelongsToOrganization;
    use HasFactory;
    use HasUniversalSlug;

    protected $table = 'contracts';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'signed_at' => 'datetime',
            'effective_from' => 'datetime',
            'effective_until' => 'datetime',
            'contract_value' => 'decimal:2',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function award(): BelongsTo
    {
        return $this->belongsTo(Award::class);
    }

    public function supplierOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'supplier_organization_id');
    }

    public function clauses(): HasMany
    {
        return $this->hasMany(ContractClause::class)->orderBy('sort_order');
    }

    public function renewals(): HasMany
    {
        return $this->hasMany(ContractRenewal::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\AwardsContracts\Database\Factories\ContractFactory
    {
        return \App\Modules\Sourcing\AwardsContracts\Database\Factories\ContractFactory::new();
    }
}

PHP);

put("{$base}/AwardsContracts/Models/ContractClause.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\AwardsContracts\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractClause extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'contract_clauses';

    protected $guarded = [];

    protected function casts(): array
    {
        return [];
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\AwardsContracts\Database\Factories\ContractClauseFactory
    {
        return \App\Modules\Sourcing\AwardsContracts\Database\Factories\ContractClauseFactory::new();
    }
}

PHP);

put("{$base}/AwardsContracts/Models/ContractRenewal.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\AwardsContracts\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractRenewal extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'contract_renewals';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'renewal_date' => 'datetime',
            'new_effective_until' => 'datetime',
        ];
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\AwardsContracts\Database\Factories\ContractRenewalFactory
    {
        return \App\Modules\Sourcing\AwardsContracts\Database\Factories\ContractRenewalFactory::new();
    }
}

PHP);

put("{$base}/BidScoring/Models/ScoringCriterion.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\BidScoring\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScoringCriterion extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'scoring_criteria';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'weight' => 'decimal:4',
            'max_score' => 'decimal:2',
        ];
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(BidScore::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\BidScoring\Database\Factories\ScoringCriterionFactory
    {
        return \App\Modules\Sourcing\BidScoring\Database\Factories\ScoringCriterionFactory::new();
    }
}

PHP);

put("{$base}/BidScoring/Models/BidScore.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\BidScoring\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\User;
use App\Modules\Sourcing\Bidding\Models\Bid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BidScore extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'bid_scores';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'score' => 'decimal:2',
            'weighted_score' => 'decimal:4',
        ];
    }

    public function bid(): BelongsTo
    {
        return $this->belongsTo(Bid::class);
    }

    public function criterion(): BelongsTo
    {
        return $this->belongsTo(ScoringCriterion::class, 'scoring_criterion_id');
    }

    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    protected static function newFactory(): \App\Modules\Sourcing\BidScoring\Database\Factories\BidScoreFactory
    {
        return \App\Modules\Sourcing\BidScoring\Database\Factories\BidScoreFactory::new();
    }
}

PHP);

put("{$base}/BidScoring/Models/BidEvaluatorAssignment.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\BidScoring\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\User;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BidEvaluatorAssignment extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'bid_evaluator_assignments';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    protected static function newFactory(): \App\Modules\Sourcing\BidScoring\Database\Factories\BidEvaluatorAssignmentFactory
    {
        return \App\Modules\Sourcing\BidScoring\Database\Factories\BidEvaluatorAssignmentFactory::new();
    }
}

PHP);

put("{$base}/ReverseAuctions/Models/ReverseAuction.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\ReverseAuctions\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReverseAuction extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'reverse_auctions';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'starting_price' => 'decimal:2',
            'current_price' => 'decimal:2',
            'decrement' => 'decimal:2',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    public function auctionBids(): HasMany
    {
        return $this->hasMany(AuctionBid::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\ReverseAuctions\Database\Factories\ReverseAuctionFactory
    {
        return \App\Modules\Sourcing\ReverseAuctions\Database\Factories\ReverseAuctionFactory::new();
    }
}

PHP);

put("{$base}/ReverseAuctions/Models/AuctionBid.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\ReverseAuctions\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuctionBid extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'auction_bids';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'is_winning' => 'boolean',
            'placed_at' => 'datetime',
        ];
    }

    public function reverseAuction(): BelongsTo
    {
        return $this->belongsTo(ReverseAuction::class);
    }

    public function supplierOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'supplier_organization_id');
    }

    protected static function newFactory(): \App\Modules\Sourcing\ReverseAuctions\Database\Factories\AuctionBidFactory
    {
        return \App\Modules\Sourcing\ReverseAuctions\Database\Factories\AuctionBidFactory::new();
    }
}

PHP);

put("{$base}/Negotiation/Models/Negotiation.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\Negotiation\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Organization;
use App\Modules\Sourcing\Bidding\Models\Bid;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Negotiation extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'negotiations';

    protected $guarded = [];

    protected function casts(): array
    {
        return [];
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    public function bid(): BelongsTo
    {
        return $this->belongsTo(Bid::class);
    }

    public function supplierOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'supplier_organization_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(NegotiationMessage::class);
    }

    public function counterOffers(): HasMany
    {
        return $this->hasMany(CounterOffer::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\Negotiation\Database\Factories\NegotiationFactory
    {
        return \App\Modules\Sourcing\Negotiation\Database\Factories\NegotiationFactory::new();
    }
}

PHP);

put("{$base}/Negotiation/Models/NegotiationMessage.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\Negotiation\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NegotiationMessage extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'negotiation_messages';

    protected $guarded = [];

    protected function casts(): array
    {
        return [];
    }

    public function negotiation(): BelongsTo
    {
        return $this->belongsTo(Negotiation::class);
    }

    public function senderUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    public function senderOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'sender_organization_id');
    }

    protected static function newFactory(): \App\Modules\Sourcing\Negotiation\Database\Factories\NegotiationMessageFactory
    {
        return \App\Modules\Sourcing\Negotiation\Database\Factories\NegotiationMessageFactory::new();
    }
}

PHP);

put("{$base}/Negotiation/Models/CounterOffer.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\Negotiation\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CounterOffer extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'counter_offers';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'expires_at' => 'datetime',
        ];
    }

    public function negotiation(): BelongsTo
    {
        return $this->belongsTo(Negotiation::class);
    }

    public function offeredByOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'offered_by_organization_id');
    }

    protected static function newFactory(): \App\Modules\Sourcing\Negotiation\Database\Factories\CounterOfferFactory
    {
        return \App\Modules\Sourcing\Negotiation\Database\Factories\CounterOfferFactory::new();
    }
}

PHP);

put("{$base}/SupplierInvitations/Models/SupplierBroadcastProfile.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\SupplierInvitations\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierBroadcastProfile extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'supplier_broadcast_profiles';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'certifications' => 'array',
            'min_rating' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    protected static function newFactory(): \App\Modules\Sourcing\SupplierInvitations\Database\Factories\SupplierBroadcastProfileFactory
    {
        return \App\Modules\Sourcing\SupplierInvitations\Database\Factories\SupplierBroadcastProfileFactory::new();
    }
}

PHP);

// ===================== SERVICES =====================

put("{$base}/Bidding/Services/BidSubmissionService.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\Bidding\Services;

use App\Modules\Sourcing\Bidding\Models\Bid;
use App\Modules\Sourcing\Bidding\Models\BidRevision;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class BidSubmissionService
{
    public function submit(Bid $bid): Bid
    {
        return DB::transaction(function () use ($bid) {
            $rfq = Rfq::query()
                ->withoutGlobalScope('organization')
                ->find($bid->rfq_id);

            if (! $rfq || $rfq->status !== 'open') {
                throw new InvalidArgumentException('RFQ is not open for bidding.');
            }

            if ($rfq->deadline !== null && $rfq->deadline->isPast()) {
                throw new InvalidArgumentException('RFQ deadline has passed.');
            }

            $bid->loadMissing('items');

            $revisionNumber = (int) BidRevision::query()
                ->withoutGlobalScope('organization')
                ->where('bid_id', $bid->id)
                ->max('revision_number');

            BidRevision::query()->create([
                'organization_id' => $bid->organization_id,
                'bid_id' => $bid->id,
                'revision_number' => $revisionNumber + 1,
                'total' => $bid->total,
                'snapshot' => [
                    'status' => $bid->status,
                    'total' => (string) $bid->total,
                    'currency' => $bid->currency,
                    'lead_time_days' => $bid->lead_time_days,
                    'valid_until' => optional($bid->valid_until)?->toIso8601String(),
                    'is_sealed' => $bid->is_sealed,
                    'items' => $bid->items->map(fn ($item) => $item->only([
                        'id',
                        'rfq_item_id',
                        'quantity',
                        'unit_price',
                        'line_total',
                    ]))->all(),
                ],
                'revised_at' => now(),
            ]);

            $bid->update([
                'status' => 'submitted',
                'submitted_at' => now(),
            ]);

            return $bid->fresh(['items', 'revisions']);
        });
    }
}

PHP);

put("{$base}/AwardsContracts/Services/RfqAwardWorkflow.php", <<<'PHP'
<?php

namespace App\Modules\Sourcing\AwardsContracts\Services;

use App\Modules\Sourcing\AwardsContracts\Models\Award;
use App\Modules\Sourcing\Bidding\Models\Bid;
use App\Modules\Sourcing\BidScoring\Models\BidScore;
use App\Modules\Sourcing\BidScoring\Models\ScoringCriterion;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class RfqAwardWorkflow
{
    public function awardTopScoredBid(Rfq $rfq, Bid $bid, float $percentage = 100): Award
    {
        return DB::transaction(function () use ($rfq, $bid, $percentage) {
            if ((int) $bid->rfq_id !== (int) $rfq->id) {
                throw new InvalidArgumentException('Bid does not belong to this RFQ.');
            }

            if (! in_array($bid->status, ['submitted', 'awarded'], true)) {
                throw new InvalidArgumentException('Only submitted bids can be awarded.');
            }

            Bid::query()
                ->withoutGlobalScope('organization')
                ->where('rfq_id', $rfq->id)
                ->where('id', '!=', $bid->id)
                ->where('status', 'submitted')
                ->update(['status' => 'rejected']);

            $bid->update(['status' => 'awarded']);

            $award = Award::query()->create([
                'organization_id' => $rfq->organization_id,
                'rfq_id' => $rfq->id,
                'bid_id' => $bid->id,
                'supplier_organization_id' => $bid->supplier_organization_id,
                'awarded_amount' => (float) $bid->total * ($percentage / 100),
                'award_percentage' => $percentage,
                'currency' => $bid->currency,
                'status' => 'awarded',
                'awarded_at' => now(),
            ]);

            $rfq->update(['status' => 'awarded']);

            return $award;
        });
    }

    public function totalWeightedScore(Bid $bid): float
    {
        return (float) BidScore::query()
            ->withoutGlobalScope('organization')
            ->where('bid_id', $bid->id)
            ->sum('weighted_score');
    }

    public function ensureCriterion(Rfq $rfq, string $name, float $weight = 1, float $maxScore = 100): ScoringCriterion
    {
        return ScoringCriterion::query()->create([
            'organization_id' => $rfq->organization_id,
            'rfq_id' => $rfq->id,
            'name' => $name,
            'weight' => $weight,
            'max_score' => $maxScore,
        ]);
    }
}

PHP);

echo "Models and services written.\n";
