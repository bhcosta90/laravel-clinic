<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('triages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->unsignedTinyInteger('risk');
            $table->string('description');
            $table->string('mmhg');
            $table->string('bpm');
            $table->string('irpm');
            $table->unsignedTinyInteger('temperature');
            $table->unsignedTinyInteger('saturation');
            $table->string('allergies');
            $table->string('current_medication');
            $table->string('history_diseases');
            $table->string('time_symptom_onset');
            $table->string('general_condition');
            $table->unsignedTinyInteger('eva');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('triages');
    }
};
