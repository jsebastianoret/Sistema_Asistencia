<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $asistencia_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>

        <!-- CONTENIDO PRINCIPAL  -->
        <section class="content p-0 my-4">
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

            <div class="card">
                <?php
                $gestionAsistencia = $permisoAsistencia['actualizar'];
                $gestionAsistencia2 = $permisoAsistencia['eliminar'];
                $gestionAsistencia3 = $permisoAsistencia['crear'];
                $gestionAsistencia4 = $permisoAsistencia['leer'];
                ?>

                <div class="card-body table-responsive">
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="d-none"></th>
                                <th>Fecha</th>
                                <th>Nombre</th>
                                <th>Unidad de Negocio</th>
                                <th>Área</th>
                                <th>Hora Entrada</th>
                                <th>Hora Salida</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php include 'includes/data_asistencia.php';

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
                                        <?php echo $row['nombre_negocio'] ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['description'] ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $entrada . $status ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $salida ?>
                                    </td>
                                <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <?php include 'includes/footer.php'; ?>
    </div>

    <?php include 'includes/attendance_modal_comuinterna.php'; ?>
    <?php include 'includes/scripts2.php'; ?>

    <script src="js/scripts.js"></script>

    <script>
        $('.edit').on('click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            getRow(id);
            $('#edit').modal('show');
        });

        $('.delete').on('click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            getRow(id);
            $('#delete').modal('show');
        });

        function getRow(id) {
            $.ajax({
                type: 'POST',
                url: 'attendance_row.php',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    $('#datepicker_edit').val(response.date);
                    $('#attendance_date').html(response.date);
                    $('#edit_time_in').val(response.time_in);
                    $('#edit_time_out').val(response.time_out);
                    $('#attid').val(response.attid);
                    $('#employee_name').html(response.firstname + ' ' + response.lastname);
                    $('#del_attid').val(response.attid);
                    $('#del_employee_name').html(response.firstname + ' ' + response.lastname);
                }
            });
        }
    </script>
</body>

</html>