<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $programar_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="content p-0 px-3 my-4">
            <?php
            if (isset($_SESSION['evento_guardado']) && $_SESSION['evento_guardado'] === true) {
                echo '<div class="alert alert-success">Evento guardado exitosamente.</div>';
                unset($_SESSION['evento_guardado']);
            } else if (isset($_SESSION['evento_no_guardado']) && $_SESSION['evento_no_guardado'] === true) {
                echo '<div class="alert alert-danger">Error al guardar el evento. Inténtalo de nuevo.</div>';
                unset($_SESSION['evento_no_guardado']);
            } else if (isset($_SESSION['evento_actualizado']) && $_SESSION['evento_actualizado'] === true) {
                echo '<div class="alert alert-success">Evento actualizado exitosamente.</div>';
                unset($_SESSION['evento_actualizado']);
            } else if (isset($_SESSION['evento_no_actualizado']) && $_SESSION['evento_no_actualizado'] === true) {
                echo '<div class="alert alert-danger">Error al actualizar el evento. Inténtalo de nuevo.</div>';
                unset($_SESSION['evento_no_actualizado']);
            } else if (isset($_SESSION['evento_eliminado']) && $_SESSION['evento_eliminado'] === true) {
                echo '<div class="alert alert-success">Evento eliminado exitosamente.</div>';
                unset($_SESSION['evento_eliminado']);
            } else if (isset($_SESSION['evento_no_eliminado']) && $_SESSION['evento_no_eliminado'] === true) {
                echo '<div class="alert alert-danger">Error al eliminar el evento. Inténtalo de nuevo.</div>';
                unset($_SESSION['evento_no_eliminado']);
            }
            ?>

            <h5 class="fw-bold">REDACTA UN MENSAJE PARA TODO EL EQUIPO</h5>
            <p>Aquí la leyenda para que los colaboradores sepan qué tipo de evento hay.<br>General, por unidad, por
                persona.</p>
            <button class="button-secondary" data-bs-toggle="modal" data-bs-target="#add_evento">
                <i class="fa fa-plus me-2"></i>Nuevo Evento
            </button>

            <!-- TABLA EVENTOS -->
            <div class="card mt-4">
                <div class="card-body table-responsive">
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="d-none"></th>
                                <th class="text-center">Publicacion</th>
                                <th class="text-center">Titulo</th>
                                <th class="text-center">Contenido</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Hora</th>
                                <th class="text-center">Imagen</th>
                                <th class="text-center">Color</th>
                                <th class="text-center">Negocio</th>
                                <th class="text-center">Empleado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT e.id, e.tipo_publicacion, CONCAT(em.firstname, ' ', em.lastname) AS nombre_empleado, e.titulo, e.contenido, e.fecha, e.hora, e.imagen_url , e.color, n.nombre_negocio, e.id_empleado, e.id_negocio
                            FROM eventos2 e
                            LEFT JOIN employees em ON e.id_empleado = em.id
                            LEFT JOIN negocio n ON e.id_negocio = n.id";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td class="d-none"></td>
                                        <td class="align-middle text-center">
                                            <?php echo $row['tipo_publicacion'] ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo $row['titulo'] ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo $row['contenido'] ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo $row['fecha'] ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo $row['hora'] ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo $row['imagen_url'] ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div style="padding: 16px; background-color: <?php echo $row["color"] ?>"></div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo $row['nombre_negocio'] ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo $row['nombre_empleado'] ?>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                                <input type="hidden" id="edit-<?php echo $row["id"] ?>"
                                                    value="<?php echo $row["id"] ?>">
                                                <input type="hidden" id="publicacion-<?php echo $row["id"] ?>"
                                                    value="<?php echo $row["tipo_publicacion"] ?>">
                                                <input type="hidden" id="titulo-<?php echo $row["id"] ?>"
                                                    value="<?php echo $row["titulo"] ?>">
                                                <input type="hidden" id="contenido-<?php echo $row["id"] ?>"
                                                    value="<?php echo $row["contenido"] ?>">
                                                <input type="hidden" id="fecha-<?php echo $row["id"] ?>"
                                                    value="<?php echo $row["fecha"] ?>">
                                                <input type="hidden" id="hora-<?php echo $row["id"] ?>"
                                                    value="<?php echo $row["hora"] ?>">
                                                <input type="hidden" id="imagen_url-<?php echo $row["id"] ?>"
                                                    value="<?php echo $row["imagen_url"] ?>">
                                                <input type="hidden" id="color-<?php echo $row["id"] ?>"
                                                    value="<?php echo $row["color"] ?>">
                                                <input type="hidden" id="negocio-<?php echo $row["id"] ?>"
                                                    value="<?php echo $row["id_negocio"] ?>">
                                                <input type="hidden" id="empleado-<?php echo $row["id"] ?>"
                                                    value="<?php echo $row["id_empleado"] ?>">
                                                <button class="btn btn-success btn-sm text-white rounded-3 button-edit-eventos"
                                                    data-bs-toggle="modal" data-bs-target="#edit_evento"
                                                    data-id="<?php echo $row["id"] ?>">
                                                    <i class="fa fa-edit"></i> Editar
                                                </button>
                                                <button class="btn btn-danger btn-sm text-white rounded-3 delete"
                                                    data-bs-toggle="modal" data-bs-target="#delete_evento"
                                                    data-id="<?php echo $row["id"] ?>">
                                                    <i class="fa fa-trash"></i> Eliminar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="10" class="text-center">No hay datos disponibles</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include 'includes/footer.php'; ?>
    </div>

    <!-- MODAL DE AGREGAR EVENTO-->
    <div class="modal fade" id="add_evento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Agregar Evento</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="includes/evento_add.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body d-flex flex-column gap-3 py-4 px-5">
                        <div class="d-flex mb-4 gap-3">
                            <div class="position-relative">
                                <select id="tipo-publicacion" name="tipo_publicacion" required>
                                    <option value="" selected disabled>TIPO DE EVENTO</option>
                                    <option value="GENERAL">GENERAL</option>
                                    <option value="UNIDAD">UNIDAD</option>
                                    <option value="PERSONA">PERSONA</option>
                                </select>
                                <div class="select-icon">
                                    <svg width="20" height="12" viewBox="0 0 27 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="Group 44">
                                            <path id="Polygon 1"
                                                d="M13.0886 17.0677L1.76371 4.37678L24.2801 4.25904L13.0886 17.0677Z"
                                                fill="white" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <div id="empleados-select" class="w-100"></div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="event-datatype">TÍTULO</div>
                            <input type="text" class="rounded-pill border-0 bg-light w-100 px-4" name="titulo" required>
                        </div>
                        <div class="editor-container">
                            <textarea id="content" contenteditable="true" class="editor-content w-100" name="contenido"
                                spellcheck="false" required></textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-6 d-flex gap-2">
                                <div class="event-datatype">FECHA</div>
                                <input type="date" class="rounded-pill border-0 bg-light w-100 px-4 text-center"
                                    name="fecha" required>
                            </div>
                            <div class="col-6 d-flex gap-2">
                                <div class="event-datatype">HORA</div>
                                <input type="time" class="rounded-pill border-0 bg-light w-100 px-4 text-center"
                                    name="hora" required>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="event-datatype">IMAGEN</div>
                            <input type="file" class="rounded-pill border-0 bg-light w-100 px-4 pt-1" name="imagen">
                        </div>
                        <div class="d-flex gap-2">
                            <div class="event-datatype">COLOR</div>
                            <input type="color" class="rounded-pill border-0 bg-light w-100 px-4" name="color" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" name="add">
                            <i class="fa-solid fa-bullhorn me-2"></i>Publicar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DE EDITAR EVENTO -->
    <div class="modal fade" id="edit_evento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Editar Evento</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="includes/evento_edit.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="id_evento" name="id_evento">

                    <div class="modal-body d-flex flex-column gap-3 py-4 px-5">
                        <div class="d-flex mb-4 gap-3">
                            <div class="position-relative">
                                <select id="edit-tipo-publicacion" name="tipo_publicacion" required>
                                    <option value="" selected disabled>TIPO DE EVENTO</option>
                                    <option value="GENERAL">GENERAL</option>
                                    <option value="UNIDAD">UNIDAD</option>
                                    <option value="PERSONA">PERSONA</option>
                                </select>
                                <div class="select-icon">
                                    <svg width="20" height="12" viewBox="0 0 27 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="Group 44">
                                            <path id="Polygon 1"
                                                d="M13.0886 17.0677L1.76371 4.37678L24.2801 4.25904L13.0886 17.0677Z"
                                                fill="white" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <div id="edit-empleados-select" class="w-100"></div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="event-datatype">TÍTULO</div>
                            <input type="text" id="edit-titulo" class="rounded-pill border-0 bg-light w-100 px-4"
                                name="titulo" required>
                        </div>
                        <div class="editor-container">
                            <textarea id="edit-content" contenteditable="true" class="editor-content w-100"
                                name="contenido" spellcheck="false" required></textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-6 d-flex gap-2">
                                <div class="event-datatype">FECHA</div>
                                <input type="date" id="edit-fecha"
                                    class="rounded-pill border-0 bg-light w-100 px-4 text-center" name="fecha" required>
                            </div>
                            <div class="col-6 d-flex gap-2">
                                <div class="event-datatype">HORA</div>
                                <input type="time" id="edit-hora"
                                    class="rounded-pill border-0 bg-light w-100 px-4 text-center" name="hora" required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-6 d-flex gap-2">
                                <div class="event-datatype">IMAGEN CARGADA</div>
                                <div id="edit-imagen"
                                    class="rounded-pill border-0 bg-light w-100 px-4 d-flex align-items-center">
                                    Imagen no cargada.</div>
                            </div>
                            <div class="col-6 d-flex gap-2">
                                <div class="event-datatype">NUEVA IMAGEN</div>
                                <input type="file" class="rounded-pill border-0 bg-light w-100 px-4 pt-3" name="imagen">
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="event-datatype">COLOR</div>
                            <input type="color" id="edit-color" class="rounded-pill border-0 bg-light w-100 px-4"
                                name="color" required>
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

    <!-- MODAL DE ELIMINAR EVENTO -->
    <div class="modal fade" id="delete_evento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Eliminar Evento</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center fw-bolder">
                        ¿Está seguro de eliminar este evento?
                    </h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form method="POST" action="includes/evento_delete.php">
                        <input type="hidden" id="evento_id" name="evento_id">
                        <button type="submit" id="btn-eliminar" class="btn btn-danger" name="delete">
                            <i class="fa fa-trash me-2"></i>Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/scripts2.php'; ?>

    <script src="js/scripts.js"></script>
    <script src="../js/textEditor.js"></script>

    <!-- PLACEHOLDER Y FOCUS DE TEXTAREA -->
    <script>
        const editor = document.getElementById('content');
        const placeholderText = 'Describir publicación...';
        if (editor.textContent.trim() === '') {
            editor.textContent = placeholderText;
        }

        editor.addEventListener('focus', () => {
            if (editor.textContent === placeholderText) {
                editor.textContent = '';
            }
        });

        editor.addEventListener('blur', () => {
            if (editor.textContent === '') {
                editor.textContent = placeholderText;
            }
        });
    </script>

    <?php
    $sql2 = "SELECT * FROM employees";
    $result2 = $conn->query($sql2);
    $sql3 = "SELECT id, nombre_negocio FROM negocio";
    $result3 = $conn->query($sql3);
    ?>

    <?php
    $sql4 = "SELECT * FROM employees";
    $result4 = $conn->query($sql4);
    $sql5 = "SELECT id, nombre_negocio FROM negocio";
    $result5 = $conn->query($sql5);
    ?>

    <!-- SELECT TIPO EVENTO -->
    <script>
        var alerta = document.querySelector('.alert-success');

        if (alerta) {
            setTimeout(function () {
                alerta.style.display = 'none';
            }, 3000);
        }

        var tipoPublicacionSelect = document.getElementById('tipo-publicacion');
        var empleadosSelectDiv = document.getElementById('empleados-select');

        tipoPublicacionSelect.addEventListener('change', function () {
            if (tipoPublicacionSelect.value === 'PERSONA') {
                empleadosSelectDiv.innerHTML = `
                <?php
                if ($result2->num_rows > 0) {
                    echo '<div class="d-flex gap-3">
                                <input type="text" id="searchInput" class="event-datatype-content select-employee form-control" placeholder="Buscar Empleadoed">
                                <select name="empleado" id="empleado" class="event-datatype-content select-employee form-select" required>
                                    <option value="" selected disabled>Selecciona un empleado</option>';
                    while ($row = $result2->fetch_assoc()) {
                        echo "<option value='" . $row["id"] . "'>" . $row["firstname"] . " " . $row["lastname"] . "</option>";
                    }
                    echo '</select>
                        </div>';
                } else {
                    echo "No se encontraron resultados.";
                } ?>`;

                $("#searchInput").on("keyup", function () {
                    var searchText = $(this).val().toLowerCase();
                    $("#empleado option").filter(function () {
                        $(this).toggle(
                            $(this).text().toLowerCase().indexOf(searchText) > -1
                        );
                    });
                });
            } else if (tipoPublicacionSelect.value === 'UNIDAD') {
                empleadosSelectDiv.innerHTML = `
                <select class="event-datatype-content select-employee form-select" name="negocio" required>
                    <option value="" selected disabled>Selecciona una unidad</option>
                <?php
                if ($result3->num_rows > 0) {
                    while ($row = $result3->fetch_assoc()) {
                        echo '<option value="' . $row["id"] . '">' . $row["nombre_negocio"] . '</option>';
                    }
                } else {
                    echo "No se encontraron registros en la tabla negocio.";
                } ?>
                </select>`;
            } else {
                empleadosSelectDiv.innerHTML = '';
            }
        });

        var tipoPublicacionSelect2 = document.getElementById('edit-tipo-publicacion');
        var empleadosSelectDiv2 = document.getElementById('edit-empleados-select');
        tipoPublicacionSelect2.addEventListener('change', function () {
            if (tipoPublicacionSelect2.value === 'PERSONA') {
                empleadosSelectDiv2.innerHTML = `
                <div class="d-flex gap-3">
                    <input type="text" id="searchInput2" class="event-datatype-content select-employee form-control" placeholder="Buscar Empleado">
                    <select name="empleado" id="editEmpleado" class="event-datatype-content select-employee form-select" required>
                        <option value="" selected disabled>Selecciona un empleado</option>
                <?php
                if ($result4->num_rows > 0) {
                    while ($row = $result4->fetch_assoc()) {
                        echo "<option value='" . $row["id"] . "'>" . $row["firstname"] . " " . $row["lastname"] . "</option>";
                    }
                    echo '</select>
                        </div>';
                    
                } else {
                    echo "No se encontraron resultados.";
                } ?>`;

                $("#searchInput2").on("keyup", function () {
                    var searchText = $(this).val().toLowerCase();
                    $("#editEmpleado option").filter(function () {
                        $(this).toggle(
                            $(this).text().toLowerCase().indexOf(searchText) > -1
                        );
                    });
                });
                
            } else if (tipoPublicacionSelect2.value === 'UNIDAD') {
                empleadosSelectDiv2.innerHTML = `
                <select id="editNegocio" class="event-datatype-content select-employee form-select" name="negocio" required>
                    <option value="" selected disabled>Selecciona una unidad</option>
                <?php
                if ($result5->num_rows > 0) {
                    mysqli_data_seek($result5, 0);
                    while ($row = $result5->fetch_assoc()) {
                        echo '<option value="' . $row["id"] . '">' . $row["nombre_negocio"] . '</option>';
                    }
                } else {
                    echo "No se encontraron registros en la tabla negocio.";
                } ?>
                </select>`;
            } else {
                empleadosSelectDiv2.innerHTML = '';
            }
        });
    </script>

    <!-- EDITAR EVENTO -->
    <script>
        const editarBotones = document.querySelectorAll('.button-edit-eventos');

        editarBotones.forEach(function (boton) {
            boton.addEventListener('click', function () {
                const id = boton.getAttribute('data-id');
                const tipoPublicacion = document.getElementById('publicacion-' + id).value;
                const titulo = document.getElementById('titulo-' + id).value;
                const contenido = document.getElementById('contenido-' + id).value;
                const fecha = document.getElementById('fecha-' + id).value;
                const hora = document.getElementById('hora-' + id).value;
                const imagen_url = document.getElementById('imagen_url-' + id).value;
                const color = document.getElementById('color-' + id).value;
                const empleado = document.getElementById('empleado-' + id).value;
                const negocio = document.getElementById('negocio-' + id).value;

                document.getElementById('id_evento').value = id;
                document.getElementById('edit-tipo-publicacion').value = tipoPublicacion;
                document.getElementById('edit-titulo').value = titulo;
                document.getElementById('edit-content').value = contenido;
                document.getElementById('edit-fecha').value = fecha;
                document.getElementById('edit-hora').value = hora;
                imagen_url !== ''
                    ? document.getElementById('edit-imagen').textContent = imagen_url
                    : document.getElementById('edit-imagen').textContent = 'Imagen no cargada.';
                document.getElementById('edit-color').value = color;

                var empleadosSelectDiv = document.getElementById('edit-empleados-select');
                if (document.getElementById('edit-tipo-publicacion').value == 'PERSONA') {
                    empleadosSelectDiv.innerHTML = `
                        <?php
                        if ($result4->num_rows > 0) {
                            echo '<div class="d-flex gap-3">
                                        <input type="text" id="searchInput2" class="event-datatype-content select-employee form-control" placeholder="Buscar Empleado">

                                        <select name="empleado" id="editEmpleado" class="event-datatype-content select-employee form-select">';
                            while ($row = $result4->fetch_assoc()) {
                                echo "<option value='" . $row["id"] . "'>" . $row["firstname"] . " " . $row["lastname"] . "</option>";
                            }

                            echo '</select>
                                </div>';
                        } else {
                            echo "No se encontraron resultados.";
                        } ?>`;
                    $("#searchInput2").on("keyup", function () {
                        var searchText = $(this).val().toLowerCase();
                        $("#editEmpleado option").filter(function () {
                            $(this).toggle(
                                $(this).text().toLowerCase().indexOf(searchText) > -1
                            );
                        });
                    });
                    document.getElementById('editEmpleado').value = empleado;
                } else if (document.getElementById('edit-tipo-publicacion').value == 'UNIDAD') {
                    empleadosSelectDiv.innerHTML = `
                        <select id="editNegocio" class="event-datatype-content select-employee" name="negocio">
                        <?php
                        if ($result5->num_rows > 0) {
                            mysqli_data_seek($result5, 0);
                            while ($row = $result5->fetch_assoc()) {
                                echo '<option value="' . $row["id"] . '">' . $row["nombre_negocio"] . '</option>';
                            }
                        } else {
                            echo "No se encontraron registros en la tabla negocio.";
                        }
                        ?>
                        </select>`;
                    document.getElementById('editNegocio').value = negocio;
                } else {
                    empleadosSelectDiv.innerHTML = '';
                }
            });
        });
    </script>

    <!-- ELIMINAR EVENTO -->
    <script>
        $(".delete").click(function () {
            var id = $(this).data("id");
            $("#evento_id").val(id);
        });
    </script>
</body>

</html>