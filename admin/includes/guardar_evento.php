<?php
include 'conn.php';
$codigo = $_POST['employee_id'];
$query = "SELECT e.*, p.description AS position, n.nombre_negocio AS negocio, s.time_in AS ingreso, s.time_out AS salida FROM employees e
      LEFT JOIN position p ON e.negocio_id = p.id
      LEFT JOIN negocio n ON e.negocio_id = n.id
      LEFT JOIN schedules s ON e.negocio_id = s.id
      WHERE e.employee_id='$codigo'";
$result = mysqli_query($conn, $query);

// Recibir datos del formulario
$titulo = $_POST['titulo'];
$fechaDesde = $_POST['fechaDesde'];
$fechaHasta = $_POST['fechaHasta'];
$detalles = $_POST['detalles'];
$color = $_POST['color'];
$idPracticante = $_POST['idPracticante'];

// Consulta SQL para insertar un nuevo evento
$sql = "INSERT INTO eventos (titulo, fecha_desde, fecha_hasta, detalles, color, idPracticante) 
        VALUES ('$titulo', '$fechaDesde', '$fechaHasta', '$detalles', '$color', '$idPracticante')";

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
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>