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

<h2>上映スケジュール</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>開始時刻</th>
            <th>終了時刻</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($movie->schedules as $schedule)
            <tr>
                <td>{{ $schedule->start_time->format('Y-m-d H:i:s') }}</td>
                <td>{{ $schedule->end_time->format('Y-m-d H:i:s') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<a href="{{ route('sheets.index', [
    'movie' => $movie->id,
    'schedule' => $schedule->id,
    'date' => \Carbon\Carbon::today()->toDateString(),
]) }}">
    座席を予約する
</a>

<a href="{{ route('admin.movies.index') }}">一覧に戻る</a>
@endsection
