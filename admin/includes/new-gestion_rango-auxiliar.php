<?php

include 'includes/conn.php';


function obtenerPermisosPorIdRangoNew($conn, $idRango) {
    $query = "SELECT permisos.*, rango.nombre_rango FROM permisos JOIN rango ON permisos.id_rango = rango.id WHERE permisos.id_rango = $idRango";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}


function actualizarPermiso($conn, $id, $idRango, $modulo, $crear, $leer, $actualizar, $eliminar) {
    $query = "UPDATE permisos SET id_rango = '$idRango', modulo = '$modulo', crear = '$crear', leer = '$leer', actualizar = '$actualizar', eliminar = '$eliminar' WHERE id = $id";
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

    if (actualizarPermiso($conn, $id, $idRango, $modulo, $crear, $leer, $actualizar, $eliminar)) {
        echo "Permiso actualizado exitosamente.";
    } else {
        echo "Error al actualizar el permiso.";
    }
}


$permisos = obtenerPermisosPorIdRangoNew($conn, 2);


$rangos = obtenerRangosNew($conn);

?>