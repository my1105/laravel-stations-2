@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div>
        <strong>エラーがあります：</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div>{{ session('success') }}</div>
@endif

<form action="{{ route('admin.movies.store') }}" method="POST">
    @csrf
    <label>映画タイトル</label><br>
    <input type="text" name="title" value="{{ old('title') }}"><br><br>

    <label>画像URL</label><br>
    <input type="text" name="image_url" value="{{ old('image_url') }}"><br><br>

    <label>公開年</label><br>
    <input type="number" name="published_year" value="{{ old('published_year') }}"><br><br>

    <label>概要</label><br>
    <textarea name="description" rows="5">{{ old('description') }}</textarea><br><br>

    <label>公開中</label>
    <input type="hidden" name="is_showing" value="0">
    <input type="checkbox" name="is_showing" value="1" {{ old('is_showing') ? 'checked' : '' }}>


    <button type="submit">登録</button>
</form>
@endsection
