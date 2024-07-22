<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $exportar_area_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>
        <?php
        $gestionExportar = $permisoExportar['leer'];
        $gestionExportar2 = $permisoExportar['accion'];

        if ($gestionExportar == "No") {
            echo '<script>window.location.replace("panel-control.php");</script>';
            exit;
        }
        ?>

        <!-- CONTENIDO PRINCIPAL -->
        <section class="content p-0 my-4">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th class="align-middle">Área</th>
                            <th class="align-middle">Acción</th>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM negocio";
                            $query = $conn->query($sql);

                            while ($row = $query->fetch_assoc()) { ?>
                                <tr>
                                    <td class="align-middle">
                                        <?php echo $row['nombre_negocio'] ?>
                                    </td>
                                    <td>
                                        <?php if ($gestionExportar2 == "Sí") { ?>
                                            <a href="includes/excel_area.php?negocio=<?= $row['nombre_negocio'] ?>"
                                                class="btn btn-success btn-sm text-white rounded-3">
                                                <i class="fa-solid fa-file-arrow-down me-1"></i> Reporte en Excel
                                            </a>
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

    <script src="js/scripts.js"></script>
</body>

</html>