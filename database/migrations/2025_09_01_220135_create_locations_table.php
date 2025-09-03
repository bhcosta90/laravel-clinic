<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignUuid('tenant_id')->constrained();
            $table->string('code');
            $table->unsignedTinyInteger('type');

            $table->string('aisle')->nullable(); // row/corridor
            $table->string('column')->nullable(); // rack/module
            $table->string('level')->nullable(); // level/shelf
            $table->string('position')->nullable(); // depth/slot

            // Zone (picking zone, receiving, shipping, quarantine, etc.)
            $table->unsignedTinyInteger('zone')->nullable();
            $table->unsignedInteger('max_capacity')->nullable(); // max units
            $table->integer('sequence')->nullable(); // picking route order
            $table->unsignedTinyInteger('control')->nullable(); // controlled substances?
            $table->decimal('temperature', 5)->nullable(); // °C if refrigerated
            $table->unsignedTinyInteger('status');
            $table->boolean('is_imported')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['tenant_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
