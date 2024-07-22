<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $horarios_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>
        <?php
        $gestionCargos = $permisoCargos['actualizar'];
        $gestionCargos2 = $permisoCargos['eliminar'];
        $gestionCargos3 = $permisoCargos['crear'];
        $gestionCargos4 = $permisoCargos['leer'];

        if ($gestionCargos4 == "No") {
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
            <div class="row">

                <?php
                $gestionAsistencia = $permisoPracticantes['actualizar'];
                $gestionAsistencia2 = $permisoPracticantes['eliminar'];
                $gestionAsistencia3 = $permisoPracticantes['crear'];
                ?>

                <div class="card">
                            <?php
                            if ($gestionAsistencia3 == "Sí") {
                            ?><div class="me-auto">
                                    <button class="button-secondary" data-bs-target="#addnew" data-bs-toggle="modal">
                                        <i class="fa fa-plus me-2"></i>Nuevo
                                    </button>
                                </div>
                            <?php }
                            ?>
                        <div class="card-body table-responsive">

                            <table class="table table-bordered">
                                <thead>
                                    <th class="align-middle">Tiempo Entrada</th>
                                    <th class="align-middle">Tiempo Salida</th>
                                    <th class="align-middle">Acción</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM schedules";
                                    $query = $conn->query($sql);
                                    while ($row = $query->fetch_assoc()) { ?> 
                                        <tr>
                                            <td>
                                                <?php echo date('h:i A', strtotime($row['time_in']))?>
                                            </td>
                                            <td>
                                                <?php echo date('h:i A', strtotime($row['time_out'])) ?>
                                            </td>
                                            <td>
                                                <?php if ($gestionAsistencia == "Sí") { ?>                      
                                                    <button class="btn btn-success btn-sm rounded-3 edit" data-id="<?= $row['id'] ?>" data-bs-target="#edit" data-bs-toggle="modal">
                                                        <i class="fa fa-edit"></i> Editar
                                                    </button>
                                                <?php }
                                                if ($gestionAsistencia2 == "Sí") { ?>
                                                    <button class="btn btn-danger btn-sm rounded-3 delete" data-id="<?= $row['id'] ?> " data-bs-target="#delete" data-bs-toggle="modal">
                                                        <i class="fa fa-trash"></i> Eliminar
                                                    </button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                <?php } ?>       
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <?php include 'includes/footer.php'; ?>
        <?php include 'includes/scripts.php'; ?>
    </div>

    <!-- MODAL DE AGREGAR -->
    <div class="modal fade" id="addnew" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Agregar Horario</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form  method="POST" action="schedule_add.php">
                        <div class="form-group">
                            <label for="time_in" class="fw-bolder">Hora Entrada</label>

                            <div class="col-sm-9">
                                <div class="bootstrap-timepicker">
                                    <input type="text" class="form-control timepicker" id="time_in" name="time_in" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="time_out" class="fw-bolder">Hora Salida</label>

                            <div class="col-sm-9">
                                <div class="bootstrap-timepicker">
                                    <input type="text" class="form-control timepicker" id="time_out" name="time_out" required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" name="add"><i class="fa-solid fa-floppy-disk me-2"></i> Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DE EDITAR -->                                                
    <div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Modificar Horario</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form  method="POST" action="schedule_edit.php">
                        <input type="hidden" id="timeid" name="id">
                        <div class="form-group">
                            <label for="edit_time_in" class="fw-bolder">Hora Entrada</label>

                            <div class="col-sm-9">
                                <div class="bootstrap-timepicker">
                                    <input type="text" class="form-control timepicker" id="edit_time_in" name="time_in" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_time_out" class="fw-bolder">Hora Salida</label>

                            <div class="col-sm-9">
                                <div class="bootstrap-timepicker">
                                    <input type="text" class="form-control timepicker" id="edit_time_out" name="time_out" required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" name="edit"><i class="fa-solid fa-floppy-disk me-2"></i> Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DE ELIMINAR -->                                                
    <div class="modal fade" id="delete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Eliminar Horario</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form  method="POST" action="schedule_delete.php">
                        <input type="hidden" id="del_timeid" name="id">
                        <div class="text-center">
	                	    <p>Borrar Horario</p>
	                	    <h2 id="del_schedule" class="bold"></h2>
	            	    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" name="delete"><i class="fa-solid fa-floppy-disk me-2"></i> Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        $('.edit').click(function(e) {
            e.preventDefault();
            $('#edit').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $('.delete').click(function(e) {
            e.preventDefault();
            $('#delete').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });


        function getRow(id) {
            $.ajax({
                type: 'POST',
                url: 'schedule_row.php',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    $('#timeid').val(response.id);
                    $('#edit_time_in').val(response.time_in);
                    $('#edit_time_out').val(response.time_out);
                    $('#del_timeid').val(response.id);
                    $('#del_schedule').html(response.time_in + ' - ' + response.time_out);
                }
            });
        }
    </script>
</body>