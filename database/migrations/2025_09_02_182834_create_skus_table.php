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
            $table->string('sku_code');  // Internal code
            $table->string('gtin')->nullable();    // Bar code of the sale of sale
            $table->json('attributes')->nullable(); // JSON com atributos (ex.: {"color": "red", "size": "500ml"})
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['tenant_id', 'model_type', 'model_id', 'sku_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skus');
    }
};
