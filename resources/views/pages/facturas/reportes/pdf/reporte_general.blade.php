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
        }
    </style>
</head>

<body>
    <h1>Reporte Mensual - {{ $tituloMes }}</h1>
    <p>Período: {{ $fechaInicio }} a {{ $fechaFinal }}</p>

    <h2>Totales Globales</h2>
    <table>
        <thead>
            <tr>
                <th>Total Facturas (No Anuladas)</th>
                <th>Total Facturas Anuladas</th>
                <th>Total Abonos</th>
                <th>Total Retención IVA</th>
                <th>Total Retención Fuente</th>
                <th>Total Saldo Abonos</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>${{ $totalFacturasNoAnuladas }}</td>
                <td>${{ $totalFacturasAnuladas }}</td>
                <td>${{ $totalAbonos }}</td>
                <td>${{ $totalRetencionIva }}</td>
                <td>${{ $totalRetencionFuente }}</td>
                <td>${{ $totalSaldoAbonos }}</td>
            </tr>
        </tbody>
    </table>

    @foreach ($reportesPorEstablecimiento as $nombreEstablecimiento => $reporte)
        <h2>Totales por Establecimiento: {{ $nombreEstablecimiento }}</h2>
        <table>
            <thead>
                <tr>
                    <th>Total Facturas (No Anuladas)</th>
                    <th>Total Facturas Anuladas</th>
                    <th>Total Abonos</th>
                    <th>Total Retención IVA</th>
                    <th>Total Retención Fuente</th>
                    <th>Total Saldo Abonos</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>${{ $reporte['totalFacturasNoAnuladas'] }}</td>
                    <td>${{ $reporte['totalFacturasAnuladas'] }}</td>
                    <td>${{ $reporte['totalAbonos'] }}</td>
                    <td>${{ $reporte['totalRetencionIva'] }}</td>
                    <td>${{ $reporte['totalRetencionFuente'] }}</td>
                    <td>${{ $reporte['totalSaldoAbonos'] }}</td>
                </tr>
            </tbody>
        </table>
    @endforeach
</body>

</html>
