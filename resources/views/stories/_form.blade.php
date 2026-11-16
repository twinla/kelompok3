
<form
    action="{{ $story->exists
        ? route('stories.update', $story)
        : route('stories.store') }}"
    method="POST"
    enctype="multipart/form-data"
    class="story-form"
>

    @csrf

    @if($story->exists)
        @method('PUT')
    @endif

    <div class="form-group">
        <label>Story Title</label>

        <input
            type="text"
            name="title"
            value="{{ old('title', $story->title) }}"
            placeholder="Enter your novel title"
            required
        >

        @error('title')
            <small class="error">{{ $message }}</small>
        @enderror
    </div>


    <div class="form-row">

        <div class="form-group">
            <label>Author Name</label>

            <input
                type="text"
                name="author"
                value="{{ old('author', $story->author) }}"
                placeholder="Your author name"
                required
            >

            @error('author')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Genre</label>

            <select name="genre" required>
                <option value="">Choose Genre</option>

                @foreach([
                    'Romance',
                    'Fantasy',
                    'Mystery',
                    'Horror',
                    'Science Fiction',
                    'Drama',
                    'Adventure',
                    'Thriller',
                    'Comedy'
                ] as $genre)

                    <option
                        value="{{ $genre }}"
                        @selected(old('genre', $story->genre) === $genre)
                    >
                        {{ $genre }}
                    </option>

                @endforeach

            </select>

            @error('genre')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>

    </div>


    <div class="form-group">
        <label>Synopsis</label>

        <textarea
            name="synopsis"
            rows="4"
            placeholder="Write a short description of your story..."
            required
        >{{ old('synopsis', $story->synopsis) }}</textarea>

        @error('synopsis')
            <small class="error">{{ $message }}</small>
        @enderror
    </div>


    <div class="form-group">
        <label>Story Content</label>

        <textarea
            name="content"
            rows="15"
            placeholder="Start writing your story here..."
            required
        >{{ old('content', $story->content) }}</textarea>

        @error('content')
            <small class="error">{{ $message }}</small>
        @enderror
    </div>


    <div class="form-group">
        <label>Book Cover</label>

        @if($story->cover)
            <img
                src="{{ asset('storage/' . $story->cover) }}"
                alt="Current cover"
                class="current-cover"
            >
        @endif

        <input
            type="file"
            name="cover"
            accept=".jpg,.jpeg,.png,.webp"
        >

        <small>Maximum 2 MB. JPG, PNG, or WEBP.</small>

        @error('cover')
            <small class="error">{{ $message }}</small>
        @enderror
    </div>


    <div class="form-group">
        <label>Publication Status</label>

        <select name="status" required>
            <option value="published"
                @selected(old('status', $story->status ?? 'published') === 'published')>
                Published
            </option>

            <option value="draft"
                @selected(old('status', $story->status ?? '') === 'draft')>
                Draft
            </option>
        </select>
    </div>


    <div class="form-actions">
        <a href="{{ route('stories.index') }}" class="btn btn-outline">
            Cancel
        </a>

        <button type="submit" class="btn btn-dark">
            {{ $story->exists ? 'Save Changes' : 'Publish Story' }}
        </button>
    </div>

</form>
