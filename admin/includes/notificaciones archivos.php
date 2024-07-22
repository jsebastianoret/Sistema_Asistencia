<?php
echo '<h5 class="mt-2">Archivos</h5>';
include 'conn.php';
$sql12 = "SELECT * FROM archivos";
$result12 = $conn->query($sql12);

if ($result12->num_rows > 0) {
      while ($row12 = $result12->fetch_assoc()) {
            echo '<div class="notificaciones-event">
      <div class="ver-event-1">
            <span class="notificaciones-tt">Se agrego un nuevo archivo</span>
            <br>
            <span>' . $row12["archivos"] . '</span>
         </div>
         <form method="post" action="archivos-practicante.php" class="">
            <input type="hidden" name="employee_id" value="' . $row['employee_id'] . '">
            <button type="submit" class="boton-detalles" id="button1">
                  Ver
            </button>
         </form>
         </div>';
            $notiCount++;
      }
} else {
      echo "<span>No hay archivos registrados.</span>";
}

$conn->close();
?>