<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        // patients
        Schema::create('patients', function (Blueprint $t): void {
            $t->id();
            $t->string('code')->unique();
            $t->string('name');
            $t->timestamps();
            $t->softDeletes();
        });

        // insurances
        Schema::create('insurances', function (Blueprint $t): void {
            $t->id();
            $t->string('name');
            $t->unsignedInteger('min_days_in_advance')->nullable();
            $t->unsignedInteger('max_monthly_appointments')->nullable();
            $t->unsignedInteger('max_total_appointments')->nullable();
            $t->unsignedInteger('max_appointments_per_patient_month')->nullable();
            $t->json('allowed_weekdays')->nullable();
            $t->timestamps();
            $t->softDeletes();
        });

        // patient_insurance pivot
        Schema::create('patient_insurance', function (Blueprint $t): void {
            $t->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $t->foreignId('insurance_id')->constrained('insurances')->cascadeOnDelete();
            $t->boolean('active')->default(true);
            $t->timestamps();
            $t->softDeletes();
            $t->primary(['patient_id', 'insurance_id']);
        });

        // procedures
        Schema::create('procedures', function (Blueprint $t): void {
            $t->id();
            $t->string('code')->unique();
            $t->string('name');
            $t->unsignedInteger('min_duration_minutes')->default(0);
            $t->unsignedInteger('max_duration_minutes')->default(0);
            $t->timestamps();
            $t->softDeletes();
        });

        // specialties
        Schema::create('specialties', function (Blueprint $t): void {
            $t->id();
            $t->string('code')->unique();
            $t->string('name');
            $t->timestamps();
            $t->softDeletes();
        });

        // pivots procedure_user & specialty_user
        Schema::create('procedure_user', function (Blueprint $t): void {
            $t->foreignId('procedure_id')->constrained('procedures')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->primary(['procedure_id', 'user_id']);
            $t->timestamps();
            $t->softDeletes();
        });

        Schema::create('specialty_user', function (Blueprint $t): void {
            $t->foreignId('specialty_id')->constrained('specialties')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->primary(['specialty_id', 'user_id']);
            $t->timestamps();
            $t->softDeletes();
        });

        // user_schedules
        Schema::create('user_schedules', function (Blueprint $t): void {
            $t->id();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->unsignedTinyInteger('day_of_week');
            $t->time('start_time');
            $t->time('end_time');
            $t->unsignedSmallInteger('slot_minutes');
            $t->timestamps();
            $t->softDeletes();
            $t->index(['user_id', 'day_of_week']);
        });

        // doctor_unavailabilities
        Schema::create('doctor_unavailabilities', function (Blueprint $t): void {
            $t->id();
            $t->foreignId('doctor_id')->constrained('users')->cascadeOnDelete();
            $t->dateTime('start_at');
            $t->dateTime('end_at');
            $t->timestamps();
            $t->softDeletes();
            $t->index(['doctor_id', 'start_at', 'end_at']);
        });

        // clinic schedules & unavailabilities
        Schema::create('clinic_schedules', function (Blueprint $t): void {
            $t->id();
            $t->unsignedTinyInteger('day_of_week');
            $t->time('start_time');
            $t->time('end_time');
            $t->unsignedSmallInteger('slot_minutes');
            $t->timestamps();
            $t->softDeletes();
            $t->index('day_of_week');
        });

        Schema::create('clinic_unavailabilities', function (Blueprint $t): void {
            $t->id();
            $t->dateTime('start_at');
            $t->dateTime('end_at');
            $t->timestamps();
            $t->softDeletes();
            $t->index(['start_at', 'end_at']);
        });

        // rooms and room unavailability
        Schema::create('rooms', function (Blueprint $t): void {
            $t->id();
            $t->string('code')->unique();
            $t->string('name');
            $t->boolean('is_active')->default(true);
            $t->timestamps();
            $t->softDeletes();
        });

        Schema::create('room_unavailabilities', function (Blueprint $t): void {
            $t->id();
            $t->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $t->dateTime('start_at');
            $t->dateTime('end_at');
            $t->timestamps();
            $t->softDeletes();
            $t->index(['room_id', 'start_at', 'end_at']);
        });

        // appointments
        Schema::create('appointments', function (Blueprint $t): void {
            $t->id();
            $t->foreignId('doctor_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $t->foreignId('procedure_id')->nullable()->constrained('procedures')->nullOnDelete();
            $t->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $t->dateTime('start_at');
            $t->dateTime('end_at');
            $t->timestamps();
            $t->softDeletes();
            $t->index(['start_at', 'end_at']);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('room_unavailabilities');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('doctor_unavailabilities');
        Schema::dropIfExists('user_schedules');
        Schema::dropIfExists('clinic_unavailabilities');
        Schema::dropIfExists('clinic_schedules');
        Schema::dropIfExists('specialty_user');
        Schema::dropIfExists('procedure_user');
        Schema::dropIfExists('specialties');
        Schema::dropIfExists('procedures');
        Schema::dropIfExists('patient_insurance');
        Schema::dropIfExists('insurances');
        Schema::dropIfExists('patients');
        // do not drop or alter users table
    }
};
