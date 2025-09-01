<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('tenant_id');
            $table->string('code');
            $table->unsignedTinyInteger('type');

            $table->string('warehouse')->nullable(); // e.g. CD01
            $table->string('aisle')->nullable(); // row/corridor
            $table->string('column')->nullable(); // rack/module
            $table->string('level')->nullable(); // level/shelf
            $table->string('position')->nullable(); // depth/slot

            // Zone (picking zone, receiving, shipping, quarantine, etc.)
            $table->string('zone')->nullable();
            $table->unsignedTinyInteger('location_type');

            $table->integer('max_capacity')->nullable(); // max units
            $table->integer('picking_sequence')->nullable(); // picking route order
            $table->boolean('is_controlled')->default(false); // controlled substances?
            $table->decimal('temperature', 5, 2)->nullable(); // °C if refrigerated
            $table->unsignedTinyInteger('status');

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
