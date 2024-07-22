<?php
include 'includes/conn.php';

function obtenerPermisosPorIdRango2($conn, $idRango)
{
    $query = "SELECT permisos.*, rango.nombre_rango FROM permisos_practicante permisos JOIN rango ON permisos.id_rango = rango.id WHERE permisos.id_rango = $idRango";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}

function obtenerRangos2($conn)
{
    $query = "SELECT * FROM rango";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}

$permisos = obtenerPermisosPorIdRango2($conn, $_SESSION['admin']);
$rangos = obtenerRangos2($conn);

$permisoPracticantes = null;
foreach ($permisos as $permiso) {
    if ($permiso['modulo'] === 'Lista de Practicantes') {
        $permisoPracticantes = $permiso;
        break;
    }
}
?>