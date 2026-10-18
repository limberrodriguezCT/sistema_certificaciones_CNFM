<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2 style="color: #0d47a1;">¡Hola, {{ $participant->full_name }}!</h2>
    <p>Te hacemos entrega de tu documento correspondiente a: <strong>{{ $event->title }}</strong>.</p>
    <p>Agradecemos tu participación y compromiso con la formación técnica.</p>
    <br>
    <p>Saludos cordiales,</p>
    <p><strong>Centro Nacional de Formación de Mestros y Mestras de la Educación Técnica Sede Olof Palme Estelí - INATEC</strong></p>
</body>
</html>