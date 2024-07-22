<?php
include 'conn.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "SELECT date_in, date_out FROM employees WHERE id = '$id'";
} else {
    $id = $_POST['paid'];
    $sql = "SELECT date_in, date_out FROM papelera WHERE id = '$id'";
}
$resultado = $conn->query($sql);
$empleado = $resultado->fetch_assoc();

$inicio = new DateTime($empleado['date_in']);
$fin = new DateTime($empleado['date_out']);
$inicio->modify('+1 week');

while ($inicio <= $fin) {
    $fechasSemanas[] = $inicio->format('d/m/Y');
    $inicio->modify('+1 week');
}

if (end($fechasSemanas) !== $fin->format('d/m/Y')) {
    $fechasSemanas[key($fechasSemanas)] = $fin->format('d/m/Y');
}

$sql = "SELECT * FROM criterios";
$resultado = $conn->query($sql);

while ($row = $resultado->fetch_assoc()) {
    $criterio['nombre'] = $row['nombre_criterio'];
    $contador = 0;
    $notaCriterioTotalMes = 0;
    $notaCriterioCantidadMes = 0;
    foreach ($fechasSemanas as $fechaSemana) {
        $contador++;

        $sql = "SELECT SUM(nota)/COUNT(nota) AS total FROM grades WHERE employee_id = '$id' AND id_criterio = {$row['id']} AND fecha_fin_semana = STR_TO_DATE('$fechaSemana', '%d/%m/%Y')";
        $resultadoNota = $conn->query($sql);
        $nota = $resultadoNota->fetch_assoc();

        isset($nota['total']) ? $promedioNotaSemana = $nota['total'] : $promedioNotaSemana = 0;

        if ($promedioNotaSemana > 0) {
            $notaCriterioTotalMes += $promedioNotaSemana;
            $notaCriterioCantidadMes++;
        }

        $promedioNotaCriterioMes = ($notaCriterioCantidadMes > 0)
            ? $notaCriterioTotalMes / $notaCriterioCantidadMes
            : 0;
        if ($contador % 4 == 0) {
            $criterio['notas'][] = round($promedioNotaCriterioMes, 2);

            $notaCriterioTotalMes = 0;
            $notaCriterioCantidadMes = 0;
        }
    }
    $criterio['notas'][] = round($promedioNotaCriterioMes, 2);
    $criterios[] = $criterio;
    $criterio = [];
}

echo json_encode($criterios);
?>