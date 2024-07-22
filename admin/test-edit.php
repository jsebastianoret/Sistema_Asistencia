<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $test_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php'
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
                <div class="ms-auto">
                    <button class="button-secondary" data-bs-target="#add_pregunta" data-bs-toggle="modal">
                        <i class="fa fa-plus me-2"></i>Nueva Pregunta
                    </button>
                </div>
                <div class="card-body table-responsive">
                    <?php if ($_GET['test'] == 3) { ?>
                        <table id="example1" class="table table-bordered">
                            <thead>
                                <th class="align-middle text-center">Pregunta 1</th>
                                <th class="align-middle text-center">Pregunta 2</th>
                                <th class="align-middle text-center">Valor1</th>
                                <th class="align-middle text-center">Valor2</th>
                                <th class="align-middle text-center">Estado</th>
                                <th class="align-middle text-center">Accion</th>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT *
                                        FROM preguntas_test WHERE test = '{$_GET['test']}'";
                                $query = $conn->query($sql);

                                while ($row = $query->fetch_assoc()) {
                                    if (isset($row['pregunta1'])) { ?>
                                        <tr>
                                            <td class="align-middle text-center">
                                                <?php echo $row['pregunta1'] ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php echo $row['pregunta2'] ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php echo $row['valor_1'] ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php echo $row['valor_2'] ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php echo $row['estado'] ?>
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex flex-wrap justify-content-center gap-1">
                                                    <button class="btn btn-success btn-sm rounded-3 edit" data-id="<?= $row['id'] ?>">
                                                        <i class="fa fa-edit"></i> Editar
                                                    </button>
                                                    <button class="btn btn-danger btn-sm rounded-3 delete" data-id="<?= $row['id'] ?>">
                                                        <i class="fa fa-trash"></i> Eliminar
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <table id="example1" class="table table-bordered">
                            <thead>
                                <?php 
                                if ($_GET['test'] == 1){?>
                                <th class="align-middle text-center">Pregunta</th>
                                <th class="align-middle text-center">Valor 1</th>
                                <th class="align-middle text-center">Valor 2</th>
                                <th class="align-middle text-center">Accion</th>
                                <?php } else { ?>
                                <th class="align-middle text-center">Pregunta</th>
                                <th class="align-middle text-center">Opcion 1</th>
                                <th class="align-middle text-center">Opcion 2</th>
                                <th class="align-middle text-center">Opcion 3</th>
                                <th class="align-middle text-center">Opcion 4</th>
                                <th class="align-middle text-center">Opcion 5</th>
                                <th class="align-middle text-center">Valor 1</th>
                                <th class="align-middle text-center">Valor 2</th>
                                <th class="align-middle text-center">Valor 3</th>
                                <th class="align-middle text-center">Valor 4</th>
                                <th class="align-middle text-center">Valor 5</th>
                                <th class="align-middle text-center">Accion</th>
                                <?php } ?>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT *
                                        FROM preguntas_test WHERE test = '{$_GET['test']}'";
                                $query = $conn->query($sql);

                                while ($row = $query->fetch_assoc()) {
                                    if (isset($row['pregunta1'])) { ?>
                                        <tr>
                                            <?php 
                                            if ($_GET['test'] == 1){?>
                                            <td class="align-middle text-center">
                                                <?php echo $row['pregunta1'] ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php echo $row['valor_1'] ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php echo $row['valor_2'] ?>
                                            </td>
                                            <?php } else { ?>
                                            <td class="align-middle text-center">
                                                <?php echo $row['pregunta1'] ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php echo $row['opc_1'] ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php echo $row['opc_2'] ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php echo $row['opc_3'] ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php echo $row['opc_4'] ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php echo $row['opc_5'] ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php echo $row['valor_1'] ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php echo $row['valor_2'] ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php echo $row['valor_3'] ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php echo $row['valor_4'] ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php echo $row['valor_5'] ?>
                                            </td>
                                            <?php } ?>
                                            <td class="align-middle">
                                                <div class="d-flex flex-wrap justify-content-center gap-1">
                                                    <button class="btn btn-success btn-sm rounded-3 edit" data-id="<?= $row['id'] ?>">
                                                        <i class="fa fa-edit"></i> Editar
                                                    </button>
                                                    <button class="btn btn-danger btn-sm rounded-3 delete" data-id="<?= $row['id'] ?>">
                                                        <i class="fa fa-trash"></i> Eliminar
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>

                    <a href="test-panel.php" style="display:flex ;justify-content: right;"><input type="button" class="btn text-white letraNavBar rounded-pill px-6 " value="Atras" style="background: #1e4da9;"></a>
                </div>
            </div>
        </section>
        <?php $tipo = $_GET['test']; ?>        
         <!-- MODAL DE AGREGAR PREGUNTA -->
        <div class="modal fade" id="add_pregunta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-3">
                    <div class="modal-header py-2">
                        <h4 class="modal-title text-white fw-bold ms-auto">Agregar Pregunta</h4>
                        <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="includes/test_add.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body d-flex flex-column gap-2 py-4 px-5">
                            <div class="row">
                                <input type="hidden" class="empid" name="test" value=<?php echo $tipo?>>
                                <?php 
                                if ($_GET['test'] == 3){?>
                                <div class="col-sm-13 ">
                                    <label for="pregunta1" class="fw-bolder">Pregunta 1</label>
                                    <input type="text" class="form-control rounded" id="pregunta1" name="pregunta1" required>
                                </div>
                                <div class="col-sm-13 ">
                                    <label for="pregunta2" class="fw-bolder">Pregunta 2</label>
                                    <input type="text" class="form-control rounded" id="pregunta2" name="pregunta2" required>
                                </div>
                                <?php } else { ?>
                                <div class="col-sm-13 ">

                                    <?php 
                                    if ($_GET['test'] == 1){?>
                                    <label for="pregunta1" class="fw-bolder">Pregunta</label>
                                    <input type="text" class="form-control rounded" id="pregunta1" name="pregunta1" required>
                                    <?php } else { ?>

                                    <label for="pregunta1" class="fw-bolder">Pregunta</label>
                                    <input type="text" class="form-control rounded" id="pregunta1" name="pregunta1" required>
                                    <label for="opc1" class="fw-bolder">Opcion 1</label>
                                    <input type="text" class="form-control rounded" id="opc1" name="opc1" >
                                    <label for="opc2" class="fw-bolder">Opcion 2</label>
                                    <input type="text" class="form-control rounded" id="opc2" name="opc2" >
                                    <label for="opc3" class="fw-bolder">Opcion 3</label>
                                    <input type="text" class="form-control rounded" id="opc3" name="opc3" >
                                    <label for="opc4" class="fw-bolder">Opcion 4</label>
                                    <input type="text" class="form-control rounded" id="opc4" name="opc4" >
                                    <label for="opc5" class="fw-bolder">Opcion 5</label>
                                    <input type="text" class="form-control rounded" id="opc5" name="opc5" >
                                    <?php } ?>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <?php 
                                if ($_GET['test'] == 1){?>
                                <div id="campos-dinamicos">
                                <div class="col-sm-4">
                                    <label for="valor1" class="fw-bolder">Valor 1</label>
                                    <input type="text" class="form-control rounded" id="valor1" name="valor1" required>
                                </div>
                                <div class="col-sm-4">
                                    <label for="valor2" class="fw-bolder">Valor 2</label>
                                    <input type="text" class="form-control rounded" id="valor2" name="valor2" required>
                                </div>
                                </div>
                                <?php } else { ?>
                                <div class="col-sm-4">
                                    <label for="valor1" class="fw-bolder">Valor 1</label>
                                    <input type="text" class="form-control rounded" id="valor1" name="valor1" required>
                                </div>
                                <div class="col-sm-4">
                                    <label for="valor2" class="fw-bolder">Valor 2</label>
                                    <input type="text" class="form-control rounded" id="valor2" name="valor2" required>
                                </div>
                                <div class="col-sm-4">
                                    <label for="valor3" class="fw-bolder">Valor 3</label>
                                    <input type="text" class="form-control rounded" id="valor3" name="valor3" >
                                </div>
                                <div class="col-sm-4">
                                    <label for="valor4" class="fw-bolder">Valor 4</label>
                                    <input type="text" class="form-control rounded" id="valor4" name="valor4" >
                                </div>
                                <div class="col-sm-4">
                                    <label for="valor5" class="fw-bolder">Valor 5</label>
                                    <input type="text" class="form-control rounded" id="valor5" name="valor5" >
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" id="agregar-campo" onclick="agregarCampo()">Agregar Campo</button>

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" name="add" >
                                <i class="fa-solid fa-floppy-disk me-2"></i>Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- MODAL DE EDITAR PREGUNTA -->
    <div class="modal fade" id="edit_pregunta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Modificar Pregunta</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="includes/test_edit.php">
                    <div class="modal-body d-flex flex-column gap-2 py-4 px-5">
                        <input type="hidden" class="empid" name="id">
                        <div class="row">
                        <input type="hidden" class="edittest" name="edittest" value=<?php echo $tipo?>>
                        <?php 
                                if ($_GET['test'] == 3){?>
                                <div class="col-sm-13 ">
                                    <label for="editpregunta1" class="fw-bolder">Pregunta 1</label>
                                    <input type="text" class="form-control rounded" id="editpregunta1" name="editpregunta1" required>
                                </div>
                                <div class="col-sm-13 ">
                                    <label for="editpregunta2" class="fw-bolder">Pregunta 2</label>
                                    <input type="text" class="form-control rounded" id="editpregunta2" name="editpregunta2" required>
                                </div>
                                <?php } else { ?>
                                    <div class="col-sm-13 ">
                                    <?php 
                                    if ($_GET['test'] == 1){?>
                                    <label for="editpregunta1" class="fw-bolder">Pregunta</label>
                                    <input type="text" class="form-control rounded" id="editpregunta1" name="editpregunta1" required>
                                    <?php } else { ?>
                                    <label for="editpregunta1" class="fw-bolder">Pregunta</label>
                                    <input type="text" class="form-control rounded" id="editpregunta1" name="editpregunta1" required>
                                    <label for="editopc1" class="fw-bolder">Opcion 1</label>
                                    <input type="text" class="form-control rounded" id="editopc1" name="editopc1" >
                                    <label for="editopc2" class="fw-bolder">Opcion 2</label>
                                    <input type="text" class="form-control rounded" id="editopc2" name="editopc2" >
                                    <label for="editopc3" class="fw-bolder">Opcion 3</label>
                                    <input type="text" class="form-control rounded" id="editopc3" name="editopc3" >
                                    <label for="editopc4" class="fw-bolder">Opcion 4</label>
                                    <input type="text" class="form-control rounded" id="editopc4" name="editopc4" >
                                    <label for="editopc5" class="fw-bolder">Opcion 5</label>
                                    <input type="text" class="form-control rounded" id="editopc5" name="editopc5" >
                                    <?php } ?>
                                </div>
                                <?php } ?>
                        </div>
                        <div class="row">
                            
                                <?php 
                                if ($_GET['test'] == 1){?>
                                <div class="col-sm-4">
                                    <label for="editvalor1" class="fw-bolder">Valor 1</label>
                                    <input type="text" class="form-control rounded" id="editvalor1" name="editvalor1" required>
                                </div>
                                <div class="col-sm-4">
                                    <label for="editvalor2" class="fw-bolder">Valor 2</label>
                                    <input type="text" class="form-control rounded" id="editvalor2" name="editvalor2" required>
                                </div>
                                
                                <?php } else { ?>
                                <div class="col-sm-4">
                                    <label for="editvalor1" class="fw-bolder">Valor 1</label>
                                    <input type="text" class="form-control rounded" id="editvalor1" name="editvalor1" required>
                                </div>
                                <div class="col-sm-4">
                                    <label for="editvalor2" class="fw-bolder">Valor 2</label>
                                    <input type="text" class="form-control rounded" id="editvalor2" name="editvalor2" required>
                                </div>
                                <div class="col-sm-4">
                                    <label for="editvalor3" class="fw-bolder">Valor 3</label>
                                    <input type="text" class="form-control rounded" id="editvalor3" name="editvalor3" required>
                                </div>
                                <div class="col-sm-4">
                                    <label for="editvalor4" class="fw-bolder">Valor 4</label>
                                    <input type="text" class="form-control rounded" id="editvalor4" name="editvalor4" required>
                                </div>
                                <div class="col-sm-4">
                                    <label for="editvalor5" class="fw-bolder">Valor 5</label>
                                    <input type="text" class="form-control rounded" id="editvalor5" name="editvalor5" required>
                                </div>
                                <?php } ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="edit">
                            <i class="fa fa-edit me-2"></i>Agregar Valor
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" name="edit">
                            <i class="fa fa-edit me-2"></i>Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DE ELIMINAR PREGUNTA -->
    <div class="modal fade" id="delete_pregunta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Eliminar Pregunta</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center fw-bolder">
                        ¿Está seguro de eliminar la Pregunta?
                    </h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form method="POST" action="includes/test-delete.php">
                        <input type="hidden" class="empid" name="id">
                        <input type="hidden" class="test" name="test" value=<?php echo $tipo?>>
                        <button type="submit" class="btn btn-danger" name="delete">
                            <i class="fa fa-trash me-2"></i>Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <!-- FOOTER -->
        <?php include 'includes/footer.php'; ?>
    </div>
    <?php include 'includes/scripts2.php'; ?>

    <script src="js/scripts.js"></script>
    <script>
        $('.edit').on("click", function (e) {
            $('#edit_pregunta').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $('.delete').on("click", function (e) {
            $('#delete_pregunta').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        function getRow(id) {
            $.ajax({
                type: 'POST',
                url: 'test_row.php',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    $('.empid').val(response.id);
                    $('#editpregunta1').val(response.pregunta1);
                    $('#editpregunta2').val(response.pregunta2);
                    $('#editopc1').val(response.opc_1);
                    $('#editopc2').val(response.opc_2);
                    $('#editopc3').val(response.opc_3);
                    $('#editopc4').val(response.opc_4);
                    $('#editopc5').val(response.opc_5);
                    $('#editvalor1').val(response.valor_1);
                    $('#editvalor2').val(response.valor_2);
                    $('#editvalor3').val(response.valor_3);
                    $('#editvalor4').val(response.valor_4);
                    $('#editvalor5').val(response.valor_5);
                }
            });
        }
    </script>
    <script>
    // Contador para llevar el registro de cuántos campos se han agregado
    var contadorCampos = 2;

    // Función para agregar un nuevo campo de valor
    function agregarCampo() {
        if (contadorCampos < 5) { // Verifica que no se haya alcanzado el máximo de 5 campos
            var container = document.getElementById('campos-dinamicos');
            var nuevoCampo = document.createElement('div');
            nuevoCampo.classList.add('col-sm-4');
            nuevoCampo.innerHTML = `
                <label class="fw-bolder">Valor ${contadorCampos + 1}</label>
                <input type="text" class="form-control rounded" name="valor1[]" required>
            `;
            container.appendChild(nuevoCampo);
            contadorCampos++; // Incrementa el contador de campos agregados
        } else {
            alert('Ya se ha alcanzado el máximo de 5 campos.');
        }
    }
</script>

</body>

</html>