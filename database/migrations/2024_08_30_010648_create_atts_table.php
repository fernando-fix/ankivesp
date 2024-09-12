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
        Schema::create('atts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('extension', 10);
            $table->string('type', 50);
            $table->unsignedBigInteger('size');
            $table->text('folder');
            $table->text('file_path');
            $table->string('table_name');  // Tabela relacionada
            $table->unsignedBigInteger('table_id');  // ID do registro na tabela relacionada
            $table->string('field_name'); // Nome do tipo de arquivo (imagem, capa, avatar, documento, rg, etc)
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['table_name', 'table_id', 'field_name']);

            // Foreign keys
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atts');
    }
};
