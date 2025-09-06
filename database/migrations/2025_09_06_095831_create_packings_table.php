<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('packings', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->string('model_type');
            $table->string('model_id');
            $table->tinyInteger('level');
            $table->unsignedBigInteger('quantity');
            $table->decimal('weight', 30, 4);
            $table->decimal('length', 30, 4);
            $table->decimal('width', 30, 4);
            $table->decimal('height', 30, 4);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packings');
    }
};
