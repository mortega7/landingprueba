<!DOCTYPE html>
<html>
<head>
    <title>{{ $mailData['titulo'] }}</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif;">
    <h3>{{ $mailData['titulo'] }}</h3>
    <table border="1" cellspacing="1" cellpadding="6">
        <tbody>
            <tr>
                <td bgcolor="#DEDEDE"><b>Fecha y hora:</b></td>
                <td>{{ $mailData['cotizacion']->created_at }}</td>
            </tr>
            <tr>
                <td bgcolor="#DEDEDE"><b>Modelo:</b></td>
                <td>{{ $mailData['cotizacion']->modelo }}</td>
            </tr>
            <tr>
                <td bgcolor="#DEDEDE"><b>Cliente:</b></td>
                <td>{{ $mailData['cotizacion']->nombre_cliente }}</td>
            </tr>
            <tr>
                <td bgcolor="#DEDEDE"><b>Correo:</b></td>
                <td>{{ $mailData['cotizacion']->email }}</td>
            </tr>
            <tr>
                <td bgcolor="#DEDEDE"><b>Celular:</b></td>
                <td>{{ $mailData['cotizacion']->celular }}</td>
            </tr>
            <tr>
                <td bgcolor="#DEDEDE"><b>Departamento:</b></td>
                <td>{{ $mailData['cotizacion']->ciudad->departamento->nombre }}</td>
            </tr>
            <tr>
                <td bgcolor="#DEDEDE"><b>Ciudad:</b></td>
                <td>{{ $mailData['cotizacion']->ciudad->nombre }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>