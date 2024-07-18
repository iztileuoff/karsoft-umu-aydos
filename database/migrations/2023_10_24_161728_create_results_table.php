<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->morphs('resultable');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('complated_at')->nullable();
            $table->unsignedTinyInteger('count_questions')->nullable();
            $table->unsignedTinyInteger('count_correct_questions')->nullable();
            $table->unsignedTinyInteger('count_incorrect_questions')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
