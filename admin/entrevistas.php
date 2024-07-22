<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $entrevistas_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>

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
                <div class="ms-auto">
                    <button class="button-secondary" data-bs-target="#add_entrevista" data-bs-toggle="modal">
                        <i class="fa fa-plus me-2"></i>Agregar Entrevista
                    </button>
                </div>
                <div class="card-body table-responsive" id="tabla">
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2" class="align-middle text-white fs-6" style="background-color: #54af0c;">
                                    Fecha</th>
                                <th rowspan="2" class="align-middle text-white fs-6" style="background-color: #54af0c;">
                                    Nombre</th>
                                <th colspan="8" class="text-center text-white" style="background-color: #54af0c;">
                                    Entrevista</th>
                            </tr>
                            <tr>
                                <th class="align-middle text-white" style="background-color: #1e4da9;">Estado</th>
                                <th class="align-middle text-white" style="background-color: #1e4da9;">Día</th>
                                <th class="align-middle text-white" style="background-color: #1e4da9;">Hora</th>
                                <th class="align-middle text-white" style="background-color: #1e4da9;">Asistencia</th>
                                <th class="align-middle text-white" style="background-color: #1e4da9;">Unidad</th>  
                                <th class="align-middle text-white" style="background-color: #1e4da9;">Área</th>
                                <th class="align-middle text-white" style="background-color: #1e4da9;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM entrevistas";
                            $query = $conn->query($sql);
                            while ($row = $query->fetch_assoc()) {
                                $fecha = "";
                                $hora = "";
                                if (isset($row['fecha_entrevista']) && isset($row['hora_entrevista'])) {
                                    $fecha = date('d/m/Y', strtotime($row['fecha_entrevista']));
                                    $hora = date('h:i A', strtotime($row['hora_entrevista']));
                                }

                                switch ($row["estado_entrevista"]) {
                                    case 1:
                                        $estado = "Speech enviado";
                                        break;
                                    case 2:
                                        $estado = "Practicante respondio";
                                        break;
                                    case 3:
                                        $estado = "Entrevista agendada";
                                        break;
                                        
                                    case 0:
                                        $estado = "Pendiente";
                                        break;
                                }

                                switch ($row["asistencia"]) {
                                    case 1:
                                        $asistencia = '<span class="badge bg-success text-white ms-1" style="font-size: 12px !important;">Asistió</span>';
                                        break;
                                    case 2:
                                        $asistencia = '<span class="badge bg-danger text-white ms-1" style="font-size: 12px !important;">No Asistió</span>';
                                        break;
                                    case 0:
                                        $row['estado_entrevista'] != 3
                                            ? $asistencia = '<span class="badge bg-warning text-white ms-1" style="font-size: 12px !important;">Pendiente</span>'
                                            : $asistencia = '<button class="btn btn-success btn-sm rounded-2 asistio p-1" data-id="' . $row['id'] . '">
                                                <i class="fa-solid fa-check fa-xl"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm rounded-2 falto py-1 px-2" data-id="' . $row['id'] . '">
                                                <i class="fa-solid fa-xmark fa-xl"></i>
                                            </button>';
                                        break;
                                }
                                switch ($row["unidad"]) {
                                    case 1:
                                        $unidad = "Yuntas";
                                        break;
                                    case 2:
                                        $unidad = "NHL";
                                        break;
                                    case 3:
                                        $unidad = "Tami";
                                        break;
                                        
                                    case 4:
                                        $unidad = "Digimedia";
                                        break;
                                    case 0:
                                        $unidad = "Pendiente";
                                        break;
                                }
                                switch ($row["area"]) {
                                    case 1:
                                        $area = "Comunicaciones";
                                        break;
                                    case 2:
                                        $area = "Diseño Gráfico";
                                        break;
                                    case 3:
                                        $area = "Diseño de Interiores";
                                        break;
                                        
                                    case 4:
                                        $area = "Marketing";
                                        break;
                                        
                                    case 5:
                                        $area = "Audiovisuales";
                                        break;
                                    case 0:
                                        $area = "Pendiente";
                                        break;
                                }
                                ?>
                                <tr>
                                    <td class="align-middle">
                                        <?= date('M d, Y', strtotime($row['fecha'])) ?>
                                    </td>
                                    <td class="align-middle">
                                        <?= $row['firstname'] . " " . $row['lastname'] ?>
                                    </td>
                                    <td class="align-middle">
                                        <?= $estado ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?= $fecha ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?= $hora ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?= $asistencia ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?= $unidad ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?= $area ?>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex flex-wrap justify-content-center gap-1">
                                            
                                                <button class="btn btn-success btn-sm rounded-3 edit"
                                                    data-id="<?= $row['id'] ?>">
                                                    <i class="fa fa-edit"></i> Editar
                                                </button>
                                           
                                            <button class="btn btn-danger btn-sm rounded-3 delete"
                                                data-id="<?= $row['id'] ?>">
                                                <i class="fa fa-trash"></i> Eliminar
                                            </button>
                                        </div>
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

    <!-- MODAL DE AGREGAR ENTREVISTA -->
    <div class="modal fade" id="add_entrevista" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Agregar Entrevista</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="includes/entrevista_add.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body d-flex flex-column gap-2 py-4 px-5">
                        <label for="nombres" class="fw-bolder">Nombres</label>
                        <input type="text" class="form-control rounded" id="nombres" name="nombres" required>
                        <label for="apellidos" class="fw-bolder">Apellidos</label>
                        <input type="text" class="form-control rounded" id="apellidos" name="apellidos" required>
                        <label for="unidad" class="fw-bolder">Unidad</label>
                        <select class="form-control rounded" name="unidad" id="unidad">
                                <option value=0 selected>- Seleccionar -</option>
                                <option value=1>Yuntas</option>
                                <option value=2>NHL</option>
                                <option value=3>Tami</option>
                                <option value=4>Digimedia</option>
                        </select>
                        <label for="area" class="fw-bolder">Area</label>
                        <select class="form-control rounded" name="area" id="area">
                                <option value=0 selected>- Seleccionar -</option>
                                <option value=1>Comunicaciones</option>
                                <option value=2>Diseño Grafico</option>
                                <option value=3>Diseño de Interiores</option>
                                <option value=4>Marketing</option>
                                <option value=5>Audiovisuales</option>
                            </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" name="add">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DE EDITAR ENTREVISTA-->
    <div class="modal fade" id="edit_entrevista" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Modificar Entrevista</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="includes/entrevista_edit.php">
                    <div class="modal-body d-flex flex-column gap-2 py-4 px-5">
                        <input type="hidden" class="id" name="id">

                        <div id="estado">
                            <label for="state_entrevista" class="fw-bolder">Estado de Entrevista</label>
                            <select class="form-control rounded" name="state_entrevista" id="state_entrevista">
                                <option value=0 disabled>- Seleccionar -</option>
                                <option value=1>Speech enviado</option>
                                <option value=2>Practicante respondio</option>
                                <option value=3>Entrevista agendada</option>
                            </select>
                        </div>
                        <div id="agendar"></div>
                        <div id="correccion"></div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" name="edit">
                            <i class="fa fa-edit me-2"></i>Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DE ELIMINAR ENTREVISTA -->
    <div class="modal fade" id="delete_entrevista" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Eliminar Entrevista</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center fw-bolder">
                        ¿Está seguro de eliminar la entrevista de <span id="del_entrevista" class="fw-bold"></span>?
                    </h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form method="POST" action="includes/entrevista_delete.php">
                        <input type="hidden" class="id" name="id">
                        <button type="submit" class="btn btn-danger" name="delete">
                            <i class="fa fa-trash me-2"></i>Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="asistencia_entrevista" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Confirmar Asistencia</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center fw-bolder">
                        ¿Está seguro de confirmar la <span class="label_asistencia"></span> de <span
                            id="entrevista_name" class="fw-bold"></span>?
                    </h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form method="POST" action="includes/entrevista_edit.php">
                        <input type="hidden" class="id" name="id">
                        <input type="hidden" name="asistencia" id="asistencia">
                        <button type="submit" class="btn btn-danger" name="edit">
                            <i class="fa fa-trash me-2"></i>Guardar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/scripts2.php'; ?>

    <script src="js/scripts.js"></script>

    <!-- DATA PARA MODAL -->
    <script>
        $('.edit').on("click", function (e) {
            $('#edit_entrevista').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $('.delete').on("click", function (e) {
            $('#delete_entrevista').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $('.asistio').on("click", function (e) {
            $('#asistencia_entrevista').modal('show');
            var id = $(this).data('id');
            $('#asistencia').val(1);
            $('.label_asistencia').html('asistencia');
            getRow(id);
        });

        $('.falto').on("click", function (e) {
            $('#asistencia_entrevista').modal('show');
            var id = $(this).data('id');
            $('#asistencia').val(2);
            $('.label_asistencia').html('falta');
            getRow(id);
        });

        function getRow(id) {
            $.ajax({
                type: 'POST',
                url: 'entrevista_row.php',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    $('.id').val(response.id);
                    $('#state_entrevista').val(response.estado_entrevista);
                    if ($('#state_entrevista').val() == 3) {
                        $('#estado').hide();
                        $('#agendar').html(agendar());
                        $('#correccion').html(correccion());
                        $('#date_entrevista').val(response.fecha_entrevista);
                        $('#hour_entrevista').val(response.hora_entrevista);
                        $('#state_asistencia').val(response.asistencia);
                        hora();
                    } else {
                        $('#estado').show();
                        $('#agendar').html('');
                    }
                    $('#del_entrevista').html(response.firstname + " " + response.lastname);
                    $('#entrevista_name').html(response.firstname + " " + response.lastname);
                }
            });
        }
    </script>

    <!-- HTML DE AGENDAR ENTREVISTA -->
    <script>
        function agendar() {
            return `
            <label for="date_entrevista" class="fw-bolder">Fecha Entrevista</label>
            <input type="date" class="form-control rounded" id="date_entrevista" name="date_entrevista" required>
            <label for="hour_entrevista" class="fw-bolder">Hora Entrevista</label>
            <input type="time" class="form-control rounded timepicker" id="hour_entrevista" name="hour_entrevista" required>`;
        }
        function correccion() {
            return `
            <label for="state_asistencia" class="fw-bolder">Asistencia</label>
            <select class="form-control rounded" name="state_asistencia" id="state_asistencia">
                <option value=0>- Seleccionar -</option>
                <option value=1>Asistio</option>
                <option value=2>Falto</option>
            </select>`;
        }
        function hora(){
            if($('#state_asistencia').val() != 0){
                $('#agendar').hide();
            }
        }
    </script>

    <!-- MOSTRAR AGENDAR ENTREVISTA CON SELECT -->
    <script>
        $('#state_entrevista').on('change', function () {
            this.value == 3
                ? $('#agendar').html(agendar())
                : $('#agendar').html('');
        });
    </script>
</body>