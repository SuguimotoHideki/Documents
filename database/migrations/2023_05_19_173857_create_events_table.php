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
            $table->string('event_name')->unique();
            $table->string('event_email');
            $table->string('event_website')->nullable();
            $table->string('organizer');
            $table->string('organizer_email');
            $table->string('organizer_website')->nullable();
            $table->longText('event_information');
            $table->enum('event_status', ['Em breve', 'Encerrado', 'Inscrições abertas', 'Inscrições encerradas', 'Submissões abertas', 'Submissões encerradas', 'Adiado', 'Cancelado']);
            $table->boolean('event_published');
            $table->longText('paper_topics');
            $table->date('subscription_start');
            $table->date('subscription_deadline');
            $table->date('submission_start');
            $table->date('submission_deadline');
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
