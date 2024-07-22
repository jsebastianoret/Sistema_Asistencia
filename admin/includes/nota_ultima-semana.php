<?php
include 'includes/conn.php';
$employeeId = $row['id'];
$sql_max_fecha_fin = "SELECT MAX(fecha_fin_semana) AS ultima_fecha FROM grades WHERE employee_id = $employeeId";
$result_max_fecha_fin = $conn->query($sql_max_fecha_fin);

if ($result_max_fecha_fin->num_rows > 0) {
   $row_max_fecha_fin = $result_max_fecha_fin->fetch_assoc();
   $ultima_fecha_fin = $row_max_fecha_fin["ultima_fecha"];

   $sql = "SELECT * FROM grades WHERE employee_id = $employeeId AND fecha_fin_semana = '$ultima_fecha_fin'";
   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
      $sum_criterio_1 = 0;
      $sum_criterio_2 = 0;
      $sum_criterio_3 = 0;
      $count_criterio_1 = 0;
      $count_criterio_2 = 0;
      $count_criterio_3 = 0;
      while ($row1 = $result->fetch_assoc()) {
            if ($row1["id_criterio"] == 1) {
               $sum_criterio_1 += $row1["nota"];
               $count_criterio_1++;
            } elseif ($row1["id_criterio"] == 2) {
               $sum_criterio_2 += $row1["nota"];
               $count_criterio_2++;
            } elseif ($row1["id_criterio"] == 3) {
               $sum_criterio_3 += $row1["nota"];
               $count_criterio_3++;
            }
         }
         $promedioNota1 = round(($sum_criterio_1 / $count_criterio_1),0);
         $promedioNota2 = round(($sum_criterio_2 / $count_criterio_2),0);
         $promedioNota3 = round(($sum_criterio_3 / $count_criterio_3),0);
         $promidioSemanal = round((($promedioNota1 + $promedioNota2 + $promedioNota3)/3),0);
      } else {
         $promedioNota1 = '-';
         $promedioNota2 = '-';
         $promedioNota3 = '-';
         $promidioSemanal = '-';
      }
} else {
   echo "No se encontraron resultados.";
}

// Cerrar la conexión
$conn->close();
?>