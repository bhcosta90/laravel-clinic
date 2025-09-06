<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('barcodes', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->foreignId('packing_id')->constrained('packings');
            $table->string('ean');
            $table->unsignedInteger('type');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['tenant_id', 'packing_id', 'ean']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barcodes');
    }
};
