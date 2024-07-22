<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reporte</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            border: none;
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
            border: none;
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
    @if ($loop->first)
        <div class="header">
            <img src="{{ asset('images/GS1-logo.png') }}" alt="">
            <p>{{ $fechaInicio }} a {{ $fechaFinal }}</p>
        </div>
    @endif
    <table>
        <thead>
            @if ($loop->first)
                <tr>
                    <th colspan="6">Total de facturas anuladas: ${{ $TotalValorAnulados }}</th>
                </tr>
                <tr>
                    <th>Nro. factura</th>
                    <th>Prefijo</th>
                    <th>Razón soc.</th>
                    <th>Fec. emisión</th>
                    <th>Valor anulado</th>
                    <th>Total</th>
                </tr>
            @endif
        </thead>
        <tbody>
            @foreach ($Facturas as $factura)
                <tr>
                    <td>{{ $factura->establecimiento->nombre . $factura->puntoEmision->nombre . $factura->Secuencial ?? 'N/A' }}
                    </td>
                    <td>{{ $factura->Prefijo }}</td>
                    <td>{{ Str::substr($factura->RazonSocial, 0, 6) . '...' }}</td>
                    <td>{{ Str::substr($factura->FechaEmision, 0, 10) }}</td>
                    <td style="color:#F44336">${{ $factura->ValorAnulado }}</td>
                    <td>${{ $factura->Total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
