<?php
    include 'includes/conn.php';
    $employeeId = $row['id'];


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mes_a_mostrar = $_POST['mes_a_mostrar'];
        $employee_id = $_POST['employee_id'];
        $semanaN2 = $_POST['semanN'];
    }
                    
    $desiredDate = $mes_a_mostrar;
    

    $sql_max_fecha_fin = "SELECT MAX(fecha_fin_semana) AS ultima_fecha FROM grades WHERE employee_id = $employeeId";
    $result_max_fecha_fin = $conn->query($sql_max_fecha_fin);

    if ($result_max_fecha_fin->num_rows > 0) {
        $row_max_fecha_fin = $result_max_fecha_fin->fetch_assoc();
        $ultima_fecha_fin = $row_max_fecha_fin["ultima_fecha"];

        // Query to fetch the notes for the specific date and criteria 1
        $sql1 = "SELECT * FROM grades WHERE employee_id = $employeeId AND fecha_fin_semana = '$desiredDate' AND id_criterio = 1";
        $result1 = $conn->query($sql1);

        // Query to fetch the notes for the specific date and criteria 2
        $sql2 = "SELECT * FROM grades WHERE employee_id = $employeeId AND fecha_fin_semana = '$desiredDate' AND id_criterio = 2";
        $result2 = $conn->query($sql2);

        // Query to fetch the notes for the specific date and criteria 3
        $sql3 = "SELECT * FROM grades WHERE employee_id = $employeeId AND fecha_fin_semana = '$desiredDate' AND id_criterio = 3";
        $result3 = $conn->query($sql3);
    } else {
        echo "No se encontraron resultados.";
    }
    $conn->close();
    ?>