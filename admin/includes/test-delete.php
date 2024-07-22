<?php
include 'session.php';

if (isset($_POST['delete'])) {
	$id = $_POST['id'];

	$sql = "DELETE FROM preguntas_test WHERE id = '$id'";
		if ($conn->query($sql) === TRUE) {
			$_SESSION['success'] = 'Pregunta eliminada con éxito';
		} else {
			$_SESSION['error'] = $conn->error;
		}
		
}

switch($_POST['test']){
    case 1:
        header('location: ../test-edit.php?test=1');
        break;
    case 2:
        header('location: ../test-edit.php?test=2');
        break;
    case 3:
        header('location: ../test-edit.php?test=3');
        break;
}
?>