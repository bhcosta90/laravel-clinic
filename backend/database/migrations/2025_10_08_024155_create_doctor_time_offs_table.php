<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_time_offs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->string('reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_time_offs');
    }
};
