<?php
include 'conn.php';

$notiCount = 0;
$sql10 = "SELECT * FROM eventos2";
$result10 = $conn->query($sql10);

$employee_id = 345;
$sql11 = "SELECT
DATE_FORMAT(fecha_inicio_semana, '%Y-%m-%d') AS semana_inicio,
DATE_FORMAT(fecha_fin_semana, '%Y-%m-%d') AS semana_fin,
AVG(nota) AS promedio_semana
FROM grades
WHERE employee_id = $employee_id
GROUP BY semana_inicio, semana_fin
ORDER BY semana_inicio";

$result11 = $conn->query($sql11);

$registros10 = [];
$registros11 = [];

if ($result10->num_rows > 0) {
    while ($row10 = $result10->fetch_assoc()) {
        $registros10[] = $row10;
    }
}

if ($result11->num_rows > 0) {
    while ($row11 = $result11->fetch_assoc()) {
        $registros11[] = $row11;
    }
}

$registros10 = array_reverse($registros10);
$registros11 = array_reverse($registros11);
foreach ($registros11 as $row11) {
    echo '<h5>Notas</h5>';
    $notiCount++;
    break;
}
echo '<h5>Eventos</h5>';
foreach ($registros10 as $row10) {
    if ($row10["tipo_publicacion"] == 'GENERAL') {
        echo '<div class="notificaciones-event">
        <div class="ver-event-1">
        <span class="notificaciones-tt">Tienes un evento ' . $row10["tipo_publicacion"] . '</span>
        </br>
        <span>' . $row10["titulo"] . '</span>
        </div>
        <form method="post" action="calendario-general-practicante.php" class="">
            <input type="hidden" name="employee_id" value="' . $row['employee_id'] . '">
            <button type="submit" class="boton-detalles" id="button1">
                  Ver
            </button>
         </form>
        </div>';
        $notiCount++;
    } elseif ($row10["tipo_publicacion"] == 'PERSONA' && $row10["id_empleado"] == $row["id"]) {
        echo '<div class="notificaciones-event">
        <div class="ver-event-1">
        <span class="notificaciones-tt">Tienes un evento ' . $row10["tipo_publicacion"] . 'L</span>
        </br>
        <span>' . $row10["titulo"] . '</span>
        </div>
        <form method="post" action="calendario-eventos-practicante.php" class="">
            <input type="hidden" name="employee_id" value="' . $row['employee_id'] . '">
            <button type="submit" class="boton-detalles" id="button1">
                  Ver
            </button>
         </form>
        </div>';
        $notiCount++;
    } elseif ($row10["tipo_publicacion"] == 'UNIDAD' && $row10["id_negocio"] == $row["negocio_id"]) {
        echo '<div class="notificaciones-event">
        <div class="ver-event-1">
        <span class="notificaciones-tt">Tienes un evento en tu ' . $row10["tipo_publicacion"] . '</span>
        </br>
        <span>' . $row10["titulo"] . '</span>
        </div>
        <form method="post" action="calendario-eventos-practicante.php" class="">
            <input type="hidden" name="employee_id" value="' . $row['employee_id'] . '">
            <button type="submit" class="boton-detalles" id="button1">
                  Ver
            </button>
         </form>
        </div>';
        $notiCount++;
    }
}

$conn->close();
?>