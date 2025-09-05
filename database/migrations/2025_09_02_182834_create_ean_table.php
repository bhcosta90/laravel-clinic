<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('ean', function (Blueprint $table): void {
            $table->id();
            $table->uuid('tenant_id')->index();
            $table->morphs('model');
            $table->unsignedTinyInteger('unit_of_measure');
            $table->string('ean')->nullable();
            $table->decimal('gross_weight', 30, 4)->nullable();
            $table->decimal('net_weight', 30, 4)->nullable();
            $table->decimal('volume', 30, 4)->nullable();
            $table->decimal('conversion_factor', 30, 8)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['tenant_id', 'ean']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ean');
    }
};
