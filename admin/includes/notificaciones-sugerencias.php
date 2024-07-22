<?php
echo '<h5 class="mt-2">Sugerencias</h5>';
include 'conn.php';
$employee_id = $row['employee_id'];

$employee_query = "SELECT id FROM employees WHERE employee_id = '$employee_id'";
$employee_result = $conn->query($employee_query);

if ($employee_result->num_rows > 0) {
    $employee_row = $employee_result->fetch_assoc();
    $empleado_id = $employee_row["id"];

    $consulta = "SELECT * FROM sugerencias WHERE employee_id = '$empleado_id'";
    $resultado = $conn->query($consulta);

    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $sugerencia_id = $fila["id"];
            $consulta_respuesta = "SELECT respuesta FROM respuesta_sugerencias WHERE sugerencia_id = '$sugerencia_id'";
            $resultado_respuesta = $conn->query($consulta_respuesta);

            if ($resultado_respuesta->num_rows > 0) {
                $respuesta = $resultado_respuesta->fetch_assoc()["respuesta"];
            } else {
                $respuesta = '';
            }

            if (!empty($respuesta)) {
                echo '<div class="notificaciones-event">
                        <div class="ver-event-1">
                            <span class="notificaciones-tt">Respondieron a tu ' . $fila["tipo"] . '</span>
                            <br>
                            <span>' . $fila["asunto"] . '</span>
                        </div>
                        <form method="post" action="buzon.php" class="">
                            <input type="hidden" name="employee_id" value="' . $row['employee_id'] . '">
                            <button type="submit" class="boton-detalles" id="button1">
                                Ver
                            </button>
                        </form>
                     </div>';
            }
            $notiCount++;
        }
    } else {
        echo "<span>No hay sugerencias registradas.</span>";
    }
} else {
    echo "No se encontró el empleado con el employee_id proporcionado.";
}

$conn->close();
?>