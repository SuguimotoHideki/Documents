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
        Schema::create('submission_type_review_field', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('review_field_id');
            $table->unsignedBigInteger('submission_type_id');

            $table->foreign('review_field_id')
            ->references('id')
            ->on('review_fields')
            ->onDelete('cascade');

            $table->foreign('submission_type_id')
            ->references('id')
            ->on('submission_types')
            ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_type_review_field');
    }
};
