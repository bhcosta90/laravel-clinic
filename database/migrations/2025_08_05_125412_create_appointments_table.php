<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table): void {
            $table->id();
            $table->uuid('tenant_id')->index();
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('procedure_id')->constrained('procedures');
            $table->foreignId('transaction_id')->nullable()->constrained('transactions');
            $table->foreignId('agreement_id')->nullable()->constrained('agreements');
            $table->dateTime('date');
            $table->boolean('is_return')->nullable();
            $table->boolean('is_paid')->nullable();
            $table->unsignedTinyInteger('status');
            $table->string('exam_withdrawal_date')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
