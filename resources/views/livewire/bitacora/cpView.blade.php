<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>Document</title> --}}

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
    <table class="table align-items-center mb-0">
        <thead>
            <tr class="text-center">
                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                    Código postal</th>
                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                    Chofer</th>
                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                    Firma de Recibido</th>
                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                    Guias</th>
                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                    Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($guias as $key => $guia)
                @if ($guia->guides != 0)
                    <tr class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 text-center">
                        <td>
                            {{ $guia->cp }}
                        </td>
                        <td>
                            {{ $guia->chofer }}
                        </td>
                        <td>
                        </td>
                        <td>
                            {{ $guia->guides }}
                        </td>
                        <td>
                            {{ $dateP }}
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</body>

</html>
