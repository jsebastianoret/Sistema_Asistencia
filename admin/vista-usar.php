<?php include 'includes/header.php' ?>
<?php include 'includes/session.php' ?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM imagen_frase WHERE id = '$id'";
    $query = $conn->query($sql);
    $imagen = $query->fetch_assoc();

    if (!$imagen) {
        die("Imagen no encontrada.");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $fraseMotivacional = $_POST['frase_motivacional'];

    $imagenActual = $_POST['imagen_actual']; // Ruta de la imagen actual

    // Procesar la imagen si se ha seleccionado un nuevo archivo
    if ($_FILES['imagen']['tmp_name']) {
        $nombreImagen = $_FILES['imagen']['name'];
        $rutaImagen = $nombreImagen;

        // Mover la imagen cargada a la carpeta de destino
        move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen);

        // Eliminar la imagen anterior si existe
        if ($imagenActual && file_exists($imagenActual)) {
            unlink($imagenActual);
        }
    } else {
        // Si no se ha seleccionado un nuevo archivo, conservar la imagen actual
        $rutaImagen = $imagenActual;
    }

    // Actualizar la información de la imagen en la base de datos
    $sql = "UPDATE imagen_frase SET frase_motivacional = '$fraseMotivacional', nombre = '$rutaImagen' WHERE id = '$id'";
    $conn->query($sql);

    // Redirigir a la página de ver_imagenes.php después de editar
    header("Location: vista-asistencia.php");
    exit();
}
?>

<body class="hold-transition skin-purple-light sidebar-mini" onload="displayTime();">
    <div class="wrapper">
        <?php include 'includes/navbar_sidebar.php' ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content p-0 px-3 my-4 mb-0">
                <h5 class="fw-bold">ASISTENCIA</h5>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="container container__sd">
                                <h2>Usar esta plantilla</h2>
                                <form method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="1">
                                    <div class="form-group">

                                        <?php if ($imagen['nombre']): ?>
                                            <input type="hidden" name="imagen_actual" value="<?= $imagen['nombre'] ?>">
                                            <p>Imagen actual:</p>
                                            <img src="<?= 'img/' . $imagen['nombre'] ?>" alt="Imagen actual"
                                                style="max-width: 300px;">
                                        <?php endif; ?><br><br>
                                        <input type="file" class="form-control-file container__file3" id="imagen"
                                            name="imagen">
                                    </div>
                                    <div class="form-group">
                                        <label for="frase_motivacional">Frase motivacional:</label><br>
                                        <input type="text" class="container__frase" id="frase_motivacional"
                                            name="frase_motivacional" value="<?= $imagen['frase_motivacional'] ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Usar plantilla</button>
                                    <a href="vista-asistencia.php" class="btn btn-danger">Cancelar</a>
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