<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $buzon_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="content p-0 px-3 my-4">
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

            <h5 class="fw-bold">EL EQUIPO TE DEJÓ SUGERENCIAS</h5>
            <p>Aquí la leyenda para que los colaboradores sepan qué tipo de evento hay.<br>General, por unidad, por
                persona.</p>
            <button id="ordenarBtn" class="button-secondary">
                <i class="fa-solid fa-sort me-2"></i>Ordenar
            </button>

            <!-- TABLA SUGERENCIAS -->
            <div class="card mt-4">
                <div class="card-body table-responsive">
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="d-none"></th>
                                <th class="text-center">Remitente</th>
                                <th class="text-center">Asunto</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Unidad</th>
                                <th class="text-center">Sugerencia</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM sugerencias";
                            $query = $conn->query($sql);

                            while ($row = $query->fetch_assoc()) {
                                $sugerencia_id = $row["id"];
                                $consulta_respuesta = "SELECT * FROM respuesta_sugerencias WHERE sugerencia_id = '$sugerencia_id'";
                                $resultado_respuesta = $conn->query($consulta_respuesta); ?>
                                <tr>
                                    <td class="d-none"></td>
                                    <td class="align-middle text-center">
                                        <?php echo $row['nombre'] ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?php echo $row['asunto'] ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?php echo $row['tipo'] ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?php echo $row['unidad'] ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?php echo $row['sugerencia'] ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?php echo $row['fecha'] ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?php if ($resultado_respuesta->num_rows > 0) { ?>
                                            <div class="bg-light rounded p-2 content-response-btn">
                                                <i class="fa-solid fa-check"></i> Respondido
                                            </div>
                                        <?php } else { ?>
                                            <a href="sugerencia-respuesta.php?id=<?php echo $sugerencia_id ?>"
                                                class="btn btn-success rounded content-response-btn">
                                                <i class="fa-solid fa-reply"></i> Responder
                                            </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include 'includes/footer.php' ?>
    </div>

    <?php include 'includes/scripts2.php' ?>

    <script src="js/scripts.js"></script>

    <!-- ORDENAR TABLA -->
    <script>
        var ordenAscendente = true;

        $("#ordenarBtn").click(function () {
            ordenAscendente = !ordenAscendente;

            var rows = $("#example1 tbody tr").get();

            rows.sort(function (a, b) {
                var hasResponseA = $(a).find(".content-response-btn").length > 0;
                var hasResponseB = $(b).find(".content-response-btn").length > 0;

                if (ordenAscendente) {
                    if (hasResponseA && !hasResponseB) {
                        return -1;
                    } else if (!hasResponseA && hasResponseB) {
                        return 1;
                    }
                } else {
                    if (hasResponseA && !hasResponseB) {
                        return 1;
                    } else if (!hasResponseA && hasResponseB) {
                        return -1;
                    }
                }
                return 0;
            });
            $.each(rows, function (index, row) {
                $("#example1").append(row);
            });
        });
    </script>
</body>

</html>