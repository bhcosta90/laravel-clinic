<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('local_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id');
            $table->string('code');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['location_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('local_addresses');
    }
};
