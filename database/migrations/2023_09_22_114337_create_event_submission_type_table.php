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
        Schema::create('event_submission_type', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('submission_type_id');

            $table->foreign('event_id')
            ->references('id')
            ->on('events');

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
        Schema::dropIfExists('event_submission_type');
    }
};
