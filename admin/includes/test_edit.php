<?php
include 'session.php';

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
	$pregunta1 = $_POST['editpregunta1'];
    $pregunta2 = "";
    if (isset($_POST['editpregunta2'])){
        $pregunta2 = $_POST['editpregunta2'];
    }
    if (isset($_POST['editvalor3'])){
        $valor3 = $_POST['editvalor3'];
        $valor4 = $_POST['editvalor4'];
        $valor5 = $_POST['editvalor5'];
    }
    if (isset($_POST['editopc1'])){
        $opc1 = $_POST['editopc1'];
        $opc2 = $_POST['editopc2'];
        $opc3 = $_POST['editopc3'];
        $opc4 = $_POST['editopc4'];
        $opc5 = $_POST['editopc5'];
    }
	$valor1 = $_POST['editvalor1'];
	$valor2 = $_POST['editvalor2'];
	$estado = 1;
    $tipo = $_POST['edittest'];

	$sql = "UPDATE preguntas_test SET test = '$tipo', pregunta1 = '$pregunta1', pregunta2 = '$pregunta2',
		 valor_1 = '$valor1', valor_2 = '$valor2', valor_3 = '$valor3', valor_4 = '$valor4', valor_5 = '$valor5',
		 opc_1 = '$opc1', opc_2 = '$opc2', opc_3 = '$opc3', opc_4 = '$opc4', opc_5 = '$opc5',
		 estado = '$estado'
		 WHERE id = '$id'";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Pregunta actualizada con éxito';
	} else {
		$_SESSION['error'] = $conn->error;
	}
}


switch($_POST['edittest']){
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