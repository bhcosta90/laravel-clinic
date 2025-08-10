<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('anamnesis_items', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->foreignId('anamnesis_group_id')->constrained('anamnesis_groups');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anamnesis_items');
    }
};
