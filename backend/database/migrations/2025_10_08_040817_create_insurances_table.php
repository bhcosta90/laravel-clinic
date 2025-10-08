<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('insurances', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('min_days_in_advance');
            $table->unsignedInteger('max_monthly_appointments');
            $table->unsignedInteger('max_total_appointments');
            $table->json('allowed_weekdays');
            $table->unsignedInteger('max_appointments_per_patient_month');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurances');
    }
};
