<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pdf_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('original_name', 255);
            $table->string('file_path', 500)->unique();
            $table->string('mime_type', 120)->default('application/pdf');
            $table->unsignedBigInteger('size_bytes');
            $table->timestamp('uploaded_at');
            $table->timestamps();

            $table->index(['user_id', 'uploaded_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pdf_documents');
    }
};
