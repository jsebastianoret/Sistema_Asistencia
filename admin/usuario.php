<?php include 'includes/session.php'; ?>
<?php include 'includes/header-admin.php'; ?>

<body class="hold-transition skin-purple-light sidebar-mini">
  <div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php';?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Lista de Admins
        </h1>
        <ol class="breadcrumb">
          <li><a href="../admin/home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
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
          $gestionAsistencia = $permisoUsuarios['actualizar'];
          $gestionAsistencia2 = $permisoUsuarios['eliminar'] ;
          $gestionAsistencia3 = $permisoUsuarios['crear'];
          $gestionAsistencia4 = $permisoUsuarios['leer'];

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
                    echo '<a href="#addnew" data-toggle="modal" class=" margin_btn btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Nuevo</a>';
                  }
                  if ($gestionAsistencia == "Sí") {
                    echo '<a href="gestion_rango.php" class="btn btn-warning btn-sm btn-flat">Administrar rangos</a>';
                  }
                ?>
              </div>
              <div class="box-body">
                <table id="example1" class="table table-bordered">
                  <thead>
                    <th>Usuario</th>
                    <th>Contraseña</th>
                    <th>Nombre</th>
                    <th>Rango</th>
                    <th>Acciones</th>
                  </thead>
                  <tbody>
                  <?php
                    $sql = "SELECT admin.*, rango.nombre_rango 
                            FROM admin 
                            LEFT JOIN rango ON admin.id_rango = rango.id";

                    $query = $conn->query($sql);
                    while ($row = $query->fetch_assoc()) {
                      echo "
                        <tr>
                          <td>" . $row['username'] . "</td>
                          <td>" . $row['password'] . "</td>
                          <td>" . $row['firstname'] . ' ' . $row['lastname'] . "</td>
                          <td>" . $row['nombre_rango'] . "</td>
                          <td>";
                          if ($gestionAsistencia == "Sí") {
                            echo "<button class='btn btn-success margin_btn btn-sm edit btn-flat' data-id='" . $row['id'] . "'><i class='fa fa-edit'></i> Editar</button>";
                          }
                          if ($gestionAsistencia2 == "Sí") {
                            echo "<button class='btn btn-danger btn-sm delete btn-flat' data-id='" . $row['id'] . "'><i class='fa fa-trash'></i> Eliminar</button>";
                          }
                          echo 
                          "</td>
                        </tr>
                      ";
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
    <?php include 'includes/usuario_modal.php'; ?>
  </div>
  <?php include 'includes/scripts.php'; ?>
  <script>
    $('.edit').click(function(e) {
      e.preventDefault();
      $('#edit').modal('show');
      var id = $(this).data('id');
      getRow(id);
    });

    $('.delete').click(function(e) {
      e.preventDefault();
      $('#delete').modal('show');
      var id = $(this).data('id');
      getRow(id);
    });

    function getRow(id) {
      $.ajax({
        type: 'POST',
        url: 'usuario_row.php',
        data: {
          id: id
        },
        dataType: 'json',
        success: function(response) {
          $('.id').val(response.id);
          $('#edit_username').val(response.username);
          $('#edit_password').val(response.password);
          $('#edit_firstname').val(response.firstname);
          $('#edit_lastname').val(response.lastname);
          $('#edit_rango').val(response.rango);
        }
      });
    }
  </script>
</body>
</html>