<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('story_chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('chapter_number');
            $table->string('title', 160);
            $table->longText('content');
            $table->string('status', 20)->default('published');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->unique(['story_id', 'chapter_number']);
            $table->index(['story_id', 'status', 'chapter_number']);
        });

        // Pindahkan isi novel lama menjadi Chapter 1 agar karya yang sudah ada tetap bisa dibaca.
        if (Schema::hasTable('stories') && Schema::hasColumn('stories', 'content')) {
            DB::table('stories')
                ->whereNotNull('content')
                ->orderBy('id')
                ->chunkById(100, function ($stories) {
                    foreach ($stories as $story) {
                        $content = trim((string) $story->content);
                        if ($content === '') {
                            continue;
                        }

                        $isPublished = ($story->status ?? 'published') === 'published';
                        $createdAt = $story->created_at ?? now();
                        $updatedAt = $story->updated_at ?? now();

                        DB::table('story_chapters')->insert([
                            'story_id' => $story->id,
                            'chapter_number' => 1,
                            'title' => 'Chapter 1',
                            'content' => $content,
                            'status' => $isPublished ? 'published' : 'draft',
                            'published_at' => $isPublished ? $updatedAt : null,
                            'created_at' => $createdAt,
                            'updated_at' => $updatedAt,
                        ]);
                    }
                });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('story_chapters');
    }
};
