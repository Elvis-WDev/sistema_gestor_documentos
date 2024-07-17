<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reporte</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-size: 15px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 150px;
        }

        .header p {
            text-align: right;
            margin: 0;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="{{ asset('images/GS1-logo.png') }}" alt="">
        <p>{{ $fechaInicio }} a {{ $fechaFinal }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th colspan="2">Reporte de cuentas por cobrar - {{ $tituloMes }}</th>
            </tr>
        </thead>
    </table>

    <h4>General</h4>
    <table>
        <thead>
            <tr>
                <th>Total Facturado</th>
                <th>Total Facturas Anuladas</th>
                <th>Total Abonos</th>
                <th>Total Retención IVA</th>
                <th>Total Retención Fuente</th>
                <th>Total cuentas por cobrar</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>${{ $totalFacturado }}</td>
                <td>${{ $totalFacturasAnuladas }}</td>
                <td>${{ $totalAbonos }}</td>
                <td>${{ $totalRetencionIva }}</td>
                <td>${{ $totalRetencionFuente }}</td>
                <td>${{ $totalCuentasPorCobrar }}</td>
            </tr>
        </tbody>
    </table>

    @foreach ($reportesPorEstablecimiento as $nombreEstablecimiento => $reporte)
        <h4>Establecimiento: {{ $nombreEstablecimiento }}</h4>
        <table>
            <thead>
                <tr>
                    <th>Total Facturado</th>
                    <th>Total Facturas Anuladas</th>
                    <th>Total Abonos</th>
                    <th>Total Retención IVA</th>
                    <th>Total Retención Fuente</th>
                    <th>Total cuentas por cobrar</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>${{ $reporte['totalFacturado'] }}</td>
                    <td>${{ $reporte['totalFacturasAnuladas'] }}</td>
                    <td>${{ $reporte['totalAbonos'] }}</td>
                    <td>${{ $reporte['totalRetencionIva'] }}</td>
                    <td>${{ $reporte['totalRetencionFuente'] }}</td>
                    <td>${{ $reporte['totalCuentasPorCobrar'] }}</td>
                </tr>
            </tbody>
        </table>
    @endforeach
</body>

</html>
