
<?php include 'includes/header-practicante.php'; ?>

<body class="bg-white">
  <?php $perfil_click = "clicked" ?>
  <?php include 'includes/fecha_actual.php' ?>
  <?php include 'includes/navbar-sidebar-practicante.php' ?>
  <?php include 'includes/conn.php' ?>

  <main class="buzon-container">
    <div class="buzon-table">
      <table>
        <thead>
          <tr>
            <th class="text-center" style="width: 190px;">Asunto</th>
            <th class="text-center">Tipo</th>
            <th class="text-center" style="width: 120px;">Fecha</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $employee_id = $row['employee_id'];

          $employee_query = "SELECT id FROM employees WHERE employee_id = '$employee_id'";
          $employee_result = $conn->query($employee_query);

          if ($employee_result->num_rows > 0) {
            $employee_row = $employee_result->fetch_assoc();
            $empleado_id = $employee_row["id"];
            

            // Check for both memorandums and termination letters
            $consulta_memorandum = "SELECT * FROM memorandums WHERE employee_id = '$empleado_id' AND tipo = 'memorandum'";
            $resultado_memorandum = $conn->query($consulta_memorandum);

            $consulta_despido = "SELECT * FROM memorandums WHERE employee_id = '$empleado_id' AND tipo = 'carta_despido'";
            $resultado_despido = $conn->query($consulta_despido);

            // Display memorandums if found
            if ($resultado_memorandum->num_rows > 0) {
              while ($fila_memorandum = $resultado_memorandum->fetch_assoc()) {
                echo '<tr>';
                echo '<td class="text-center"><a href="download.php?document=' . urlencode($fila_memorandum["document"]) . '">' . $fila_memorandum["document"] . '</a></td>';

        // ... (rest of the code)
                echo '  <td class="text-center">Memorandum</td>';
                echo '  <td class="text-center">' . $fila_memorandum["fecha"] . '</td>';
                echo '</tr>';
              }
            }

            // Display termination letters if found (after memorandums)
            if ($resultado_despido->num_rows > 0) {
              while ($fila_despido = $resultado_despido->fetch_assoc()) {
                echo '<tr>';
                //echo '  <td class="text-center"><a href="download_doc.php?id=' . $fila_despido["id"] . '">' . $fila_despido["document"] . '</a></td>'; // Link to download script

                echo '<td class="text-center"><a href="download.php?document=' . urlencode($fila_despido["document"]) . '">' . $fila_despido["document"] . '</a></td>';
        // ... (rest of the code)
                echo '  <td class="text-center">Carta de despido</td>';
                echo '  <td class="text-center">' . $fila_despido["fecha"] . '</td>';
                echo '</tr>';
              }
            }

            // No documents found message
            if ($resultado_memorandum->num_rows === 0 && $resultado_despido->num_rows === 0) {
              echo '<tr><td colspan="3">No hay memorandums ni cartas de despido registradas.</td></tr>';
            }
          } else {
            echo "No se encontró el empleado con el employee_id proporcionado.";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>
  </body>
