<?php

// Validar y sanitizar el nombre del documento recibido del parámetro URL
$document = filter_var($_GET['document'], FILTER_SANITIZE_STRING);

// Comprobar si el documento existe en el directorio includes/
$filePath = 'includes/' . $document;
if (!file_exists($filePath)) {
    die('Documento no encontrado');
}

// Establecer encabezados apropiados para la descarga de PDF
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $document . '"');

// Leer el contenido del PDF del archivo
readfile($filePath);

exit;

