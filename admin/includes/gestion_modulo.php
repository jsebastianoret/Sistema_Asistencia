<?php
function obtenerPermisosPorIdRango2($conn, $idRango)
{
    $query = "SELECT permisos.*, rango.nombre_rango FROM permisos_modulo permisos JOIN rango ON permisos.id_rango = rango.id";
    if ($idRango !== null) {
        $query .= " WHERE permisos.id_rango = $idRango";
    }
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

// Aquí se adaptan los nombres de los módulos
$permisoConsultas = null;
foreach ($permisos as $permiso) {
    if ($permiso['modulo'] === 'consultas') {
        $permisoConsultas = $permiso;
        break;
    }
}

$permisoExportar = null;
foreach ($permisos as $permiso) {
    if ($permiso['modulo'] === 'exportar') {
        $permisoExportar = $permiso;
        break;
    }
}

$permisoForo = null;
foreach ($permisos as $permiso) {
    if ($permiso['modulo'] === 'foro') {
        $permisoForo = $permiso;
        break;
    }
}

$permisoPapelera = null;
foreach ($permisos as $permiso) {
    if ($permiso['modulo'] === 'papelera') {
        $permisoPapelera = $permiso;
        break;
    }
}
?>