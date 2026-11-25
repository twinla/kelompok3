
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
        <label>Judul Cerita</label>

        <input
            type="text"
            name="title"
            value="{{ old('title', $story->title) }}"
            placeholder="Masukkan judul cerita"
            required
        >

        @error('title')
            <small class="error">{{ $message }}</small>
        @enderror
    </div>


    <div class="form-row">

        <div class="form-group">
            <label>Nama Penulis</label>

            <input
                type="text"
                name="author"
                value="{{ old('author', $story->author) }}"
                placeholder="Nama pena kamu"
                required
            >

            @error('author')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Genre</label>

            <select name="genre" required>
                <option value="">Pilih genre</option>

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
                        {{ __($genre) }}
                    </option>

                @endforeach

            </select>

            @error('genre')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>

    </div>


    <div class="form-group">
        <label>Sinopsis</label>

        <textarea
            name="synopsis"
            rows="4"
            placeholder="Tulis ringkasan singkat ceritamu..."
            required
        >{{ old('synopsis', $story->synopsis) }}</textarea>

        @error('synopsis')
            <small class="error">{{ $message }}</small>
        @enderror
    </div>


    <div class="form-group">
        <label>Isi Cerita</label>

        <textarea
            name="content"
            rows="15"
            placeholder="Mulai tulis ceritamu di sini..."
            required
        >{{ old('content', $story->content) }}</textarea>

        @error('content')
            <small class="error">{{ $message }}</small>
        @enderror
    </div>


    <div class="form-group">
        <label>Sampul Cerita</label>

        @if($story->cover)
            <img
                src="{{ asset('storage/' . $story->cover) }}"
                alt="Sampul saat ini"
                class="current-cover"
            >
        @endif

        <input
            type="file"
            name="cover"
            accept=".jpg,.jpeg,.png,.webp"
        >

        <small>Maksimal 2 MB. Format JPG, PNG, atau WEBP.</small>

        @error('cover')
            <small class="error">{{ $message }}</small>
        @enderror
    </div>


    <div class="form-group">
        <label>Status Publikasi</label>

        <select name="status" required>
            <option value="published"
                @selected(old('status', $story->status ?? 'published') === 'published')>
                Terbit
            </option>

            <option value="draft"
                @selected(old('status', $story->status ?? '') === 'draft')>
                Draf
            </option>
        </select>
    </div>


    <div class="form-actions">
        <a href="{{ route('stories.index') }}" class="btn btn-outline">
            Batal
        </a>

        <button type="submit" class="btn btn-dark">
            {{ $story->exists ? 'Simpan Perubahan' : 'Terbitkan Cerita' }}
        </button>
    </div>

</form>
