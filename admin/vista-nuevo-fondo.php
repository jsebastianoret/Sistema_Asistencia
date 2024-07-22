<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="hold-transition skin-purple-light sidebar-mini" onload="displayTime();">
    <div class="wrapper">
        <?php include 'includes/navbar_sidebar.php' ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content p-0 px-3 my-4 mb-0">
                <h5 class="fw-bold">VISTA DE ASISTENCIA</h5>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="container container__sd">
                                <h2 class="letraAgregarNuevaPlantilla">Agregar nuevo fondo</h2>
                                <form action="vista-guardar-fondo.php" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="imagen">Imagen:</label>
                                        <div class="container__sds">
                                            <span span class="form-control-file container__file2"><i
                                                    class="fa fa-file"></i> Seleccionar archivo</span>
                                            <input class="form-control-file container__file" type="file" name="imagen"
                                                id="imagen" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary px-5 btn-lg mt-5"><i
                                            class="fa fa-plus"></i> Agregar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <?php include 'includes/scripts.php'; ?>

    <script src="js/scripts.js"></script>
</body>

</html>