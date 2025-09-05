<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('skus', function (Blueprint $table): void {
            $table->id();
            $table->uuid('tenant_id')->index();
            $table->morphs('model');
            $table->string('sku_code');  // Internal code
            $table->string('barcode')->nullable();    // Bar code of the sale of sale
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
