@extends('layouts.app')

@section('content')
<h1>上映スケジュール一覧</h1>

@foreach ($movies as $movie)
    <h2>{{ $movie->id }} : {{ $movie->title }}</h2>

    <a href="{{ route('admin.movies.show', $movie->id) }}">作品詳細ページへ</a>
    <a href="{{ route('admin.schedules.create', $movie->id) }}">スケジュール追加</a>

    <ul>
        @foreach ($movie->schedules as $schedule)
            <li>
                <a href="{{ route('admin.schedules.show', $schedule->id) }}">
                    開始: {{ $schedule->start_time->format('Y-m-d H:i:s') }},
                    終了: {{ $schedule->end_time->format('Y-m-d H:i:s') }}
                </a>
                <a href="{{ route('admin.schedules.edit', $schedule->id) }}">編集</a>
                <form method="POST" action="{{ route('admin.schedules.destroy', $schedule->id) }}" style="display:inline;" onsubmit="return confirm('本当に削除しますか？');">
                    @csrf
                    @method('DELETE')
                    <button type="submit">削除</button>
                </form>
            </li>
        @endforeach
    </ul>
@endforeach

@endsection
