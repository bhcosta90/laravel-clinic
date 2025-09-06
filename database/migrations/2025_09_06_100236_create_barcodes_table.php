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
            $table->foreignUuid('packing_id')->constrained('packings');
            $table->string('code');
            $table->unsignedInteger('type');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['tenant_id', 'packing_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barcodes');
    }
};
