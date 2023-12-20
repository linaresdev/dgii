<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Formulario</h1>

    <form action="{{__url('{form}')}}" method="POST" enctype="multipart/form-data">
        <table>
            <tr>
                <td><input type="file" name="xml"></td>                
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