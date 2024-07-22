<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $archivos_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>

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
                <div class="ms-auto">
                    <a href="archivo-nuevo.php" class="btn button-secondary text-white">
                        <i class="fa fa-plus me-2"></i>Nuevo Archivo
                    </a>
                </div>
                <div class="card-body table-responsive">
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="d-none"></th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Archivos</th>
                                <th class="text-center w-25">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM archivos";
                            $query = $conn->query($sql);

                            while ($row = $query->fetch_assoc()) { ?>
                                <tr>
                                    <td class="d-none"></td>
                                    <td class="align-middle text-center">
                                        <?php
                                        $images = json_decode($row['images'], true);
                                        if (!empty($images)) {
                                            foreach ($images as $image) { ?>
                                                <img src="../img/<?php echo $image ?>" width="30px" height="30px">
                                            <?php } ?>
                                        <?php } ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php
                                        $documents = json_decode($row['archivos'], true);
                                        if (!empty($documents)) {
                                            foreach ($documents as $document) { ?>
                                                <a href="../documents/<?php echo $document ?>" target="_blank">
                                                    <?php echo $document ?>
                                                </a><br>
                                            <?php } ?>
                                        <?php } ?>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="archivo-editar.php?id=<?php echo $row['id'] ?>"
                                                class="btn btn-success btn-sm rounded text-white">
                                                <i class="fa fa-edit"></i> Editar
                                            </a>
                                            <button class="btn btn-danger btn-sm rounded delete"
                                                data-id="<?php echo $row['id'] ?>">
                                                <i class="fa fa-trash"></i> Eliminar
                                            </button>
                                        </div>
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

    <!-- MODAL DE ELIMINAR ARCHIVO -->
    <div class="modal fade" id="delete_archivo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Eliminar Archivo(s)</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 id="del_employee_name" class="text-center fw-bolder">¿Estás
                        seguro de eliminar?</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form method="POST" action="includes/archivo_delete.php">
                        <input type="hidden" id="del_archid" name="id">
                        <button type="submit" class="btn btn-danger" name="delete">
                            <i class="fa fa-trash me-2"></i>Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/scripts2.php'; ?>

    <script src="js/scripts.js"></script>

    <!-- ELIMINAR ARCHIVO -->
    <script>
        $('.delete').on("click", function (e) {
            e.preventDefault();
            $('#delete_archivo').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        function getRow(id) {
            $.ajax({
                type: 'POST',
                url: 'archivo_row.php',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    $('#del_archid').val(response.id);
                }
            });
        }
    </script>
</body>

</html>