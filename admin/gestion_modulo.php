<?php include 'includes/session.php'; ?>
<?php include 'includes/header-admin.php'; ?>

<body class="hold-transition skin-purple-light sidebar-mini">
  <div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar_gestion.php'; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Gestionar otros módulos
        </h1>
        <ol class="breadcrumb">
          <li><a href="../admin/home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border gestion__seccion">
                <div class="button__gestion">
                  <a href="usuario.php" class="btn btn-danger btn-sm btn-flat">Volver</a>
                  <a href="gestion_practicante.php" class="btn  btn-sm btn-flat">Gestionar lista de practicantes</a>
                  <a href="gestion_modulo.php" class="btn btn-primary btn-sm btn-flat">Otros módulos</a>
                </div>
                <div>
                  <a href="gestion_rango.php" class="btn btn-sm btn-flat">Gerencia</a>
                  <a href="gestion_rango-auxiliar.php" class="btn btn-sm btn-flat">Auxiliar de gerencia</a>
                  <a href="gestion_rango-administracion.php" class="btn btn-sm btn-flat">Administración de proyectos</a>
                  <a href="gestion_rango-comunicacion.php" class="btn btn-sm btn-flat">Comunicacion interna</a>
                  <a href="gestion_rango-jefatura.php" class="btn btn-sm btn-flat">Jefatura de proyectos</a>
                  <a href="gestion_rango-unidad.php" class="btn btn-sm btn-flat">Unidad proyectos</a>
                </div>
                <div>
                  <!-- Aquí puedes agregar los botones para los diferentes rangos -->
                </div>
              </div>
              <div class="box-body">
                <?php include 'includes/gestion_rango-modulo.php'; ?>

                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>id</th>
                      <th>Rango</th>
                      <th>Módulo</th>
                      <th>Leer</th>
                      <th>Acción</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($permisos as $permiso) : ?>
                      <tr>
                        <td><?php echo $permiso["id"]; ?></td>
                        <td><?php echo $permiso["nombre_rango"]; ?></td>
                        <td><?php echo $permiso["modulo"]; ?></td>
                        <td class="<?php echo ($permiso["leer"] == 'Sí') ? 'verde-claro' : 'rojo'; ?>"><?php echo $permiso["leer"]; ?></td>
                        <td class="<?php echo ($permiso["accion"] == 'Sí') ? 'verde-claro' : 'rojo'; ?>"><?php echo $permiso["accion"]; ?></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editarModal<?php echo $permiso["id"]; ?>">Editar</button>
                          <form method="POST" action="gestion_modulo.php" style="display: inline-block;">
                            <input type="hidden" name="id" value="<?php echo $permiso["id"]; ?>">
                          </form>
                        </td>
                      </tr>

                      <div class="modal fade" id="editarModal<?php echo $permiso["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="editarModalLabel">Editar Permiso</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form method="POST" action="gestion_modulo.php">
                                <input type="hidden" name="id" value="<?php echo $permiso["id"]; ?>"> <!-- Campo oculto con el id del permiso -->
                                <!-- Aquí puedes agregar los campos de edición para el módulo -->
                                <div class="form-group">
                                  <label for="idRango">Rango:</label>
                                  <select class="form-control" id="idRango" name="idRango" required>
                                    <?php foreach ($rangos as $rango) : ?>
                                      <option value="<?php echo $rango["id"]; ?>" <?php if ($rango["id"] == $permiso["id_rango"]) echo "selected"; ?>><?php echo $rango["nombre_rango"]; ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="modulo">Módulo:</label>
                                  <input type="text" class="form-control" id="modulo" name="modulo" value="<?php echo $permiso["modulo"]; ?>" required>
                                </div>
                                <div class="form-group">
                                  <label for="leer">Leer:</label>
                                  <select class="form-control" id="leer" name="leer" required>
                                    <option value="Sí" <?php if ($permiso["leer"] == "Sí") echo "selected"; ?>>Sí</option>
                                    <option value="No" <?php if ($permiso["leer"] == "No") echo "selected"; ?>>No</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="accion">Acción:</label>
                                  <select class="form-control" id="accion" name="accion" required>
                                    <option value="Sí" <?php if ($permiso["accion"] == "Sí") echo "selected"; ?>>Sí</option>
                                    <option value="No" <?php if ($permiso["accion"] == "No") echo "selected"; ?>>No</option>
                                  </select>
                                </div>
                                <!-- Fin de los campos de edición -->
                                <button type="submit" class="btn btn-primary" name="Update">Actualizar</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
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
</body>
</html>