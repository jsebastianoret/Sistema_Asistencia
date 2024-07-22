<?php
include 'includes/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["completar"]) && isset($_POST["employee_id"])) {
    $codigo = $_POST['employee_id'];
    $query = "SELECT e.*, p.description AS position, n.nombre_negocio AS negocio, s.time_in AS ingreso, s.time_out AS salida FROM employees e
              LEFT JOIN position p ON e.negocio_id = p.id
              LEFT JOIN negocio n ON e.negocio_id = n.id
              LEFT JOIN schedules s ON e.negocio_id = s.id
              WHERE e.employee_id='$codigo'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $sugerenciaId = $_POST['completar'];
        $employeeId = $_POST['employee_id'];

        $jsonFile = "usuarios.json";
        $existingData = json_decode(file_get_contents($jsonFile), true);

        $userData = null;
        foreach ($existingData as $data) {
            if ($data['employee_id'] === $employeeId && $data['id'] == $sugerenciaId) {
                $userData = $data;
                break;
            }
        }
        if ($userData) {
            echo '
            <form method="post" action="form-completar-sugerencia.php">
                <input type="hidden" name="employee_id" value="' . $row['employee_id'] . '">
                <input type="hidden" name="data" value="' . urlencode(json_encode($userData)) . '">
                <input type="submit" style="display: none;">
            </form>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var form = document.querySelector("form");
                    form.submit();
                });
            </script>
            ';
            exit;
        } else {
            echo "Registro no encontrado. Datos esperados: employee_id = " . $row['employee_id'] . ", sugerenciaId = " . $sugerenciaId;
        }
    } else {
        echo "<div class='alert alert-danger'>No se encontró ningún practicante con el código ingresado.</div>";
    }
}

mysqli_close($conn);
?>