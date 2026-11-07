<?php

namespace App\Modules\Suppliers\Catalog\Services;

use App\Modules\Suppliers\Catalog\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProductBulkImportService
{
    /**
     * @param  list<array<string, mixed>>  $rows
     * @return array{created: int, updated: int, errors: list<string>}
     */
    public function import(int $organizationId, array $rows): array
    {
        $created = 0;
        $updated = 0;
        $errors = [];

        DB::transaction(function () use ($organizationId, $rows, &$created, &$updated, &$errors): void {
            foreach ($rows as $index => $row) {
                $sku = Arr::get($row, 'sku');
                $name = Arr::get($row, 'name');

                if (! is_string($name) || $name === '') {
                    $errors[] = "Row {$index}: name is required.";

                    continue;
                }

                $attributes = [
                    'name' => $name,
                    'description' => Arr::get($row, 'description'),
                    'price' => Arr::get($row, 'price'),
                    'currency' => Arr::get($row, 'currency', 'USD'),
                    'moq' => Arr::get($row, 'moq'),
                    'stock' => Arr::get($row, 'stock'),
                    'is_active' => (bool) Arr::get($row, 'is_active', true),
                    'variants' => Arr::get($row, 'variants'),
                    'supplier_category_id' => Arr::get($row, 'supplier_category_id'),
                    'supplier_profile_id' => Arr::get($row, 'supplier_profile_id'),
                ];

                $query = Product::query()->withoutGlobalScope('organization')
                    ->where('organization_id', $organizationId);

                if (is_string($sku) && $sku !== '') {
                    $query->where('sku', $sku);
                } else {
                    $query->where('name', $name);
                }

                $product = $query->first();

                if ($product) {
                    $product->fill($attributes);
                    if (is_string($sku) && $sku !== '') {
                        $product->sku = $sku;
                    }
                    $product->save();
                    $updated++;
                } else {
                    Product::query()->withoutGlobalScope('organization')->create([
                        'organization_id' => $organizationId,
                        'sku' => $sku,
                        ...$attributes,
                    ]);
                    $created++;
                }
            }
        });

        return compact('created', 'updated', 'errors');
    }
}
