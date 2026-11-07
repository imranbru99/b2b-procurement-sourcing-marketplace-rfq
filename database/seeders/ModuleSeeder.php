<?php

namespace Database\Seeders;

use App\Modules\ModuleManager;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        app(ModuleManager::class)->syncRegistryToDatabase();
    }
}
