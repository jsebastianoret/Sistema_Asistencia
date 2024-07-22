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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["guardar"])) {
        $jsonFile = "usuarios.json";

        $existingData = file_get_contents($jsonFile);
        $existingData = json_decode($existingData, true);

        $employeeId = $_POST["employee_id"];
        
        if (isset($_POST["id"])) {
            $sugerenciaId = $_POST["id"];
            $sugerenciaExistente = true;
        } else {
            $lastId = end($existingData)["id"];
            $newId = $lastId + 1;
            $sugerenciaId = $newId;
            $sugerenciaExistente = false;
        }

        foreach ($existingData as &$data) {
            if ($data['id'] == $sugerenciaId) {
                $data['nombre'] = $_POST["nombre"];
                $data['fecha'] = $_POST["fecha"];
                $data['asunto'] = $_POST["asunto"];
                $data['tipo'] = $_POST["tipo"];
                $data['unidad'] = $_POST["unidad"];
                $data['sugerencia'] = $_POST["sugerencia"];

                $sugerenciaExistente = true;
                break;
            }
        }

        if (!$sugerenciaExistente) {
            $newData = array(
                "id" => $sugerenciaId,
                "employee_id" => $employeeId,
                "nombre" => $_POST["nombre"],
                "fecha" => $_POST["fecha"],
                "asunto" => $_POST["asunto"],
                "tipo" => $_POST["tipo"],
                "unidad" => $_POST["unidad"],
                "sugerencia" => $_POST["sugerencia"]
            );

            $existingData[] = $newData;
        }

        $jsonData = json_encode($existingData, JSON_PRETTY_PRINT);
        file_put_contents($jsonFile, $jsonData);

        echo '
            <form method="post" action="borradores-buzon.php">
                <input type="hidden" name="employee_id" value="' . $row['employee_id'] . '">
                <input type="hidden" name="data" value="' . urlencode(json_encode($existingData)) . '">
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
    }
} else {
    echo "<div class='alert alert-danger'>No se encontró ningún practicante con el código ingresado.</div>";
}

mysqli_close($conn);
?>