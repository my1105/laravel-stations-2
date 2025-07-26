<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>座席表</title>
    <style>
        table { border-collapse: collapse; margin-top: 20px; }
        td { border: 1px solid #000; padding: 10px; text-align: center; }
    </style>
</head>
<body>
    <h1>座席表</h1>

    <table>
        <tr>
            <td></td><td></td><td colspan="3">スクリーン</td><td></td><td></td>
        </tr>
       @foreach ($sheets as $sheet)
    <tr>
        <td>{{ $sheet->row }}-{{ $sheet->column }}</td>
    </tr>
@endforeach

    </table>
</body>
</html>
