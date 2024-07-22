<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $vista_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>
        <?php
        $sql = "SELECT * FROM fondo WHERE id > 1";
        $query3 = $conn->query($sql);
        $imagenes3 = $query3->fetch_all(MYSQLI_ASSOC);

        $sql = "SELECT * FROM fondo LIMIT 1";
        $query4 = $conn->query($sql);
        $imagen4 = $query4->fetch_assoc();

        $sql = "SELECT * FROM imagen_frase LIMIT 1";
        $query1 = $conn->query($sql);
        $imagen1 = $query1->fetch_assoc();

        $sql = "SELECT * FROM imagen_frase WHERE id > 1";
        $query = $conn->query($sql);
        $imagenes = $query->fetch_all(MYSQLI_ASSOC);

        $gestionVista = $permisoVista['actualizar'];
        $gestionVista2 = $permisoVista['eliminar'];
        $gestionVista3 = $permisoVista['crear'];
        $gestionVista4 = $permisoVista['leer'];

        if ($gestionVista4 == "No") {
            echo '<script>window.location.replace("panel-control.php");</script>';
            exit;
        }
        ?>

        <!-- MODAL DE ELIMINAR FONDO -->
        <div class="modal-fondo">
            <div class="modal-fondo__conted">
                <div class="nontaine__nuevo">
                    <span class="container__tittle">Imagenes de fondo</span>
                    <div>
                        <?php
                        if ($gestionVista3 == "Sí") {
                            echo '<a href="vista-nuevo-fondo.php" class="btn btn-primary">Agregar fondo</a>';
                        }
                        ?>
                        <a href="#" class="btn btn-danger" onclick="closseModalFondo()">Cerrar</a>
                    </div>
                </div>
                <div class="modal-fondo__fondos">
                    <?php foreach ($imagenes3 as $imagen) { ?>
                        <div class="modal-fondo__fondo-contend">
                            <div>
                                <img src="fondo-admin/<?= $imagen['nombre'] ?>" alt="Imagen" class="modal-fondo__img">
                            </div>
                            <div class="modal-fondo__fondo-cacciones">
                                <?php
                                if ($gestionVista == "Sí") {
                                    echo '
                                        <a href="vista-usar-fondo.php?id=' . $imagen['id'] . '" class="btn btn-success container__bt1-a"><i class="fa fa-hand"></i> Usar</a>';
                                }
                                if ($gestionVista2 == "Sí") {
                                    echo '<button type="button" class="btn container__bt1-a btn-danger eliminarBtn" data-id="' . $imagen['id'] . '" data-bs-toggle="modal" data-bs-target="#modal-eliminar-fondo"><i class="fa fa-trash"></i> Eliminar</button>';
                                }
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

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

            <div class="card mb-4">
                <div class="card-body">
                    <div class="nontaine__nuevo">
                        <span class="container__tittle">Asistencia</span>
                        <?php
                        if ($gestionVista3 == "Sí") {
                            echo '<a href="#" class="btn btn-primary cambiar__fondo" onclick="openModalFondo()">Cambiar fondo</a>';
                        }
                        ?>
                    </div>
                    <div class="plantilla__center"
                        style="background-image: url(<?= 'fondo-admin/' . $imagen4['nombre'] ?>);">
                        <div class="plantilla">
                            <p class="plantilla__titulo mb-0">¡Hola, Desiree Jasmin Meregildo Palomino!</p>
                            <p class="plantilla__sub mb-0">Se ha registrado tu ingreso</p>
                            <div class="plantilla__div">
                                <div class="plantilla__time">
                                    <p class="plantilla__fecha mb-0">LUNES - Enero 1, 2024</p>
                                    <p class="plantilla__hora mb-0">12:00:00 PM</p>
                                    <div class="plantilla__btn-contend">
                                        <span class="plantilla__btn">VISITAR MI PERFIL</span><br>
                                        <span class="plantilla__btn">VER MIS ESTADÍSTICAS</span>
                                    </div>
                                </div>
                                <img src="<?= 'img/' . $imagen1['nombre'] ?>" alt="imagen" class="plantilla__img">
                            </div>
                            <p class="plantilla__frase">
                                <?= $imagen1['frase_motivacional'] ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PLANTILLAS -->
            <div class="card">
                <div class="card-body">
                    <div class="container__1">
                        <div class="nontaine__nuevo">
                            <span class="container__tittle">Plantillas</span>
                            <?php
                            if ($gestionVista3 == "Sí") {
                                echo '<a href="vista-nuevo.php" class="btn btn-primary">Agregar plantilla</a>';
                            }
                            ?>
                        </div>
                        <div class="center__contend">
                            <?php foreach ($imagenes as $imagen) { ?>
                                <div class="opcion">
                                    <div>
                                        <br>
                                        <img src="<?= 'img/' . $imagen['nombre'] ?>" alt="img" class="opcion__img"><br>
                                        <p class="opcion__frase">
                                            <?= $imagen['frase_motivacional'] ?>
                                        </p>
                                    </div><br>
                                    <?php
                                    if ($gestionVista == "Sí") {
                                        echo '<a href="vista-usar.php?id=' . $imagen['id'] . '" class="btn btn-primary container__bt1-a"><i class="fa fa-hand"></i> Usar</a>
                                        <a href="vista-editar.php?id=' . $imagen['id'] . '" class="btn btn-success container__bt1-a"><i class="fa fa-edit"></i> Editar</a>';
                                    }
                                    if ($gestionVista2 == "Sí") {
                                        echo '<a class="btn btn-danger container__bt1-a deleteButton" data-bs-toggle="modal" data-bs-target="#modal-plantilla" data-id="' . $imagen['id'] . '"><i class="fa fa-trash"></i> Eliminar</a>';
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <?php include 'includes/footer.php'; ?>
    </div>

    <!-- MODAL DE CONFIRMACION DE ELIMINACION DE FONDO -->
    <div class=" modal fade" id="modal-eliminar-fondo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Eliminar fondo</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center fw-bolder">
                        ¿Está seguro de eliminar el fondo <span id="del_eliminar-fondo_name" class="fw-bold"></span>?
                    </h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form method="POST" action="vista-eliminar-fondo.php">
                        <input type="hidden" name="id" id="inputEliminarId">
                        <button type="submit" class="btn btn-danger" name="delete">
                            <i class="fa fa-trash me-2 deleteButton" data-id="<?php echo $imagen['id']; ?>"
                                data-toggle="modal" data-target="#deleteModal"></i>Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DE ELIMINAR PLANTILLA -->
    <div class="modal fade" id="modal-plantilla" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content rounded-3">
                <div class="modal-header py-2">
                    <h4 class="modal-title text-white fw-bold ms-auto">Eliminar plantilla</h4>
                    <button class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center fw-bolder">
                        ¿Está seguro de eliminar la plantilla<span id="del_plantilla_name" class="fw-bold"></span>?
                    </h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form method="POST" action="vista-eliminar.php">
                        <input type="hidden" class="posid" name="id" id="id">
                        <button type="submit" class="btn btn-danger" name="delete">
                            <i class="fa fa-trash me-2 deleteButton" data-id="<?php echo $imagen['id']; ?>"
                                data-toggle="modal" data-target="#deleteModal"></i>Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src=" js/scripts.js"></script>

    <script>
        let abrirModalFondo = document.querySelector(".modal-fondo");

        function openModalFondo() {
            abrirModalFondo.classList.add("modal-fondo__active")
        }

        function closseModalFondo() {
            abrirModalFondo.classList.remove("modal-fondo__active")
        }
    </script>

    <script>
        $(document).ready(function () {
            $('.deleteButton').on('click', function () {
                var id = $(this).data('id');
                $("#id").val(id);
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var deleteButtons = document.querySelectorAll('.eliminarBtn');
            deleteButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var imagenId = this.getAttribute('data-id');
                    document.getElementById('inputEliminarId').value = imagenId;
                });
            });
        });
    </script>
</body>

</html>