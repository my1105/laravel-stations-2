<form method="POST" action="{{ route('admin.movies.update', ['id' => $movie->id]) }}">
    @csrf
    @method('PATCH')

    <label>映画タイトル</label>
    <input type="text" name="title" value="{{ old('title', $movie->title) }}">

    <label>画像URL</label>
    <input type="text" name="image_url" value="{{ old('image_url', $movie->image_url) }}">

    <label>公開年</label>
    <input type="number" name="published_year" value="{{ old('published_year', $movie->published_year) }}">

    <label>概要</label>
    <textarea name="description">{{ old('description', $movie->description) }}</textarea>

    <label>
        <input type="hidden" name="is_showing" value="0">
        <input type="checkbox" name="is_showing" value="1" {{ old('is_showing', $movie->is_showing) ? 'checked' : '' }}>
        上映中
    </label>

    <label for="genre">ジャンル</label>
    <input type="text" name="genre" id="genre" value="{{ old('genre', $movie->genre->name ?? '') }}" required>
    @error('genre')
        <div class="error">{{ $message }}</div>
    @enderror


    <button type="submit">更新</button>
</form>
