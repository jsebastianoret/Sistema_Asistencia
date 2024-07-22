<?php
include 'includes/session.php';

if (isset($_POST['id']) && isset($_POST['criterio']) && isset($_POST['subcriterio']) && isset($_POST['fecha'])) {
    $id = $_POST['id'];
    $criterio = $_POST['criterio'];
    $subcriterio = $_POST['subcriterio'];
    $fecha = $_POST['fecha'];

    $sql = "SELECT id, nota
            FROM grades
            WHERE employee_id = '$id'
            AND id_criterio = '$criterio'
            AND id_subcriterio = '$subcriterio'
            AND fecha_fin_semana = STR_TO_DATE('$fecha', '%d/%m/%Y')";

    $query = $conn->query($sql);

    if ($query && $query->num_rows > 0) {
        $row = $query->fetch_assoc();
        echo json_encode($row);
    } else {
        $response = array('nota' => null);
        echo json_encode($response);
    }
} else {
    $response = array('error' => 'No se proporcionaron todos los parámetros necesarios.');
    echo json_encode($response);
}
?>