<?php

function obtenerPermisosPorIdRango($conn, $idRango)
{
    $sql = "SELECT permisos.*, rango.nombre_rango FROM permisos JOIN rango ON permisos.id_rango = rango.id WHERE permisos.id_rango = $idRango";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}

function obtenerRangos($conn)
{
    $sql = "SELECT * FROM rango";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}

$permisos = obtenerPermisosPorIdRango($conn, $_SESSION['rid']);
$rangos = obtenerRangos($conn);

$permisoAsistencia = null;
foreach ($permisos as $permiso) {
    if ($permiso['modulo'] === 'Asistencia') {
        $permisoAsistencia = $permiso;
        break;
    }
}

$permisoPracticantes = null;
foreach ($permisos as $permiso) {
    if ($permiso['modulo'] === 'Practicantes') {
        $permisoPracticantes = $permiso;
        break;
    }
}

$permisoCargos = null;
foreach ($permisos as $permiso) {
    if ($permiso['modulo'] === 'Cargos') {
        $permisoCargos = $permiso;
        break;
    }
}

$permisoUnidad = null;
foreach ($permisos as $permiso) {
    if ($permiso['modulo'] === 'Unidad de Negocio') {
        $permisoUnidad = $permiso;
        break;
    }
}

$permisoVista = null;
foreach ($permisos as $permiso) {
    if ($permiso['modulo'] === 'Vista de asistencia') {
        $permisoVista = $permiso;
        break;
    }
}
$permisoUsuarios = null;
foreach ($permisos as $permiso) {
    if ($permiso['modulo'] === 'Lista de Usuarios') {
        $permisoUsuarios = $permiso;
        break;
    }
}

$permisoCriterios = null;
foreach ($permisos as $permiso) {
    if ($permiso['modulo'] === 'metricas') {
        $permisoCriterios = $permiso;
        break;
    }
}

function obtenerPermisosPorIdRango3($conn, $idRango)
{
    $sql = "SELECT permisos.*, rango.nombre_rango FROM permisos_modulo permisos JOIN rango ON permisos.id_rango = rango.id";
    if ($idRango !== null) {
        $sql .= " WHERE permisos.id_rango = $idRango";
    }
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}

function obtenerRangos3($conn)
{
    $sql = "SELECT * FROM rango";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}

$permisos = obtenerPermisosPorIdRango3($conn, $_SESSION['rid']);
$rangos = obtenerRangos3($conn);

// Aquí se adaptan los nombres de los módulos
$permisoResumen = null;
foreach ($permisos as $permiso) {
    if ($permiso['modulo'] === 'consultas') {
        $permisoResumen = $permiso;
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

$permisoPublicaciones = null;
foreach ($permisos as $permiso) {
    if ($permiso['modulo'] === 'foro') {
        $permisoPublicaciones = $permiso;
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