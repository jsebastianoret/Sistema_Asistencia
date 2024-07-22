<?php include 'includes/header-practicante.php'; ?>
<?php include './includes/conn.php'; ?>

<body class="bg-white">
    <?php $buzon_click = "clicked" ?>
    <?php include 'includes/fecha_actual.php' ?>
    <?php include 'includes/navbar-sidebar-practicante.php' ?>
    <?php include 'includes/conn.php' ?>

    <main class="buzon-container">
        <div class="regresar">
            <form method="post" action="buzon.php">
                <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                <input class="volver" type="submit" value="< VOLVER">
            </form>
        </div>
        <div class="form-container">
            <p>¡Adelante! Queremos escucharte :</p>
            <div>
                <form method="post" action="" id="sugerencia-form">
                    <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                    <?php
                    date_default_timezone_set('America/Lima');
                    $fechaActual = date('Y-m-d')
                        ?>
                    <input type="hidden" name="fecha" value="<?php echo $fechaActual; ?>">

                    <div class="form-inputs">
                        <select name="nombre" id="select_target">
                            <option value="" selected disabled>¿Cómo te llamas?</option>
                            <option value="Prefiero no decirlo">Anónimo</option>
                            <option value="<?php echo $row['firstname']; ?>">
                                <?php echo $row['firstname']; ?>
                            </option>
                        </select>
                        <input name="asunto" type="text" placeholder="Nombre del asunto (Título)" />
                        <select name="tipo">
                            <option value="" selected disabled>¿Para qué usaras el buzón?</option>
                            <option value="Sugerencia de mejora">Sugerencia de mejora</option>
                            <option value="Observación">Observación</option>
                            <option value="Reclamo">Reclamo</option>
                        </select>
                        <select name="unidad" id="select_unidad">
                            <option value="" selected disabled>¿A qué unidad perteneces?</option>

                            <?php
                            $stm = $conn->query('SELECT * FROM negocio');
                            if ($stm) {
                                $data = array();
                                while ($rows = $stm->fetch_assoc()) {
                                    $data[] = $rows;
                                }
                            }
                            foreach ($data as $unidad) { ?>
                                <option value="<?php echo $unidad['nombre_negocio']; ?>">
                                    <?php echo $unidad['nombre_negocio']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <span style="display: none; text-align: start; color: red; font-weight: bold;"
                        id="message_anonimo"></span>
                    <textarea id="area_sugerencia" name="sugerencia" class="contenido-sugerencia"
                        placeholder="Escribe aquí..."></textarea>
                    <div class="form-btns">
                        <div class="button-container">
                            <button class="guardar" type="submit" name="guardar" formaction="guardarJSON.php"
                                style="font-size: 20px;">Guardar</button>
                        </div>
                        <div class="button-container">
                            <button class="enviar" type="submit" name="enviar" formaction="enviar-sugerencia.php"
                                style="font-size: 20px;">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script>
        const select_target = document.querySelector('#select_target');
        const select_unidad = document.querySelector('#select_unidad');

        select_target.addEventListener('change', (event) => {

            let option = select_target.value.toLowerCase();
            let newOption = document.createElement('option');
            let message_anonimo = document.querySelector('#message_anonimo');

            select_unidad.disabled = false;
            select_unidad.removeChild(select_unidad.lastChild);
            select_unidad[0].selected = true;
            message_anonimo.style.display = 'none';


            if (option == 'prefiero no decirlo') {

                newOption.value = 'ANONIMO'
                newOption.text = 'Anónimo'
                newOption.selected = true;

                select_unidad.appendChild(newOption);

                message_anonimo.style.display = 'block';
                message_anonimo.textContent = 'Tu nombre y área serán enviados como anónimo';
                select_unidad.disabled = true;
            }


        });


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