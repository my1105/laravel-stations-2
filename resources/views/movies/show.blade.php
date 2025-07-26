@extends('layouts.app')

@section('content')
<h1>{{ $movie->title }}</h1>
<img src="{{ $movie->image_url }}" alt="{{ $movie->title }}" style="max-width:300px;">
<p>公開年: {{ $movie->published_year }}</p>
<p>上映状況: {{ $movie->is_showing ? '上映中' : '上映予定' }}</p>
<p>概要: {{ $movie->description }}</p>

<h2>上映スケジュール</h2>

@if($schedules->isEmpty())
    <p>上映スケジュールは登録されていません。</p>
@else
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>開始時刻</th>
            <th>終了時刻</th>
        </tr>
    </thead>
    <tbody>
        @foreach($schedules as $schedule)
        <tr>
            <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</td>
            <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
            <td>
                <a href="{{ route('sheets.index', [
                    'movie' => $movie->id,
                    'schedule' => $schedule->id,
                    'date' => \Carbon\Carbon::today()->toDateString()
                ]) }}">
                    座席を予約する
                </a>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
@endif

@endsection
