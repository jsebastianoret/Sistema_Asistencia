<?php include 'includes/session.php'; ?>
<?php include 'includes/header-admin.php'; ?>

<body class="hold-transition skin-purple-light sidebar-mini">
  <div class="wrapper">
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="col-xs-7 text-center">
          <div class="box">
            <h2 class="text-center" style="margin-top: 10px; margin-bottom:10px ;color: #605CA8">
              <?php echo $_GET['codigo_practicante']; ?>
            </h2>
          </div>
        </div>
        <ol class="breadcrumb">
          <li><a href="../admin/home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
          <li>Practicantes</li>
          <li class="active">Lista de Practicantes</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <div>
          <div class="col-xs-7">
            <div class="box">
              <div class="box-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th rowspan="2" class=" text-center"
                        style="font-size: 20px; overflow-wrap: break-word; width: 250px;">EVALUACIÓN DE DESEMPEÑO</th>
                      <th class="text-center">INGRESO</th>
                      <td colspan="2" class="text-center" style="font-size: 15px">
                        <?php echo $_GET['fecha_inicio']; ?>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-center">SALIDA</th>
                      <td colspan="2" class="text-center" style="font-size: 15px">
                        <?php echo $_GET['fecha_fin']; ?>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-center">PRACTICANTE</th>
                      <td colspan="3" class="text-center" style="font-size: 18px">
                        <?php echo $_GET['nombre']; ?>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-center">PUESTO</th>
                      <td colspan="3" class="text-center" style="font-size: 15px">
                        <?php echo $_GET['position']; ?>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-center">ÁREA</th>
                      <td colspan="3" class="text-center" style="font-size: 15px">
                        <?php echo $_GET['negocio']; ?>
                      </td>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-3">
          <div class="box">
            <div class="box-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th rowspan="2" class=" text-center"
                      style="font-size: 20px; overflow-wrap: break-word; width: 250px;">NOTA FINAL</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="4" id="promedio-nota-final" class="text-center" style="font-size: 18px">Promedio:
                      <?php echo $promedioNotas; ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-3" style="text-align-last: center;">
            <div class="box">
              <div class="box-body">
                <button class="btn btn-danger btn-sm delete_grades btn-flat"
                  data-id="<?php echo $_GET['id_practicante']; ?>"><i class="fa fa-trash"></i> Eliminar Nota</button>
              </div>
            </div>
          </div>
        </div>
        <?php
        // Generar las fechas de cada semana
        $fechaInicio = $_GET['fecha_inicio'];
        $fechaFin = $_GET['fecha_fin'];
        $employee = $_GET['id_practicante'];

        // Convertir las fechas en objetos DateTime
        $inicio = new DateTime($fechaInicio);
        $fin = new DateTime($fechaFin);

        // Obtener la diferencia en días entre las fechas de inicio y fin
        $diferencia = $inicio->diff($fin);
        $numSemanas = ceil($diferencia->days / 7);

        // Crear un array para almacenar las fechas de cada semana
        $fechasSemanas = array();
        $inicioSemana = clone $inicio;
        $prevFecha = clone $inicio; // Agrega esta línea para llevar un registro de la fecha anterior
        
        // Crear un array para almacenar las fechas de cada semana
        $fechasSemanas = array();
        $inicioSemana = clone $inicio;
        $prevFecha = clone $inicio; // Agrega esta línea para llevar un registro de la fecha anterior
        
        for ($i = 0; $i < $numSemanas; $i++) {
          $finSemana = clone $inicioSemana;
          $finSemana->modify('+7 days');

          if ($finSemana <= $fin) {
            $prevFecha = $finSemana;
          }

          // Agrega esta condición para manejar la última semana
          if ($inicioSemana <= $fin && $finSemana > $fin) {
            $diff = $fin->diff($prevFecha)->days;

            // Si la diferencia es menor o igual a 4 días, sumarlos a la semana anterior
            if ($diff <= 4) {
              $prevFecha->modify('+' . $diff . ' days');
            }

            // Si prevFecha es igual a $fin, elimina la última fecha generada
            if ($prevFecha == $fin) {
              array_pop($fechasSemanas);
            }
          }

          if ($inicioSemana > $fin) {
            break;
          }

          // Cambia $fechaSemana por $prevFecha si es menor a $fin
          $fechaSemana = ($prevFecha <= $fin) ? $prevFecha->format('d/m/Y') : $finSemana->format('d/m/Y');
          $fechasSemanas[] = $fechaSemana;

          $inicioSemana->modify('+7 days');
        }

        // Consultar los criterios de la base de datos
        $consultaCriterios = "SELECT * FROM criterios";
        $resultadoCriterios = $conn->query($consultaCriterios);
        $numCriterios = mysqli_num_rows($resultadoCriterios);
        $promedioNotasArray = array(); //
        $contador = 0;
        if ($numCriterios > 0) {
          while ($criterio = mysqli_fetch_assoc($resultadoCriterios)) {
            $criterioId = $criterio['id'];
            $criterioNombre = $criterio['nombre_criterio'];
            $contador++;

            // Consultar los subcriterios para el criterio actual
            $consultaSubcriterios = "SELECT * FROM subcriterios WHERE id_criterio = $criterioId";
            $resultadoSubcriterios = $conn->query($consultaSubcriterios);
            $numSubcriterios = mysqli_num_rows($resultadoSubcriterios);

            if ($numSubcriterios > 0) {
              echo '<div class="row">';
              echo '<div class="col-xs-12">';
              echo '<div class="box">';
              echo '<div class="box-body table-responsive">';
              echo '<table class="table table-bordered">';
              echo '<thead>';
              echo '<tr>';
              echo '<th rowspan="3" class="text-center" style="font-size: 19px; vertical-align: middle; overflow-wrap: break-word; width: 250px;">' . $contador . '. ' . $criterioNombre . '</th>';
              if (count($fechasSemanas) <= 14) {
                echo '<th colspan="4" class="text-center">MES 1</th>';
                echo '<th colspan="4" class="text-center">MES 2</th>';
                echo '<th colspan="5" class="text-center">MES 3</th>';
              }

              if (count($fechasSemanas) > 14 && count($fechasSemanas) <= 16) {
                echo '<th colspan="4" class="text-center">MES 1</th>';
                echo '<th colspan="4" class="text-center">MES 2</th>';
                echo '<th colspan="4" class="text-center">MES 3</th>';
                echo '<th colspan="4" class="text-center">MES 4</th>';
              }
              if (count($fechasSemanas) > 16 && count($fechasSemanas) <= 20) {
                echo '<th colspan="4" class="text-center">MES 1</th>';
                echo '<th colspan="4" class="text-center">MES 2</th>';
                echo '<th colspan="4" class="text-center">MES 3</th>';
                echo '<th colspan="4" class="text-center">MES 4</th>';
                echo '<th colspan="4" class="text-center">MES 5</th>';
              }
              if (count($fechasSemanas) > 20 && count($fechasSemanas) <= 24) {
                echo '<th colspan="4" class="text-center">MES 1</th>';
                echo '<th colspan="4" class="text-center">MES 2</th>';
                echo '<th colspan="4" class="text-center">MES 3</th>';
                echo '<th colspan="4" class="text-center">MES 4</th>';
                echo '<th colspan="4" class="text-center">MES 5</th>';
                echo '<th colspan="4" class="text-center">MES 6</th>';
              }
              if (count($fechasSemanas) > 24) {
                echo '<th colspan="4" class="text-center">MES 1</th>';
                echo '<th colspan="4" class="text-center">MES 2</th>';
                echo '<th colspan="4" class="text-center">MES 3</th>';
                echo '<th colspan="4" class="text-center">MES 4</th>';
                echo '<th colspan="4" class="text-center">MES 5</th>';
                echo '<th colspan="4" class="text-center">MES 6</th>';
                echo '<th colspan="4" class="text-center">MES 7</th>';
              }
              echo '</tr>';
              echo '<tr>';
              if (count($fechasSemanas) <= 14) {
                echo '<th class="text-center">SEM 1</th>
                             <th class="text-center">SEM 2</th>
                             <th class="text-center">SEM 3</th>
                             <th class="text-center">SEM 4</th>
                             <th class="text-center">SEM 5</th>
                             <th class="text-center">SEM 6</th>
                             <th class="text-center">SEM 7</th>
                             <th class="text-center">SEM 8</th>
                             <th class="text-center">SEM 9</th>
                             <th class="text-center">SEM 10</th>
                             <th class="text-center">SEM 11</th>
                             <th class="text-center">SEM 12</th>
                             <th class="text-center">SEM 13</th>';
                if (count($fechasSemanas) == 14) {
                  echo '<th class="text-center">SEM 14</th>';
                }
              }
              if (count($fechasSemanas) > 14) {
                echo '<th class="text-center">SEM 1</th>
                             <th class="text-center">SEM 2</th>
                             <th class="text-center">SEM 3</th>
                             <th class="text-center">SEM 4</th>
                             <th class="text-center">SEM 5</th>
                             <th class="text-center">SEM 6</th>
                             <th class="text-center">SEM 7</th>
                             <th class="text-center">SEM 8</th>
                             <th class="text-center">SEM 9</th>
                             <th class="text-center">SEM 10</th>
                             <th class="text-center">SEM 11</th>
                             <th class="text-center">SEM 12</th>
                             <th class="text-center">SEM 13</th>
                             <th class="text-center">SEM 14</th>
                             <th class="text-center">SEM 15</th>';
                if (count($fechasSemanas) > 15) {
                  echo '<th class="text-center">SEM 16</th>';
                }
                if (count($fechasSemanas) > 16) {
                  echo '<th class="text-center">SEM 17</th>';
                }
                if (count($fechasSemanas) > 17) {
                  echo '<th class="text-center">SEM 18</th>';
                }
                if (count($fechasSemanas) > 18) {
                  echo '<th class="text-center">SEM 19</th>';
                }
                if (count($fechasSemanas) > 19) {
                  echo '<th class="text-center">SEM 20</th>';
                }
                if (count($fechasSemanas) > 20) {
                  echo '<th class="text-center">SEM 21</th>';
                }
                if (count($fechasSemanas) > 21) {
                  echo '<th class="text-center">SEM 22</th>';
                }
                if (count($fechasSemanas) > 22) {
                  echo '<th class="text-center">SEM 23</th>';
                }
                if (count($fechasSemanas) > 23) {
                  echo '<th class="text-center">SEM 24</th>';
                }
                if (count($fechasSemanas) > 24) {
                  echo '<th class="text-center">SEM 25</th>';
                }
                if (count($fechasSemanas) > 25) {
                  echo '<th class="text-center">SEM 26</th>';
                }
                if (count($fechasSemanas) > 26) {
                  echo '<th class="text-center">SEM 27</th>';
                }
                if (count($fechasSemanas) > 27) {
                  echo '<th class="text-center">SEM 28</th>';
                }
                if (count($fechasSemanas) > 28) {
                  echo '<th class="text-center">SEM 29</th>';
                }
              }
              echo '<tr>';
              foreach ($fechasSemanas as $fechaSemana) {
                echo '<th class="text-center" style="font-size: 13px;">' . $fechaSemana . '</th>';
              }
              echo '</thead>';
              echo '<tbody>';
              $totalNota = 0;
              $cantidadNotaTotal = 0;
              while ($subcriterio = mysqli_fetch_assoc($resultadoSubcriterios)) {
                $subcriterioId = $subcriterio['id'];
                $subcriterioNombre = $subcriterio['nombre_subcriterio'];
                echo '<tr>';
                echo '<td class="text-center">' . $subcriterioNombre . '</td>';
                $subcriterioTotalNota = 0;
                $subcriterioCantidadNota = 0;
                // Consultar las notas para el subcriterio actual
                foreach ($fechasSemanas as $fechaSemana) {
                  $consultaNota = "SELECT * FROM grades WHERE employee_id = $employee AND id_subcriterio = $subcriterioId AND id_criterio = $criterioId AND fecha_fin_semana = STR_TO_DATE('$fechaSemana', '%d/%m/%Y')";
                  $resultadoNota = $conn->query($consultaNota);
                  $notaNum = null;

                  if ($resultadoNota && $resultadoNota->num_rows > 0) {
                    $nota = mysqli_fetch_assoc($resultadoNota);
                    $notaNum = $nota['nota'];
                  }
                  if (is_null($notaNum)) {
                    $notaNum = 0; // Asignamos 0 a la variable $notaNum si es nula
                  }
                  if ($resultadoNota && $resultadoNota->num_rows > 0) {
                    echo '<td class="text-center">' . $notaNum . '<button class="text-center btn btn-warning btn-sm edit_grades" data-id="' . $employee . '"data-criterio="' . $criterioId . '"data-subcriterio="' . $subcriterioId . '"data-fecha="' . $fechaSemana . '"data-nota="' . $notaNum . '"><i class="fa fa-pencil"></i></button></td>';

                    $subcriterioTotalNota += $notaNum;
                    $subcriterioCantidadNota++;
                  } else {
                    echo '<td class="text-center">' . $notaNum . '</td>';
                  }

                  $subcriterioTotalNota += $notaNum;
                  $subcriterioCantidadNota++;
                }
                $totalNota += $subcriterioTotalNota;
                $cantidadNotaTotal += $subcriterioCantidadNota;
                echo '</tr>';
              }
              $promedioNotas = ($cantidadNotaTotal > 0) ? $totalNota / $cantidadNotaTotal : 0;
              $promedioNotasArray[] = $promedioNotas;
              echo '<th class="text-center">TOTAL DE SEMANAS</th>';
              $promedioSubcriterios = array();
              foreach ($fechasSemanas as $fechaSemana) {
                $subcriterioTotalNotaSemana = 0;
                $subcriterioCantidadNotaSemana = 0;
                foreach ($resultadoSubcriterios as $subcriterio) {
                  $subcriterioId = $subcriterio['id'];
                  $consultaNota = "SELECT * FROM grades WHERE employee_id = $employee AND id_subcriterio = $subcriterioId AND id_criterio = $criterioId AND fecha_fin_semana = STR_TO_DATE('$fechaSemana', '%d/%m/%Y')";
                  $resultadoNota = $conn->query($consultaNota);
                  $notaNum = null;

                  if ($resultadoNota && $resultadoNota->num_rows > 0) {
                    $nota = mysqli_fetch_assoc($resultadoNota);
                    $notaNum = $nota['nota'];
                  }

                  $subcriterioTotalNotaSemana += $notaNum;
                  $subcriterioCantidadNotaSemana++;
                }
                $promedioSubcriterioSemana = ($subcriterioCantidadNotaSemana > 0) ? $subcriterioTotalNotaSemana / $subcriterioCantidadNotaSemana : 0;
                $promedioSubcriterios[] = $promedioSubcriterioSemana;
                echo '<td class="text-center">' . $promedioSubcriterioSemana . '</td>';
              }

              echo '<tr><th class="text-center">TOTAL</th>';
              echo '<td colspan="13" class="text-center">' . number_format($promedioNotas, 2) . '</td>';
              echo '</tr>';
              echo '</tbody>';
              echo '</table>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
            }
          }
        }
        $promedioGeneral = 0;
        if (count($promedioNotasArray) > 0) {
          $promedioGeneral = array_sum($promedioNotasArray) / count($promedioNotasArray);
        }
        echo '<script>';
        echo 'document.getElementById("promedio-nota-final").innerHTML = "' . number_format($promedioGeneral, 2) . '";';
        echo '</script>';
        ?>
      </section>
    </div>
    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/employee_modal.php'; ?>
  </div>
  <script>
    $('.delete_grades').click(function (e) {
      e.preventDefault();
      $('#delete_grades').modal('show');
      var id = $(this).data('id');
      getRow(id);
    });

    $(document).ready(function () {
      $('.edit_grades').click(function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var criterio = $(this).data('criterio');
        var subcriterio = $(this).data('subcriterio');
        var fecha = $(this).data('fecha');
        var nota = $(this).data('nota');

        $.ajax({
          type: 'POST',
          url: 'employee_grades_row.php',
          data: {
            id: id,
            criterio: criterio,
            subcriterio: subcriterio,
            fecha: fecha
          },
          dataType: 'json',
          success: function (response) {
            $('#id').val(response.id);
            $('#nota').val(response.nota);
            $('#edit_grades').modal('show');
          }
        });
      });
    });

    function getRow(id) {
      $.ajax({
        type: 'POST',
        url: 'employee_row.php',
        data: { id: id },
        dataType: 'json',
        success: function (response) {
          $('.empid').val(response.empid);
        }
      });
    }
  </script>
</body>

</html>