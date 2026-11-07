<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_audits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('inspector_assignment_id')->nullable()->constrained('inspector_assignments')->nullOnDelete();
            $table->string('title');
            $table->string('status', 32)->default('scheduled');
            $table->timestamp('audited_at')->nullable();
            $table->unsignedTinyInteger('score')->nullable();
            $table->timestamps();

            $table->index('organization_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_audits');
    }
};
