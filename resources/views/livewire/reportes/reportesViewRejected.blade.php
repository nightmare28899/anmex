<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        body {
            font-family: Roboto, sans-serif;
            font-size: 11px;
        }

        table,
        td,
        th {
            border: 1px solid;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }
    </style>

</head>

<body>
    <div>
        <p><strong>Reporte Guías Devueltas</strong></p>
        <p style="margin-top: -3rem; margin-left: 36rem;"><strong>Fecha: {{ $date }}</strong></p>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>
                            Código Postal</th>
                        <th>
                            ID Externo</th>
                        <th>
                            ID Cliente</th>
                        <th>
                            Cliente</th>
                        <th>
                            Domicilio</th>
                        <th>
                            Estatus Entrega</th>
                        <th>
                            Guía Prepago</th>
                        <th>
                            Fecha Entrega</th>
                        <th>
                            Fecha Captura</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bitacoras as $bitacora)
                        <tr>
                            <td>
                                {{ $bitacora->id }}
                            </td>
                            <td>
                                {{ $bitacora->cp }}
                            </td>
                            <td>
                                {{ $bitacora->id_externo }}
                            </td>
                            <td>
                                {{ $bitacora->id_cliente }}
                            </td>
                            <td>
                                {{ $bitacora->nombre }}
                            </td>
                            <td>
                                {{ $bitacora->domicilio }}
                            </td>
                            <td>
                                <strong>{{ $bitacora->estatus_entrega }}</strong>
                            </td>
                            <td>
                                {{ $bitacora->guia_prepago }}
                            </td>
                            <td>
                                {{ $bitacora->fecha_entrega }}
                            </td>
                            <td>
                                {{ $bitacora->created_at }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <p style="margin-top: 1rem;"><strong>Total de registros: {{ $bitacoras->count() }}</strong></p>
            </div>
        </div>
    </div>
</body>

</html>
