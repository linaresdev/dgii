<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
</head>
<body>
    <h1>{{$title}}</h1>

    <form action="{{__url($url)}}" method="POST" enctype="multipart/form-data">
        <table>
            <tr>
                <td>
                    <input type="file" name="xml">
                    <input type="hidden" name="urlRecepcion" value="{{$urlRecepcion}}">
                </td>                
            </tr>
            <tr>
                <td>
                    <button type="submit">Send</button>
                </td>
            </tr>
        </form>    
    </table>
</body>
</html>