<?php include 'includes/header-practicante.php'; ?>

<body class="bg-white">
    <?php $organigrama_click = "clicked" ?>
    <?php include 'includes/fecha_actual.php' ?>
    <?php include 'includes/navbar-sidebar-practicante.php' ?>
    <?php include 'includes/conn.php' ?>
    <?php
    $sql = "SELECT *
    FROM employees e
    INNER JOIN position p ON e.position_id = p.id
    WHERE negocio_id = {$row['negocio_id']}";
    $query = $conn->query($sql);
    $rowEmployees = $query->fetch_all(MYSQLI_ASSOC);
    ?>

    <div class="card w-75 mx-auto mt-5">
        <div class="organigrama-container">
            <div class="button-container">
                <button id="increaseSize">+</button>
                <button id="decreaseSize">-</button>
            </div>
            <div class="organigrama">
                <ul>
                    <li>
                        <?php foreach ($rowEmployees as $admJefatura) {
                            if ($admJefatura['position_id'] == 13) { ?>
                                <ul>
                                    <div class="employee-card view">
                                        <div class="employee-details">
                                            <div class="employee-info">
                                                <img src="../images/profile.jpg" alt="Adm. Jefatura" class="employee-photo">
                                                <div class="employee-text">
                                                    <span class="employee-name">
                                                        <?= $admJefatura['firstname'] . ' ' . $admJefatura['lastname'] ?>
                                                    </span>
                                                    <hr>
                                                    <span class="business-name">
                                                        <?= $admJefatura['description'] ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </ul>
                            <?php } ?>
                        <?php } ?>
                        <ul>
                            <ul>
                                <?php foreach ($rowEmployees as $admProyecto) {
                                    if ($admProyecto['position_id'] == 2) { ?>
                                        <li>
                                            <div class="employee-card view">
                                                <div class="employee-details">
                                                    <div class="employee-info">
                                                        <img src="../images/profile.jpg" alt="Adm. Proyecto"
                                                            class="employee-photo">
                                                        <div class="employee-text">
                                                            <span class="employee-name">
                                                                <?= $admProyecto['firstname'] . ' ' . $admProyecto['lastname'] ?>
                                                            </span>
                                                            <hr>
                                                            <span class="business-name">
                                                                <?= $admProyecto['description'] ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                            <ul>
                                <li>
                                    <span class="toggle container-positions fw-bolder">
                                        Audiovisual
                                        <hr>
                                        <div class="person-count-container">
                                            <span class="total-persons">
                                            </span>
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </span>
                                    <?php foreach ($rowEmployees as $employee) {
                                        if ($employee['position_id'] == 8) { ?>
                                            <ul class="subordinates">
                                                <div class="employee-card view">
                                                    <div class="employee-details">
                                                        <div class="employee-info">
                                                            <img src="../images/profile.jpg" alt="Adm. Proyecto"
                                                                class="employee-photo">
                                                            <div class="employee-text">
                                                                <span class="employee-name">
                                                                    <?= $employee['firstname'] . ' ' . $employee['lastname'] ?>
                                                                </span>
                                                                <hr>
                                                                <span class="business-name">
                                                                    <?= $employee['description'] ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </ul>
                                        <?php } ?>
                                    <?php } ?>
                                </li>
                                <li>
                                    <span class="toggle container-positions fw-bolder">
                                        Comunicación
                                        <hr>
                                        <div class="person-count-container">
                                            <span class="total-persons">
                                            </span>
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </span>
                                    <?php foreach ($rowEmployees as $employee) {
                                        if ($employee['position_id'] == 4) { ?>
                                            <ul class="subordinates">
                                                <div class="employee-card view">
                                                    <div class="employee-details">
                                                        <div class="employee-info">
                                                            <img src="../images/profile.jpg" alt="Adm. Proyecto"
                                                                class="employee-photo">
                                                            <div class="employee-text">
                                                                <span class="employee-name">
                                                                    <?= $employee['firstname'] . ' ' . $employee['lastname'] ?>
                                                                </span>
                                                                <hr>
                                                                <span class="business-name">
                                                                    <?= $employee['description'] ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </ul>
                                        <?php } ?>
                                    <?php } ?>
                                </li>
                                <li>
                                    <span class="toggle container-positions fw-bolder">
                                        Diseño de Interiores
                                        <hr>
                                        <div class="person-count-container">
                                            <span class="total-persons">
                                            </span>
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </span>
                                    <?php foreach ($rowEmployees as $employee) {
                                        if ($employee['position_id'] == 6) { ?>
                                            <ul class="subordinates">
                                                <div class="employee-card view">
                                                    <div class="employee-details">
                                                        <div class="employee-info">
                                                            <img src="../images/profile.jpg" alt="Adm. Proyecto"
                                                                class="employee-photo">
                                                            <div class="employee-text">
                                                                <span class="employee-name">
                                                                    <?= $employee['firstname'] . ' ' . $employee['lastname'] ?>
                                                                </span>
                                                                <hr>
                                                                <span class="business-name">
                                                                    <?= $employee['description'] ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </ul>
                                        <?php } ?>
                                    <?php } ?>
                                </li>
                                <li>
                                    <span class="toggle container-positions fw-bolder">
                                        Diseño Gráfico
                                        <hr>
                                        <div class="person-count-container">
                                            <span class="total-persons">
                                            </span>
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </span>
                                    <?php foreach ($rowEmployees as $employee) {
                                        if ($employee['position_id'] == 5) { ?>
                                            <ul class="subordinates">
                                                <div class="employee-card view">
                                                    <div class="employee-details">
                                                        <div class="employee-info">
                                                            <img src="../images/profile.jpg" alt="Adm. Proyecto"
                                                                class="employee-photo">
                                                            <div class="employee-text">
                                                                <span class="employee-name">
                                                                    <?= $employee['firstname'] . ' ' . $employee['lastname'] ?>
                                                                </span>
                                                                <hr>
                                                                <span class="business-name">
                                                                    <?= $employee['description'] ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </ul>
                                        <?php } ?>
                                    <?php } ?>
                                </li>
                                <li>
                                    <span class="toggle container-positions fw-bolder">
                                        Marketing
                                        <hr>
                                        <div class="person-count-container">
                                            <span class="total-persons">
                                            </span>
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </span>
                                    <?php foreach ($rowEmployees as $employee) {
                                        if ($employee['position_id'] == 3) { ?>
                                            <ul class="subordinates">
                                                <div class="employee-card view">
                                                    <div class="employee-details">
                                                        <div class="employee-info">
                                                            <img src="../images/profile.jpg" alt="Adm. Proyecto"
                                                                class="employee-photo">
                                                            <div class="employee-text">
                                                                <span class="employee-name">
                                                                    <?= $employee['firstname'] . ' ' . $employee['lastname'] ?>
                                                                </span>
                                                                <hr>
                                                                <span class="business-name">
                                                                    <?= $employee['description'] ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </ul>
                                        <?php } ?>
                                    <?php } ?>
                                </li>
                            </ul>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

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

    <script>
        let idPracticante = document.getElementById("idPracticante");
        if (idPracticante.value.length == 0) {
            window.location.href = "../index.php";
        }
    </script>
    <script>
        function salirMiPerfil() {
            Swal.fire({
                title: '¿Estás seguro de que quieres salir de tu perfil?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Salir de perfil'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../index.php";
                }
            })
        }
    </script>
    <script>
        function toggleButtonColor(event, buttonId) {
            event.preventDefault();
            const buttons = document.getElementsByClassName("enlaces");
            for (let i = 0; i < buttons.length; i++) {
                buttons[i].classList.remove("clicked");
            }
            const button = document.getElementById(buttonId);
            button.classList.add("clicked");
        }
    </script>
</body>