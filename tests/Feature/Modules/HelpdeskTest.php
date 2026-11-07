<?php

use App\Models\Organization;
use App\Models\User;
use App\Modules\Platform\Helpdesk\Models\SlaPolicy;
use App\Modules\Platform\Helpdesk\Models\Ticket;
use App\Modules\Platform\Helpdesk\Models\TicketReply;

it('creates helpdesk tickets with sla policy and replies', function () {
    $organization = Organization::query()->create([
        'name' => 'Support Org',
        'type' => 'buyer',
    ]);

    $user = User::factory()->create();

    $sla = SlaPolicy::query()->withoutGlobalScope('organization')->create([
        'organization_id' => $organization->id,
        'name' => 'Standard',
        'first_response_minutes' => 120,
        'resolution_minutes' => 2880,
    ]);

    $ticket = Ticket::query()->withoutGlobalScope('organization')->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
        'sla_policy_id' => $sla->id,
        'subject' => 'Cannot submit bid',
        'description' => 'Form validation error',
        'status' => 'open',
    ]);

    TicketReply::query()->create([
        'ticket_id' => $ticket->id,
        'user_id' => $user->id,
        'body' => 'We are investigating.',
    ]);

    expect($ticket->fresh()->slug)->not->toBeEmpty()
        ->and(TicketReply::query()->where('ticket_id', $ticket->id)->count())->toBe(1);
});
