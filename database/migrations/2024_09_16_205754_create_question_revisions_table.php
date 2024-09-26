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
        Schema::create('question_revisions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_user_id');
            $table->unsignedBigInteger('selected_answer_id');
            $table->datetime('last_view')->nullable();
            $table->datetime('next_view');
            $table->integer('score')->default(0);
            $table->float('factor');
            $table->integer('interval');
            $table->timestamps();

            // Foreign keys
            $table->foreign('question_user_id')->references('id')->on('question_users');
            $table->foreign('selected_answer_id')->references('id')->on('answers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_revisions');
    }
};
