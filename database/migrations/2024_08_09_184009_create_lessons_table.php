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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('module_id');
            $table->string('name');
            $table->enum('type', ['youtube', 'pdf', 'link']);
            $table->string('url'); // link ou url
            $table->integer('position')->default(0); //ordem de exibição
            $table->timestamps();

            // unique
            $table->unique(['module_id', 'name']);

            // Foreign keys
            $table->foreign('module_id')->references('id')->on('modules');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('lessons', function (Blueprint $table) {
        //     $table->dropForeign(['module_id']);
        // });

        Schema::dropIfExists('lessons');
    }
};
