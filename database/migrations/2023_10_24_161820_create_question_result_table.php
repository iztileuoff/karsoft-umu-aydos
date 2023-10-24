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
            $table->foreignId('option_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('drag_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('result_id')->constrained()->cascadeOnDelete();
            $table->string('answer_text')->nullable();
            $table->tinyInteger('position')->nullable();
            $table->boolean('is_correct');
            $table->timestamps();
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
