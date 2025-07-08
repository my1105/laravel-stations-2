@extends('layouts.app')

@section('content')
<h1>映画一覧（管理画面）</h1>

@if(session('success'))
    <div style="color: green; margin-bottom: 10px;">
        {{ session('success') }}
    </div>
@endif

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>タイトル</th>
            <th>画像</th>
            <th>公開年</th>
            <th>上映状況</th>
            <th>概要</th>
            <th>詳細</th>
            <th>編集</th>
            <th>削除</th> {{-- 削除列追加 --}}
        </tr>
    </thead>
    <tbody>
    @foreach ($movies as $movie)
        <tr>
            <td>{{ $movie->id }}</td>
            <td>{{ $movie->title }}</td>
            <td><img src="{{ $movie->image_url }}" alt="{{ $movie->title }}" width="100"></td>
            <td>{{ $movie->published_year }}</td>
            <td>{{ $movie->is_showing ? '上映中' : '上映予定' }}</td>
            <td>{{ Str::limit($movie->description, 50) }}</td>
            <td><a href="{{ route('admin.movies.show', $movie->id) }}">詳細</a></td>
            <td><a href="{{ route('admin.movies.edit', ['id' => $movie->id]) }}">編集</a></td>
            <td>
                <form method="POST" action="{{ route('admin.movies.destroy', ['id' => $movie->id]) }}" onsubmit="return confirm('本当に削除しますか？');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="color: red;">削除</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
