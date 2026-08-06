<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedimento {{ $pedimento->numero_pedimento }} - Vista Previa Imprimible (PDF)</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #111;
            background: #f3f4f6;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 24px;
            border: 1px solid #ccc;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 3px 0 0;
            font-size: 10px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px 7px;
            text-align: left;
        }
        th {
            background-color: #e5e7eb;
            font-size: 9px;
            text-transform: uppercase;
        }
        .section-title {
            background-color: #1e293b;
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
            padding: 4px 7px;
            font-size: 10px;
            margin-top: 10px;
            margin-bottom: 4px;
        }
        .btn-print {
            display: block;
            width: 180px;
            margin: 0 auto 15px auto;
            padding: 10px;
            background-color: #2563eb;
            color: #fff;
            text-align: center;
            font-weight: bold;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
        }
        @media print {
            .btn-print { display: none; }
            body { background: #fff; padding: 0; }
            .container { border: none; box-shadow: none; width: 100%; max-width: 100%; }
        }
    </style>
</head>
<body>

    <!-- chingadera para generar la vista imprimible en PDF del pedimento M3 -->
    <a onclick="window.print()" class="btn-print">🖨️ Imprimir Pedimento (PDF)</a>

    <div class="container">
        <div class="header">
            <h1>PEDIMENTO ADUANAL - SIMULADOR S.E.P.A.</h1>
            <p>Formato de Simulación Operativa de Despacho Aduanero (Anexo 22 RGCE)</p>
        </div>

        <table>
            <tr>
                <th>NUM. PEDIMENTO</th>
                <th>TIPO OPER</th>
                <th>CVE. PEDIMENTO</th>
                <th>ADUANA</th>
                <th>REGIMEN</th>
            </tr>
            <tr>
                <td><strong>{{ $pedimento->numero_pedimento }}</strong></td>
                <td>{{ $pedimento->tipo_operacion ?? '1' }}</td>
                <td>{{ $pedimento->clave_pedimento ?? 'A1' }}</td>
                <td>{{ $pedimento->clave_aduana ?? '240' }}</td>
                <td>{{ $pedimento->clave_regimen ?? 'IMD' }}</td>
            </tr>
        </table>

        <div class="section-title">DATOS DEL IMPORTADOR / EXPORTADOR</div>
        <table>
            <tr>
                <td colspan="2"><strong>RFC:</strong> {{ $pedimento->rfc_importador ?? 'N/A' }}</td>
                <td colspan="2"><strong>CURP:</strong> {{ $pedimento->curp ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td colspan="4"><strong>RAZÓN SOCIAL:</strong> {{ $pedimento->razon_social ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td colspan="4"><strong>DOMICILIO:</strong> {{ $pedimento->domicilio ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td colspan="4"><strong>PAIS:</strong> {{ $pedimento->pais ?? 'N/A' }}</td>
            </tr>
        </table>

        <div class="section-title">VALORES Y TASAS</div>
        <table>
            <tr>
                <th>VALOR COMERCIAL</th>
                <th>MONEDA</th>
                <th>TIPO CAMBIO</th>
                <th>VALOR ADUANA (MXN)</th>
            </tr>
            <tr>
                <td>${{ number_format($pedimento->valor_comercial ?? 0, 2) }}</td>
                <td>{{ $pedimento->moneda ?? 'USD' }}</td>
                <td>${{ number_format($pedimento->tipo_cambio ?? 1, 4) }}</td>
                <td><strong>${{ number_format($pedimento->valor_aduana ?? 0, 2) }} MXN</strong></td>
            </tr>
        </table>

        <div class="section-title">DATOS DEL PROVEEDOR Y FACTURA</div>
        <table>
            <tr>
                <td><strong>PROVEEDOR:</strong> {{ $pedimento->proveedor ?? 'N/A' }}</td>
                <td><strong>FACTURA:</strong> {{ $pedimento->numero_factura ?? 'N/A' }}</td>
            </tr>
        </table>

        <div class="section-title">MERCANCÍAS DECLARADAS</div>
        <table>
            <tr>
                <th>DESCRIPCIÓN</th>
                <th>CANTIDAD</th>
                <th>PRECIO UNITARIO</th>
                <th>IMPORTE TOTAL</th>
            </tr>
            <tr>
                <td>{{ $pedimento->descripcion_mercancia ?? 'Mercancía general de importación' }}</td>
                <td>{{ $pedimento->cantidad ?? 1 }}</td>
                <td>${{ number_format($pedimento->precio_unitario ?? 0, 2) }}</td>
                <td>${{ number_format($pedimento->importe_total ?? 0, 2) }}</td>
            </tr>
        </table>

        <div class="section-title">LIQUIDACIÓN DE CONTRIBUCIONES</div>
        <table>
            <tr>
                <th>CONCEPTO</th>
                <th>FORMA PAGO</th>
                <th>IMPORTE</th>
            </tr>
            <tr>
                <td>LIQUIDACIÓN ADUANERA (DTA / IGI / IVA)</td>
                <td>EFECTIVO (PE)</td>
                <td><strong>${{ number_format($pedimento->total_general ?? 0, 2) }} MXN</strong></td>
            </tr>
        </table>

        <div style="margin-top: 20px; font-size: 9px; text-align: center; color: #777;">
            <p>Este pedimento es un documento educativo simulado generado por la plataforma S.E.P.A. Sin valor fiscal ni aduanero oficial.</p>
        </div>
    </div>

</body>
</html>
