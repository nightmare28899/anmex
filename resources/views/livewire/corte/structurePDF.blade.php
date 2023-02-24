<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 5px;
        }

        th {
            text-align: center;
        }

        .title {
            color: #630404;
            font-size: 15px;
        }
    </style>

</head>

<body>
    <p>Fecha: {{ $dateNow }}</p>
    <table>
        <thead>
            <tr>
                <th>
                    Código postal</th>
                <th>
                    Guias</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($guias as $key => $guia)
                <tr>
                    <td>
                        {{ $guia->cp }}
                    </td>
                    <td>
                        {{ $cantidad[$key] }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
