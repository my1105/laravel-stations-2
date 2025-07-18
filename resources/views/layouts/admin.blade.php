<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>管理画面</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>管理画面ヘッダー</h1>
        <hr>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <hr>
        <p>&copy; 2025 映画管理システム</p>
    </footer>
</body>
</html>
