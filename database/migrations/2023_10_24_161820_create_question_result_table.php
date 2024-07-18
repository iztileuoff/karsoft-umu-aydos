<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('question_result', function (Blueprint $table) {
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->foreignId('result_id')->constrained()->cascadeOnDelete();
            $table->json('options')->nullable();
            $table->json('drags')->nullable();
            $table->string('answer_text')->nullable();
            $table->boolean('is_answered')->default(false);
            $table->boolean('is_correct')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_result');
    }
};
