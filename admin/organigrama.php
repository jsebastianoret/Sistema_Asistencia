<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $organigrama_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>

        <!-- CONTENIDO PRINCIPAL  -->
        <section class="content p-0 my-4">
            <div class="organigrama-container">
                <div class="button-container">
                    <button id="increaseSize">+</button>
                    <button id="decreaseSize">-</button>
                </div>
                <div class="organigrama">
                    <ul>
                        <li>
                            <div class="gerente-card">
                                <div class="employee-info">
                                    <img src="../images/profile.jpg" alt="Gerente General" class="employee-photo">
                                    <div class="employee-text">
                                        <span class="employee-name">Juan Carlos Molina Orrego</span>
                                        <hr>
                                        <span class="business-name">Neon House Led S.A.C.</span>
                                    </div>
                                </div>
                            </div>
                            <ul>
                                <li>
                                    <?php
                                    $sqlAuxGerencia = "SELECT e.id, e.firstname, e.lastname, d.nombre_departamento
                                    FROM employees e
                                    INNER JOIN departamentos d ON e.departamento_id = d.id
                                    WHERE d.id = 1";
                                    $queryAuxGerencia = $conn->query($sqlAuxGerencia);
                                    ?>
                                    <span class="toggle container-positions fw-bolder">
                                        Adm. General
                                        <hr>
                                        <div class="person-count-container">
                                            <span class="total-persons">
                                                <?= $queryAuxGerencia->num_rows ?>
                                            </span>
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </span>
                                    <ul class="subordinates">
                                        <?php while ($rowAuxGerencia = $queryAuxGerencia->fetch_assoc()) { ?>
                                            <div class="employee-card view" data-id="<?= $rowAuxGerencia['id'] ?>">
                                                <div class="employee-details">
                                                    <div class="employee-info">
                                                        <img src="../images/profile.jpg" alt="Aux. de Gerencia"
                                                            class="employee-photo">
                                                        <div class="employee-text">
                                                            <span class="employee-name">
                                                                <?= $rowAuxGerencia['firstname'] . ' ' . $rowAuxGerencia['lastname'] ?>
                                                            </span>
                                                            <hr>
                                                            <span class="business-name">
                                                                <?= $rowAuxGerencia['nombre_departamento'] ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </ul>
                                    <ul>
    <?php
    $sqlDepartamentos = "SELECT * FROM departamentos WHERE NOT id = 1";
    $queryDepartamentos = $conn->query($sqlDepartamentos);
    $rowDepartamentos = $queryDepartamentos->fetch_all(MYSQLI_ASSOC);

    foreach ($rowDepartamentos as $key => $departamento) {
        if ($key == 2) { // Cambia este valor si necesitas mostrar algo específico en otro índice
            $sqlNumEmployeesPeople = "SELECT COUNT(*) as total FROM employees e
                INNER JOIN position p ON e.position_id = p.id
                WHERE  p.id IN (3,4,5,8,6,7,17,2,13)";
            $resultPeople = $conn->query($sqlNumEmployeesPeople);
            $totalPeople = $resultPeople->fetch_assoc()['total'];
            ?>
            <li>
                <span class="toggle container-positions fw-bolder">
                    People
                    <hr>
                    <div class="person-count-container">
                        <span class="total-persons">
                            <?= $totalPeople ?>
                        </span>
                        <i class="fas fa-users"></i>
                    </div>
                </span>
                <ul class="subordinates">
                    <?php
                    $sqlPositions = "SELECT * FROM position WHERE id IN (11, 17)";
                    $queryPositions = $conn->query($sqlPositions);

                    while ($rowPosition = $queryPositions->fetch_assoc()) { ?>
                        <li>
                            <span class="toggle container-positions fw-bolder">
                                <?= $rowPosition['description'] ?>
                                <hr>
                                <div class="person-count-container">
                                    <span class="total-persons">
                                        <?= $conn->query("SELECT COUNT(*) as total FROM employees WHERE position_id = {$rowPosition['id']}")->fetch_assoc()['total'] ?>
                                    </span>
                                    <i class="fas fa-users"></i>
                                </div>
                            </span>
                            <?php if ($rowPosition['id'] == 11) { // Clima y Cultura ?>
                                <ul class="subordinates">
                                    <?php
                                    $sqlNumEmployees = "SELECT COUNT(*) as total FROM employees e 
                                        INNER JOIN departamentos d ON e.departamento_id = d.id
                                        WHERE d.id IN (6, 7)";
                                    $resultNumEmployees = $conn->query($sqlNumEmployees);
                                    $totalEmployees = $resultNumEmployees->fetch_assoc()['total'];
                                    
                                    $sqlJefatura = "SELECT * FROM departamentos WHERE id IN (6, 7)";
                                    $queryJefatura = $conn->query($sqlJefatura);

                                    while ($rowJefatura = $queryJefatura->fetch_assoc()) { ?>
                                        <li>
                                            <span class="toggle container-positions fw-bolder">
                                                Adm. de
                                                <?= $rowJefatura['nombre_departamento'] ?>
                                                <hr>
                                                <div class="person-count-container">
                                                    <span class="total-persons">
                                                        <?= $conn->query("SELECT * FROM employees WHERE departamento_id = {$rowJefatura['id']}")->num_rows ?>
                                                    </span>
                                                    <i class="fas fa-users"></i>
                                                </div>
                                            </span>
                                            <ul class="subordinates">
                                                <?php
                                                $sqlAdmJefatura = "SELECT e.id, e.firstname, e.lastname, p.description, d.nombre_departamento
                                                    FROM employees e
                                                    INNER JOIN position p ON e.position_id = p.id
                                                    INNER JOIN departamentos d ON e.departamento_id = d.id
                                                    WHERE e.departamento_id = {$rowJefatura['id']} AND e.position_id = 13";
                                                $queryAdmJefatura = $conn->query($sqlAdmJefatura);

                                                while ($rowAdmJefatura = $queryAdmJefatura->fetch_assoc()) { ?>
                                                    <li>
                                                        <div class="employee-card view"
                                                            data-id="<?= $rowAdmJefatura['id'] ?>">
                                                            <div class="employee-details">
                                                                <div class="employee-info">
                                                                    <img src="../images/profile.jpg"
                                                                        alt="Adm. de Jefatura <?= $rowJefatura['nombre_departamento'] ?>"
                                                                        class="employee-photo">
                                                                    <div class="employee-text">
                                                                        <span class="employee-name">
                                                                            <?= $rowAdmJefatura['firstname'] . ' ' . $rowAdmJefatura['lastname'] ?>
                                                                        </span>
                                                                        <hr>
                                                                        <span class="business-name">
                                                                            <?= $rowAdmJefatura['description'] ?>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                            <ul class="subordinates">
                                                                    <?php
                                                                    $rowJefatura['id'] == 6 ?
                                                                        $sqlNegocio = "SELECT * FROM negocio WHERE id = 2 OR id = 4 OR id = 10 OR id = 3 OR id = 8 OR id = 11" :
                                                                        $sqlNegocio = "SELECT * FROM negocio WHERE   id = 7  OR id = 12";
                                                                    $queryNegocio = $conn->query($sqlNegocio);

                                                                    while ($rowNegocio = $queryNegocio->fetch_assoc()) { ?>
                                                                        <li>
                                                                            <span class="toggle container-positions fw-bolder">
                                                                                Adm. de Unidad
                                                                                <?= $rowNegocio['nombre_negocio'] ?>
                                                                                <hr>
                                                                                <div class="person-count-container">
                                                                                    <span class="total-persons">
                                                                                        <?= $conn->query("SELECT * FROM employees WHERE negocio_id = {$rowNegocio['id']} AND NOT (position_id = 2 OR position_id = 13)")->num_rows ?>
                                                                                    </span>
                                                                                    <i class="fas fa-users"></i>
                                                                                </div>
                                                                            </span>
                                                                            <?php
                                                                            $sqlAdmProyecto = "SELECT e.id, e.firstname, e.lastname, p.description, n.nombre_negocio
                                                                                FROM employees e
                                                                                INNER JOIN position p ON e.position_id = p.id
                                                                                INNER JOIN negocio n ON e.negocio_id = n.id
                                                                                WHERE n.id = {$rowNegocio['id']} AND p.id = 2";
                                                                            $queryAdmProyecto = $conn->query($sqlAdmProyecto);

                                                                            while ($rowAdmProyecto = $queryAdmProyecto->fetch_assoc()) { ?>
                                                                                <ul class="subordinates">
                                                                                    <div class="employee-card view"
                                                                                        data-id="<?= $rowAdmProyecto['id'] ?>">
                                                                                        <div class="employee-details">
                                                                                            <div class="employee-info">
                                                                                                <img src="../images/profile.jpg"
                                                                                                    alt="Adm. Proyecto <?= $rowNegocio['nombre_negocio'] ?>"
                                                                                                    class="employee-photo">
                                                                                                <div class="employee-text">
                                                                                                    <span class="employee-name">
                                                                                                        <?= $rowAdmProyecto['firstname'] . ' ' . $rowAdmProyecto['lastname'] ?>
                                                                                                    </span>
                                                                                                    <hr>
                                                                                                    <span class="business-name">
                                                                                                        <?= $rowAdmProyecto['description'] ?>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </ul>
                                                                            <?php } ?>
                                                                            <ul class="subordinates">
                                                                                <?php $sqlNumEmployees = "SELECT * FROM employees WHERE negocio_id = {$rowNegocio['id']} AND (position_id = 3 OR position_id = 4 OR position_id = 5 OR position_id = 8)"; ?>
                                                                               <?php $queryNumEmployees = $conn->query($sqlNumEmployees);

                                                                                 if ($queryNumEmployees->num_rows > 1) { ?>
                                                                                <li>
                                                                                    <span class="toggle container-positions fw-bolder">
                                                                                        Departamento Comercial
                                                                                        <hr>
                                                                                        <div class="person-count-container">
                                                                                            <span class="total-persons">
                                                                                                <?= $conn->query($sqlNumEmployees)->num_rows ?>
                                                                                            </span>
                                                                                            <i class="fas fa-users"></i>
                                                                                        </div>
                                                                                    </span>
                                                                                    <ul>
                                                                                        <?php
                                                                                        $sqlPosition = "SELECT * FROM position WHERE id = 3 OR id = 4 OR id = 5 OR id = 8 or id=6 ";
                                                                                        $queryPosition = $conn->query($sqlPosition);
                                                                                        
                                                                                        while ($rowPosition = $queryPosition->fetch_assoc()) { ?>
                                                                                            <li>
                                                                                                <span
                                                                                                    class="toggle container-positions fw-bolder">
                                                                                                    Área de
                                                                                                    <?= $rowPosition['description'] ?>
                                                                                                    <hr>
                                                                                                    <div class="person-count-container">
                                                                                                        <span class="total-persons">
                                                                                                            <?= $conn->query("SELECT * FROM employees WHERE position_id = {$rowPosition['id']} AND negocio_id = {$rowNegocio['id']}")->num_rows ?>
                                                                                                        </span>
                                                                                                        <i class="fas fa-users"></i>
                                                                                                    </div>
                                                                                                </span>
                                                                                                <?php
                                                                                                $sql = "SELECT e.id, e.firstname, e.lastname, p.description
                                                                                                    FROM employees e
                                                                                                    INNER JOIN negocio n ON e.negocio_id = n.id
                                                                                                    INNER JOIN position p ON e.position_id = p.id
                                                                                                    WHERE n.id = {$rowNegocio['id']} AND e.position_id = {$rowPosition['id']}";
                                                                                                $query = $conn->query($sql);

                                                                                                while ($employee = $query->fetch_assoc()) { ?>
                                                                                                    <ul class="subordinates">
                                                                                                        <div class="employee-card view"
                                                                                                            data-id=<?= $employee["id"] ?>>
                                                                                                            <div class="employee-details">
                                                                                                                <div class="employee-info">
                                                                                                                    <img src="../images/profile.jpg"
                                                                                                                        alt="<?= $employee['firstname'] ?>"
                                                                                                                        class="employee-photo">
                                                                                                                    <div class="employee-text">
                                                                                                                        <span
                                                                                                                            class="employee-name">
                                                                                                                            <?= $employee['firstname'] . ' ' . $employee['lastname'] ?>
                                                                                                                        </span>
                                                                                                                        <hr>
                                                                                                                        <span
                                                                                                                            class="business-name">
                                                                                                                            <?= $employee['description'] ?>
                                                                                                                        </span>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </ul>
                                                                                                <?php } ?>
                                                                                            </li>
                                                                                        <?php } ?>
                                                                                    </ul>
                                                                                </li>
                                                                                <?php } ?>
                                                                                <?php
                                                                                $sqlNumEmployees = "SELECT * FROM employees WHERE negocio_id = {$rowNegocio['id']} AND position_id = 7";
                                                                                $queryNumEmployees = $conn->query($sqlNumEmployees);

                                                                                if ($queryNumEmployees->num_rows > 5) { ?>
                                                                                    <li>
                                                                                        <span class="toggle container-positions fw-bolder">
                                                                                            Departamento Tecnológico
                                                                                            <hr>
                                                                                            <div class="person-count-container">
                                                                                                <span class="total-persons">
                                                                                                    <?= $queryNumEmployees->num_rows ?>
                                                                                                </span>
                                                                                                <i class="fas fa-users"></i>
                                                                                            </div>
                                                                                        </span>
                                                                                        <ul>
                                                                                            <?php
                                                                                            $sqlPosition = "SELECT * FROM position WHERE id = 7";
                                                                                            $queryPosition = $conn->query($sqlPosition);
                                                                                            $rowPosition = $queryPosition->fetch_assoc();
                                                                                            ?>
                                                                                            <li>
                                                                                                <span
                                                                                                    class="toggle container-positions fw-bolder">
                                                                                                    Área de
                                                                                                    <?= $rowPosition['description'] ?>
                                                                                                    <hr>
                                                                                                    <div class="person-count-container">
                                                                                                        <span class="total-persons">
                                                                                                            <?= $conn->query("SELECT * FROM employees WHERE position_id = {$rowPosition['id']} AND negocio_id = {$rowNegocio['id']}")->num_rows ?>
                                                                                                        </span>
                                                                                                        <i class="fas fa-users"></i>
                                                                                                    </div>
                                                                                                </span>
                                                                                                <?php
                                                                                                $sql = "SELECT e.id, e.firstname, e.lastname, p.description
                                                                                                    FROM employees e
                                                                                                    INNER JOIN negocio n ON e.negocio_id = n.id
                                                                                                    INNER JOIN position p ON e.position_id = p.id
                                                                                                    WHERE n.id = {$rowNegocio['id']} AND e.position_id = {$rowPosition['id']}";
                                                                                                $query = $conn->query($sql);

                                                                                                while ($employee = $query->fetch_assoc()) { ?>
                                                                                                    <ul class="subordinates">
                                                                                                        <div class="employee-card view"
                                                                                                            data-id=<?= $employee["id"] ?>>
                                                                                                            <div class="employee-details">
                                                                                                                <div class="employee-info">
                                                                                                                    <img src="../images/profile.jpg"
                                                                                                                        alt="<?= $employee['firstname'] ?>"
                                                                                                                        class="employee-photo">
                                                                                                                    <div class="employee-text">
                                                                                                                        <span
                                                                                                                            class="employee-name">
                                                                                                                            <?= $employee['firstname'] . ' ' . $employee['lastname'] ?>
                                                                                                                        </span>
                                                                                                                        <hr>
                                                                                                                        <span
                                                                                                                            class="business-name">
                                                                                                                            <?= $employee['description'] ?>
                                                                                                                        </span>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </ul>
                                                                                                <?php } ?>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </li>
                                                                                <?php } ?>
                                                                            </ul>
                                                                        </li>
                                                                    <?php } ?>
                                                                </ul>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                                                                                                </li>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php }
    } ?>
</ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <?php include 'includes/footer.php'; ?>
    </div>

    <!-- MODAL DE VER PRACTICANTE -->
    <div class="modal fade" id="view" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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

    <style>
        .organigrama-container {
            border: 1px solid black;
        }

        .organigrama * {
            margin: 0px;
            padding: 0px;
        }

        .organigrama {
            overflow: auto;
            background: #ecf0f1;
            max-width: 100%;
            white-space: nowrap;
            height: 700px;
            cursor: grab;
            /* Cambia el cursor al hacer clic */
        }

        .organigrama.grabbing {
            cursor: grabbing;
            /* Cambia el cursor durante el arrastre */
        }

        .organigrama ul {
            padding-top: 20px;
            position: relative;
        }

        .organigrama li {
            display: inline-table;
            text-align: center;
            list-style-type: none;
            padding: 20px 5px 0px 5px;
            position: relative;
        }

        .organigrama>ul>li {
            display: inline-block;
        }

        .organigrama li::before,
        .organigrama li::after {
            content: '';
            position: absolute;
            top: 0px;
            right: 50%;
            border-top: 2px solid #a6d4f2;
            width: 60%;
            height: 20px;
        }

        .organigrama li::after {
            right: auto;
            left: 50%;
            border-left: 2px solid #a6d4f2;
        }

        .organigrama li:only-child::before,
        .organigrama li:only-child::after {
            display: none;
        }

        .organigrama li:only-child {
            padding-top: 0;
        }

        .organigrama li:first-child::before,
        .organigrama li:last-child::after {
            border: 0 none;
        }

        .organigrama li:last-child::before {
            border-right: 2px solid #a6d4f2;
            -webkit-border-radius: 0 5px 0 0;
            -moz-border-radius: 0 5px 0 0;
            border-radius: 0 5px 0 0;
        }

        .organigrama li:first-child::after {
            border-radius: 5px 0 0 0;
        }

        .organigrama ul ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 2px solid #a6d4f2;
            width: -webkit-fill-available;
            height: 20px;
        }

        .organigrama li a {
            text-decoration: none;
            display: inline-block;
        }

        .organigrama li a:hover {
            border: 1px solid #fff;
            color: #1e3d8f;
            background-color: #add8e6;
            display: inline-block;
        }

        .subordinates {
            display: none;
        }

        .container-positions {
            border: 1px solid #ccc;
            border-radius: 3px;
            padding: 10px;
            transition: all 0.3s;
            display: inline-block;
            white-space: nowrap;
            background-color: white;
            color: black;
        }

        .container-positions:hover {
            background-color: #e0e0e0;
            color: #1e3d8f;
        }

        .employee-card,
        .gerente-card {
            display: inline-block;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 1em;
            text-align: center;
            transition: all 0.3s;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .employee-card:hover {
            background-color: #d2f3cb;
            transform: scale(1.03);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border: 1px solid #fff;
            color: #1e3d8f;
        }

        .employee-text {
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
        }

        .employee-card.small {
            transform: scale(0.8);
            /* Ajusta el tamaño de la tarjeta */
        }

        .employee-details {
            display: flex;
            align-items: center;
        }

        .employee-info {
            display: flex;
        }

        .employee-photo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
            transition: all 0.3s;
            /* Agregado para una transición suave */
        }

        .employee-card.small .employee-photo {
            width: 30px;
            /* Ajusta el ancho de la imagen al reducir el tamaño de la tarjeta */
            height: 30px;
            /* Ajusta la altura de la imagen al reducir el tamaño de la tarjeta */
        }

        .employee-text {
            display: flex;
            flex-direction: column;

        }

        .employee-name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .business-name {
            color: #555;
        }

        /*//////////////*/
        /* Estilo para extender la línea horizontal */
        hr {
            width: 100%;
            border-top: 1px solid black;
            /* Puedes ajustar el color según tus preferencias */
            margin: 20px 0;
            /* Ajusta el margen según tus necesidades */
        }

        /* Otros estilos para tu contenido */
        .content {
            padding: 20px;
        }

        .person-count-container {
            position: relative;
            bottom: 0;
            right: 0;
            /* Ajuste: cambiar a 0 para que esté en el lado derecho */
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
            /*margin: 10px;*/
        }

        .total-persons {
            margin-right: 5px;
        }


        .total-persons {
            margin-right: 5px;
        }

        /* Estilos para el contenedor de los botones */
        .button-container {
            position: relative;
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
            top: 0;
            right: 0;
            background-color: #ecf0f1;
            /* Mismo color de fondo que el contenedor principal */
            padding: 10px;
            /*border: 1px solid black;*/
            /*border-radius: 0 0 0 10px; /* Bordes redondeados solo en la esquina inferior izquierda */
        }

        .button-container button {
            margin-right: 5px;
        }

        .organigrama {
            user-select: none;
            /* Evita la selección de texto */
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            cursor: grab;
            /* Cambia el cursor al hacer clic */
        }

        .organigrama.grabbing {
            cursor: grabbing;
            /* Cambia el cursor durante el arrastre */
        }
    </style>

    <script>
        $(document).ready(function () {
            var isDragging = false;
            var startPosition = { x: 0, y: 0 };
            var scrollPosition = { top: 0, left: 0 };

            $('.organigrama')
                .mousedown(function (e) {
                    isDragging = true;
                    startPosition = { x: e.clientX, y: e.clientY };
                    scrollPosition = { top: $(this).scrollTop(), left: $(this).scrollLeft() };
                    $(this).addClass('grabbing');
                })
                .mousemove(function (e) {
                    if (!isDragging) return;
                    var deltaX = e.clientX - startPosition.x;
                    var deltaY = e.clientY - startPosition.y;
                    $(this).scrollTop(scrollPosition.top - deltaY);
                    $(this).scrollLeft(scrollPosition.left - deltaX);
                })
                .mouseup(function () {
                    isDragging = false;
                    $(this).removeClass('grabbing');
                })
                .mouseleave(function () {
                    isDragging = false;
                    $(this).removeClass('grabbing');
                });
        });
    </script>

    <!-- ZOOM DE CARDS -->
    <script>
        $(document).ready(function () {
            $('#increaseSize').click(function () {
                $('.organigrama').css('font-size', '+=2');
                $('.employee-card').removeClass('small');
            });

            $('#decreaseSize').click(function () {
                $('.organigrama').css('font-size', '-=2');
                $('.employee-card').addClass('small');
            });

            $('.toggle').click(function (e) {
                e.preventDefault();
                $(this).siblings('.subordinates').toggle();
            });
        });
    </script>

    <!-- DATA PARA MODAL -->
    <script>
        $('.view').on('click', function (e) {
            $('#view').modal('show');
            var id = $(this).data('id');
            getPracticante(id);
            getCalificacion(id);
            getAsistencia(id);
        });

        function getPracticante(id) {
            $.ajax({
                type: 'POST',
                url: 'employee_row.php',
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
        $('#view').on('shown.bs.modal', function () {
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
                data: { id: id },
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
                data: { id: id },
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
                            data: { id: id },
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