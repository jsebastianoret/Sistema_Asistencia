<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>
<?php
if (!isset($_SESSION['response'])) {
    header('Location: buzon-sugerencias.php');
}
?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $buzon_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>

        <!-- CONTENIDO PRINCIPAL INICIO -->
        <div class="content d-flex flex-column align-items-center text-center gap-5 my-auto">
            <h1 class="text-primary fw-bold">¡Hemos enviado tu <b class="text-warning">respuesta</b>!</h1>
            <i class="fa-regular fa-face-grin-stars fa-bounce text-warning my-4" style="font-size: 140px;"></i>
            <a href="buzon-sugerencias.php" class="btn button-primary text-white fs-6">
                <i class="fa-solid fa-caret-left me-2 fs-6"></i>Volver
            </a>
        </div>

        <!-- FOOTER -->
        <?php include 'includes/footer.php' ?>
    </div>

    <script src="js/scripts.js"></script>
</body>