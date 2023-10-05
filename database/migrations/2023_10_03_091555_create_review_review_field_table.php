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
        Schema::create('review_review_field', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('review_id');
            $table->unsignedBigInteger('review_field_id');
            $table->integer('score');

            $table->foreign('review_id')
            ->references('id')
            ->on('reviews')
            ->onDelete('cascade');

            $table->foreign('review_field_id')
            ->references('id')
            ->on('review_fields')
            ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_review_field');
    }
};
