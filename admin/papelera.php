<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $papelera_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>
        <?php
        $gestionPapelera = $permisoPapelera['leer'];
        $gestionPapelera2 = $permisoPapelera['accion'];

        if ($gestionPapelera == "No") {
            echo '<script>window.location.replace("panel-control.php");</script>';
            exit;
        }
        ?>

        <!-- CONTENIDO PRINCIPAL  -->
        <section class="content p-0 my-4">
        <?php
                            $sql = "SELECT *, papelera.id AS paid
                                    FROM papelera
                                    LEFT JOIN position
                                    ON position.id = papelera.position_id
                                    LEFT JOIN schedules
                                    ON schedules.id = papelera.schedule_id
                                    LEFT JOIN negocio
                                    ON negocio.id = papelera.negocio_id";

//FILTRO PRACTICANTES
$filter = (isset($_POST['filter'])) ? $_POST['filter'] : 'all'; 

if ($filter !== 'all') {
    $today = date('Y-m-d');
    $four_months_ago = date('Y-m-d', strtotime('-4 month', strtotime($today)));
    $sql .= " WHERE ";
    if ($filter === 'last_4_months') {
        $sql .= "created_on >= '$four_months_ago'";
    } else { 
        $sql .= "created_on < '$four_months_ago'";
    }
}

                            $query = $conn->query($sql);

                            ?>
        
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
            <div class="d-flex justify-content-end mb-3">
    </div>
            <div class="card">

            
            <div class="card-1">
    <h3 class="card-title">Filtro Practicantes</h3>
    <div class="card-tools">
        <form action="" method="post" class="d-flex" id="filterForm">
            <select name="filter" class="form-select mx-2" onchange="document.getElementById('filterForm').submit()">
                <option value="all" <?= ($filter === 'all') ? 'selected' : '' ?>>All</option>
                <option value="last_4_months" <?= ($filter === 'last_4_months') ? 'selected' : '' ?>>Últimos 4 meses</option>
                <option value="more_than_4_months" <?= ($filter === 'more_than_4_months') ? 'selected' : '' ?>>Más de 4 meses</option>
            </select>
        </form>
    </div>
