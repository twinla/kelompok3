<div class="tp-form-field">
    <label for="chapter-title">Judul Bab</label>
    <input id="chapter-title" type="text" name="title" value="{{ old('title', isset($chapter) && $chapter->title === 'Chapter ' . $chapter->chapter_number ? 'Bab ' . $chapter->chapter_number : ($chapter->title ?? '')) }}" maxlength="160" required>
    @error('title')<small class="error">{{ $message }}</small>@enderror
</div>
<div class="tp-form-field">
    <label for="chapter-content">Isi Bab</label>
    <textarea id="chapter-content" name="content" rows="20" required>{{ old('content', $chapter->content ?? '') }}</textarea>
    @error('content')<small class="error">{{ $message }}</small>@enderror
</div>
<div class="tp-form-field">
    <label for="chapter-status">Status Publikasi</label>
    <select id="chapter-status" name="status" required>
        <option value="draft" @selected(old('status', $chapter->status ?? 'published') === 'draft')>Simpan sebagai draf</option>
        <option value="published" @selected(old('status', $chapter->status ?? 'published') === 'published')>Terbitkan bab</option>
    </select>
    @error('status')<small class="error">{{ $message }}</small>@enderror
</div>
