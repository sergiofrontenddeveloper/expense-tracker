<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen Mensual</title>
</head>
<body style="font-family: system-ui, -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f8f9fa; color: #212529; margin: 0; padding: 40px 20px;">

    {{-- Contenedor principal estilo tarjeta --}}
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #dee2e6; border-radius: 0.375rem; overflow: hidden;">

        {{-- Header imitando tu nav (navbar-light bg-light border-bottom) --}}
        <div style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6; padding: 15px 20px; text-align: center;">
            <span style="font-size: 1.25rem; font-weight: bold; margin: 0;">Expense Tracker</span>
        </div>

        {{-- Cuerpo del correo (imita el main p-4) --}}
        <div style="padding: 30px 20px;">
            <h2 style="margin-top: 0; font-size: 1.5rem;">Resumen de {{ $mes }}</h2>

            <p style="font-size: 1rem; line-height: 1.5; color: #495057;">
                Hola,<br><br>
                Aquí tienes el resumen automatizado de tus movimientos correspondientes al mes pasado.
            </p>

            {{-- Caja destacada del total --}}
            <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 0.375rem; padding: 20px; text-align: center; margin: 30px 0;">
                <span style="display: block; font-size: 0.875rem; color: #6c757d; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">Total Gastado</span>
                <span style="font-size: 2.5rem; font-weight: bold; color: #dc3545;">{{ number_format($totalGastado, 2) }} €</span>
            </div>

            <p style="font-size: 0.875rem; line-height: 1.5; color: #6c757d; text-align: center; margin-bottom: 0;">
                Puedes revisar el desglose completo accediendo a tu panel de control.
            </p>
        </div>

        {{-- Footer --}}
        <div style="background-color: #f8f9fa; border-top: 1px solid #dee2e6; padding: 15px 20px; text-align: center;">
            <a href="{{ route('dashboard') }}" style="display: inline-block; background-color: #212529; color: #ffffff; text-decoration: none; padding: 10px 20px; border-radius: 0.375rem; font-weight: bold; font-size: 0.875rem;">Ir al Dashboard</a>
        </div>

    </div>

</body>
</html>
