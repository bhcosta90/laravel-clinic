<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_time_offs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms');
            $table->string('start_at');
            $table->string('end_at');
            $table->string('reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_time_offs');
    }
};
