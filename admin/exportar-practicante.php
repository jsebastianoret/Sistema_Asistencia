<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $exportar_practicante_click = "clicked" ?>
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
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <th class="align-middle">Código de Asistencia</th>
                            <th class="align-middle">Nombre</th>
                            <th class="align-middle">Unidad de Negocio</th>
                            <th class="align-middle">Área</th>
                            <th class="align-middle">Horarios</th>
                            <th class="align-middle">Acción</th>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT *, employees.id AS empid
                                 FROM employees
                                 LEFT JOIN position
                                 ON position.id = employees.position_id
                                 LEFT JOIN schedules
                                 ON schedules.id = employees.schedule_id
                                 LEFT JOIN negocio
                                 ON negocio.id = employees.negocio_id";
                            $query = $conn->query($sql);

                            while ($row = $query->fetch_assoc()) { ?>
                                <tr>
                                    <td class="align-middle">
                                        <?php echo $row['employee_id']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['firstname'] . ' ' . $row['lastname']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['nombre_negocio']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['description']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo date('h:i A', strtotime($row['time_in'])) . ' - ' . date('h:i A', strtotime($row['time_out'])); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($gestionExportar2 == "Sí") { ?>
                                            <a href="includes/excel_practicante.php?employee_id=<?= $row['employee_id'] ?>"
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

    <?php include 'includes/scripts2.php'; ?>

    <script src="js/scripts.js"></script>
</body>

</html>