<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('location_modules', function (Blueprint $table): void {
            $table->id();
            $table->foreignUuid('tenant_id')->constrained('tenants');
            $table->string('acronym');
            $table->unsignedInteger('sequence');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('location_modules');
    }
};
