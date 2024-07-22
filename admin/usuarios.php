<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $usuarios_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>
        <?php
        $gestionUsuarios = $permisoUsuarios['actualizar'];
        $gestionUsuarios2 = $permisoUsuarios['eliminar'];
        $gestionUsuarios3 = $permisoUsuarios['crear'];
        $gestionUsuarios4 = $permisoUsuarios['leer'];

        if ($gestionUsuarios4 == "No") {
            echo '<script>window.location.replace("panel-control.php");</script>';
            exit;
        }
        ?>

        <!-- CONTENIDO PRINCIPAL -->
        <section class="content p-0 my-4">
            <?php if (isset($_SESSION['error'])) { ?>
                <div class='alert alert-danger alert-dismissible'>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    <h4><i class='icon fa fa-warning'></i> Error!</h4>
                    <?php echo $_SESSION['error'] ?>
                </div>
                <?php unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) { ?>
                <div class='alert alert-success alert-dismissible'>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    <h4><i class='icon fa fa-check'></i>¡Proceso Exitoso!</h4>
                    <?php echo $_SESSION['success'] ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php } ?>

            <div class="card">
                <div class="d-flex gap-3">
                    <?php if ($gestionUsuarios3 == "Sí") { ?>
                        <button class="button-secondary" data-bs-target="#add_usuario" data-bs-toggle="modal">
                            <i class="fa fa-plus me-2"></i>Nuevo Usuario
                        </button>
                    <?php } ?>
                    <?php if ($gestionUsuarios == "No") { ?>
                        <button class="button-primary">
                            <i class="fa-solid fa-gear me-2"></i>Administrar Rangos
                        </button>
                    <?php } ?>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th class="align-middle">Usuario</th>
                            <th class="align-middle">Nombre</th>
                            <th class="align-middle">Rango</th>
                            <th class="align-middle">Acciones</th>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT a.*, r.nombre_rango
                            FROM admin a
                            LEFT JOIN rango r ON a.id_rango = r.id";
                            $query = $conn->query($sql);

                            while ($row = $query->fetch_assoc()) { ?>
                                <tr>
                                    <td class="align-middle">
                                        <?= $row['username'] ?>
                                    </td>
                                    <td class="align-middle">
                                        <?= $row['firstname'] . ' ' . $row['lastname'] ?>
                                    </td>
                                    <td class="align-middle">
                                        <?= $row['nombre_rango'] ?>
                                    </td>
                                    <td>
                                        <?php if ($gestionUsuarios == "Sí") { ?>
                                            <button class="btn btn-success btn-sm rounded-3 edit" data-id="<?= $row['id'] ?>">
                                                <i class="fa fa-edit"></i> Editar
                                            </button>
                                        <?php }
                                        if ($gestionUsuarios2 == "Sí") { ?>
                                            <button class="btn btn-danger btn-sm rounded-3 delete" data-id="<?= $row['id'] ?>">
                                                <i class="fa fa-trash"></i> Eliminar
                                            </button>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <?php include 'includes/footer.php'; ?>
    </div>

    <!-- MODAL DE AGREGAR USUARIO -->
    <div class="modal fade" id="add_usuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Agregar Usuario</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="includes/usuario_add.php">
                    <div class="modal-body d-flex flex-column gap-2 py-4 px-5">
                        <div>
                            <label for="usuario" class="fw-bolder">Usuario</label>
                            <input type="text" class="form-control rounded" id="usuario" name="usuario" required>
                        </div>
                        <div>
                            <label for="password" class="fw-bolder">Contraseña</label>
                            <input type="password" class="form-control rounded" id="password" name="password" required>
                        </div>
                        <div>
                            <label for="nombre" class="fw-bolder">Nombre</label>
                            <input type="text" class="form-control rounded" id="nombre" name="nombre" required>
                        </div>
                        <div>
                            <label for="apellido" class="fw-bolder">Apellido</label>
                            <input type="text" class="form-control rounded" id="apellido" name="apellido" required>
                        </div>
                        <div>
                            <label for="rango" class="fw-bolder">Rango</label>
                            <select class="form-control rounded" id="rango" name="rango" required>
                                <option value="" selected disabled>-Seleccionar-</option>
                                <?php
                                $sql = "SELECT * FROM rango";
                                $query = $conn->query($sql);
                                while ($row = $query->fetch_assoc()) { ?>
                                    <option value="<?= $row['id'] ?>">
                                        <?= $row['nombre_rango'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" name="add">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DE EDITAR USUARIO -->
    <div class="modal fade" id="edit_usuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Modificar Usuario</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="includes/usuario_edit.php">
                    <div class="modal-body d-flex flex-column gap-2 py-4 px-5">
                        <input type="hidden" class="id" name="id">

                        <div>
                            <label for="usuario" class="fw-bolder">Usuario</label>
                            <input type="text" class="form-control rounded" id="edit_username" name="usuario" required>
                        </div>
                        <div>
                            <label for="password" class="fw-bolder">Contraseña</label>
                            <input type="password" class="form-control rounded" id="edit_password" name="password"
                                required>
                        </div>
                        <div>
                            <label for="nombre" class="fw-bolder">Nombre</label>
                            <input type="text" class="form-control rounded" id="edit_nombre" name="nombre" required>
                        </div>
                        <div>
                            <label for="apellido" class="fw-bolder">Apellido</label>
                            <input type="text" class="form-control rounded" id="edit_apellido" name="apellido" required>
                        </div>
                        <div>
                            <label for="rango" class="fw-bolder">Rango</label>
                            <select class="form-control rounded" id="edit_rango" name="rango" required>
                                <option value="" selected disabled>-Seleccionar-</option>
                                <?php
                                $sql = "SELECT * FROM rango";
                                $query = $conn->query($sql);
                                while ($row = $query->fetch_assoc()) { ?>
                                    <option value="<?= $row['id'] ?>">
                                        <?= $row['nombre_rango'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" name="edit">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DE ELIMINAR USUARIO -->
    <div class="modal fade" id="delete_usuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Eliminar Usuario</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center fw-bolder">
                        ¿Está seguro de eliminar el usuario <span id="del_username" class="fw-bold"></span>?
                    </h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form method="POST" action="includes/usuario_delete.php">
                        <input type="hidden" class="id" name="id">
                        <button type="submit" class="btn btn-danger" name="delete">
                            <i class="fa fa-trash me-2"></i>Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="js/scripts.js"></script>

    <!-- DATA PARA MODAL -->
    <script>
        $('.edit').on("click", function (e) {
            $('#edit_usuario').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $('.delete').on("click", function (e) {
            $('#delete_usuario').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        function getRow(id) {
            $.ajax({
                type: 'POST',
                url: 'usuario_row.php',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    $('.id').val(response.id);
                    $('#edit_username').val(response.username);
                    $('#edit_password').val(response.password);
                    $('#edit_nombre').val(response.firstname);
                    $('#edit_apellido').val(response.lastname);
                    $('#edit_rango').val(response.rid);
                    $('#del_username').html(response.username);
                }
            });
        }
    </script>
</body>

</html>