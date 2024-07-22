<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>
<?php
$image_array = [];
$document_array = [];

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM publications WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $title = $row['title'];
        $content = $row['content'];
        $type = $row['type'];
        $privacy = $row['privacy'];
        $employee_id = $row['employee_id'];
        $negocio_id = $row['negocio_id'];

        $image_json = $row['images'];
        $document_json = $row['documents'];

        $image_array = json_decode($image_json, true);
        $document_array = json_decode($document_json, true);
    } else {
        header('Location: publicaciones.php');
    }
} else {
    header('Location: publicaciones.php');
}
?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $publicacion_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>

        <!-- CONTENIDO PRINCIPAL INICIO -->
        <div class="content p-0 px-3 my-4">
            <h5 class="fw-bold">REDACTA UN MENSAJE PARA TODO EL EQUIPO</h5>
            <p>Aquí poner info que deje claro algunos lineamiento de la comunicación interna que el comunicador
                debe recordar.</p>

            <form id="form-publicaciones" method="POST" action="includes/publicacion_edit.php"
                enctype="multipart/form-data">
                <input type="hidden" name="publication_id" value='<?php echo $id ?>'>
                <input type="hidden" id="contentHidden" name="contentHidden">

                <div class="d-flex justify-content-between gap-3 mb-4">
                    <div class="position-relative">
                        <select id="tipo-publicacion" name="type" required>
                            <option selected disabled>TIPO DE PUBLICACIÓN</option>
                            <option value="FESTIVIDADES" <?php if ($type == "FESTIVIDADES")
                                echo "selected"; ?>>FESTIVIDADES</option>
                            <option value="ANUNCIOS" <?php if ($type == "ANUNCIOS")
                                echo "selected"; ?>>ANUNCIOS</option>
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
                    <button class="button-primary" type="submit" name="edit">ACTUALIZAR</button>
                </div>

                <div class="d-flex gap-4">
                    <div class="position-relative">
                        <select id="tipo-evento" name="tipo_evento" required>
                            <option selected disabled>TIPO DE EVENTO</option>
                            <option value="GENERAL" <?php if ($privacy == "GENERAL")
                                echo "selected"; ?>>GENERAL</option>
                            <option value="UNIDAD" <?php if ($privacy == "UNIDAD")
                                echo "selected"; ?>>UNIDAD</option>
                            <option value="PERSONA" <?php if ($privacy == "PERSONA")
                                echo "selected"; ?>>PERSONA</option>
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
                    <div id="empleados-select" class="d-flex gap-4 w-100"></div>
                </div>

                <div class="d-flex justify-content-between my-3">
                    <div class="event-datatype">TÍTULO</div>
                    <input type="text" id="title" name="title" class="event-datatype-content"
                        value="<?php echo $title; ?>" required>
                </div>

                <div class="editor-container">
                    <div class="editor-controls">
                        <select onchange="formatDoc('fontSize', this.value); ">
                            <option selected disabled>Font size</option>
                            <option value="1">Extra small</option>
                            <option value="2">Small</option>
                            <option value="3">Regular</option>
                            <option value="4">Medium</option>
                            <option value="5">Large</option>
                            <option value="6">Extra Large</option>
                            <option value="7">Big</option>
                        </select>
                        <hr class="vertical-hr">
                        <div class="btn-toolbar">
                            <button class="control-button" onclick="formatDoc('undo')"><i
                                    class="fas fa-undo"></i></button>
                            <button class="control-button" onclick="formatDoc('redo')"><i
                                    class="fas fa-redo"></i></button>
                            <hr class="vertical-hr-2">
                            <button class="control-button" onclick="formatDoc('bold')"><i
                                    class="fas fa-bold"></i></button>
                            <button class="control-button" onclick="formatDoc('italic')"><i
                                    class="fas fa-italic"></i></button>
                            <button class="control-button" onclick="formatDoc('strikeThrough')"><i
                                    class="fas fa-strikethrough"></i></button>
                            <button class="control-button" onclick="formatDoc('underline')"><i
                                    class="fas fa-underline"></i></button>
                            <hr class="vertical-hr-2">
                            <button class="control-button" onclick="formatDoc('justifyLeft')"><i
                                    class="fas fa-align-left"></i></button>
                            <button class="control-button" onclick="formatDoc('justifyCenter')"><i
                                    class="fas fa-align-center"></i></button>
                            <button class="control-button" onclick="formatDoc('justifyRight')"><i
                                    class="fas fa-align-right"></i></button>
                            <button class="control-button" onclick="formatDoc('justifyFull')"><i
                                    class="fas fa-align-justify"></i></button>
                            <hr class="vertical-hr-2">
                            <button class="control-button" onclick="formatDoc('insertUnorderedList')"><i
                                    class="fas fa-list-ul"></i></button>
                            <button class="control-button" onclick="formatDoc('insertOrderedList')"><i
                                    class="fas fa-list-ol"></i></button>
                            <hr class="vertical-hr-2">
                            <button class="control-button" onclick="addLink()"><i class="fas fa-link"></i></button>
                            <button class="control-button" onclick="formatDoc('unlink')"><i
                                    class="fas fa-unlink"></i></button>
                            <button class="control-button" id="show-code" data-active="false"><i
                                    class="fas fa-code"></i></button>
                        </div>
                        <hr class="vertical-hr">
                        <div class="color">
                            <i class="fas fa-font"></i>
                            <input type="color" oninput="formatDoc('foreColor',this.value); this.value='#000000';">
                        </div>
                        <div class="color">
                            <i class="fas fa-fill-drip"></i>
                            <input type="color" oninput="formatDoc('hiliteColor',this.value); this.value='#000000';">
                        </div>
                    </div>
                    <div id="content" class="editor-content" contenteditable="true" spellcheck="false">
                    </div>
                </div>

                <div class="d-flex align-items-center gap-4 my-3">
                    <div class="event-datatype">
                        IMÁGENES
                    </div>
                    <?php if (isset($image_array[0])) { ?>
                        <input type="hidden" name="existing_images[]"
                            value="<?php echo htmlspecialchars($image_array[0]) ?>">
                        <button id="remove-image-link" class="btn p-0" data-type="image"
                            data-filename="<?php echo urlencode($image_array[0]) ?>">
                            <span>
                                <?php echo htmlspecialchars($image_array[0]) ?>
                            </span>
                            <i class="fas fa-times ms-1"></i>
                        </button>
                    <?php } ?>
                    <input type="file" id="images" name="images[]" multiple>
                </div>

                <div class="d-flex align-items-center gap-4 my-3">
                    <div class="event-datatype">
                        DOCUMENTOS
                    </div>
                    <?php if (isset($document_array[0])) { ?>
                        <input type="hidden" name="existing_documents[]"
                            value="<?php echo htmlspecialchars($document_array[0]) ?>">
                        <button id="remove-document-link" class="btn p-0" data-type="document"
                            data-filename="<?php echo urlencode($document_array[0]) ?>">
                            <span>
                                <?php echo htmlspecialchars($document_array[0]) ?>
                            </span>
                            <i class="fas fa-times ms-1"></i>
                        </button>
                    <?php } ?>
                    <input type="file" id="documents" name="documents[]" multiple>
                </div>
            </form>
        </div>

        <!-- FOOTER -->
        <?php include 'includes/footer.php'; ?>
    </div>

    <script src="js/scripts.js"></script>
    <script src="../js/textEditor.js"></script>

    <!-- SELECT TIPO PUBLICACIÓN -->
    <script>
        $(document).ready(function () {
            cargarSelectores();

            $('#tipo-evento').change(function () {
                cargarSelectores();
            });
        });

        function selectUnidad() {
            var selectUnidades = '<div class="position-relative">';
            selectUnidades += '<select id="unidad" name="unidad" class="border border-dark border-3" required>';
            selectUnidades += '</select>';
            selectUnidades += '</div>';
            return selectUnidades;
        }

        function selectEmpleado() {
            var selectEmpleados = '<div class="position-relative w-100">';
            selectEmpleados += '<select id="persona" name="persona" class="border border-dark border-3 w-100" required>';
            selectEmpleados += '<option selected disabled value="">SELECCIONA UN EMPLEADO</option>';
            selectEmpleados += '</select>';
            selectEmpleados += '</div>';
            return selectEmpleados;
        }

        function cargarEmpleados() {
            var unidadId = $('#unidad').val();
            $.ajax({
                url: 'includes/cargar_empleados.php?id=' + unidadId,
                type: 'GET',
                success: function (data) {
                    $('#persona').html(data);
                    $('#persona').val('<?php echo $employee_id ?>');
                }
            });
        }

        function cargarSelectores() {
            var tipoEvento = $('#tipo-evento').val();
            if (tipoEvento === 'UNIDAD') {
                $('#empleados-select').html(selectUnidad());

                $.ajax({
                    url: 'includes/cargar_negocios.php',
                    type: 'GET',
                    success: function (data) {
                        $('#unidad').html(data);
                        $('#unidad').val('<?php echo $negocio_id ?>');
                    }
                });
            } else if (tipoEvento === 'PERSONA') {
                $('#empleados-select').html(selectUnidad() + selectEmpleado());

                $.ajax({
                    url: 'includes/cargar_negocios.php',
                    type: 'GET',
                    success: function (data) {
                        $('#unidad').html(data);
                        $('#unidad').val('<?php echo $negocio_id ?>');

                        cargarEmpleados();
                    }
                });

                $('#unidad').change(function () {
                    cargarEmpleados();
                });
            } else {
                $('#empleados-select').empty();
            }
        }
    </script>

    <!-- SELECT BOTONES DE EDITOR DE TEXTO -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.control-button');

            buttons.forEach(button => {
                button.addEventListener('click', (event) => {
                    event.preventDefault();

                    button.classList.toggle('active');

                    buttons.forEach(otherButton => {
                        if (otherButton !== button && !otherButton.getAttribute('data-active')) {
                            otherButton.classList.remove('active');
                        }
                    });

                    // Toggle the data-active attribute on the clicked button
                    if (button.classList.contains('active')) {
                        button.setAttribute('data-active', 'true');
                    } else {
                        button.removeAttribute('data-active');
                    }
                });
            });
        });
    </script>

    <!-- PLACEHOLDER Y FOCUS DE TEXTAREA -->
    <script>
        const editor = document.getElementById('content');
        const contentHidden = document.getElementById('contentHidden');
        const placeholderText = 'Describir publicación...';
        <?php if (!empty($content)) { ?>
            editor.innerHTML = '<?php echo htmlspecialchars($content) ?>';
        <?php } else { ?>
            editor.textContent = placeholderText;
        <?php } ?>

        editor.addEventListener('input', () => {
            contentHidden.value = editor.innerHTML;
        });

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


    <!-- ELIMINAR IMAGEN SUBIDA -->
    <script>
        $('#remove-image-link').on("click", function (e) {
            e.preventDefault();

            var filename = $(this).data('filename');
            var id_publicacion = <?php echo $id ?>;

            Swal.fire({
                title: "¿Está seguro de eliminar la imagen?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Confirmar",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'eliminar-imagen.php?type=image&filename=' + filename + '&id=' + id_publicacion,
                        type: 'GET',
                        success: function (response) {
                            if (response.includes('eliminada exitosamente')) {
                                $(e.target).parent().fadeOut();
                            } else {
                                alert('Error al eliminar la imagen: ' + response);
                            }
                        },
                        error: function () {
                            alert('Error al comunicarse con el servidor.');
                        }
                    });
                }
            });
        });
    </script>

    <!-- ELIMINAR DOCUMENTO SUBIDO -->
    <script>
        $('#remove-document-link').on("click", function (e) {
            e.preventDefault();

            var filename = $(this).data('filename');
            var id_publicacion = <?php echo $id ?>;

            Swal.fire({
                title: "¿Está seguro de eliminar el documento?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Confirmar",
            }).then((result) => {
                if (result.isConfirmed) {
                    $(e.target).parent().fadeOut();
                    // $.ajax({
                    //     url: 'eliminar-archivo.php?type=document&filename=' + filename + '&id=' + id_publicacion,
                    //     type: 'GET',
                    //     success: function (response) {
                    //         if (response.includes('eliminado exitosamente')) {
                    //             $(e.target).parent().fadeOut();
                    //         } else {
                    //             alert('Error al eliminar el documento: ' + response);
                    //         }
                    //     },
                    //     error: function () {
                    //         alert('Error al comunicarse con el servidor.');
                    //     }
                    // });
                }
            });
        });
    </script>
</body>

</html>