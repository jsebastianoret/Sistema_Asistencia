<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $cargos_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>
        <?php
        $gestionCargos = $permisoCargos['actualizar'];
        $gestionCargos2 = $permisoCargos['eliminar'];
        $gestionCargos3 = $permisoCargos['crear'];
        $gestionCargos4 = $permisoCargos['leer'];

        if ($gestionCargos4 == "No") {
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
                <?php if ($gestionCargos3 == "Sí") { ?>
                    <div class="me-auto">
                        <button class="button-secondary" data-bs-target="#add_cargo" data-bs-toggle="modal">
                            <i class="fa fa-plus me-2"></i>Nuevo Cargo
                        </button>
                    </div>
                <?php } ?>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th class="align-middle">Cargo</th>
                            <th class="align-middle">Acción</th>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM position";
                            $query = $conn->query($sql);

                            while ($row = $query->fetch_assoc()) { ?>
                                <tr>
                                    <td class="align-middle">
                                        <?= $row['description'] ?>
                                    </td>
                                    <td>
                                        <?php if ($gestionCargos == "Sí") { ?>
                                            <button class="btn btn-success btn-sm rounded-3 edit" data-id="<?= $row['id'] ?>">
                                                <i class="fa fa-edit"></i> Editar
                                            </button>
                                        <?php }
                                        if ($gestionCargos2 == "Sí") { ?>
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

    <!-- MODAL DE AGREGAR CARGO -->
    <div class="modal fade" id="add_cargo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Agregar Cargo</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="includes/cargo_add.php">
                    <div class="modal-body py-4 px-5">
                        <label for="cargo_name" class="fw-bolder">Nombre del Cargo</label>
                        <input type="text" class="form-control rounded" id="cargo_name" name="cargo" required>
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

    <!-- MODAL DE EDITAR CARGO -->
    <div class="modal fade" id="edit_cargo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Modificar Cargo</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="includes/cargo_edit.php">
                    <div class="modal-body py-4 px-5">
                        <input type="hidden" class="posid" name="id">
                                            
                        <label for="edit_cargo_name" class="fw-bolder">Nombre del Cargo</label>
                        <input type="text" class="form-control rounded" id="edit_cargo_name" name="cargo" required>
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

    <!-- MODAL DE ELIMINAR CARGO -->
    <div class="modal fade" id="delete_cargo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Eliminar Cargo</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center fw-bolder">
                        ¿Está seguro de eliminar el cargo <span id="del_cargo_name" class="fw-bold"></span>?
                    </h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form method="POST" action="includes/cargo_delete.php">
                        <input type="hidden" class="posid" name="id">
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
            $('#edit_cargo').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $('.delete').on("click", function (e) {
            $('#delete_cargo').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        function getRow(id) {
            $.ajax({
                type: 'POST',
                url: 'cargo_row.php',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    $('.posid').val(response.id);
                    $('#edit_cargo_name').val(response.description);
                    $('#del_cargo_name').html(response.description);
                }
            });
        }
    </script>
</body>