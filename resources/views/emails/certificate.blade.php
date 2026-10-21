<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f1f5f9; margin: 0; padding: 20px; color: #1e293b; }
        .card { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; }
        .header { background-color: #0d47a1; color: #ffffff; padding: 24px; text-align: center; border-bottom: 4px solid #00bcd4; }
        .content { padding: 30px; line-height: 1.6; }
        .footer { background-color: #f8fafc; padding: 15px; text-align: center; font-size: 12px; color: #64748b; border-top: 1px solid #e2e8f0; }
        .highlight { color: #0d47a1; font-weight: bold; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h2 style="margin: 0; font-size: 20px;">Centro Nacional de Formación de Maestras y Maestros de la Educación Técnica y Formación Profesional Sede Centro Técnologico Olof Palme, Estelí</h2>
            <p style="margin: 5px 0 0; font-size: 13px; color: #bae6fd;">Emisión Oficial de Certificados</p>
        </div>
        <div class="content">
            <p>Estimado(a) <strong>{{ $participant->full_name }}</strong>,</p>
            <p>Reciba un cordial saludo. Por medio del presente correo hacemos entrega formal de su certificado de <span class="highlight">{{ strtoupper($event->document_type) }}</span> correspondiente a:</p>
            <p style="font-size: 16px; font-weight: bold; color: #e91e63; text-align: center; margin: 20px 0;">
                "{{ $event->title }}"
            </p>
            <p>El certificado se encuentra adjunto a este mensaje en formato PDF.</p>
            <p style="margin-top: 25px;">Atentamente,<br><strong>Centro Nacional de Formación de Maestras y Maestros de la Educación Técnica y Formación Profesional Sede Centro Técnologico Olof Palme, Estelí</strong></p>
        </div>
        <div class="footer">
            Este es un mensaje generado automáticamente. Por favor, no responda a este correo.
        </div>
    </div>
</body>
</html>