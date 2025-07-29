@extends('layouts.app')

@section('content')
  <h1>予約編集</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.reservations.update', $reservation->id) }}">
    @csrf
    @method('PUT')

    <div>
      <label>上映スケジュール</label>
      <select name="schedule_id" required>
        <option value="">選択してください</option>
        @foreach ($schedules as $schedule)
          <option value="{{ $schedule->id }}" {{ old('schedule_id', $reservation->schedule_id) == $schedule->id ? 'selected' : '' }}>
            {{ $schedule->movie->title }} - {{ $schedule->start_time }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label>座席</label>
      <select name="sheet_id" required>
        <option value="">選択してください</option>
        @foreach ($seats as $seat)
          <option value="{{ $seat->id }}" {{ old('sheet_id', $reservation->sheet_id) == $seat->id ? 'selected' : '' }}>
            {{ $seat->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label>氏名</label>
      <input type="text" name="name" value="{{ old('name', $reservation->name) }}" required>
    </div>

    <div>
      <label>メールアドレス</label>
      <input type="email" name="email" value="{{ old('email', $reservation->email) }}" required>
    </div>

    <button type="submit">更新する</button>
  </form>

  <form method="POST" action="{{ route('admin.reservations.destroy', $reservation->id) }}" onsubmit="return confirm('本当に削除しますか？');">
    @csrf
    @method('DELETE')
    <button type="submit" style="margin-top: 20px; color: red;">削除する</button>
  </form>
@endsection
