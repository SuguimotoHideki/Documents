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
        Schema::create('co_authors_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('co_author_id');
            $table->integer('number');

            $table->foreign('document_id')
            ->references('id')
            ->on('documents')
            ->onDelete('cascade');

            $table->foreign('co_author_id')
            ->references('id')
            ->on('co_authors')
            ->onDelete('cascade');

            $table->unique(['co_author_id', 'document_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('co_authors_documents');
    }
};
