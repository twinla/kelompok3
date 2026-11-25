<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('story_pdf_imports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('story_id')->constrained('stories')->cascadeOnDelete();
            $table->string('original_name', 255);
            $table->char('file_sha256', 64);
            $table->timestamps();

            // Prevent the same uploaded file from creating duplicate stories for one account.
            $table->unique(['user_id', 'file_sha256'], 'story_pdf_imports_user_hash_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('story_pdf_imports');
    }
};
