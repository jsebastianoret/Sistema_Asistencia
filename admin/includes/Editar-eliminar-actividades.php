<?php
include 'conn.php';
$codigo = $_POST['employee_id'];
$query = "SELECT e.*, p.description AS position, n.nombre_negocio AS negocio, s.time_in AS ingreso, s.time_out AS salida FROM employees e
        LEFT JOIN position p ON e.negocio_id = p.id
        LEFT JOIN negocio n ON e.negocio_id = n.id
        LEFT JOIN schedules s ON e.negocio_id = s.id
        WHERE e.employee_id='$codigo'";
$result = mysqli_query($conn, $query);

if (isset($_POST['guardar'])) {
    // Obtener los valores del formulario
    $id = $_POST['idModal'];
    $titulo = $_POST['TituloModal'];
    $fecha_desde = $_POST['desdeModal'];
    $fecha_hasta = $_POST['hastaModal'];
    $detalles = $_POST['detallesModal'];
    $color = $_POST['colorModal'];

    // Actualizar el registro en la base de datos
    $sql = "UPDATE eventos SET titulo='$titulo', fecha_desde='$fecha_desde', fecha_hasta='$fecha_hasta', detalles='$detalles', color='$color' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo '
        <form method="post" action="../calendario-practicante.php" class="form__calendar calendar-button-color">
            <input type="hidden" name="employee_id" value="'.$codigo.'">
            <input type="submit" id="autoSubmitButton" value="" class="btn__calendar letraNavBar text-light">
        </form>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var submitButton = document.getElementById("autoSubmitButton");
                submitButton.click();
            });
        </script>
        ';
    } else {
        echo "Error al actualizar el registro: " . $conn->error;
    }
}

if (isset($_POST['eliminar'])) {
    // Obtener el valor del ID a eliminar
    $id = $_POST['idModal'];

    // Eliminar el registro de la base de datos
    $sql = "DELETE FROM eventos WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo '
        <form method="post" action="../calendario-practicante.php" class="form__calendar calendar-button-color">
            <input type="hidden" name="employee_id" value="'.$codigo.'">
            <input type="submit" id="autoSubmitButton" value="" class="btn__calendar letraNavBar text-light">
        </form>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var submitButton = document.getElementById("autoSubmitButton");
                submitButton.click();
            });
        </script>
        ';
    } else {
        echo "Error al eliminar el registro: " . $conn->error;
    }
}

$conn->close();
?>