<!DOCTYPE html>
<html>
<head>
    <title>Notificación de Cambio de Contraseña</title>
</head>
<body>
    <h1>Notificación de Cambio de Contraseña</h1>
    <p>El usuario {{ $user->email }} ha cambiado su contraseña.</p>
    <p>Fecha y hora: {{ $time }}</p>
    <p>Dirección IP: {{ $ip }}</p>
</body>
</html>
