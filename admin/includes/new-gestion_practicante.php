<?php

include 'includes/conn.php';

function obtenerTodosPermisos($conn) {
    $query = "SELECT permisos.*, rango.nombre_rango FROM permisos_practicante permisos JOIN rango ON permisos.id_rango = rango.id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}

function actualizarPermiso($conn, $id, $idRango, $modulo, $crear, $leer, $actualizar, $eliminar, $agregar_notas, $ver_notas) {
    $query = "UPDATE permisos_practicante SET id_rango = '$idRango', modulo = '$modulo', crear = '$crear', leer = '$leer', actualizar = '$actualizar', eliminar = '$eliminar', agregar_notas = '$agregar_notas', ver_notas = '$ver_notas' WHERE id = $id";
    $result = $conn->query($query);

    if ($result) {
        return true;
    }

    return false;
}

function obtenerRangosNew($conn) {
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
    $crear = $_POST["crear"];
    $leer = $_POST["leer"];
    $actualizar = $_POST["actualizar"];
    $eliminar = $_POST["eliminar"];
    $agregar_notas = $_POST["agregar_notas"];
    $ver_notas = $_POST["ver_notas"];

    if (actualizarPermiso($conn, $id, $idRango, $modulo, $crear, $leer, $actualizar, $eliminar, $agregar_notas, $ver_notas)) {
        echo "Permiso actualizado exitosamente.";
    } else {
        echo "Error al actualizar el permiso.";
    }
}

$permisos = obtenerTodosPermisos($conn);
$rangos = obtenerRangosNew($conn);

?>
