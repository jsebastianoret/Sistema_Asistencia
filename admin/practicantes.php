<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $practicantes_click = "clicked" ?>
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

            <?php
            include 'includes/gestion_practicantes.php';
            $gestionPracticantes = $permisoPracticantes['leer'];
            $gestionPracticantes2 = $permisoPracticantes['crear'];
            $gestionPracticantes3 = $permisoPracticantes['actualizar'];
            $gestionPracticantes4 = $permisoPracticantes['eliminar'];
            $gestionPracticantes5 = $permisoPracticantes['agregar_notas'];
            $gestionPracticantes6 = $permisoPracticantes['ver_notas'];
            $gestionPracticantes7 = $permisoPracticantes['hora_extra'];
            ?>
            <div class="card">
                <?php if ($gestionPracticantes2 == "Sí") { ?>
                    <div class="ms-auto">
                        <button class="button-secondary" data-bs-target="#add_practicante" data-bs-toggle="modal">
                            <i class="fa fa-plus me-2"></i>Nuevo Practicante
                        </button>
                    </div>
                <?php } ?>
                <div class="card-body table-responsive">
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <th class="align-middle">Código de Asistencia</th>
                            <th class="align-middle">Foto</th>
                            <th class="align-middle">Nombre</th>
                            <th class="align-middle">Unidad de Negocio</th>
                            <th class="align-middle">Área</th>
                            <th class="align-middle">Departamento</th>
                            <th class="align-middle">Horarios</th>
                            <th class="align-middle">Acción</th>
                            <th class="align-middle">Acción 2</th>
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
                                 ON negocio.id = employees.negocio_id
                                 LEFT JOIN departamentos
                                 ON departamentos.id = employees.departamento_id";
                            $query = $conn->query($sql);

                            while ($row = $query->fetch_assoc()) { ?>
                                <tr>
                                    <td class="align-middle">
                                        <?= $row['employee_id']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <img src="<?= (!empty($row['photo'])) ? '../images/' . $row['photo'] : '../images/profile.jpg'; ?>" width="30px" height="30px">
                                    </td>
                                    <td class="align-middle">
                                        <?= $row['firstname'] . ' ' . $row['lastname']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?= $row['nombre_negocio']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?= $row['description']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?= $row['nombre_departamento']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?= date('h:i A', strtotime($row['time_in'])) . ' - ' . date('h:i A', strtotime($row['time_out'])); ?>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex flex-wrap justify-content-center gap-1">
                                            <?php if ($gestionPracticantes3 == "Sí") { ?>
                                                <button class="btn btn-success btn-sm rounded-3 edit" data-id="<?= $row['empid'] ?>">
                                                    <i class="fa fa-edit"></i> Editar
                                                </button>
                                            <?php } ?>
                                            <?php if ($gestionPracticantes4 == "Sí") { ?>
                                                <button class="btn btn-danger btn-sm rounded-3 delete" data-id="<?= $row['empid'] ?>">
                                                    <i class="fa fa-trash"></i> Eliminar
                                                </button>
                                            <?php } ?>
                                        </div>
                                        <div class="d-flex flex-wrap justify-content-center gap-1 mt-1">
                                            <?php
                                            if ($user['id'] == 1) {
                                                $gestionPracticantes5 = "Sí";
                                            } else if ($user['id'] == 2 && ($row['position_id'] == 11 || $row['position_id'] == 13)) {
                                                $gestionPracticantes5 = "Sí";
                                            } else if ($user['id'] == 4 && $row['position_id'] == 13) {
                                                $gestionPracticantes5 = "Sí";
                                            } else if ($user['id'] == 5 && $row['position_id'] == 2) {
                                                $gestionPracticantes5 = "Sí";
                                            } else if ($user['id'] == 3 && !($row['position_id'] == 1 || $row['position_id'] == 2 || $row['position_id'] == 11 || $row['position_id'] == 13)) {
                                                $gestionPracticantes5 = "Sí";
                                            } else if ($user['id'] == 6 && $row['position_id'] == 7) {
                                                $gestionPracticantes5 = "Sí";
                                            } else {
                                                $gestionPracticantes5 = "No";
                                            }

                                            if ($gestionPracticantes5 == "Sí") { ?>
                                                <button class="btn btn-primary btn-sm rounded-3 add" data-id="<?= $row['empid'] ?>">
                                                    <i class="fa fa-pencil"></i> Agregar Nota
                                                </button>
                                            <?php } ?>
                                            <?php if ($gestionPracticantes6 == "Sí") { ?>
                                                <a href="practicante-notas.php?id=<?= $row['empid'] ?>&nombre=<?= urlencode($row['firstname'] . ' ' . $row['lastname']) ?>&negocio=<?= urlencode($row['nombre_negocio']) ?>&position=<?= urldecode($row['description']) ?>&fecha_inicio=<?= urldecode($row['date_in']) ?>&fecha_fin=<?= urldecode($row['date_out']) ?>&codigo_practicante=<?= $row['employee_id'] ?>&id_practicante=<?= $row['empid'] ?>" class="btn btn-warning btn-sm rounded-3 text-white">
                                                    <i class="fa fa-eye"></i> Ver Notas
                                                </a>
                                            <?php } ?>
                                            <?php if ($gestionPracticantes7 == "Sí") { ?>
                                                <button class="btn btn-primary btn-sm rounded-3 hora_extra" data-id="<?php echo htmlspecialchars($row['empid']); ?>">
                                                    <i class="fa fa-clock"></i> Horas Extra
                                                </button>
                                            <?php } ?>
                                            <button class="btn btn-info btn-sm rounded-3 text-light activities" data-id="<?= $row['empid'] ?>">
                                                <i class="fa-solid fa-list-check"></i> Actividades
                                            </button>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button class="btn btn-success btn-sm rounded-3" data-id="<?= $row['empid'] ?>">
                                            <i class="fa fa-edit"></i> Convers
                                        </button>
                                        <button type="submit" name="memo_id" value="<?= $row['empid'] ?>" class="btn btn-danger btn-sm rounded-3 mt-1 editar" data-id="<?= $row['empid'] ?>">
                                            <i class="fa fa-edit"></i> Memos
                                        </button>



                                        <div class="modal fade" id="editar_entrevista" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
                                            <div class="modal-dialog modal-md">
                                                <div class="modal-content rounded-3">
                                                    <div class="modal-header py-2">
                                                        <h4 class="modal-title text-white fw-bold ms-auto">Documentos</h4>
                                                        <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form id="documentoForm" method="post" action="includes/generate-doc.php">
                                                        <div class="modal-body d-flex flex-column gap-2 py-4 px-5">
                                                            <input type="hidden" class="id" name="id" value="<?= $row['empid'] ?>">
                                                            <div id="estado1">
                                                                <label for="state_entrevista" class="fw-bolder">Seleccione documento</label>
                                                                <select class="form-control rounded" name="documento_tipo" id="documento_tipo">
                                                                    <option value=0 disabled>- Seleccionar -</option>
                                                                    <option value="memorandum">Memorandum</option>
                                                                    <option value="carta_despido">Carta de despido</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                            <button type="submit" class="btn btn-success" name="edit">
                                                                <i class="fa fa-edit me-2"></i>Generar documento
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
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




    <script>
        document.getElementById('documentoForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Get selected document type
            var documentType = document.getElementById('documento_tipo').value;

            // Perform additional validation or processing as needed

            // Submit the form using AJAX
            var formData = new FormData(this);
            fetch('generate-doc.php', {
                    method: 'POST',
                    body: formData

                })
                .then(response => response.text())
                .then(data => {
                    if (data.includes('success')) { // Check for success message
                        $('#modalExitoso').modal('show'); // Show success modal if successful
                    } else {
                        console.error(error);
                        alert('An error occurred. Please try again later.');
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('An error occurred. Please try again later.');
                });
        });
    </script>

    <!-- MODAL DE AGREGAR PRACTICANTE -->
    <div class="modal fade" id="add_practicante" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Agregar Practicante</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="includes/practicantes_add.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body d-flex flex-column gap-2 py-4 px-5">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="date_in" class="fw-bolder">Fecha Ingreso</label>
                                <input type="date" class="form-control rounded" id="date_in" name="date_in" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="date_out" class="fw-bolder">Fecha Salida</label>
                                <input type="date" class="form-control rounded" id="date_out" name="date_out" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="time_practice" class="fw-bolder">Tiempo (meses)</label>
                                <select class="form-control rounded" name="time_practice" id="time_practice" required>
                                    <option value="" selected disabled>- Seleccionar -</option>
                                    <option value="3">3 meses</option>
                                    <option value="4">4 meses</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="type_practice" class="fw-bolder">Tipo</label>
                                <select class="form-control rounded" name="type_practice" id="type_practice" required>
                                    <option value="" selected disabled>- Seleccionar -</option>
                                    <option value="Pre Profesionales">Pre Profesionales</option>
                                    <option value="Profesionales">Profesionales</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="dni" class="fw-bolder">DNI</label>
                                <input type="text" class="form-control rounded" id="dni" name="dni" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="contact" class="fw-bolder">Celular</label>
                                <input type="text" class="form-control rounded" id="contact" name="contact">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="firstname" class="fw-bolder">Nombre</label>
                                <input type="text" class="form-control rounded" id="firstname" name="firstname" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="lastname" class="fw-bolder">Apellido</label>
                                <input type="text" class="form-control rounded" id="lastname" name="lastname" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="gender" class="fw-bolder">Género</label>
                                <select class="form-control rounded" name="gender" id="gender" required>
                                    <option value="" selected disabled>- Seleccionar -</option>
                                    <option value="Male">Hombre</option>
                                    <option value="Female">Mujer</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="birthday" class="fw-bolder">Cumpleaños</label>
                                <input type="date" class="form-control rounded" id="birthday" name="birthday" required>
                            </div>
                            <div class="col-sm-8">
                                <label for="photo" class="fw-bolder">Foto</label>
                                <input type="file" class="form-control rounded" id="photo" name="photo">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="personal_email" class="fw-bolder">Correo Personal</label>
                                <input type="email" class="form-control rounded" id="personal_email" name="personal_email" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="institutional_email" class="fw-bolder">Correo Institucional</label>
                                <input type="email" class="form-control rounded" id="institutional_email" name="institutional_email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="university" class="fw-bolder">Centro de Estudios</label>
                                <input type="text" class="form-control rounded" id="university" name="university" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="career" class="fw-bolder">Carrera</label>
                                <input type="text" class="form-control rounded" id="career" name="career" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="negocio" class="fw-bolder">Unidad de Negocio</label>
                                <select class="form-control rounded" name="negocio" id="negocio" required>
                                    <option value="" selected disabled>- Seleccionar -</option>
                                    <?php
                                    $sql = "SELECT * FROM negocio";
                                    $query = $conn->query($sql);
                                    while ($prow = $query->fetch_assoc()) { ?>
                                        <option value="<?= $prow['id'] ?>">
                                            <?= $prow['nombre_negocio'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="position" class="fw-bolder">Cargo</label>
                                <select class="form-control rounded" name="position" id="position" required>
                                    <option value="" selected disabled>- Seleccionar -</option>
                                    <?php
                                    $sql = "SELECT * FROM position";
                                    $query = $conn->query($sql);
                                    while ($prow = $query->fetch_assoc()) { ?>
                                        <option value="<?= $prow['id'] ?>">
                                            <?= $prow['description'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="departamento" class="fw-bolder">Departamento</label>
                                <select class="form-control rounded" name="departamento" id="departamento" required>
                                    <option value="" selected disabled>- Seleccionar -</option>
                                    <?php
                                    $sql = "SELECT * FROM departamentos";
                                    $query = $conn->query($sql);
                                    while ($prow = $query->fetch_assoc()) { ?>
                                        <option value="<?= $prow['id'] ?>">
                                            <?= $prow['nombre_departamento'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="schedule" class="fw-bolder">Horario</label>
                            <select class="form-control rounded" id="schedule" name="schedule" required>
                                <option value="" selected disabled>- Seleccionar -</option>
                                <?php
                                $sql = "SELECT * FROM schedules";
                                $query = $conn->query($sql);
                                while ($srow = $query->fetch_assoc()) { ?>
                                    <option value="<?= $srow['id'] ?>">
                                        <?= $srow['time_in'] . ' - ' . $srow['time_out'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
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

    <!-- MODAL DE EDITAR PRACTICANTE -->
    <div class="modal fade" id="edit_practicante" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Modificar Practicante</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="includes/practicantes_edit.php">
                    <div class="modal-body d-flex flex-column gap-2 py-4 px-5">
                        <input type="hidden" class="empid" name="id">

                        <div class="row">
                            <div class="col-sm-4">
                                <label for="edit_date_in" class="fw-bolder">Fecha Ingreso</label>
                                <input type="date" class="form-control rounded" id="edit_date_in" name="date_in" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="edit_date_out" class="fw-bolder">Fecha Salida</label>
                                <input type="date" class="form-control rounded" id="edit_date_out" name="date_out" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="edit_date_out" class="fw-bolder">Nueva Fecha de Salida</label>
                                <input type="date" class="form-control rounded" id="edit_date_out_new" name="edit_date_out_new" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="edit_time_practice" class="fw-bolder">Tiempo (meses)</label>
                                <select class="form-control rounded" name="time_practice" id="edit_time_practice" required>
                                    <option selected id="time_practice_val"></option>
                                    <option value="3">3 meses</option>
                                    <option value="4">4 meses</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="edit_type_practice" class="fw-bolder">Tipo</label>
                                <select class="form-control rounded" name="type_practice" id="edit_type_practice" required>
                                    <option selected id="type_practice_val"></option>
                                    <option value="Pre Profesionales">Pre Profesionales</option>
                                    <option value="Profesionales">Profesionales</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="edit_dni" class="fw-bolder">DNI</label>
                                <input type="text" class="form-control rounded" id="edit_dni" name="dni" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="edit_contact" class="fw-bolder">Celular</label>
                                <input type="text" class="form-control rounded" id="edit_contact" name="contact">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="edit_firstname" class="fw-bolder">Nombre</label>
                                <input type="text" class="form-control rounded" id="edit_firstname" name="firstname" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="edit_lastname" class="fw-bolder">Apellido</label>
                                <input type="text" class="form-control rounded" id="edit_lastname" name="lastname" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="edit_gender" class="fw-bolder">Género</label>
                                <select class="form-control rounded" name="gender" id="edit_gender" required>
                                    <option selected id="gender_val"></option>
                                    <option value="Hombre">Hombre</option>
                                    <option value="Mujer">Mujer</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="edit_birthday" class="fw-bolder">Cumpleaños</label>
                                <input type="date" class="form-control rounded" id="edit_birthday" name="birthday" required>
                            </div>
                            <div class="col-sm-8">
                                <label for="edit_photo" class="fw-bolder">Foto</label>
                                <input type="file" class="form-control rounded" id="edit_photo" name="photo">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="edit_personal_email" class="fw-bolder">Correo Personal</label>
                                <input type="email" class="form-control rounded" id="edit_personal_email" name="personal_email" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="edit_institutional_email" class="fw-bolder">Correo Institucional</label>
                                <input type="email" class="form-control rounded" id="edit_institutional_email" name="institutional_email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="edit_university" class="fw-bolder">Centro de Estudios</label>
                                <input type="text" class="form-control rounded" id="edit_university" name="university" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="edit_career" class="fw-bolder">Carrera</label>
                                <input type="text" class="form-control rounded" id="edit_career" name="career" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="edit_negocio" class="fw-bolder">Unidad de Negocio</label>
                                <select class="form-control rounded" name="negocio" id="edit_negocio" required>
                                    <option selected id="negocio_val"></option>
                                    <?php
                                    $sql = "SELECT * FROM negocio";
                                    $query = $conn->query($sql);
                                    while ($prow = $query->fetch_assoc()) { ?>
                                        <option value="<?= $prow['id'] ?>">
                                            <?= $prow['nombre_negocio'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="edit_position" class="fw-bolder">Cargo</label>
                                <select class="form-control rounded" name="position" id="edit_position">
                                    <option selected id="position_val"></option>
                                    <?php
                                    $sql = "SELECT * FROM position";
                                    $query = $conn->query($sql);
                                    while ($prow = $query->fetch_assoc()) { ?>
                                        <option value="<?= $prow['id'] ?>">
                                            <?= $prow['description'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="edit_departamento" class="fw-bolder">Departamento</label>
                                <select class="form-control rounded" name="departamento" id="edit_departamento" required>
                                    <option selected id="departamento_val"></option>
                                    <?php
                                    $sql = "SELECT * FROM departamentos";
                                    $query = $conn->query($sql);
                                    while ($prow = $query->fetch_assoc()) { ?>
                                        <option value="<?= $prow['id'] ?>">
                                            <?= $prow['nombre_departamento'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for=" edit_schedule" class="fw-bolder">Horario</label>
                            <select class="form-control rounded" id="edit_schedule" name="schedule">
                                <option selected id="schedule_val"></option>
                                <?php
                                $sql = "SELECT * FROM schedules";
                                $query = $conn->query($sql);
                                while ($srow = $query->fetch_assoc()) { ?>
                                    <option value="<?= $srow['id'] ?>">
                                        <?= $srow['time_in'] . ' - ' . $srow['time_out'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
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

    <!-- MODAL DE ELIMINAR PRACTICANTE -->
    <div class="modal fade" id="delete_practicante" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Eliminar Practicante</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center fw-bolder">
                        ¿Está seguro de eliminar al practicante <span id="del_employee_name" class="fw-bold"></span>?
                    </h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form method="POST" action="includes/practicante_delete.php">
                        <input type="hidden" class="empid" name="id">
                        <button type="submit" class="btn btn-danger" name="delete">
                            <i class="fa fa-trash me-2"></i>Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DE AGREGAR NOTA -->
    <div class="modal fade" id="add_nota" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Agregar Notas</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="includes/practicante_notas_add.php">
                    <div class="modal-body d-flex flex-column gap-2 py-4 px-5">
                        <input type="hidden" class="empid" name="id">

                        <div class="d-flex justify-content-center">
                            <div class="d-flex gap-5">
                                <div class="text-center">
                                    <label for="fecha1" class="fw-bolder">Fecha Inicio</label>
                                    <input type="date" class="form-control rounded border border-black" id="fecha1" name="fecha1" required>
                                </div>
                                <div class="text-center">
                                    <label for="fecha2" class="fw-bolder">Fecha Final</label>
                                    <input type="date" class="form-control rounded border border-black" id="fecha2" name="fecha2" required>
                                </div>
                            </div>
                        </div>
                        <?php
                        $sqlCriterios = "SELECT * FROM criterios";
                        $queryCriterios = $conn->query($sqlCriterios);
                        $numCriterio = 1;

                        while ($criterio = $queryCriterios->fetch_assoc()) { ?>
                            <div class="my-4 criterio-container">
                                <h5 class="text-center fw-bold">
                                    <?= $numCriterio . '. ' . $criterio['nombre_criterio'] ?>
                                </h5>
                                <div class="d-flex justify-content-center">
                                    <div class="col-9">
                                        <?php
                                        $sqlSubcriterios = "SELECT * FROM subcriterios WHERE id_criterio = {$criterio['id']}";
                                        $querySubcriterios = $conn->query($sqlSubcriterios);

                                        while ($subcriterio = $querySubcriterios->fetch_assoc()) { ?>
                                            <div class="d-flex align-items-center gap-3 my-2">
                                                <label for="criterio<?= $subcriterio['id'] ?>" class="fw-bolder w-50">
                                                    <?= $subcriterio['nombre_subcriterio'] ?>:
                                                </label>
                                                <input type="text" id="criterio<?= $subcriterio['id'] ?>" class="form-control rounded text-center border-0 w-25 py-2 subcriterio-input" name="criterio<?= $subcriterio['id'] ?>" style="background-color: #e6e6e6;" required>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-sm-2 my-auto">
                                        <div class="rounded-top text-center text-white border-black fw-bolder py-2" style="background-color: #54af0c;">
                                            Promedio
                                        </div>
                                        <input type="text" class="form-control rounded-bottom border-0 text-center fw-bolder py-2 subtotal-input" name="subtotal" id="subtotal" style="background-color: #e6e6e6;" readonly>
                                    </div>
                                </div>
                            </div>
                        <?php
                            $numCriterio++;
                        }
                        ?>
                        <div class="d-flex flex-column mx-auto w-25">
                            <div class="rounded-top text-center text-white border-black fw-bolder py-2" style="background-color: #54af0c;">
                                Nota Final
                            </div>
                            <input type="text" class="form-control rounded-bottom border-0 text-center fw-bolder py-2" name="total" id="total" style="background-color: #e6e6e6;" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" name="add_nota">
                            <i class="fa-solid fa-floppy-disk"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DE AGREGAR ACTIVIDAD -->
    <div class="modal fade" id="add_actividad" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Actividades</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="includes/actividad_add.php">
                    <div class="modal-body d-flex flex-column gap-4 p-4 px-sm-5">
                        <div class="col-sm-7 mx-auto ps-sm-4">
                            <label for="fecha" class="fw-bolder">Fecha</label>
                            <input type="date" id="fecha" class="form-control rounded text-center border-0 py-2" name="fecha" style="background-color: #e6e6e6;" required>
                        </div>
                        <div class="col-sm-7 mx-auto ps-sm-4">
                            <label for="asistencia" class="fw-bolder">Evidencia de Foto de Entrada</label>
                            <div class="d-flex gap-4">
                                <div>
                                    <input type="radio" class="form-check-input" id="entrada_true" name="entrada" value="1" required>
                                    <label for="entrada_true">Sí</label>
                                </div>
                                <div>
                                    <input type="radio" class="form-check-input" id="entrada_false" name="entrada" value="0" required>
                                    <label for="entrada_false">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7 mx-auto ps-sm-4">
                            <label for="asistencia" class="fw-bolder">Evidencia de Foto de Salida</label>
                            <div class="d-flex gap-4">
                                <div>
                                    <input type="radio" class="form-check-input" id="salida_true" name="salida" value="1" required>
                                    <label for="salida_true">Sí</label>
                                </div>
                                <div>
                                    <input type="radio" class="form-check-input" id="salida_false" name="salida" value="0" required>
                                    <label for="salida_false">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7 mx-auto ps-sm-4">
                            <label for="actividades" class="fw-bolder">Evidencia de Actividades</label>
                            <input type="number" id="actividades" class="form-control rounded text-center border-0 py-2 subcriterio-input" name="actividades" style="background-color: #e6e6e6;" required>
                        </div>
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

    <!-- MODAL DE AGREGAR HORAS EXTRA -->
    <div class="modal fade" id="add_hora" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Horas Extra</h4>
                    <button id="btn_cerrar" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="user-info container-fluid pt-4" style="padding-left: 30px; padding-right: 30px;">
                    <p>Por favor verifica la información del usuario antes de agregar las horas extras. Asegúrate de que los datos sean correctos y actualiza el registro con las nuevas horas extras según corresponda.</p>
                    <p><strong>Usuario: </strong><span id="userName"></span></p>
                    <p><strong>Horas Extras Previas: </strong><span id="userExtraHours"></span> horas</p>
                    <p>Por favor, ingresa las nuevas horas extras que deseas agregar para este usuario:</p>
                </div>


                <form id="form_hour" method="POST" action="includes/practicante_hourExtra.php ">
                    <div class="modal-body d-flex flex-column gap-4 p-4 px-sm-5">
                        <div class="col-sm-7 mx-auto ps-sm-4">
                            <label for="fecha" class="fw-bolder">Horas Extras:</label>
                            <input min="0" type="number" id="horaExtra" class="form-control rounded text-center border-0 py-2 subcriterio-input" name="horaExtra" style="background-color: #e6e6e6;" required> <!-- mandara lanueva hora -->
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button id="btn_cerrar_footer" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <input type="hidden" id="id_horaExtra" name="id">
                        <button id="btn_guardar" type="submit" class="btn btn-success" name="add">
                            <i class="fa-solid fa-plus me-2"></i>Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'includes/scripts2.php'; ?>

    <script src="js/scripts.js"></script>

    <!-- CALCULAR PROMEDIO DE NOTAS -->
    <script>
        $(".subcriterio-input").on("input", function() {
            var criterio = $(this).closest(".criterio-container");
            var subcriterios = criterio.find(".subcriterio-input");
            var subtotal = 0;
            var count = 0;

            subcriterios.each(function() {
                var value = $(this).val();
                if (value !== "") {
                    subtotal += parseFloat(value);
                    count++;
                }
            });

            var promedio = subtotal / count;
            criterio.find(".subtotal-input").val(promedio.toFixed(2));

            // Calcular el promedio de los subtotales
            var total = 0;
            var criterios = $(".criterio-container");
            var criteriosCount = 0;

            criterios.each(function() {
                var subtotalValue = parseFloat($(this).find(".subtotal-input").val());
                if (!isNaN(subtotalValue)) {
                    total += subtotalValue;
                    criteriosCount++;
                }
            });

            var totalPromedio = total / criteriosCount;
            $("#total").val(totalPromedio.toFixed(2));
        });
    </script>

    <!-- DATA PARA MODAL -->
    <script>
        $('.edit').on("click", function(e) {
            $('#edit_practicante').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $('.delete').on("click", function(e) {
            $('#delete_practicante').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $('.add').on("click", function(e) {
            $('#add_nota').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $('.activities').on("click", function(e) {
            $('#add_actividad').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $('.photo').on("click", function(e) {
            var id = $(this).data('id');
            getRow(id);
        });
        $('.hora_extra').on("click", function(e) {
            var id = $(this).data('id');
            getRowHour(id);
            $('#id_horaExtra').val(id);
            $('#add_hora').modal('show');
        });

        var dato_salida;
        var id_user;
        function getRow(id) {
            $.ajax({
                type: 'POST',
                url: 'employee_row.php',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    $('.id_practicante').val(response.id);
                    $('.empid').val(response.empid);
                    $('.employee_id').html(response.employee_id);
                    $('#del_employee_name').html(response.firstname + ' ' + response.lastname);
                    $('#employee_name').html(response.firstname + ' ' + response.lastname);
                    $('#edit_firstname').val(response.firstname);
                    $('#edit_lastname').val(response.lastname);
                    $('#edit_address').val(response.address);
                    $('#datepicker_edit').val(response.birthdate);
                    $('#edit_contact').val(response.contact_info);
                    $('#gender_val').val(response.gender).html(response.gender);
                    $('#position_val').val(response.position_id).html(response.description);
                    $('#negocio_val').val(response.negocio_id).html(response.nombre_negocio);
                    $('#schedule_val').val(response.schedule_id).html(response.time_in + ' - ' + response.time_out);
                    $('#edit_date_in').val(response.date_in).html(response.date_in);
                    $('#departamento_val').val(response.departamento_id).html(response.nombre_departamento);
                    $('#edit_date_out').val(response.date_out).html(response.date_out);
                    $('#edit_birthday').val(response.birthday).html(response.birthday);
                    $('#type_practice_val').val(response.type_practice).html(response.type_practice);
                    $('#time_practice_val').val(response.time_practice).html(response.time_practice);
                    $('#edit_dni').val(response.dni);
                    $('#edit_personal_email').val(response.personal_email);
                    $('#edit_institutional_email').val(response.institutional_email);
                    $('#edit_university').val(response.university);
                    $('#edit_career').val(response.career);
                    dato_salida=response.date_out;
                    id_user=response.empid;
                    $.ajax({
                        type: 'POST',
                        url: 'get_cantidad_faltas_justificadas_injustificadas.php',
                        data: { employee_id: response.empid },
                        dataType: 'json',
                        success: function (response) {                            
                            let faltaInjustificadas=response.faltas_injustificadas;
                            salidaNew(dato_salida,faltaInjustificadas,id_user);
                        }
                    });
                }
            });
        }
        function salidaNew(dato_salida,faltaInjustificadas,id_user){
            var partesFecha = dato_salida.split('-');
            var año = parseInt(partesFecha[0]);
            var mes = parseInt(partesFecha[1]) - 1; 
            var dia = parseInt(partesFecha[2]);
            var nueva_fechaSalida = new Date(año, mes, dia);
            nueva_fechaSalida.setDate(nueva_fechaSalida.getDate() + parseInt(faltaInjustificadas));
            var nueva_fecha_salida_formateada = nueva_fechaSalida.toISOString().slice(0, 10);
            $('#edit_date_out_new').val(nueva_fecha_salida_formateada).html(nueva_fecha_salida_formateada);
            
            $.ajax({
                type: 'POST',
                url: 'insert_new_out.php',
                data: { employee_id: id_user, new_out:nueva_fecha_salida_formateada },
                dataType: 'json',
                success: function (response) {

                }
            });
        }
        function getRowHour(id) {
            $.ajax({
                type: 'POST',
                url: 'hour_extra.php',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    $('#userExtraHours').text(response.extra_hour);
                    $('#userName').text(response.fullname);
                    $('.btn_guardar').prop('disabled', true);
                }
            });
        }
        function clearSpanContents() {
            document.getElementById('userExtraHours').textContent = '';
            document.getElementById('userName').textContent = '';
        }

        document.getElementById('btn_cerrar_footer').addEventListener('click', clearSpanContents);
        document.getElementById('btn_cerrar').addEventListener('click', clearSpanContents);
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('horaExtra').value = '';
        });
    </script>
</body>