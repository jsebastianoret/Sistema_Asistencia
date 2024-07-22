<?php
	include 'includes/session.php';

    if (isset($_POST['deletegrades'])) {
        $id = $_POST['id'];
        $fecha_fin_semana = $_POST['fecha_fin_semana']; 
        
        $sql = "DELETE FROM grades WHERE fecha_fin_semana = '$fecha_fin_semana' AND employee_id = '$id'";
            
          if ($conn->query($sql)) {
                $_SESSION['success'] = 'Notas eliminadas con éxito';
          } else {
                $_SESSION['error'] = 'Error al eliminar notas: ' . $conn->error;
          }
        }
     else {
        $_SESSION['error'] = 'Seleccione el elemento para eliminar primero';
    }

	header('location: employee.php');
	
?>