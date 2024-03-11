<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$subject}}</title>
</head>
<body>
    <table>
        @foreach($messages as $label => $value)
        <tr>
            <td style="padding: 0 15px 0 0;">{{$label}}</td>
            <td>{{$value}}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>