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
            $table->foreignId('sku_id');
            $table->unsignedTinyInteger('unit_of_measure');
            $table->string('dun14')->nullable();
            $table->string('sscc')->nullable();
            $table->decimal('gross_weight')->nullable();
            $table->decimal('net_weight')->nullable();
            $table->decimal('volume')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packings');
    }
};
