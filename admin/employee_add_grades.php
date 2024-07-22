<?php
include 'includes/session.php';

if(isset($_POST['addGrades'])){
    $empid = $_POST['id'];
    $fecha_inicio = $_POST['fecha1'];
    $fecha_fin = $_POST['fecha2'];

    // Insertar los datos en la tabla "grades"
    $sqlCriterios = "SELECT * FROM criterios";
    $queryCriterios = $conn->query($sqlCriterios);

    while($criterio = $queryCriterios->fetch_assoc()){
        $sqlSubcriterios = "SELECT * FROM subcriterios WHERE id_criterio = ".$criterio['id'];
        $querySubcriterios = $conn->query($sqlSubcriterios);

        while($subcriterio = $querySubcriterios->fetch_assoc()){
            $nota = $_POST['criterio'.$subcriterio['id']];

            // Insertar la nota en la tabla "grades"
            $sqlInsert = "INSERT INTO grades (nota, id_criterio, id_subcriterio, fecha_inicio_semana, fecha_fin_semana, employee_id)
                          VALUES ('$nota', '".$criterio['id']."', '".$subcriterio['id']."', '$fecha_inicio', '$fecha_fin', '$empid')";
            $conn->query($sqlInsert);
        }
    }

    $_SESSION['success'] = 'Notas agregadas exitosamente';
}
else{
    $_SESSION['error'] = 'Complete el formulario de notas primero';
}

header('location: employee.php');
?>
