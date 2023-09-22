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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email');
            $table->string('website')->nullable();
            $table->string('organizer');
            $table->string('organizer_email');
            $table->string('organizer_website')->nullable();
            $table->longText('information');
            $table->integer('status');
            $table->boolean('published');
            //New fields
            $table->json('paper_topics')->nullable();
            $table->string('logo')->nullable();
            $table->string('submission_type');
            //
            $table->dateTime('subscription_start');
            $table->dateTime('subscription_deadline');
            $table->dateTime('submission_start');
            $table->dateTime('submission_deadline');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
