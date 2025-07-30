@extends('layouts.app')

@section('content')
<h1>スケジュール追加 - {{ $movie->title }}</h1>

<form method="POST" action="{{ route('admin.schedules.store', $movie->id) }}">
    @csrf
    <label>スクリーン
        <select name="screen_id" required>
            @foreach ($screens as $screen)
                <option value="{{ $screen->id }}">{{ $screen->name }}</option>
            @endforeach
        </select>
    </label>

    <label>開始日付
        <input type="date" name="start_time_date" required>
    </label>
    <label>開始時間
        <input type="time" name="start_time_time" required>
    </label>
    <label>終了日付
        <input type="date" name="end_time_date" required>
    </label>
    <label>終了時間
        <input type="time" name="end_time_time" required>
    </label>

    <button type="submit">追加</button>
</form>


<a href="{{ route('admin.schedules.index') }}">戻る</a>
@endsection
