<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table): void {
            $table->id();
            $table->foreignUlid('user_id')->constrained('users');
            $table->uuid('key');
            $table->string('name');
            $table->string('model');
            $table->unsignedBigInteger('status')->nullable();
            $table->string('file')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
