<?php

include 'includes/conn.php';
$codigo = $_POST['employee_id'];
$query = "SELECT e.*, p.description AS position, n.nombre_negocio AS negocio, s.time_in AS ingreso, s.time_out AS salida FROM employees e
      LEFT JOIN position p ON e.negocio_id = p.id
      LEFT JOIN negocio n ON e.negocio_id = n.id
      LEFT JOIN schedules s ON e.negocio_id = s.id
      WHERE e.employee_id='$codigo'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "<div class='alert alert-danger'>No se encontró ningún practicante con el código ingresado.</div>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["enviar"])) {
    $employee_id = $_POST["employee_id"];
    $fecha = $_POST["fecha"];
    $nombre = $_POST["nombre"];
    $asunto = $_POST["asunto"];
    $tipo = $_POST["tipo"];
    $unidad = $_POST["unidad"];
    $sugerencia = $_POST["sugerencia"];

    $employee_query = "SELECT id FROM employees WHERE employee_id = '$employee_id'";
    $employee_result = $conn->query($employee_query);

    if ($employee_result->num_rows > 0) {
        $employee_row = $employee_result->fetch_assoc();
        $employee_id = $employee_row["id"];

        $sql = "INSERT INTO sugerencias (employee_id, fecha, nombre, asunto, tipo, unidad, sugerencia)
                VALUES ('$employee_id', '$fecha', '$nombre', '$asunto', '$tipo', '$unidad', '$sugerencia')";

        if ($conn->query($sql) !== TRUE) {
            echo "Error al insertar los datos: " . $conn->error;
        }
    } else {
        echo "No se encontró el empleado con el employee_id proporcionado.";
    }
    echo '
    <form method="post" action="sugerencia-recibida.php" class="form__ver-perfil">
        <input type="hidden" name="employee_id" value="' . $row['employee_id'] . '">
        <button type="submit" class="enlaces__btn" id="button1">
        </button>
    </form>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var boton = document.getElementById("button1");
            boton.click();
        });
    </script>
    ';
    exit;
}
?>