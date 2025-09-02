<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('catalogs', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('tenant_id')->constrained();
            $table->string('name');
            $table->unsignedTinyInteger('tracking_mode');
            $table->unsignedTinyInteger('hazardous');
            $table->boolean('temperature_controlled')->nullable();
            $table->unsignedTinyInteger('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catalogs');
    }
};
