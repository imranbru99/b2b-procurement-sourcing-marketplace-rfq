<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ModuleSeeder::class,
            RolePermissionSeeder::class,
            DemoOrganizationSeeder::class,
            DemoUserSeeder::class,
            DemoSupplierSeeder::class,
            DemoSourcingSeeder::class,
            DemoOrderSeeder::class,
            DemoContentSeeder::class,
        ]);
    }
}
