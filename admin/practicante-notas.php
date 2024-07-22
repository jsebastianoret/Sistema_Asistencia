<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $practicantes_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>

        <!-- CONTENIDO PRINCIPAL  -->
        <div class="content p-0 my-4 row justify-content-center g-4">
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

            <section class="card col-12 col-xl-9 col-xxl-8 mt-0">
                <h3 class="text-center fw-bolder mt-1" style="color: #1e4da9;">
                    <?php echo $_GET['codigo_practicante'] ?>
                </h3>
                <div class="card-body row g-4 justify-content-center p-0 p-sm-3">
                    <div class="col-12 col-xl-9">
                        <table class="table table-bordered m-0">
                            <thead>
                                <tr class="border-0">
                                    <th rowspan="2"
                                        class="evaluacion-title align-middle text-center text-white border-0 border-end fs-5"
                                        style="width: 250px; background-color: #1e4da9;">
                                        EVALUACIÓN DE DESEMPEÑO
                                    </th>
                                    <th class="evaluacion-title align-middle text-center text-white border-0 border-end fs-6"
                                        style="background-color: #54af0c;">
                                        INGRESO
                                    </th>
                                    <td class="evaluacion-title align-middle text-center text-white border-0 fs-6"
                                        style="background-color: #54af0c;">
                                        <?php echo date('d/m/Y', strtotime($_GET['fecha_inicio'])) ?>
                                    </td>
                                </tr>
                                <tr class="border-0">
                                    <th class="evaluacion-title align-middle text-center text-white border-0 border-end fs-6"
                                        style="background-color: #ff0000;">
                                        SALIDA
                                    </th>
                                    <td class="evaluacion-title align-middle text-center text-white border-0 fs-6"
                                        style="background-color: #ff0000;">
                                        <?php echo date('d/m/Y', strtotime($_GET['fecha_fin'])) ?>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th class="text-center border">
                                        PRACTICANTE
                                    </th>
                                    <td colspan="2" class="text-center border">
                                        <?php echo $_GET['nombre'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-center border">
                                        PUESTO
                                    </th>
                                    <td colspan="2" class="text-center border">
                                        <?php echo $_GET['position'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-center border">
                                        ÁREA
                                    </th>
                                    <td colspan="2" class="text-center border">
                                        <?php echo $_GET['negocio'] ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div
                        class="col-6 col-sm-4 col-xl-3 d-flex flex-column gap-4 justify-content-center align-items-center">
                        <div class="text-center fs-5 w-100">
                            <div class="text-white fw-bold p-2 px-1 rounded-top" style="background-color: #1e4da9;">
                                NOTA FINAL
                            </div>
                            <div id="promedio-nota-final" class="bg-light rounded-bottom p-2 px-1">
                                <i class="fa-solid fa-spinner fa-spin fs-4"></i>
                            </div>
                        </div>
                        <?php
                        if ($user['id'] == 1 || $user['id'] == 2 || $user['id'] == 4) { ?>
                            <button id="delete" class="btn text-white" style="background-color: #ff0000;"
                                data-id="<?php echo $_GET['id_practicante'] ?>">
                                <i class="fa fa-trash me-2"></i>Eliminar Nota
                            </button>
                        <?php } ?>
                    </div>
                </div>
            </section>

            <?php
            // Generar las fechas de cada semana
            $employee = $_GET['id_practicante'];

            // Convertir las fechas en objetos DateTime
            $inicio = new DateTime($_GET['fecha_inicio']);
            $fin = new DateTime($_GET['fecha_fin']);

            // Se incrementa una semana a la fecha inicial
            $inicio->modify('+1 week');

            // Iterar hasta la fecha final, incrementando de a una semana
            while ($inicio <= $fin) {
                $fechasSemanas[] = $inicio->format('d/m/Y');
                $inicio->modify('+1 week');
            }

            // Verificar si la última semana tiene menos de 7 días
            if (end($fechasSemanas) !== $fin->format('d/m/Y')) {
                $fechasSemanas[key($fechasSemanas)] = $fin->format('d/m/Y');
            }

            // Calcular el número de meses totales
            $mesesTotal = ceil(count($fechasSemanas) / 4);

            $sql = "SELECT * FROM criterios";
            $resultadoCriterios = $conn->query($sql);
            $criterios = $resultadoCriterios->fetch_all(MYSQLI_ASSOC);
            ?>

            <section class="col-12 d-flex flex-column gap-4 px-0">
                <div class="card">
                    <div class="card-body table-responsive">
                        <h5 class="fw-bold mb-3">NOTAS MENSUALES POR CRITERIO</h5>
                        <table class="table table-bordered m-0">
                            <thead>
                                <tr>
                                    <th class="align-middle text-center text-white fs-6 border-secondary"
                                        style="background-color: #1e4da9; width: 300px;">
                                        Criterios
                                    </th>
                                    <?php for ($i = 1; $i <= $mesesTotal; $i++) { ?>
                                        <th class="text-center text-white fs-6 border-secondary"
                                            style="background-color: #54af0c;">
                                            MES
                                            <?= $i ?>
                                        </th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($i = 0; $i < count($criterios); $i++) { ?>
                                    <tr>
                                        <td class="text-center border-secondary">
                                            <?= $i + 1 . ". " . $criterios[$i]['nombre_criterio'] ?>
                                        </td>
                                        <?php
                                        $contador = 0;
                                        $notaCriterioTotalMes = 0;
                                        $notaCriterioCantidadMes = 0;
                                        foreach ($fechasSemanas as $fechaSemana) {
                                            $contador++;

                                            $sql = "SELECT SUM(nota)/COUNT(nota) AS total FROM grades WHERE employee_id = $employee AND id_criterio = {$criterios[$i]['id']} AND fecha_fin_semana = STR_TO_DATE('$fechaSemana', '%d/%m/%Y')";
                                            $resultadoNota = $conn->query($sql);
                                            $nota = $resultadoNota->fetch_assoc();

                                            isset($nota['total']) ? $promedioNotaSemana = $nota['total'] : $promedioNotaSemana = 0;

                                            if ($promedioNotaSemana > 0) {
                                                $notaCriterioTotalMes += $promedioNotaSemana;
                                                $notaCriterioCantidadMes++;
                                            }

                                            $promedioNotaCriterioMes = ($notaCriterioCantidadMes > 0)
                                                ? $notaCriterioTotalMes / $notaCriterioCantidadMes
                                                : 0;
                                            if ($contador % 4 == 0) { ?>
                                                <td class="align-middle text-center border-secondary">
                                                    <?= $promedioNotaCriterioMes ?>
                                                </td>
                                                <?php
                                                $notaCriterioTotalMes = 0;
                                                $notaCriterioCantidadMes = 0;
                                            }
                                        } ?>
                                        <td class="align-middle text-center border-secondary">
                                            <?= $promedioNotaCriterioMes ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <th class="text-center text-white border-secondary"
                                        style="background-color: #1e4da9;">TOTAL PROMEDIO</th>
                                    <?php
                                    $contador = 0;
                                    $promedioCriterioMes = 0;
                                    $promedioCantidadCriterioMes = 0;

                                    foreach ($fechasSemanas as $fechaSemana) {
                                        $contador++;

                                        $notaSemana = 0;
                                        $cantidadSemana = 0;
                                        $promedioCriterioSemana = 0;
                                        $promedioCantidadCriterioSemana = 0;

                                        $sql = "SELECT * FROM criterios";
                                        $resultadoCriterios = $conn->query($sql);

                                        foreach ($criterios as $value) {
                                            $sql = "SELECT SUM(nota)/COUNT(nota) AS total FROM grades WHERE employee_id = $employee AND id_criterio = {$value['id']} AND fecha_fin_semana = STR_TO_DATE('$fechaSemana', '%d/%m/%Y')";
                                            $resultadoNota = $conn->query($sql);
                                            $nota = $resultadoNota->fetch_assoc();

                                            isset($nota['total']) ? $notaCriterioSemana = $nota['total'] : $notaCriterioSemana = 0;

                                            if ($notaCriterioSemana > 0) {
                                                $notaSemana += $notaCriterioSemana;
                                                $cantidadSemana++;
                                            }
                                            $promedioSemana = ($cantidadSemana > 0)
                                                ? $notaSemana / $cantidadSemana
                                                : 0;
                                        }

                                        if ($promedioSemana > 0) {
                                            $promedioCriterioSemana += $promedioSemana;
                                            $promedioCantidadCriterioSemana++;
                                        }
                                        $promedioCriterioTotalSemana = ($promedioCantidadCriterioSemana > 0)
                                            ? $promedioCriterioSemana / $promedioCantidadCriterioSemana
                                            : 0;

                                        if ($promedioCriterioTotalSemana > 0) {
                                            $promedioCriterioMes += $promedioCriterioTotalSemana;
                                            $promedioCantidadCriterioMes++;
                                        }
                                        $promedioCriterioTotalMes = ($promedioCantidadCriterioMes > 0)
                                            ? $promedioCriterioMes / $promedioCantidadCriterioMes
                                            : 0;

                                        if ($contador % 4 == 0) { ?>
                                            <th class="align-middle text-center text-white border-secondary"
                                                style="background-color: #1e4da9;">
                                                <?= round($promedioCriterioTotalMes, 2) ?>
                                            </th>
                                            <?php
                                            $promedioCriterioMes = 0;
                                            $promedioCantidadCriterioMes = 0;
                                        }
                                    } ?>
                                    <th class="align-middle text-center text-white border-secondary"
                                        style="background-color: #1e4da9;">
                                        <?= $promedioCriterioTotalMes ?>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="col-12 d-flex flex-column gap-4 px-0">
                <?php
                for ($i = 0; $i < count($criterios); $i++) { ?>
                    <div class="card">
                        <div class="card-body table-responsive">
                            <h5 class="fw-bold mb-3 text-uppercase">
                                NOTAS MENSUALES DE
                                <?= $criterios[$i]['nombre_criterio'] ?>
                            </h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="align-middle text-center text-white fs-6 border-secondary"
                                            style="background-color: #1e4da9; width: 350px">
                                            <?= $i + 1 . '. ' . $criterios[$i]['nombre_criterio'] ?>
                                        </th>
                                        <?php for ($i2 = 1; $i2 <= $mesesTotal; $i2++) { ?>
                                            <th class="text-center text-white border-secondary"
                                                style="background-color: #54af0c;">
                                                MES
                                                <?= $i2 ?>
                                            </th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM subcriterios WHERE id_criterio = {$criterios[$i]['id']}";
                                    $resultadoSubcriterios = $conn->query($sql);

                                    while ($subcriterio = $resultadoSubcriterios->fetch_assoc()) { ?>
                                        <tr>
                                            <td class="align-middle text-center border-secondary">
                                                <?= $subcriterio['nombre_subcriterio'] ?>
                                            </td>
                                            <?php
                                            $contador = 0;
                                            $notaSubcriterioTotalMes = 0;
                                            $notaSubcriterioCantidadMes = 0;
                                            foreach ($fechasSemanas as $fechaSemana) {
                                                $contador++;

                                                $sql = "SELECT * FROM grades WHERE employee_id = $employee AND id_subcriterio = {$subcriterio['id']} AND id_criterio = {$criterios[$i]['id']} AND fecha_fin_semana = STR_TO_DATE('$fechaSemana', '%d/%m/%Y')";
                                                $resultadoNota = $conn->query($sql);
                                                $nota = $resultadoNota->fetch_assoc();

                                                if (isset($nota['nota'])) {
                                                    $notaSubcriterioTotalMes += $nota['nota'];
                                                    $notaSubcriterioCantidadMes++;
                                                }
                                                $promedioNotaSubcriterioMes = ($notaSubcriterioCantidadMes > 0)
                                                    ? $notaSubcriterioTotalMes / $notaSubcriterioCantidadMes
                                                    : 0;

                                                if ($contador % 4 == 0) { ?>
                                                    <td class="align-middle text-center border-secondary">
                                                        <?= $promedioNotaSubcriterioMes ?>
                                                    </td>
                                                    <?php
                                                    $notaSubcriterioTotalMes = 0;
                                                    $notaSubcriterioCantidadMes = 0;
                                                }
                                            } ?>
                                            <td class="align-middle text-center border-secondary">
                                                <?= $promedioNotaSubcriterioMes ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <th class="text-center text-white border-secondary"
                                            style="background-color: #1e4da9;">TOTAL</th>
                                        <?php
                                        $contador = 0;
                                        $promedioSubcriterioMes = 0;
                                        $promedioCantidadSubcriterioMes = 0;

                                        foreach ($fechasSemanas as $fechaSemana) {
                                            $contador++;

                                            $notaSemana = 0;
                                            $cantidadSemana = 0;
                                            $sql = "SELECT SUM(nota)/COUNT(nota) AS total FROM grades WHERE employee_id = $employee AND id_criterio = {$criterios[$i]['id']} AND fecha_fin_semana = STR_TO_DATE('$fechaSemana', '%d/%m/%Y')";
                                            $resultadoNota = $conn->query($sql);
                                            $nota = $resultadoNota->fetch_assoc();

                                            isset($nota['total']) ? $notaCriterioSemana = $nota['total'] : $notaCriterioSemana = 0;

                                            if ($notaCriterioSemana > 0) {
                                                $notaSemana += $notaCriterioSemana;
                                                $cantidadSemana++;
                                            }
                                            $promedioSemana = ($cantidadSemana > 0)
                                                ? $notaSemana / $cantidadSemana
                                                : 0;

                                            if ($promedioSemana > 0) {
                                                $promedioSubcriterioMes += $promedioSemana;
                                                $promedioCantidadSubcriterioMes++;
                                            }
                                            $promedioSubcriterioTotalMes = ($promedioCantidadSubcriterioMes > 0)
                                                ? $promedioSubcriterioMes / $promedioCantidadSubcriterioMes
                                                : 0;

                                            if ($contador % 4 == 0) { ?>
                                                <th class="align-middle text-center text-white border-secondary"
                                                    style="background-color: #1e4da9;">
                                                    <?= $promedioSubcriterioTotalMes ?>
                                                </th>
                                                <?php
                                                $promedioSubcriterioMes = 0;
                                                $promedioCantidadSubcriterioMes = 0;
                                            }
                                        } ?>
                                        <th class="align-middle text-center text-white border-secondary"
                                            style="background-color: #1e4da9;">
                                            <?= $promedioSubcriterioTotalMes ?>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>
            </section>

            <section class="col-12 d-flex flex-column gap-4 px-0">
                <?php
                $sql = "SELECT * FROM criterios";
                $resultadoCriterios = $conn->query($sql);

                for ($i = 0; $i < count($criterios); $i++) { ?>
                    <div class="card">
                        <div class="card-body table-responsive">
                            <h5 class="fw-bold mb-3 text-uppercase">
                                NOTAS DE
                                <?= $criterios[$i]['nombre_criterio'] ?>
                            </h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="3" class="align-middle text-center text-white fs-5 border-secondary"
                                            style="background-color: #1e4da9;">
                                            <?= $i + 1 . '. ' . $criterios[$i]['nombre_criterio'] ?>
                                        </th>
                                        <?php for ($i2 = 1; $i2 <= $mesesTotal; $i2++) { ?>
                                            <th colspan="4" class="text-center border-secondary">
                                                MES
                                                <?= $i2 ?>
                                            </th>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php for ($i3 = 1; $i3 <= count($fechasSemanas); $i3++) { ?>
                                            <th class="text-center border-secondary">
                                                SEM
                                                <?= $i3 ?>
                                            </th>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php foreach ($fechasSemanas as $fecha) { ?>
                                            <th class="text-center text-white border-secondary"
                                                style="background-color: #54af0c;">
                                                <?= $fecha ?>
                                            </th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $totalNota = 0;
                                    $cantidadNotaTotal = 0;
                                    $sql = "SELECT * FROM subcriterios WHERE id_criterio = {$criterios[$i]['id']}";
                                    $resultadoSubcriterios = $conn->query($sql);

                                    while ($subcriterio = $resultadoSubcriterios->fetch_assoc()) {
                                        $subcriterioTotalNota = 0;
                                        $subcriterioCantidadNota = 0; ?>
                                        <tr>
                                            <td class="align-middle text-center border-secondary">
                                                <?= $subcriterio['nombre_subcriterio'] ?>
                                            </td>
                                            <?php foreach ($fechasSemanas as $fechaSemana) {
                                                $sql = "SELECT * FROM grades WHERE employee_id = $employee AND id_subcriterio = {$subcriterio['id']} AND id_criterio = {$criterios[$i]['id']} AND fecha_fin_semana = STR_TO_DATE('$fechaSemana', '%d/%m/%Y')";
                                                $resultadoNota = $conn->query($sql);
                                                $nota = $resultadoNota->fetch_assoc();

                                                if (isset($nota['nota'])) {
                                                    $subcriterioTotalNota += $nota['nota'];
                                                    $subcriterioCantidadNota++; ?>
                                                    <td class="align-middle text-center border-secondary">
                                                        <?= $nota['nota'] ?>
                                                        <?php
                                                        if ($user['id'] == 1 || $user['id'] == 2 || $user['id'] == 4) { ?>
                                                            <button class="btn btn-warning btn-sm edit" data-id="<?= $employee ?>"
                                                                data-criterio="<?= $criterios[$i]['id'] ?>" data-nota="<?= $nota['nota'] ?>"
                                                                data-subcriterio="<?= $subcriterio['id'] ?>"
                                                                data-fecha="<?= $fechaSemana ?>">
                                                                <i class="fa fa-pencil"></i>
                                                            </button>
                                                        <?php } ?>
                                                    </td>
                                                <?php } else { ?>
                                                    <td class="align-middle text-center border-secondary">0</td>
                                                <?php } ?>
                                            <?php }
                                            $totalNota += $subcriterioTotalNota;
                                            $cantidadNotaTotal += $subcriterioCantidadNota; ?>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <th class="text-center border-secondary">TOTAL DE SEMANAS</th>
                                        <?php $promedioNotas = ($cantidadNotaTotal > 0) ? $totalNota / $cantidadNotaTotal : 0;
                                        $promedioNotasArray[] = $promedioNotas;

                                        $promedioSubcriterios = array();
                                        foreach ($fechasSemanas as $fechaSemana) {
                                            $subcriterioTotalNotaSemana = 0;
                                            $subcriterioCantidadNotaSemana = 0;
                                            foreach ($resultadoSubcriterios as $subcriterio) {
                                                $sql = "SELECT * FROM grades WHERE employee_id = $employee AND id_subcriterio = {$subcriterio['id']} AND id_criterio = {$criterios[$i]['id']} AND fecha_fin_semana = STR_TO_DATE('$fechaSemana', '%d/%m/%Y')";
                                                $resultadoNota = $conn->query($sql);
                                                $nota = $resultadoNota->fetch_assoc();

                                                if (isset($nota['nota'])) {
                                                    $subcriterioTotalNotaSemana += $nota['nota'];
                                                    $subcriterioCantidadNotaSemana++;
                                                }
                                            }
                                            $promedioSubcriterioSemana = ($subcriterioCantidadNotaSemana > 0) ? $subcriterioTotalNotaSemana / $subcriterioCantidadNotaSemana : 0;
                                            $promedioSubcriterios[] = $promedioSubcriterioSemana; ?>
                                            <td class="align-middle text-center border-secondary">
                                                <?= $promedioSubcriterioSemana ?>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <th class="text-center text-white border-secondary"
                                            style="background-color: #1e4da9;">
                                            TOTAL
                                        </th>
                                        <td colspan="<?= count($fechasSemanas) ?>"
                                            class="text-center text-white border-secondary"
                                            style="background-color: #1e4da9;">
                                            <?= number_format($promedioNotas, 2) ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>
                <?php $promedioGeneral = 0;
                if (count($promedioNotasArray) > 0) {
                    $promedioGeneral = array_sum($promedioNotasArray) / count($promedioNotasArray);
                } ?>
            </section>
        </div>

        <!-- FOOTER -->
        <?php include 'includes/footer.php'; ?>
    </div>

    <!-- MODAL DE EDITAR NOTA -->
    <div class="modal fade" id="edit_notas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Editar Nota</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="includes/practicante_notas_edit.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <label for="nota" class="fw-bolder">Nota:</label>
                        <input type="number" class="form-control rounded text-center border-0 bg-light py-2" id="nota"
                            name="nota" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" name="edit_nota">
                            <i class="fa fa-pencil me-2"></i>Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DE ELIMINAR NOTA -->
    <div class="modal fade" id="delete_notas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Eliminar Notas</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="includes/practicante_notas_delete.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="empid" name="id">
                        <label for="fecha_fin_semana" class="fw-bolder">Fecha Final:</label>
                        <select class="form-control text-center" id="fecha_fin_semana" name="fecha_fin_semana">
                            <?php
                            if (isset($_GET['id'])) {
                                $sql = "SELECT DISTINCT fecha_fin_semana FROM grades WHERE employee_id = {$_GET['id']}";
                                $query = $conn->query($sql);
                                while ($prow = $query->fetch_assoc()) {
                                    echo "
                                    <option value='" . $prow['fecha_fin_semana'] . "'>" . $prow['fecha_fin_semana'] . "</option>
                                 ";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-danger" name="delete_nota">
                            <i class="fa fa-trash me-2"></i>Eliminar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/scripts.js"></script>

    <!-- MOSTRAR NOTA PROMEDIO TOTAL -->
    <script>
        $('#promedio-nota-final').html(<?= round($promedioGeneral, 2) ?>);
    </script>

    <!-- DATA PARA MODAL -->
    <script>
        $('#delete').on("click", function (e) {
            $('#delete_notas').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $('.edit').on("click", function (e) {
            var id = $(this).data('id');
            var criterio = $(this).data('criterio');
            var subcriterio = $(this).data('subcriterio');
            var fecha = $(this).data('fecha');
            var nota = $(this).data('nota');

            $.ajax({
                type: 'POST',
                url: 'employee_grades_row.php',
                data: {
                    id: id,
                    criterio: criterio,
                    subcriterio: subcriterio,
                    fecha: fecha
                },
                dataType: 'json',
                success: function (response) {
                    $('#id').val(response.id);
                    $('#nota').val(response.nota);
                    $('#edit_notas').modal('show');
                }
            });
        });

        function getRow(id) {
            $.ajax({
                type: 'POST',
                url: 'employee_row.php',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    $('#empid').val(response.empid);
                }
            });
        }
    </script>
</body>

</html>