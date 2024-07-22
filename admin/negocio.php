<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $negocio_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>
        <?php
        $gestionUnidad = $permisoUnidad['actualizar'];
        $gestionUnidad2 = $permisoUnidad['eliminar'];
        $gestionUnidad3 = $permisoUnidad['crear'];
        $gestionUnidad4 = $permisoUnidad['leer'];

        if ($gestionUnidad4 == "No") {
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
                <?php if ($gestionUnidad3 == "Sí") { ?>
                    <div class="me-auto">
                        <button class="button-secondary" data-bs-target="#add_negocio" data-bs-toggle="modal">
                            <i class="fa fa-plus me-2"></i>Nueva Unidad de Negocio
                        </button>
                    </div>
                <?php } ?>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th class="align-middle">Unidad de Negocio</th>
                            <th class="align-middle">Acción</th>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM negocio";
                            $query = $conn->query($sql);

                            while ($row = $query->fetch_assoc()) { ?>
                                <tr>
                                    <td class="align-middle">
                                        <?= $row['nombre_negocio'] ?>
                                    </td>
                                    <td>
                                        <?php if ($gestionUnidad == "Sí") { ?>
                                            <button class="btn btn-success btn-sm rounded-3 edit" data-id="<?= $row['id'] ?>">
                                                <i class="fa fa-edit"></i> Editar
                                            </button>
                                        <?php }
                                        if ($gestionUnidad2 == "Sí") { ?>
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

    <!-- MODAL DE AGREGAR UNIDAD DE NEGOCIO -->
    <div class="modal fade" id="add_negocio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Agregar Unidad de Negocio</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="includes/negocio_add.php">
                    <div class="modal-body py-4 px-5">
                        <label for="negocio_name" class="fw-bolder">Nombre de Unidad de Negocio</label>
                        <input type="text" class="form-control rounded" id="negocio_name" name="negocio" required>
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

    <!-- MODAL DE EDITAR UNIDAD DE NEGOCIO -->
    <div class="modal fade" id="edit_negocio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Modificar Unidad de Negocio</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="includes/negocio_edit.php">
                    <div class="modal-body py-4 px-5">
                        <input type="hidden" class="negid" name="id">

                        <label for="edit_negocio_name" class="fw-bolder">Nombre del Cargo</label>
                        <input type="text" class="form-control rounded" id="edit_negocio_name" name="negocio" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" name="edit">
                            <i class="fa fa-edit me-2"></i>Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DE ELIMINAR UNIDAD DE NEGOCIO -->
    <div class="modal fade" id="delete_negocio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Eliminar Unidad de Negocio</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center fw-bolder">
                        ¿Está seguro de eliminar la Unidad de Negocio <span id="del_negocio_name" class="fw-bold"></span>?
                    </h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form method="POST" action="includes/negocio_delete.php">
                        <input type="hidden" class="negid" name="id">
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
            $('#edit_negocio').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $('.delete').on("click", function (e) {
            $('#delete_negocio').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        function getRow(id) {
            $.ajax({
                type: 'POST',
                url: 'negocio_row.php',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    $('.negid').val(response.id);
                    $('#edit_negocio_name').val(response.nombre_negocio);
                    $('#del_negocio_name').html(response.nombre_negocio);
                }
            });
        }
    </script>
</body>

</html>