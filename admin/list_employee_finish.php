<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $list_finish_click = "clicked" ?>
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
            ?>
            <div class="card">
                <div class="contenedor-leyenda">
                    <div class="filter-buttons">
                        <button id="filter-rojo" class="btn btn-danger"></button>
                        <button id="filter-gold" class="btn btn-warning"></button>
                        <button id="filter-verde" class="btn btn-success"></button>
                    </div>
                    <div class="leyenda">
                        <ul>
                            <li class="verde">En 3 semanas culminan practicas</li>
                            <li class="amarillo">En 2 semanas culminan practicas</li>
                            <li class="rojo-2">En 1 semana culminan practicas</li>
                        </ul>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <th class="align-middle">Codigo de Asistencia</th>
                            <th class="align-middle">Foto</th>
                            <th class="align-middle">Nombre</th>
                            <th class="align-middle">Unidad de Negocio</th>
                            <th class="align-middle">Area</th>
                            <th class="align-middle">Turno</th>
                            <th class="align-middle">Fecha de Salida</th>
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

                            while ($row = $query->fetch_assoc()) {
                                $id = $row['id'];
                                $fechaActual = date("Y-m-d");
                                $actual = new DateTime($fechaActual);
                                $fechaFinal = new DateTime($row['date_out']);
                                $diferencia = $fechaFinal->diff($actual);
                                $diasDiferencia = $diferencia->days;
                                $scheduleId = $row['schedule_id'];
                                if ($diferencia->days <= 21 && $diferencia->days > 14) { ?>
                                    <tr data-days='<?php echo $diasDiferencia; ?>'>
                                        <td class="align-middle" style="background-color: #5eb130;">
                                            <?= $row['employee_id']; ?>
                                        </td>
                                        <td class="align-middle" style="background-color: #5eb130;">
                                            <img src="<?= (!empty($row['photo'])) ? '../images/' . $row['photo'] : '../images/profile.jpg'; ?>" width="30px" height="30px">
                                        </td>
                                        <td class="align-middle" style="background-color: #5eb130;">
                                            <?= $row['firstname'] . ' ' . $row['lastname']; ?>
                                        </td>
                                        <td class="align-middle" style="background-color: #5eb130;">
                                            <?= $row['nombre_negocio']; ?>
                                        </td>
                                        <td class="align-middle" style="background-color: #5eb130;">
                                            <?= $row['description']; ?>
                                        </td>
                                        <td class="align-middle" style="background-color: #5eb130;">
                                            <?php
                                            if ($scheduleId == 2) {
                                                echo 'Dia';
                                            } elseif ($scheduleId == 3) {
                                                echo 'Tarde';
                                            } else {
                                                echo 'Horario no definido';
                                            }
                                            ?>
                                        </td>
                                        <td class="align-middle" style="background-color: #5eb130;">
                                        <?=$row['date_out'];
                                        ?>
                                        </td>
                                    </tr>
                                <?php } 
                                if ($diferencia->days <= 14 && $diferencia->days > 7) { ?>
                                    <tr data-days='<?php echo $diasDiferencia; ?>'>
                                        <td class="align-middle" style="background-color: gold;">
                                            <?= $row['employee_id']; ?>
                                        </td>
                                        <td class="align-middle" style="background-color: gold;">
                                            <img src="<?= (!empty($row['photo'])) ? '../images/' . $row['photo'] : '../images/profile.jpg'; ?>" width="30px" height="30px">
                                        </td>
                                        <td class="align-middle" style="background-color: gold;">
                                            <?= $row['firstname'] . ' ' . $row['lastname']; ?>
                                        </td>
                                        <td class="align-middle" style="background-color: gold;">
                                            <?= $row['nombre_negocio']; ?>
                                        </td>
                                        <td class="align-middle" style="background-color: gold;">
                                            <?= $row['description']; ?>
                                        </td>
                                        <td class="align-middle" style="background-color: gold;">
                                            <?php
                                            if($scheduleId == 2){
                                                echo 'Dia';
                                            }elseif($scheduleId == 3){
                                                echo 'Tarde';
                                            }else{
                                                echo 'Horario no definido';
                                            }
                                            ?>
                                        </td>
                                        <td class="align-middle" style="background-color: gold;">
                                            <?=$row['date_out'];?>
                                        </td>
                                    </tr>
                                <?php } 
                                if ($diferencia->days <= 7 && $diferencia->days >= 0) { ?>
                                    <tr data-days='<?php echo $diasDiferencia; ?>'>
                                        <td class="align-middle" style="background-color: #DC3545;">
                                            <?= $row['employee_id']; ?>
                                        </td>
                                        <td class="align-middle" style="background-color: #DC3545;">
                                            <img src="<?= (!empty($row['photo'])) ? '../images/' . $row['photo'] : '../images/profile.jpg'; ?>" width="30px" height="30px">
                                        </td>
                                        <td class="align-middle" style="background-color: #DC3545;">
                                            <?= $row['firstname'] . ' ' . $row['lastname']; ?>
                                        </td>
                                        <td class="align-middle" style="background-color: #DC3545;">
                                            <?= $row['nombre_negocio']; ?>
                                        </td>
                                        <td class="align-middle" style="background-color: #DC3545;">
                                            <?= $row['description']; ?>
                                        </td>
                                        <td class="align-middle" style="background-color: #DC3545;">
                                            <?php
                                            if($scheduleId == 2){
                                                echo 'Dia';
                                            }elseif($scheduleId == 3){
                                                echo 'Tarde';
                                            }else{
                                                echo 'No definido';
                                            }
                                            ?>
                                        </td>
                                        <td class="align-middle" style="background-color: #DC3545;">
                                        <?=$row['date_out'];?>
                                        </td>
                                    </tr>
                                <?php } ?>
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