<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $subcriterios_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>
        <?php
        $gestionSubCriterios = $permisoCriterios['actualizar'];
        $gestionSubCriterios2 = $permisoCriterios['eliminar'];
        $gestionSubCriterios3 = $permisoCriterios['crear'];
        $gestionSubCriterios4 = $permisoCriterios['leer'];

        if ($gestionSubCriterios4 == "No") {
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
                <?php if ($gestionSubCriterios3 == "Sí") { ?>
                    <div class="me-auto">
                        <button class="button-secondary" data-bs-target="#add_subcriterio" data-bs-toggle="modal">
                            <i class="fa fa-plus me-2"></i>Nuevo Subcriterio
                        </button>
                    </div>
                <?php } ?>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th class="align-middle">Subriterio</th>
                            <th class="align-middle">Criterio</th>
                            <th class="align-middle">Acción</th>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT s.id, s.nombre_subcriterio, c.nombre_criterio
                            FROM subcriterios s
                            INNER JOIN criterios c ON s.id_criterio = c.id";
                            $query = $conn->query($sql);

                            while ($row = $query->fetch_assoc()) { ?>
                                <tr>
                                    <td class="align-middle">
                                        <?= $row['nombre_subcriterio'] ?>
                                    </td>
                                    <td class="align-middle">
                                        <?= $row['nombre_criterio'] ?>
                                    </td>
                                    <td>
                                        <?php if ($gestionSubCriterios == "Sí") { ?>
                                            <button class="btn btn-success btn-sm rounded-3 edit" data-id="<?= $row['id'] ?>">
                                                <i class="fa fa-edit"></i> Editar
                                            </button>
                                        <?php }
                                        if ($gestionSubCriterios2 == "Sí") { ?>
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

    <!-- MODAL DE AGREGAR SUBCRITERIO -->
    <div class="modal fade" id="add_subcriterio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Agregar Subcriterio</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="includes/subcriterio_add.php">
                    <div class="modal-body py-4 px-5">
                        <label for="subcriterio_name" class="fw-bolder">Nombre del Subcriterio</label>
                        <input type="text" class="form-control rounded" id="subcriterio_name" name="subcriterio"
                            required>
                        <div class="mt-2">
                            <label for="id_criterio" class="fw-bolder">Criterio</label>
                            <select class="form-control rounded" name="id_criterio" id="id_criterio" required>
                                <option value="" selected disabled>- Seleccionar -</option>
                                <?php
                                $sql = "SELECT * FROM criterios";
                                $query = $conn->query($sql);
                                while ($prow = $query->fetch_assoc()) { ?>
                                    <option value="<?= $prow['id'] ?>">
                                        <?= $prow['nombre_criterio'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class=" modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" name="add">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DE EDITAR SUBCRITERIO -->
    <div class="modal fade" id="edit_subcriterio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Modificar Criterio</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="includes/subcriterio_edit.php">
                    <div class="modal-body py-4 px-5">
                        <input type="hidden" class="subid" name="id">

                        <label for="edit_subcriterio_name" class="fw-bolder">Nombre del Criterio</label>
                        <input type="text" class="form-control rounded" id="edit_subcriterio_name" name="subcriterio"
                            required>
                        <div class="mt-2">
                            <label for="edit_id_criterio" class="fw-bolder">Criterio</label>
                            <select class="form-control rounded" name="id_criterio" id="edit_id_criterio" required>
                                <option value="" selected disabled>- Seleccionar -</option>
                                <?php
                                $sql = "SELECT * FROM criterios";
                                $query = $conn->query($sql);
                                while ($prow = $query->fetch_assoc()) { ?>
                                    <option value="<?= $prow['id'] ?>">
                                        <?= $prow['nombre_criterio'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
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

    <!-- MODAL DE ELIMINAR SUBCRITERIO -->
    <div class="modal fade" id="delete_subcriterio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Eliminar Subcriterio</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center fw-bolder">
                        ¿Está seguro de eliminar el subcriterio <span id="del_subcriterio_name" class="fw-bold"></span>?
                    </h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form method="POST" action="includes/subcriterio_delete.php">
                        <input type="hidden" class="subid" name="id">
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
            $('#edit_subcriterio').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $('.delete').on("click", function (e) {
            $('#delete_subcriterio').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        function getRow(id) {
            $.ajax({
                type: 'POST',
                url: 'subcriterios_row.php',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    $('.subid').val(response.id);
                    $('#edit_subcriterio_name').val(response.nombre_subcriterio);
                    $('#edit_id_criterio').val(response.id_criterio);
                    $('#del_subcriterio_name').html(response.nombre_subcriterio);
                }
            });
        }
    </script>
</body>

</html>