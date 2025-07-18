@extends('layouts.admin')

@section('content')
<h1>スケジュール編集 - {{ $schedule->movie->title }}</h1>

<form method="POST" action="{{ route('admin.schedules.update', $schedule->id) }}">
    @csrf
    @method('PATCH')

    <label>開始日付
        <input type="date" name="start_time_date" value="{{ $startDate }}" required>
    </label>
    <label>開始時間
        <input type="time" name="start_time_time" value="{{ $startTime }}" required>
    </label>
    <label>終了日付
        <input type="date" name="end_time_date" value="{{ $endDate }}" required>
    </label>
    <label>終了時間
        <input type="time" name="end_time_time" value="{{ $endTime }}" required>
    </label>

    <button type="submit">更新</button>
</form>

<form method="POST" action="{{ route('admin.schedules.destroy', $schedule->id) }}" onsubmit="return confirm('本当に削除しますか？');">
    @csrf
    @method('DELETE')
    <button type="submit">削除</button>
</form>

<a href="{{ route('admin.schedules.index') }}">戻る</a>
@endsection
