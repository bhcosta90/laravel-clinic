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
            $table->decimal('weight');
            $table->decimal('length');
            $table->decimal('width');
            $table->decimal('height');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packings');
    }
};
