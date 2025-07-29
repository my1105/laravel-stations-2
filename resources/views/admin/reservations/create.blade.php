@extends('layouts.app')

@section('content')
  <h1>予約追加</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.reservations.store') }}">
    @csrf

    <div>
      <label>上映スケジュール</label>
      <select name="schedule_id" required>
        <option value="">選択してください</option>
        @foreach ($schedules as $schedule)
          <option value="{{ $schedule->id }}" {{ old('schedule_id') == $schedule->id ? 'selected' : '' }}>
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
          <option value="{{ $seat->id }}" {{ old('sheet_id') == $seat->id ? 'selected' : '' }}>
            {{ $seat->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label>氏名</label>
      <input type="text" name="name" value="{{ old('name') }}" required>
    </div>

    <div>
      <label>メールアドレス</label>
      <input type="email" name="email" value="{{ old('email') }}" required>
    </div>

    <button type="submit">登録する</button>
  </form>
@endsection
