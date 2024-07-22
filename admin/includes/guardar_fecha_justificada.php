<?php
// Incluir el archivo de sesión
include 'session.php';

// Verificar si se ha enviado el formulario con el botón "add"
if (isset($_POST['add'])) {
    // Obtener la fecha justificada y el ID del empleado del formulario
    $fecha_justificada = $_POST['fecha_justificada'];
    $employee_id = $_POST['employee_id'];

    // Preparar la consulta SQL para insertar la fecha justificada en la base de datos
    $sql = "INSERT INTO faltas_justificadas (employee_id, fecha_justificada) 
            VALUES ('$employee_id', '$fecha_justificada')";

    // Ejecutar la consulta SQL y verificar si se realizó correctamente
    if ($conn->query($sql)) {
        // Si la consulta es exitosa, establecer un mensaje de éxito en la sesión
        $_SESSION['success'] = 'Fecha justificada añadida con éxito';
    } else {
        // Si ocurre un error, establecer un mensaje de error en la sesión con el mensaje de error de la base de datos
        $_SESSION['error'] = 'Error al añadir la fecha justificada: ' . $conn->error;
    }
}

// Redirigir a la página de resumen
header('location: ../resumen.php');
?>