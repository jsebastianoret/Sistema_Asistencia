<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>
<?php date_default_timezone_set('America/Lima') ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $panel_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>

        <!-- CARD PANEL DE CONTROL -->
        <div class="content row g-3 mt-4">
            <div class="col-12 col-sm-6 col-lg-3 mt-0">
                <a href="practicantes.php" class="text-decoration-none">
                    <div class="card text-center text-white" style="background-color: #1e3d8f; border-radius: 16px;">
                        <p class="mb-2 fs-5">Total de Practicantes</p>
                        <?php
                        $sql = "SELECT * FROM employees";
                        $query = $conn->query($sql); ?>

                        <h1 class="mb-0 fs-1" style="font-weight: 500;">
                            <?php echo $query->num_rows ?>
                        </h1>
                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 mt-sm-0">
                <a href="asistencias.php" class="text-decoration-none">
                    <div class="card text-center text-white" style="background-color: #20cfda; border-radius: 16px;">
                        <p class="mb-2 fs-5">Practicantes a tiempo</p>
                        <?php
                        $sql = "SELECT * FROM attendance";
                        $query = $conn->query($sql);
                        $total = $query->num_rows;

                        $sql = "SELECT * FROM attendance WHERE status = 1";
                        $query = $conn->query($sql);
                        $early = $query->num_rows;

                        $percentage = ($early / $total) * 100; ?>

                        <h1 class="mb-0 fs-1" style="font-weight: 500;">
                            <?php echo number_format($percentage, 2) ?>%
                        </h1>
                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 mt-sm-3 mt-lg-0">
                <a href="asistencias.php" class="text-decoration-none">
                    <div class="card text-center text-white" style="background-color: #1fa72c; border-radius: 16px;">
                        <p class="mb-2 fs-5">Hoy asistieron a tiempo</p>
                        <?php $sql = "SELECT * FROM attendance WHERE date = date('d/m/Y') AND status = 1";
                        $query = $conn->query($sql); ?>

                        <h1 class="mb-0 fs-1" style="font-weight: 500;">
                            <?php echo $query->num_rows ?>
                        </h1>
                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 mt-sm-3 mt-lg-0">
                <a href="asistencias.php" class="text-decoration-none">
                    <div class="card text-center text-white" style="background-color: #f0bd13; border-radius: 16px;">
                        <p class="mb-2 fs-5">Hoy asistieron tarde</p>
                        <?php
                        $sql = "SELECT * FROM attendance WHERE date = date('Y-m-d') AND status = 0";
                        $query = $conn->query($sql); ?>

                        <h1 class="mb-0 fs-1" style="font-weight: 500;">
                            <?php echo $query->num_rows ?>
                        </h1>
                    </div>
                </a>
            </div>
        </div>

        <!-- PANEL DE CONTROL -->
        <div class="content row g-3 my-3 mb-4">
            <div class="col-12 col-xl-4 m-0">
                <div class="card">
                    <div class="box-header">
                        <h3 class="box-title colorComunicacion" style="color: #1e3d8f;">Informe de asistencia mensual
                        </h3>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <br>
                            <canvas id="barChart" style="height:350px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-8 m-xl-0">
                <div class="card">
                    <div class="box-header">
                        <h3 class="box-title colorComunicacion" style="color: #1e3d8f;">Informe de Asistencia</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="example1" class="table">
                            <thead>
                                <th class="d-none"></th>
                                <th>Fecha</th>
                                <th>Nombre</th>
                                <th>Hora Entrada</th>
                                <th>Hora Salida</th>
                            </thead>
                            <tbody>
                                <?php
                                include 'includes/data_asistencia.php';

                                while ($row = $query->fetch_assoc()) {
                                    isset($row['date'])
                                        ? $fecha = date('M d, Y', strtotime($row['date']))
                                        : 'NO MARCO';
                                    isset($row['time_in'])
                                        ? $entrada = date('h:i A', strtotime($row['time_in']))
                                        : 'NO MARCO';
                                    isset($row['time_out'])
                                        ? $salida = date('h:i A', strtotime($row['time_out']))
                                        : 'NO MARCO';

                                    if (($row['status_v1']) == "1") {
                                        $status = '<span class="badge bg-success ms-1" style="font-size: 11px !important;">A Tiempo</span>';
                                    } else if (($row['status_v1']) == "0") {
                                        $status = '<span class="badge bg-warning text-dark ms-1" style="font-size: 11px !important;">Tarde</span>';
                                    } else if (($row['status_v1']) == NULL) {
                                        $status = '<span class="badge bg-danger ms-1" style="font-size: 11px !important;">No Marco</span>';
                                    } ?>

                                    <tr>
                                        <td class="d-none"></td>
                                        <td class="align-middle">
                                            <?php echo $fecha ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php echo $row['firstname'] . ' ' . $row['lastname'] ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php echo $entrada . $status ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php echo $salida ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include 'includes/footer.php'; ?>
    </div>

    <script src="js/scripts.js"></script>

    <?php include 'includes/scripts3.php' ?>
</body>

</html>