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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_lang_task')->constrained('languages');
            $table->foreignId('id_lang_answer')->constrained('languages');
            $table->foreignId('id_section')->constrained('sections');
            $table->string('name');
            $table->integer('number_task');
            $table->string('type');
            $table->string('content_name')->nullable();
            $table->text('description')->nullable();
            $table->text('true_answer')->nullable();
            $table->text('true_keywords')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
