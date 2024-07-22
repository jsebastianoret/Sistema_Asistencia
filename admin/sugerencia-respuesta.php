<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>
<?php
if (isset($_GET['id'])) {
    $sugerencia_id = $_GET['id'];

    $consulta_sugerencia = "SELECT * FROM sugerencias WHERE id = '$sugerencia_id'";
    $resultado_sugerencia = $conn->query($consulta_sugerencia);

    if ($resultado_sugerencia->num_rows > 0) {
        $sugerencia = $resultado_sugerencia->fetch_assoc();
    } else {
        header('Location: buzon-sugerencias.php');
    }
} else {
    header('Location: buzon-sugerencias.php');
}
?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $buzon_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="content p-0 my-4">
            <form action="includes/sugerencia_enviar_respuesta.php" method="post" class="d-flex justify-content-center">
                <input type="hidden" name="sugerencia_id" value="<?php echo $sugerencia_id ?>">

                <div class="bg-light rounded p-2 py-4 px-sm-4 col-12 col-sm-11 col-md-12 col-lg-10 col-xl-7">
                    <div class="d-flex justify-content-between mx-3">
                        <div>
                            <h6 class="fw-bold">NOMBRE DE COLABORADOR:</h6>
                            <p>
                                <?php echo htmlspecialchars($sugerencia['nombre']) ?>
                            </p>
                        </div>
                        <div>
                            <h6 class="fw-bold">FECHA</h6>
                            <p>
                                <?php echo htmlspecialchars($sugerencia['fecha']) ?>
                            </p>
                        </div>
                    </div>
                    <div class="mx-3">
                        <span class="fw-bold">Unidad | Área:</span>
                        <p>
                            <?php echo htmlspecialchars($sugerencia['unidad']) ?>
                        </p>
                    </div>
                    <div class="mx-3">
                        <h6 class="fw-bold">Asunto:</h6>
                        <p>
                            <?php echo htmlspecialchars($sugerencia['asunto']) ?>
                        </p>
                    </div>
                    <div class="mx-3">
                        <h6 class="fw-bold">Tipo de Sugerencia:</h6>
                        <p>
                            <?php echo htmlspecialchars($sugerencia['tipo']) ?>
                        </p>
                    </div>
                    <div class="mx-3">
                        <h6 class="fw-bold">Sugerencia:</h6>
                        <p>
                            <?php echo htmlspecialchars($sugerencia['sugerencia']) ?>
                        </p>
                    </div>
                    <div class="d-flex flex-column rounded mx-3 p-3" style="background-color: #cbcbcb;">
                        <textarea class="form-control bg-transparent border-0 mb-3" id="mensaje" name="mensaje" rows="6"
                            required style="resize: none;"></textarea>
                        <button type="submit" class="button-secondary ms-auto">
                            <i class="fa-solid fa-paper-plane me-2"></i>Responder
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- FOOTER -->
        <?php include 'includes/footer.php' ?>
    </div>

    <script src="js/scripts.js"></script>
</body>

</html>