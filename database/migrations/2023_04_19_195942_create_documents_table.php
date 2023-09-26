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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('institution');
            $table->string('keyword');
            $table->string('attachment_author');
            $table->string('attachment_no_author');
            $table->unsignedBigInteger('submission_type_id');

            $table->foreign('submission_type_id')
            ->references('id')
            ->on('submission_types');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
