<?php
include 'conn.php';

if (isset($_GET['id'])) {
    $unidadId = $_GET['id'];

    $sqlEmpleados = "SELECT id, firstname, lastname FROM employees WHERE negocio_id = $unidadId";
    $resultEmpleados = $conn->query($sqlEmpleados);

    if ($resultEmpleados->num_rows > 0) {
        $selectEmpleados = '<option selected disabled value="">SELECCIONA UN EMPLEADO</option>';
        while ($row = $resultEmpleados->fetch_assoc()) {
            $selectEmpleados .= '<option value="' . $row["id"] . '">' . $row["firstname"] . $row["lastname"] . '</option>';
        }
        echo $selectEmpleados;
    } else {
        $selectEmpleados = '<option selected disabled value="">SIN REGISTROS</option>';
        echo $selectEmpleados;
    }
} else {
    echo "ID de unidad no proporcionado.";
}

$conn->close();
?>