@extends('layouts.app')

@section('content')
<h1>映画詳細（管理画面）</h1>

<p><strong>ID:</strong> {{ $movie->id }}</p>
<p><strong>タイトル:</strong> {{ $movie->title }}</p>
<p><strong>画像:</strong><br>
<img src="{{ $movie->image_url }}" alt="{{ $movie->title }}" width="300"></p>
<p><strong>公開年:</strong> {{ $movie->published_year }}</p>
<p><strong>上映状況:</strong> {{ $movie->is_showing ? '上映中' : '上映予定' }}</p>
<p><strong>概要:</strong> {{ $movie->description }}</p>

<a href="{{ route('admin.movies.index') }}">一覧に戻る</a>
@endsection
