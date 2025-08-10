<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table): void {
            $table->id();
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['slug'], 'permissions_slug_tenant_id_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
