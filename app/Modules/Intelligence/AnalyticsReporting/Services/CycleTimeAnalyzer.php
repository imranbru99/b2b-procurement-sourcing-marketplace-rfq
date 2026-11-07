<?php

namespace App\Modules\Intelligence\AnalyticsReporting\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CycleTimeAnalyzer
{
    public function averagePoToInvoiceDays(?int $organizationId = null): ?float
    {
        $organizationId ??= organization_id();

        $query = DB::table('invoices')
            ->join('purchase_orders', 'invoices.purchase_order_id', '=', 'purchase_orders.id')
            ->whereNotNull('invoices.issued_at')
            ->whereNotNull('purchase_orders.issued_at');

        if ($organizationId !== null) {
            $query->where('invoices.organization_id', $organizationId);
        }

        $durations = [];

        foreach ($query->select(['invoices.issued_at as invoice_issued', 'purchase_orders.issued_at as po_issued'])->get() as $row) {
            $poIssued = Carbon::parse($row->po_issued);
            $invoiceIssued = Carbon::parse($row->invoice_issued);
            $durations[] = $poIssued->diffInDays($invoiceIssued);
        }

        if ($durations === []) {
            return null;
        }

        return array_sum($durations) / count($durations);
    }
}
