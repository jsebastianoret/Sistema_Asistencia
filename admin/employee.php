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
        <h1>
          Lista de Practicantes
        </h1>
        <ol class="breadcrumb">
          <li><a href="../admin/home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
          <li>Practicantes</li>
          <li class="active">Lista de Practicantes</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <?php
        if (isset($_SESSION['error'])) {
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              " . $_SESSION['error'] . "
            </div>
          ";
          unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i>¡Proceso Exitoso!</h4>
              " . $_SESSION['success'] . "
            </div>
          ";
          unset($_SESSION['success']);
        }
        ?>
        <div class="row">
          <?php
          include 'includes/gestion_practicantes.php';
          $gestionAsistencia = $permisoPracticantes['actualizar'];
          $gestionAsistencia2 = $permisoPracticantes['eliminar'];
          $gestionAsistencia3 = $permisoPracticantes['crear'];
          $gestionAsistencia4 = $permisoPracticantes['leer'];
          $gestionAsistencia5 = $permisoPracticantes['agregar_notas'];
          $gestionAsistencia6 = $permisoPracticantes['ver_notas'];

          if ($gestionAsistencia4 == "No") {
            echo '<script>window.location.replace("home.php");</script>';
            exit;
          }
          ?>
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <?php
                if ($gestionAsistencia3 == "Sí") {
                  echo '<a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Nuevo</a>';
                }
                ?>
              </div>
              <div class="box-body">
                <table id="example1" class="table table-bordered">
                  <thead>
                    <th>Código de Asistencia</th>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Unidad de Negocio</th>
                    <th>Área</th>
                    <th>Horarios</th>

                    <th>Acción</th>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT *, employees.id AS empid
                            FROM employees
                            LEFT JOIN position
                            ON position.id = employees.position_id
                            LEFT JOIN schedules
                            ON schedules.id = employees.schedule_id
                            LEFT JOIN negocio
                            ON negocio.id = employees.negocio_id";
                    $query = $conn->query($sql);
                    while ($row = $query->fetch_assoc()) {
                      ?>
                      <tr>
                        <td>
                          <?php echo $row['employee_id']; ?>
                        </td>
                        <td><img
                            src="<?php echo (!empty($row['photo'])) ? '../images/' . $row['photo'] : '../images/profile.jpg'; ?>"
                            width="30px" height="30px"> <a href="#edit_photo" data-toggle="modal" class="pull-right photo"
                            data-id="<?php echo $row['empid']; ?>"><span class="fa fa-edit"></span></a></td>
                        <td>
                          <?php echo $row['firstname'] . ' ' . $row['lastname']; ?>
                        </td>
                        <td>
                          <?php echo $row['nombre_negocio']; ?>
                        </td>
                        <td>
                          <?php echo $row['description']; ?>
                        </td>
                        <td>
                          <?php echo date('h:i A', strtotime($row['time_in'])) . ' - ' . date('h:i A', strtotime($row['time_out'])); ?>
                        </td>

                        <td>
                          <?php
                          if ($gestionAsistencia == "Sí") {
                            echo '<button class="btn btn-success btn-sm edit btn-flat" data-id="' . $row['empid'] . '"><i class="fa fa-edit"></i> Editar Datos</button>';
                          }
                          if ($gestionAsistencia2 == "Sí") {
                            echo '<button class="btn btn-danger btn-sm delete btn-flat" style="padding-right: 15px;padding-left: 15px;margin-left: 15px;" data-id="' . $row['empid'] . '"><i class="fa fa-trash"></i> Eliminar</button>';
                          }
                          ?>
                          <br>
                          <?php
                          if ($gestionAsistencia5 == "Sí") {
                            echo '<button class="btn btn-primary btn-sm add_grades btn-flat" data-id="' . $row['empid'] . '" style="margin-top: 10px;"><i class="fa fa-pencil"></i> Agregar Nota</button>';
                          }
                          if ($gestionAsistencia6 == "Sí") {
                            echo '
                                <a href="employee_grades.php?id=' . $row['empid'] .
                              '&nombre=' . urlencode($row['firstname'] . ' ' . $row['lastname']) .
                              '&negocio=' . urlencode($row['nombre_negocio']) .
                              '&position=' . urldecode($row['description']) .
                              '&fecha_inicio=' . urldecode($row['date_in']) .
                              '&fecha_fin=' . urldecode($row['date_out']) .
                              '&codigo_practicante=' . $row['employee_id'] .
                              '&id_practicante=' . $row['empid'] . '" 
                                  class="btn btn-warning btn-sm see_grades btn-flat" style="margin-top: 10px; margin-left: 15px;"><i class="fa fa-eye"></i> Ver Notas</a>
                                ';
                          }
                          ?>
                        </td>
                      </tr>
                      <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/employee_modal.php'; ?>
  </div>

  <script>

    $('.edit').click(function (e) {
      e.preventDefault();
      $('#edit').modal('show');
      var id = $(this).data('id');
      getRow(id);
    });

    $('.add_grades').click(function (e) {
      e.preventDefault();
      $('#add_grades').modal('show');
      var id = $(this).data('id');
      getRow(id);
    });

    $('.delete').click(function (e) {
      e.preventDefault();
      $('#delete').modal('show');
      var id = $(this).data('id');
      getRow(id);
    });

    $('.photo').click(function (e) {
      e.preventDefault();
      var id = $(this).data('id');
      getRow(id);
    });


    function getRow(id) {
      $.ajax({
        type: 'POST',
        url: 'employee_row.php',
        data: { id: id },
        dataType: 'json',
        success: function (response) {
          $('.id_practicante').val(response.id);
          $('.empid').val(response.empid);
          $('.employee_id').html(response.employee_id);
          $('.del_employee_name').html(response.firstname + ' ' + response.lastname);
          $('#employee_name').html(response.firstname + ' ' + response.lastname);
          $('#edit_firstname').val(response.firstname);
          $('#edit_lastname').val(response.lastname);
          $('#edit_address').val(response.address);
          $('#datepicker_edit').val(response.birthdate);
          $('#edit_contact').val(response.contact_info);
          $('#timepractice_val').val(response.time_practice).html(response.time_practice + ' meses');
          $('#typepractice_val').val(response.type_practice).html(response.type_practice);
          $('#gender_val').val(response.gender).html(response.gender);
          $('#position_val').val(response.position_id).html(response.description);
          $('#negocio_val').val(response.negocio_id).html(response.nombre_negocio);
          $('#schedule_val').val(response.schedule_id).html(response.time_in + ' - ' + response.time_out);
          $('#edit_date_in').val(response.date_in).html(response.date_in);
          $('#edit_date_out').val(response.date_out).html(response.date_out);
          $('#edit_birthday').val(response.birthday).html(response.birthday);
          $('#type_practice_val').val(response.type_practice).html(response.type_practice);
          $('#time_practice_val').val(response.time_practice).html(response.time_practice);
          $('#edit_dni').val(response.dni);
          $('#edit_personal_email').val(response.personal_email);
          $('#edit_institutional_email').val(response.institutional_email);
          $('#edit_university').val(response.university);
          $('#edit_career').val(response.career);
        }
      });
    }
  </script>
  <script>
    // Obtener el botón "Ver Notas"
    var seeGradesButtons = document.getElementsByClassName("see_grades");
    // Recorrer los botones y agregar el evento de clic a cada uno
    for (var i = 0; i < seeGradesButtons.length; i++) {
      seeGradesButtons[i].addEventListener("click", function () {
        // Obtener la URL del archivo PHP del atributo data-url del botón actual
        var url = this.getAttribute("data-url");
        // Redirigir al archivo PHP
        window.location.href = url;
      });
    }
  </script>

</body>

</html>