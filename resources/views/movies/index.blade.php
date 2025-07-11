<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>映画一覧</title>
    <style>
        img {
            max-width: 200px;
            height: auto;
        }
        .movie {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>映画一覧</h1>

    <form method="GET" action="{{ route('movies.index') }}">
        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="キーワード検索">

        <label>
            <input type="radio" name="is_showing" value="" {{ request('is_showing') === null || request('is_showing') === '' ? 'checked' : '' }}>
            すべて
        </label>
        <label>
            <input type="radio" name="is_showing" value="1" {{ request('is_showing') === '1' ? 'checked' : '' }}>
            上映中
        </label>
        <label>
            <input type="radio" name="is_showing" value="0" {{ request('is_showing') === '0' ? 'checked' : '' }}>
            上映予定
        </label>

        <button type="submit">検索</button>
    </form>

    <hr>

    @foreach($movies as $movie)
        <h3>{{ $movie->title }}</h3>
        <img src="{{ $movie->image_url }}" />
        <p>{{ $movie->published_year }}</p>
        <p>{{ $movie->description }}</p>
        <p>{{ $movie->is_showing ? '上映中' : '上映予定' }}</p>
    @endforeach


    {{ $movies->links() }}

</body>
</html>
