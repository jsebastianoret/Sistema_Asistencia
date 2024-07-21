<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $resumen_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>
        <?php
        $gestionResumen = $permisoResumen['leer'];
        $gestionResumen2 = $permisoResumen['accion'];

        if ($gestionResumen == "No") {
            echo '<script>window.location.replace("panel-control.php");</script>';
            exit;
        }
        ?>

        <!-- CONTENIDO PRINCIPAL -->
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
                <div class="card-body table-responsive">
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <th class="align-middle">Código de Asistencia</th>
                            <th class="align-middle">Nombre</th>
                            <th class="align-middle">Unidad de Negocio</th>
                            <th class="align-middle">Área</th>
                            <th class="align-middle">Horarios</th>
                            <th class="align-middle">Miembro Desde</th>
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
                            ON negocio.id = employees.negocio_id ";
                            $query = $conn->query($sql);

                            while ($row = $query->fetch_assoc()) { ?>
                                <tr>
                                    <td class="align-middle">
                                        <?php echo $row['employee_id'] ?>
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
                                        <?php echo date('h:i A', strtotime($row['time_in'])) . ' - ' . date('h:i A', strtotime($row['time_out'])) ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo date('M d, Y', strtotime($row['created_on'])) ?>
                                    </td>
                                    <td class="align-middle d-flex">
                                        <?php if ($gestionResumen2 == "Sí") { ?>
                                            <button class="btn btn-warning btn-sm text-white rounded-3 edit me-2"
                                                data-id="<?php echo $row['empid'] ?>" data-photo="<?php echo $row['photo'] ?>">
                                                <i class="fa fa-edit"></i> Detalles
                                            </button>
                                            <button type="button"
                                                class="btn btn-warning btn-sm text-white rounded-3 btn-justificar-faltas me-2"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                data-empid="<?php echo $row['empid']; ?>">
                                                <i class="fa fa-edit"></i> Justificar Faltas
                                            </button>
                                            <button type="button"
                                                class="btn btn-warning btn-sm text-white rounded-3 marcar_asistencia_1 me-2"
                                                data-bs-toggle="modal" data-bs-target="#modal_asistencia"
                                                data-empid="<?php echo $row['empid']; ?>">
                                                <i class="fa fa-edit"></i> Marcar Asistencia
                                            </button>
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
        <?php include 'includes/footer.php' ?>
    </div>

    <!-- MODAL DE JUSTIFICAR FALTAS -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto" id="exampleModalLabel">Justificar Faltas</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="includes/guardar_fecha_justificada.php" method="post">
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-sm-8 col-md-6 col-lg-4">
                                <div class="text-center">
                                    <input type="date" class="form-control rounded" id="fecha_justificada"
                                        name="fecha_justificada" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" name="add">
                            <i class="bi bi-check-circle-fill me-2"></i>Confirmar
                        </button>
                    </div>
                    <input type="hidden" id="employee_id" name="employee_id" value="">
                </form>

            </div>
        </div>
    </div>

    <!-- MODAL DE MARCAR ASISTENCIA -->
    <div class="modal fade" id="modal_asistencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto" id="exampleModalLabel">Marcar Asistencia</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="includes/guardar_asistencia.php" method="post">
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-sm-8 col-md-6 col-lg-4">
                                <div class="text-center">
                                    Fecha
                                    <input type="date" class="form-control rounded" id="marcar_fecha_asistencia"
                                        name="marcar_fecha_asistencia" required>
                                </div>
                                <div>
                                    Hora de Entrada
                                    <input type="time" id="hora_entrada" name="hora_entrada" required>
                                </div>
                                <div>
                                    Hora de Salida
                                    <input type="time" id="hora_salida" name="hora_salida" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" name="add">
                            <i class="bi bi-check-circle-fill me-2"></i>Confirmar
                        </button>
                    </div>
                    <input type="hidden" id="employee_id2" name="employee_id2" value="">
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DE DETALLES PRACTICANTE-->
    <div class="modal fade" id="detail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 id="employee_title" class="modal-title text-white fw-bold ms-auto"></h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row py-4 px-5">
                    <div class="col-lg-5 row g-2 mt-0 mb-4 mb-lg-0">
                        <div class="col-sm-6 col-lg-12">
                            <label for="cod_practicante" class="fw-bolder">Código de Practicante</label>
                            <input type="text" class="form-control rounded" id="cod_practicante" readonly>
                        </div>
                        <div class="col-sm-6 col-lg-12">
                            <label for="negocio" class="fw-bolder">Unidad de Negocio</label>
                            <input type="text" class="form-control rounded" id="negocio" readonly>
                        </div>
                        <div class="col-sm-6 col-lg-12">
                            <label for="cargo" class="fw-bolder">Cargo</label>
                            <input type="text" class="form-control rounded" id="cargo" readonly>
                        </div>
                        <div class="col-sm-6 col-lg-12">
                            <label for="horario" class="fw-bolder">Horario</label>
                            <input type="text" class="form-control rounded" id="horario" readonly>
                        </div>
                        <div class="col-sm-6 col-lg-12">
                            <label for="tiempo" class="fw-bolder">Tiempo (Meses)</label>
                            <input type="text" class="form-control rounded" id="tiempo" readonly>
                        </div>
                        <div class="col-sm-6 col-lg-12">
                            <label for="celular" class="fw-bolder">Celular</label>
                            <input type="text" class="form-control rounded" id="celular" readonly>
                        </div>
                        <div class="col-sm-6 col-lg-12">
                            <label for="cumpleaños" class="fw-bolder">Cumpleaños</label>
                            <input type="text" class="form-control rounded" id="cumpleaños" readonly>
                        </div>
                        <div class="col-sm-6 col-lg-12">
                            <label for="dni" class="fw-bolder">DNI</label>
                            <input type="text" class="form-control rounded" id="dni" readonly>
                        </div>
                        <div class="col-sm-6 col-lg-12">
                            <label for="email_personal" class="fw-bolder">Correo Personal</label>
                            <input type="text" class="form-control rounded" id="email_personal" readonly>
                        </div>
                        <div class="col-sm-6 col-lg-12">
                            <label for="email_institucional" class="fw-bolder">Correo Institucional</label>
                            <input type="text" class="form-control rounded" id="email_institucional" readonly>
                        </div>
                        <div class="col-sm-6 col-lg-12">
                            <label for="centro_estudios" class="fw-bolder">Centro de Estudios</label>
                            <input type="text" class="form-control rounded" id="centro_estudios" readonly>
                        </div>
                        <div class="col-sm-6 col-lg-12">
                            <label for="carrera" class="fw-bolder">Carrera</label>
                            <input type="text" class="form-control rounded" id="carrera" readonly>
                        </div>
                        <div class="col-sm-6 col-lg-12">
                            <label for="fecha_ingreso" class="fw-bolder">Fecha Ingreso</label>
                            <input type="text" class="form-control rounded" id="fecha_ingreso" readonly>
                        </div>
                        <div class="col-sm-6 col-lg-12">
                            <label for="fecha_salida" class="fw-bolder">Fecha Salida</label>
                            <input type="text" class="form-control rounded" id="fecha_salida" readonly>
                        </div>
                        <div class="col-sm-6 col-lg-12">
                            <label for="fecha_salida_nueva" class="fw-bolder">Nueva Fecha de Salida</label>
                            <input type="text" class="form-control rounded" id="fecha_salida_nueva" readonly>
                        </div>
                    </div>
                    <div class="col-lg-7 d-flex flex-column justify-content-between align-items-center gap-3 ps-sm-4">
                        <div class="text-center">
                            <p class="fw-bolder fs-6 mb-2">Foto de Perfil</p>
                            <img src="../images/profile.jpg" id="foto_perfil" width="200px" height="200px">
                        </div>
                        <canvas id="myChart" class="p-3"></canvas>
                        <div class="row g-3 d-flex justify-content-center">
                            <div class="text-center">
                                <label for="sum_num_hr" class="fw-bolder">Horas de Trabajo</label>
                                <input type="text" class="form-control text-center rounded" id="sum_num_hr" readonly>
                            </div>
                            <div class="col-sm-4 text-center">
                                <label for="dias_trabajados" class="fw-bolder">Asistencia</label>
                                <input type="text" class="form-control text-center rounded" id="dias_trabajados"
                                    readonly>
                            </div>
                            <div class="col-sm-4 text-center">
                                <label for="dias_faltados" class="fw-bolder">Faltas</label>
                                <input type="text" class="form-control text-center rounded" id="dias_faltados" readonly>
                            </div>
                            <div class="col-sm-4 text-center">
                                <label for="dias_tardados" class="fw-bolder">Tardanzas</label>
                                <input type="text" class="form-control text-center rounded" id="dias_tardados" readonly>
                            </div>
                            <div class="col-sm-4 text-center">
                                <label for="faltas_justificadas" class="fw-bolder">Faltas Justificadas</label>
                                <input type="text" class="form-control text-center rounded" id="faltas_justificadas"
                                    readonly>
                            </div>
                            <div class="col-sm-4 text-center">
                                <label for="faltas_injustificadas" class="fw-bolder">Faltas Injustificadas</label>
                                <input type="text" class="form-control text-center rounded" id="faltas_injustificadas"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/scripts2.php'; ?>

    <script src="js/scripts.js"></script>

    <!-- DATA PARA MODAL -->
    <script>
        var dato_salida;
        var id_user;
        $('.edit').click(function (e) {
            e.preventDefault();
            $('#detail').modal('show');
            var id = $(this).data('id');
            var photo = $(this).data('photo');
            getRow(id);
            showProfileImage(photo);
        });

        function getRow(id) {
            $.ajax({
                type: 'POST',
                url: 'schedule_employee_row.php',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    $('#employee_title').html(response.firstname + ' ' + response.lastname);
                    $('#cod_practicante').val(response.employee_id);
                    $('#negocio').val(response.nombre_negocio);
                    $('#cargo').val(response.description);
                    $('#horario').val(response.schedule_id).val(response.time_in + ' - ' + response.time_out);
                    $('#tiempo').val(response.time_practice + ' meses');
                    $('#celular').val(response.contact_info);
                    $('#cumpleaños').val(response.birthday);
                    $('#dni').val(response.dni);
                    $('#email_personal').val(response.personal_email);
                    $('#email_institucional').val(response.institutional_email);
                    $('#centro_estudios').val(response.university);
                    $('#carrera').val(response.career);
                    $('#fecha_ingreso').val(response.date_in);
                    $('#fecha_salida').val(response.date_out);
                    $('#employee_id').val(response.empid);
                    $('#employee_id2').val(response.empid);
                    dato_salida=response.date_out;
                    id_user=response.empid;
                    // Obtener la suma total de horas de trabajo del empleado
                    $.ajax({
                        type: 'POST',
                        url: 'get_total_hours.php',
                        data: { employee_id: response.empid },
                        dataType: 'json',
                        success: function (response) {
                            $('#sum_num_hr').val(parseFloat(response.total_hours).toFixed(2));
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: 'get_cantidad_asistencia.php',
                        data: { employee_id: response.empid },
                        dataType: 'json',
                        success: function (response) {
                            $('#dias_trabajados').val(response.cantidad_asistencia);
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: 'get_cantidad_faltas.php',
                        data: { employee_id: response.empid },
                        dataType: 'json',
                        success: function (response) {
                            $('#dias_faltados').val(response.cantidad_faltas);
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: 'get_cantidad_tardanzas.php',
                        data: { employee_id: response.empid },
                        dataType: 'json',
                        success: function (response) {
                            $('#dias_tardados').val(response.cantidad_tardanzas);
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: 'get_cantidad_faltas_justificadas_injustificadas.php',
                        data: { employee_id: response.empid },
                        dataType: 'json',
                        success: function (response) {
                            $('#faltas_injustificadas').val(response.faltas_injustificadas),
                                $('#faltas_justificadas').val(response.faltas_justificadas);
                            var totalFaltas = parseInt(response.faltas_injustificadas) + parseInt(response.faltas_justificadas);
                            $('#dias_faltados').val(totalFaltas);
                            let faltaInjustificadas=response.faltas_injustificadas;
                            salidaNew(dato_salida,faltaInjustificadas,id_user);
                        }
                    });
                }
            });
        }

        $('body').on('click', '.btn-justificar-faltas', function () {
            var empId = $(this).data('empid');
            console.log(empId);
            $('#employee_id').val(empId);
        });

        $('body').on('click', '.marcar_asistencia_1', function () {
            var empId = $(this).data('empid');
            console.log(empId);
            $('#employee_id2').val(empId);
        });

        function salidaNew(dato_salida,faltaInjustificadas,id_user){
            var partesFecha = dato_salida.split('-');
            var año = parseInt(partesFecha[0]);
            var mes = parseInt(partesFecha[1]) - 1; 
            var dia = parseInt(partesFecha[2]);
            var nueva_fechaSalida = new Date(año, mes, dia);
            nueva_fechaSalida.setDate(nueva_fechaSalida.getDate() + parseInt(faltaInjustificadas));
            var nueva_fecha_salida_formateada = nueva_fechaSalida.toISOString().slice(0, 10);
            $('#fecha_salida_nueva').val(nueva_fecha_salida_formateada);
            
            $.ajax({
                type: 'POST',
                url: 'insert_new_out.php',
                data: { employee_id: id_user, new_out:nueva_fecha_salida_formateada },
                dataType: 'json',
                success: function (response) {

                }
            });
        }


        function showProfileImage(photo) {
            var imageSrc = photo ? "../images/" + photo : "../images/profile.jpg";
            $('#foto_perfil').attr('src', imageSrc);
        }

        $('#detail').on('shown.bs.modal', function () {
            const diasTrabajados = parseInt($('#dias_trabajados').val());
            const diasFaltados = parseInt($('#dias_faltados').val());
            const diasTardados = parseInt($('#dias_tardados').val());

            const myChart = Chart.getChart('myChart');
            if (myChart) {
                myChart.destroy();
            }

            const ctx = document.getElementById('myChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Faltas', 'Asistencias', 'Tardanzas'],
                    datasets: [{
                        label: 'Días',
                        data: [diasFaltados, diasTrabajados, diasTardados],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>