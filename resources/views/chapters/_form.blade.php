<div class="tp-form-field">
    <label for="chapter-title">Chapter title</label>
    <input id="chapter-title" type="text" name="title" value="{{ old('title', $chapter->title ?? '') }}" maxlength="160" required>
    @error('title')<small class="error">{{ $message }}</small>@enderror
</div>
<div class="tp-form-field">
    <label for="chapter-content">Chapter content</label>
    <textarea id="chapter-content" name="content" rows="20" required>{{ old('content', $chapter->content ?? '') }}</textarea>
    @error('content')<small class="error">{{ $message }}</small>@enderror
</div>
<div class="tp-form-field">
    <label for="chapter-status">Publication status</label>
    <select id="chapter-status" name="status" required>
        <option value="draft" @selected(old('status', $chapter->status ?? 'published') === 'draft')>Save as draft</option>
        <option value="published" @selected(old('status', $chapter->status ?? 'published') === 'published')>Publish chapter</option>
    </select>
    @error('status')<small class="error">{{ $message }}</small>@enderror
</div>
