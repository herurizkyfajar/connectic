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
        Schema::create('meeting_notes', function (Blueprint $table) {
            $table->id();
            $table->string('document_no')->unique();
            $table->string('project_name');
            $table->date('meeting_date');
            $table->string('meeting_time'); // Format: HH:MM-HH:MM
            $table->string('meeting_location');
            $table->string('type_of_meeting'); // Discussion, Review, Planning, etc.
            $table->string('meeting_called_by');
            $table->text('attendance'); // Comma-separated names
            $table->string('note_taker');
            $table->string('topic');
            $table->text('meeting_result')->nullable();
            $table->text('on_progress')->nullable();
            $table->text('akan_dilakukan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_notes');
    }
};
