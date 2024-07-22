<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="hold-transition skin-purple-light sidebar-mini" onload="displayTime();">
    <div class="wrapper">
        <?php include 'includes/navbar_sidebar.php' ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="content p-0 px-3 my-4 mb-0">
                    <h5 class="fw-bold">
                        Vista de asistencia
                    </h5>
                </div>
            </section>

            <!-- Main content -->
            <section class="content py-5">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="container container__sd">
                                <h3 class="letraAgregarNuevaPlantilla">Agregar Nueva Plantilla</h3>
                                <form action="vista-guardar.php" method="post" enctype="multipart/form-data"
                                    class="py-5">
                                    <div class="form-group">
                                        <div class="container__sds ">
                                            <span class="form-control-file container__file2 ">
                                                <i class="fa fa-file"></i>
                                                Seleccionar archivo/imagen
                                            </span>
                                            <input class="form-control-file container__file" type="file" name="imagen"
                                                id="imagen" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="mb-3 row group-frase">
                                            <label for="frase" class="col-sm-2 col-form- label-frase">Frase
                                                motivacional</label>
                                            <div class="col-sm-1">
                                                <textarea class="container__frase" name="frase" id="frase"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary px-5 btn-lg">
                                            <i class="fa fa-plus"></i> Agregar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <script src="js/scripts.js"></script>
</body>

</html>