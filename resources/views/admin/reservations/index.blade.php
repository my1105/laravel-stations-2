@extends('layouts.app')

@section('content')
  <h1>予約一覧</h1>

  <table>
    <thead>
      <tr>
        <th>日付</th>
        <th>氏名</th>
        <th>メールアドレス</th>
        <th>座席</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($reservations as $reservation)
        <tr>
          <td>{{ $reservation->date }}</td>
          <td>{{ $reservation->name }}</td>
          <td>{{ $reservation->email }}</td>
          <td>{{ strtoupper($reservation->sheet->row . $reservation->sheet->column) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
