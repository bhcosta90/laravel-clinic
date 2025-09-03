<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('triages', function (Blueprint $table): void {
            $table->id();
            $table->uuid('tenant_id')->index();
            $table->foreignId('customer_id')->constrained('customers');
            $table->unsignedTinyInteger('risk_classification');
            $table->string('description');
            $table->string('mmhg')->nullable();
            $table->string('bpm')->nullable();
            $table->string('irpm')->nullable();
            $table->unsignedTinyInteger('temperature')->nullable();
            $table->unsignedTinyInteger('saturation')->nullable();
            $table->string('allergy')->nullable();
            $table->string('current_medication')->nullable();
            $table->string('history_diseases')->nullable();
            $table->string('time_symptom_onset')->nullable();
            $table->string('general_condition')->nullable();
            $table->unsignedTinyInteger('eva')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('triages');
    }
};
