<form method="POST" action="{{ route('reservation.store') }}">
    @csrf
    <input type="hidden" name="schedule_id" value="{{ $schedule_id }}">
    <input type="hidden" name="sheet_id" value="{{ $sheet->id }}">
    <input type="hidden" name="date" value="{{ $date }}">
    <input type="hidden" name="movie_id" value="{{ $movie_id }}">

    <p>映画ID: {{ $movie_id }}</p>
    <p>スケジュールID: {{ $schedule_id }}</p>
    <p>座席: {{ $sheet->row }}-{{ $sheet->column }}</p>
    <p>日付: {{ $date }}</p>

    <label>予約者氏名</label>
    <input type="text" name="name" value="{{ old('name') }}" required>
    <br>

    <label>予約者メールアドレス</label>
    <input type="email" name="email" value="{{ old('email') }}" required>
    <br>

    <button type="submit">予約する</button>
</form>
