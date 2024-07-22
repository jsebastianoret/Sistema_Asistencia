<?php
include 'session.php';

if (isset($_POST['add'])) {
	$pregunta1 = $_POST['pregunta1'];
    $pregunta2 = "";
    if (isset($_POST['pregunta2'])){
        $pregunta2 = $_POST['pregunta2'];
    }
	$valor1 = $_POST['valor1'];
	$valor2 = $_POST['valor2'];
	if (isset($_POST['valor3'])){
        $valor3 = $_POST['valor3'];
        $valor4 = $_POST['valor4'];
        $valor5 = $_POST['valor5'];
    }
    if (isset($_POST['opc1'])){
        $opc1 = $_POST['opc1'];
        $opc2 = $_POST['opc2'];
        $opc3 = $_POST['opc3'];
        $opc4 = $_POST['opc4'];
        $opc5 = $_POST['opc5'];
    }
	$estado = $_POST['estado'];
    $tipo = $_POST['test'];
	
	$sql = "INSERT INTO preguntas_test (test, pregunta1, pregunta2, valor_1, valor_2, valor_3, valor_4, valor_5, opc_1, opc_2, opc_3, opc_4, opc_5, estado) VALUES 
            ('$tipo', '$pregunta1', '$pregunta2', '$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$opc1', '$opc2', '$opc3', '$opc4', '$opc5','$estado')";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Pregunta añadida con éxito';
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