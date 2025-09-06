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
            $table->string('tenant_id');
            $table->string('name');
            $table->string('sku_code');
            $table->unsignedTinyInteger('tracking_mode');
            $table->unsignedTinyInteger('status');
            $table->unsignedTinyInteger('hazardous')->nullable();
            $table->unsignedTinyInteger('level');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['tenant_id', 'sku_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catalogs');
    }
};
