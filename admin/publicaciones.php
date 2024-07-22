<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $publicacion_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>

        <!-- CONTENIDO PRINCIPAL -->
        <?php if (isset($_SESSION['alert_post'])) { ?>
            <p id="alert_post">
                <?php unset($_SESSION['alert_post']) ?>
            </p>
        <?php } ?>
        <?php if (isset($_SESSION['alert_update'])) { ?>
            <p id="alert_update">
                <?php unset($_SESSION['alert_update']) ?>
            </p>
        <?php } ?>
        <?php if (isset($_SESSION['alert_delete'])) { ?>
            <p id="alert_delete">
                <?php unset($_SESSION['alert_delete']) ?>
            </p>
        <?php } ?>

        <section class="content p-0 my-4">
            <div class="card">
                <div class="ms-auto">
                    <a href="publicacion-nueva.php" class="btn button-secondary text-white">
                        <i class="fa fa-plus me-2"></i>Nueva Publicación
                    </a>
                </div>
                <div class="card-body table-responsive">
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="d-none"></th>
                                <th class="text-center">Titulo</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Privacidad</th>
                                <th class="text-center">Imagenes</th>
                                <th class="text-center">Documentos</th>
                                <th class="text-center">Contenido</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM publications";
                            $query = $conn->query($sql);
                            while ($row = $query->fetch_assoc()) { ?>
                                <tr>
                                    <td class="d-none"></td>
                                    <td class="align-middle text-center">
                                        <?php echo $row['title'] ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?php echo $row['publication_date'] ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?php echo $row['type'] ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?php echo $row['privacy'] ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?php $image = json_decode($row['images']);
                                        if (!empty($image)) { ?>
                                            <img src="../images/<?php echo $image[0] ?>" width="160px" alt="Publicación Image">
                                        <?php } ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?php $document = json_decode($row['documents']);
                                        if (!empty($document)) { ?>
                                            <a href="../documents/<?php echo $document[0] ?>" target='_blank'>
                                                <?php echo $document[0] ?>
                                            </a>
                                        <?php } ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?php echo $row['content'] ?>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex flex-column gap-1">
                                            <a href="publicacion-editar.php?id=<?php echo $row['id'] ?>"
                                                class="btn btn-success btn-sm text-white rounded-3">
                                                <i class="fa fa-edit"></i> Editar
                                            </a>
                                            <button class="btn btn-danger btn-sm text-white rounded-3 delete"
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

    <!-- MODAL DE ELIMINAR PUBLICACIÓN -->
    <div class="modal fade" id="delete_publicacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Eliminar Publicación</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center fw-bolder">
                        ¿Está seguro de eliminar la publicación <span id="title_publicacion" class="fw-bold"></span>?
                    </h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form method="POST" action="includes/publicacion_delete.php">
                        <input type="hidden" id="id_publicacion" name="id_publicacion">
                        <button type="submit" id="btn-eliminar" class="btn btn-danger" name="delete">
                            <i class="fa fa-trash me-2"></i>Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/scripts2.php'; ?>

    <script src="js/scripts.js"></script>

    <!-- MODAL ELIMINAR PUBLICACIÓN -->
    <script>
        $('.delete').on("click", function (e) {
            e.preventDefault();
            $('#delete_publicacion').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        function getRow(id) {
            $.ajax({
                type: 'POST',
                url: 'publicacion_row.php',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    $('#id_publicacion').val(response.id);
                    $('#title_publicacion').html(response.title);
                }
            });
        }
    </script>

    <!-- ALERTA DE CAMBIOS EN PUBLICACIÓN -->
    <script>
        let alert_post = document.querySelector('#alert_post');
        let alert_update = document.querySelector('#alert_update');
        let alert_delete = document.querySelector('#alert_delete');

        if (alert_post) {
            Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 3000
            }).fire({
                icon: 'success',
                title: 'Publicación creada con éxito.',
                background: '#00975bd7',
                color: '#fff',
                width: '355px'
            });
        }

        if (alert_update) {
            Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 3000
            }).fire({
                icon: 'success',
                title: 'Publicación actualizada con éxito.',
                background: '#00975bd7',
                color: '#fff',
                width: '365px'
            });
        }

        if (alert_delete) {
            Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 3000
            }).fire({
                icon: 'success',
                iconColor: '#fe6868',
                title: 'Publicación eliminada con éxito.',
                background: '#de1212d1',
                color: '#fff',
                width: '355px'
            });
        }
    </script>
</body>