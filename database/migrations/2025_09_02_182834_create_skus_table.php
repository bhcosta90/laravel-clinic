<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('skus', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('tenant_id')->constrained();
            $table->morphs('model');
            $table->string('sku_code');
            $table->string('barcode');
            $table->string('description');
            $table->unsignedTinyInteger('unit_of_measure');
            $table->decimal('conversion_factor');
            $table->decimal('weight');
            $table->decimal('volume');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['tenant_id', 'model_type', 'model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skus');
    }
};
