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
            $table->foreignId('co_authors_id')->constrained();
            $table->foreignId('documents_id')->constrained();

            $table->unique(['co_authors_id', 'documents_id']);

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
