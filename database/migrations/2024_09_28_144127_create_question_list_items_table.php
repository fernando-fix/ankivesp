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
        Schema::create('question_list_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_list_id');
            $table->unsignedBigInteger('answer_id')->nullable();
            $table->unsignedBigInteger('question_id');
            $table->boolean('correct')->default(false);
            $table->timestamps();

            // Foreign keys
            $table->foreign('question_list_id')->references('id')->on('question_lists')->onDelete('cascade');
            $table->foreign('answer_id')->references('id')->on('answers');
            $table->foreign('question_id')->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_list_items');
    }
};
