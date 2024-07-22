<?php

include 'includes/conn.php';

function obtenerPermisosConNombreRango($conn) {
    $query = "SELECT pm.*, r.nombre_rango FROM permisos_modulo pm JOIN rango r ON pm.id_rango = r.id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}

function actualizarPermiso($conn, $id, $idRango, $modulo, $leer, $accion) {
    $query = "UPDATE permisos_modulo SET id_rango = '$idRango', modulo = '$modulo', leer = '$leer', accion = '$accion' WHERE id = $id";
    $result = $conn->query($query);

    if ($result) {
        return true;
    }

    return false;
}

function obtenerRangos($conn) {
    $query = "SELECT * FROM rango";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Update"])) {
    $id = $_POST["id"];
    $idRango = $_POST["idRango"];
    $modulo = $_POST["modulo"];
    $leer = $_POST["leer"];
    $accion = $_POST["accion"];

    if (actualizarPermiso($conn, $id, $idRango, $modulo, $leer, $accion)) {
        echo "Permiso actualizado exitosamente.";
    } else {
        echo "Error al actualizar el permiso.";
    }
}

$permisos = obtenerPermisosConNombreRango($conn); // Obtener permisos con nombre de rango
$rangos = obtenerRangos($conn);

?>