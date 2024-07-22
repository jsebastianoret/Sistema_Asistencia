<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
  <div class="content-wrapper">
  <?php $rangos_click= "clicked" ?>
  <?php include 'includes/navbar_sidebar.php' ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content p-0 my-4">
        <div class="card">
          <div class="col-xs-12">

              <div class="box-header with-border gestion__seccion">
                <div class="button__gestion">
                  <a href="new-gestion_practicante.php" class="btn btn-sm btn-flat ">Gestionar liste de pracicantes</a>
                  <a href="new-gestion_modulo.php" class="btn btn-sm btn-flat ">Otros modulos</a>
                </div>
                <div>
                  <a href="new-gestion_rango.php" class="btn btn-sm btn-flat">Gerencia</a>
                  <a href="new-gestion_rango-auxiliar.php" class="btn btn-primary btn-sm btn-flat">Auxiliar de gerencia</a>
                  <a href="new-gestion_rango-administracion.php" class="btn btn-sm btn-flat">Administración de proyectos</a>
                  <a href="new-gestion_rango-comunicacion.php" class="btn btn-sm btn-flat">Comunicacion interna</a>
                  <a href="new-gestion_rango-jefatura.php" class="btn btn-sm btn-flat">Jefatura de proyectos</a>
                  <a href="new-gestion_rango-unidad.php" class="btn btn-sm btn-flat">Unidad proyectos</a>
                </div>
              </div>
              <div class="box-body">

              <?php include 'includes/new-gestion_rango-auxiliar.php'; ?>

              <table class="table table-bordered">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Rango</th>
                  <th>Módulo</th>
                  <th>Crear</th>
                  <th>Leer</th>
                  <th>Actualizar</th>
                  <th>Eliminar</th>
                  <th>Acciones</th>
                </tr>
              </thead>
                <tbody>
                  <?php foreach ($permisos as $permiso) : ?>
                    <tr>
                      <td><?php echo $permiso["id_rango"]; ?></td>
                      <td><?php echo $permiso["nombre_rango"]; ?></td>
                      <td><?php echo $permiso["modulo"]; ?></td>
                      <td class="<?php echo ($permiso["crear"] == 'Sí') ? 'verde-claro' : 'rojo'; ?>"><?php echo $permiso["crear"]; ?></td>
                      <td class="<?php echo ($permiso["leer"] == 'Sí') ? 'verde-claro' : 'rojo'; ?>"><?php echo $permiso["leer"]; ?></td>
                      <td class="<?php echo ($permiso["actualizar"] == 'Sí') ? 'verde-claro' : 'rojo'; ?>"><?php echo $permiso["actualizar"]; ?></td>
                      <td class="<?php echo ($permiso["eliminar"] == 'Sí') ? 'verde-claro' : 'rojo'; ?>"><?php echo $permiso["eliminar"]; ?></td>
                      <td>
                        <button type="button" class="btn btn-success btn-sm rounded-3 edit" data-bs-toggle="modal" data-bs-target="#editarModal<?php echo $permiso["id"]; ?>"><i class="fa fa-edit"></i> Editar</button>
                        <form method="POST" action="new-gestion_rango-auxiliar.php" style="display: inline-block;">
                          <input type="hidden" name="id" value="<?php echo $permiso["id"]; ?>">
                        </form>
                      </td>
                    </tr>

                    <div class="modal fade" id="editarModal<?php echo $permiso["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md" role="document">
                            <div class="modal-content rounded-3">
                            <div class="modal-header py-2">
                                    <h4 class="modal-title text-white fw-bold ms-auto" id="editarModalLabel">Editar Permiso</h4>
                                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="new-gestion_rango-auxiliar.php">
                                        <input type="hidden" name="id" value="<?php echo $permiso["id"]; ?>"> <!-- Campo oculto con el id del permiso -->
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
                                    <input type="text" class="form-control" id="modulo" name="modulo" value="<?php echo $permiso["modulo"]; ?>" required readonly>
                                </div>
                                <div class="form-group">
                                    <label for="crear">Crear:</label>
                                    <select class="form-control" id="crear" name="crear" required>
                                    <option value="Sí" <?php if ($permiso["crear"] == "Sí") echo "selected"; ?>>Sí</option>
                                    <option value="No" <?php if ($permiso["crear"] == "No") echo "selected"; ?>>No</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="leer">Leer:</label>
                                    <select class="form-control" id="leer" name="leer" required>
                                    <option value="Sí" <?php if ($permiso["leer"] == "Sí") echo "selected"; ?>>Sí</option>
                                    <option value="No" <?php if ($permiso["leer"] == "No") echo "selected"; ?>>No</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="actualizar">Actualizar:</label>
                                    <select class="form-control" id="actualizar" name="actualizar" required>
                                    <option value="Sí" <?php if ($permiso["actualizar"] == "Sí") echo "selected"; ?>>Sí</option>
                                    <option value="No" <?php if ($permiso["actualizar"] == "No") echo "selected"; ?>>No</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="eliminar">Eliminar:</label>
                                    <select class="form-control" id="eliminar" name="eliminar" required>
                                    <option value="Sí" <?php if ($permiso["eliminar"] == "Sí") echo "selected"; ?>>Sí</option>
                                    <option value="No" <?php if ($permiso["eliminar"] == "No") echo "selected"; ?>>No</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                          <button type="submit" class="btn btn-success" name="Update"><i class="fa-solid fa-floppy-disk me-2"></i> Actualizar</button>
                                        </div>
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
      </section>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="js/scripts.js"></script>
  </div>
</body>
</html>