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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_publication = $_POST['id_publicacion'];
        $employee_coment = $_POST['id_employee'];
        $comment_text = $_POST['comentario'];

        $sql = "INSERT INTO coments (id_employee, id_publication, comentario) VALUES ('$employee_coment', '$id_publication', '$comment_text')";

        if ($conn->query($sql) !== TRUE) {
            echo "Error al insertar los datos: " . $conn->error;
        } else {
            echo "Comentario insertado correctamente.";
        }
            
        echo '
        <form method="post" action="home-practicante.php" class="form__ver-perfil">
            <input type="hidden" name="employee_id" value="' . $row['employee_id'] . '">
            <button type="submit" class="enlaces__btn" id="button1"></button>
        </form>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var boton = document.getElementById("button1");
                boton.click();
            });
        </script>
        ';
        exit;
    } else {
        echo "No se encontró el empleado con el employee_id proporcionado.";
    }
} else {
    echo "<div class='alert alert-danger'>No se encontró ningún practicante con el código ingresado.</div>";
}
?>
