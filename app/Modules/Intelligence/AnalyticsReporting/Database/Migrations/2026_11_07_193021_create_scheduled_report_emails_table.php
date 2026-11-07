<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scheduled_report_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('saved_report_id')->constrained('saved_reports')->cascadeOnDelete();
            $table->string('recipient_email');
            $table->string('cadence', 32)->default('weekly');
            $table->time('send_at')->nullable();
            $table->timestamp('last_sent_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['organization_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scheduled_report_emails');
    }
};
