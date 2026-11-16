<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('story_characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained('stories')->cascadeOnDelete();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('image');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('story_characters');
    }
};
