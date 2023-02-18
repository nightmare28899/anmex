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
    <p class="title"><strong>Fecha del día - {{ $dateNow }}, del Código Postal - {{ $postalCode }}</strong></p>
    <table class="table align-items-center mb-0">
        <thead>
            <tr class="text-center">
                <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7">Id</th>
                <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7">Id externo</th>
                <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7">Id cliente</th>
                <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7">Nombre</th>
                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                    Estatus entrega</th>
                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                    Guía prepago</th>
                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                    Fecha captura</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($guias as $guia)
                <tr class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 text-center">
                    <td>
                        {{ $guia->id }}
                    </td>
                    <td>
                        {{ $guia->id_externo }}
                    </td>
                    <td>
                        {{ $guia->id_cliente }}
                    </td>
                    <td>
                        {{ $guia->nombre }}
                    </td>
                    <td>
                        {{ $guia->estatus_entrega }}
                    </td>
                    <td>
                        {{ $guia->guia_prepago }}
                    </td>
                    <td>
                        {{ $guia->fecha_captura }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
