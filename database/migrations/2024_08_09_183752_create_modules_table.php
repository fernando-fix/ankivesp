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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->string('name');
            $table->integer('lessons_count');
            $table->integer('position');
            $table->date('due_date')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('course_id')->references('id')->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('modules', function (Blueprint $table) {
        //     $table->dropForeign(['course_id']);
        // });

        Schema::dropIfExists('modules');
    }
};
