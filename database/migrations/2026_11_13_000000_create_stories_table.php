
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();

            $table->string('title', 150);
            $table->string('slug')->unique();
            $table->string('author', 100);
            $table->string('genre', 80);

            $table->string('cover')->nullable();

            $table->text('synopsis');
            $table->longText('content');

            $table->enum('status', [
                'draft',
                'published'
            ])->default('published');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