</div>

        

                <div class="card-body table-responsive">
                    
                    <table id="example1" class="table table-bordered">
                        
                        <thead>
                            <th class="align-middle text-center">Código de Asistencia</th>
                            <th class="align-middle text-center">Foto</th>
                            <th class="align-middle text-center">Nombre</th>
                            <th class="align-middle text-center">Unidad de Negocio</th>
                            <th class="align-middle text-center">Área</th>
                            <th class="align-middle text-center">Horarios</th>
                            <th class="align-middle text-center">Acción</th>
                        </thead>
                        
                        <tbody>
                            
                            <?php                         

                            $query = $conn->query($sql);

                            while ($row = $query->fetch_assoc()) 
                            { ?>
                            
                                <tr>
                                    <td class="align-middle">
                                        <?= $row['employee_id'] ?>
                                    </td>
                                    <td class="align-middle">
                                        <img src="<?= (!empty($row['photo'])) ? '../images/' . $row['photo'] : '../images/profile.jpg'; ?>"
                                            width="30px" height="30px">
                                    </td>
                                    <td class="align-middle">
                                        <?= $row['firstname'] . ' ' . $row['lastname'] ?>
                                    </td>
                                    <td class="align-middle">
                                        <?= $row['nombre_negocio'] ?>
                                    </td>
                                    <td class="align-middle">
                                        <?= $row['description'] ?>
                                    </td>
                                    <td class="align-middle">
                                        <?= date('h:i A', strtotime($row['time_in'])) . ' - ' . date('h:i A', strtotime($row['time_out'])); ?>
                                    </td>
                                    <?php if ($gestionPapelera2 == "Sí") { ?>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                                <button class="btn btn-success btn-sm text-white rounded-3 restore"
                                                    data-id="<?= $row["paid"] ?>">
                                                    <i class="fa-solid fa-rotate-left"></i> Restaurar
                                                </button>
                                                <button class="btn btn-danger btn-sm text-white rounded-3 delete"
                                                    data-id="<?= $row["paid"] ?>">
                                                    <i class="fa fa-trash"></i> Eliminar
                                                </button>
                                            </div>
                                            <div class="d-flex flex-wrap gap-1 justify-content-center mt-1">
                                                <button class="btn btn-warning btn-sm text-white rounded-3 details"
                                                    data-id="<?= $row['paid'] ?>">
                                                    <i class="fa fa-edit"></i> Detalles
                                                </button>
                                            </div>
                                        </td>
                                    <?php } 
                                    ?>
                                </tr>
                            <?php }
                             ?>
                        </tbody>
                    </table>
                    
                </div>
                
                
            </div>
        </section>
        

        <!-- FOOTER -->
        <?php include 'includes/footer.php'; ?>
    </div>

    <!-- MODAL DE RESTAURAR PRACTICANTE -->
    <div class="modal fade" id="restore_practicante" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Restaurar Practicante</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center fw-bolder">
                        Restaurar a <span id="res_employee_name" class="fw-bold"></span>
                    </h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form method="POST" action="includes/papelera_restore.php">
                        <input type="hidden" id="res_paid" name="paid">
                        <button type="submit" class="btn btn-success" name="restore">
                            <i class="fa-solid fa-rotate-left me-2"></i>Restaurar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DE ELIMINAR PRACTICANTE -->
    <div class="modal fade" id="delete_practicante" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Eliminar Permanente</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center fw-bolder">
                        ¿Está seguro de eliminar permanentemente a <span id="del_employee_name" class="fw-bold"></span>?
                    </h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form method="POST" action="includes/papelera_delete.php">
                        <input type="hidden" id="del_paid" name="paid">
                        <button type="submit" class="btn btn-danger" name="delete">
                            <i class="fa fa-trash me-2"></i>Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DE DETALLES DE PRACTICANTE -->
    <div class="modal fade" id="detail_practicante" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-xl" style="min-width: 95%;">
            <div class="modal-content rounded-3">
                <div class="modal-header py-0">
                    <div class="d-flex align-items-center gap-3">
                        <h4 class="fw-bolder text-white mb-0 mx-2">Evaluaciones</h4>
                        <button id="calificacion" class="nav-button active">
                            <span>CALIFICACIÓN</span>
                        </button>
                        <button id="asistencia" class="nav-button">
                            <span>ASISTENCIA</span>
                        </button>
                        <!-- <button id="test" class="nav-button">
                            <span>TEST</span>
                        </button> -->
                    </div>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex p-4">
                    <div class="row g-3">
                        <section class="col-md-6 col-lg-5 col-xl-4 col-xxl-3 d-flex flex-column gap-3">
                            <div class="card">
                                <div class="overflow-hidden rounded-3 p-3"
                                    style="background-image: url('../images/cielo3.webp');">
                                    <h5 id="name_practicante" class="text-center fw-bolder mb-3"
                                        style="color: #1e3d8f;">
                                    </h5>
                                    <div class="d-flex justify-content-between gap-3">
                                        <div class="row gap-3">
                                            <div class="row gap-1">
                                                <span id="type_practice" style="color: #1e3d8f;"></span>
                                                <span id="position" style="color: #1e3d8f;"></span>
                                                <span id="negocio" style="color: #1e3d8f;"></span>
                                            </div>
                                            <div class="d-flex flex-wrap gap-3">
                                                <div class="fecha-practicante d-flex align-items-center gap-2">
                                                    <p class="mb-0">Ingreso</p>
                                                    <div class="d-flex gap-2 bg-light border border-black"
                                                        style="height: fit-content;">
                                                        <p id="inicio_dia"
                                                            class="border-end border-black bg-white px-1 mb-0"></p>
                                                        <p id="inicio_mes"
                                                            class="border-start border-end border-black bg-white px-1 mb-0">
                                                        </p>
                                                        <p id="inicio_año"
                                                            class="border-start border-black bg-white px-1 mb-0"></p>
                                                    </div>
                                                </div>
                                                <div class="fecha-practicante d-flex align-items-center gap-2">
                                                    <p class="mb-0">Salida</p>
                                                    <div class="d-flex gap-2 bg-light border border-black"
                                                        style="height: fit-content;">
                                                        <p id="fin_dia"
                                                            class="border-end border-black bg-white px-1 mb-0">
                                                        </p>
                                                        <p id="fin_mes"
                                                            class="border-start border-end border-black bg-white px-1 mb-0">
                                                        </p>
                                                        <p id="fin_año"
                                                            class="border-start border-black bg-white px-1 mb-0"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="width: 130px;">
                                            <img id="avatar" src="" alt="Imagen Avatar">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="row justify-content-center g-3">
                                    <div class="px-4 px-sm-5 d-flex justify-content-center">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                    <div class="row g-3">
                                        <div class="text-center">
                                            <label for="sum_num_hr" class="fw-bolder">Horas de Trabajo</label>
                                            <input type="text" class="form-control text-center rounded" id="sum_num_hr"
                                                readonly>
                                        </div>
                                        <div class="col-sm-4 text-center">
                                            <label for="dias_trabajados" class="fw-bolder">Asistencia</label>
                                            <input type="text" class="form-control text-center rounded"
                                                id="dias_trabajados" readonly>
                                        </div>
                                        <div class="col-sm-4 text-center">
                                            <label for="dias_faltados" class="fw-bolder">Faltas</label>
                                            <input type="text" class="form-control text-center rounded"
                                                id="dias_faltados" readonly>
                                        </div>
                                        <div class="col-sm-4 text-center">
                                            <label for="dias_tardados" class="fw-bolder">Tardanzas</label>
                                            <input type="text" class="form-control text-center rounded"
                                                id="dias_tardados" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="col-md-6 col-lg-7 col-xl-8 col-xxl-9">
                            <!-- VISTA CALIFICACIÓN -->
                            <div id="view_calificacion" class="card">
                                <div class="card-body table-responsive">
                                    <h5 class="fw-bold mb-3">NOTAS MENSUALES POR CRITERIO</h5>
                                    <table class="table table-bordered m-0">
                                        <thead></thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- VISTA ASISTENCIA -->
                            <div id="view_asistencia" class="card d-none">
                                <div class="card-body table-responsive">
                                    <table id="example2" class="table table-bordered w-100">
                                        <thead>
                                            <tr>
                                                <th class="d-none"></th>
                                                <th>Fecha</th>
                                                <th>Hora Entrada</th>
                                                <th>Hora Salida</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- VISTA TEST -->
                            <div id="view_test" class="card d-none">
                                <div class="card-body table-responsive">
                                    TEST
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/scripts2.php'; ?>

    <script src="js/scripts.js"></script>

    <!-- DATA PARA MODAL -->
    <script>
        $('.restore').on("click", function (e) {
            $('#restore_practicante').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $('.delete').on("click", function (e) {
            $('#delete_practicante').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $('.details').on("click", function (e) {
            $('#detail_practicante').modal('show');
            var id = $(this).data('id');
            getPracticante(id);
            getCalificacion(id);
            getAsistencia(id);
        });

        function getRow(id) {
            $.ajax({
                type: 'POST',
                url: 'papelera_row.php',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    $('#res_paid').val(response.paid);
                    $('#del_paid').val(response.paid);
                    $('#del_employee_name').html(response.firstname + ' ' + response.lastname);
                    $('#res_employee_name').html(response.firstname + ' ' + response.lastname);
                }
            });
        }

        function getPracticante(id) {
            $.ajax({
                type: 'POST',
                url: 'papelera_row.php',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    var inicio = response.date_in.split('-');
                    var fin = response.date_out.split('-');

                    $('#name_practicante').html(response.firstname + ' ' + response.lastname);
                    $('#type_practice').html(response.type_practice);
                    $('#position').html(response.description);
                    $('#negocio').html(response.nombre_negocio);
                    $('#inicio_dia').html(inicio[2]);
                    $('#inicio_mes').html(inicio[1]);
                    $('#inicio_año').html(inicio[0][2] + inicio[0][3]);
                    $('#fin_dia').html(fin[2]);
                    $('#fin_mes').html(fin[1]);
                    $('#fin_año').html(fin[0][2] + fin[0][3]);

                    if (response.nombre_negocio == 'DIGIMEDIA') {
                        if (response.gender == 'Female') {
                            $("#avatar").attr('src', 'PERSONAJES/DIGIMEDIA MARKETING/DIGIMEDIA.webp');
                        } else {
                            $("#avatar").attr('src', 'PERSONAJES/DIGIMEDIA MARKETING/DIGIMEDIA HOMBRE.webp');
                        }
                    } else if (response.nombre_negocio == 'NHL') {
                        if (response.gender == 'Female') {
                            $("#avatar").attr('src', 'PERSONAJES/NHL SAC/NHL SAC ADMINS.webp');
                        } else {
                            $("#avatar").attr('src', 'PERSONAJES/NHL SAC/NHL SAC HOMBRE.webp');
                        }
                    } else if (response.nombre_negocio == 'VAPING') {
                        if (response.gender == 'Female') {
                            $("#avatar").attr('src', 'PERSONAJES/VAPING CLOUD/MUJER.webp');
                        } else {
                            $("#avatar").attr('src', 'PERSONAJES/VAPING CLOUD/HOMBRE VAPING.webp');
                        }
                    } else if (response.nombre_negocio == 'YUNTAS') {
                        if (response.gender == 'Female') {
                            $("#avatar").attr('src', 'PERSONAJES/YUNTAS PRODUCCIONES/YUNTAS.webp');
                        } else {
                            $("#avatar").attr('src', 'PERSONAJES/YUNTAS PRODUCCIONES/YUNTAS HOMBRE.webp');
                        }
                    } else {
                        if (response.gender == 'Female') {
                            $("#avatar").attr('src', 'PERSONAJES/VAPING CLOUD/MUJER.webp');
                        } else {
                            $("#avatar").attr('src', 'PERSONAJES/VAPING CLOUD/HOMBRE VAPING.webp');
                        }
                    }

                    $.ajax({
                        type: 'POST',
                        url: 'get_total_hours.php',
                        data: { employee_id: response.paid },
                        dataType: 'json',
                        success: function (response) {
                            $('#sum_num_hr').val(parseFloat(response.total_hours).toFixed(2));
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: 'get_cantidad_asistencia.php',
                        data: { employee_id: response.paid },
                        dataType: 'json',
                        success: function (response) {
                            $('#dias_trabajados').val(response.cantidad_asistencia);
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: 'get_cantidad_faltas.php',
                        data: { employee_id: response.paid },
                        dataType: 'json',
                        success: function (response) {
                            $('#dias_faltados').val(response.cantidad_faltas);
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: 'get_cantidad_tardanzas.php',
                        data: { employee_id: response.paid },
                        dataType: 'json',
                        success: function (response) {
                            $('#dias_tardados').val(response.cantidad_tardanzas);
                        }
                    });
                }
            });
        }
    </script>

    <!-- CAMBIAR DE TABS -->
    <script>
        $('.nav-button').on('click', function (e) {
            $(this).parent().children('.nav-button').removeClass('active');
            $(this).addClass('active');

            if ($(this).attr('id') == 'calificacion') {
                $('.modal-body section:last-child').children().addClass('d-none');
                $('#view_calificacion').removeClass('d-none');
            } else if ($(this).attr('id') == 'asistencia') {
                $('.modal-body section:last-child').children().addClass('d-none');
                $('#view_asistencia').removeClass('d-none');
            } else if ($(this).attr('id') == 'test') {
                $('.modal-body section:last-child').children().addClass('d-none');
                $('#view_test').removeClass('d-none');
            }
        });
    </script>

    <!-- GRAFICO DE DONA -->
    <script>
        $('#detail_practicante').on('shown.bs.modal', function () {
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

    <!-- DATA PARA TABLA CALIFICACION -->
    <script>
        function getCalificacion(id) {
            $('#view_calificacion tbody').empty();
            $('#view_calificacion thead').empty();

            $.ajax({
                type: 'POST',
                url: 'includes/data_notas.php',
                data: { paid: id },
                dataType: 'json',
                success: function (response) {
                    $('#view_calificacion thead').append(`
                        <tr>
                            <th class="align-middle text-center text-white fs-6 border-secondary" style="background-color: #1e4da9; width: 300px;">
                                Criterios
                            </th>
                            ${response[0].notas.map((nota, index) => {
                        return `<th class="align-middle text-center text-white fs-6 border-secondary" style="background-color: #54af0c;">MES ${index + 1}</th>`
                    })}</tr>`);

                    response.map((row, index) => {
                        $('#view_calificacion tbody').append(`
                            <tr>
                                <td class="align-middle text-center border-secondary text-uppercase fs-6">
                                    ${index + 1}. Promedios ${row.nombre}
                                </td>
                                ${row.notas.map(nota => {
                            return `<td class="align-middle text-center border-secondary fs-6">${nota}</td>`
                        })}</tr>`);
                    });

                    $('#view_calificacion tbody').append(`
                        <tr>
                            <th class="align-middle text-center text-white border-secondary fs-6" style="background-color: #1e4da9;">
                                TOTAL PROMEDIO
                            </th>
                            ${response[0].notas.map((nota, index) => {
                        return `<th class="align-middle text-center text-white border-secondary fs-6" style="background-color: #1e4da9;">
                            ${response.reduce((total, row) => total + row.notas[index] / 3, 0).toFixed(2)}
                        </th>`
                    })}</tr>`);
                }
            })
        }
    </script>

    <!-- DATA PARA TABLA ASISTENCIA -->
    <script>
        function getAsistencia(id) {
            $.ajax({
                type: 'POST',
                url: 'includes/data_asistencia.php',
                data: { paid: id },
                dataType: 'json',
                success: function (response) {
                    const optionsDate = { year: 'numeric', month: 'short', day: 'numeric' };
                    const optionsTime = { hour: '2-digit', minute: '2-digit', hour12: true };

                    $('#example2').DataTable({
                        pageLength: 14,
                        responsive: true,
                        destroy: true,
                        lengthMenu: [
                            [14, 28, 42, -1],
                            [14, 28, 42, "All"]
                        ],
                        ajax: {
                            url: 'includes/data_asistencia.php',
                            type: 'POST',
                            data: { paid: id },
                            dataType: 'json',
                            success: function (response) {
                                $("#example2").DataTable().clear();
                                $.each(response, function (index, value) {
                                    value.date != null
                                        ? fecha = new Date(value.date).toLocaleDateString('es-MX', optionsDate)
                                        : fecha = 'NO MARCO';
                                    value.time_in != null
                                        ? entrada = new Date(value.date + ' ' + value.time_in).toLocaleTimeString('en', optionsTime)
                                        : entrada = 'NO MARCO';
                                    value.time_out != null
                                        ? salida = new Date(value.date + ' ' + value.time_out).toLocaleTimeString('en', optionsTime)
                                        : salida = 'NO MARCO';

                                    value.status_v1 == 1
                                        ? status = '<span class="badge bg-success ms-1" style="font-size: 11px !important;">A Tiempo</span>'
                                        : value.status_v1 == 0
                                            ? status = '<span class="badge bg-warning text-dark ms-1" style="font-size: 11px !important;">Tarde</span>'
                                            : status = '<span class="badge bg-danger ms-1" style="font-size: 11px !important;">No Marco</span>';

                                    $('#example2').dataTable().fnAddData([
                                        '',
                                        fecha,
                                        entrada + status,
                                        salida,
                                    ]);
                                });

                                $('#example2').DataTable().rows().nodes().to$().find('td:first-child').addClass('d-none');
                                $('#example2').DataTable().rows().nodes().to$().find('td').addClass('align-middle');
                            }
                        },
                    });
                }
            });
        }
    </script>
</body>