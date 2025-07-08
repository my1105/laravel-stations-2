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

    @foreach($movies as $movie)
        <div class="movie">
            <h2>{{ $movie->title }}</h2>
            <img src="{{ $movie->image_url }}" alt="{{ $movie->title }}" />
        </div>
    @endforeach

</body>
</html>
