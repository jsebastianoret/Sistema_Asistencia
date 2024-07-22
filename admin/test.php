<?php include 'includes/header-practicante.php'; ?>

<body class="bg-white p-4">
    <div class="timer-container position-fixed" id="something" style="right: 24px; z-index: 1;">
        <svg class="progress-ring position-absolute" viewBox="0 0 520 520">
            <circle class="progress-ring-circle" stroke="#1dd6ff" stroke-width="20" fill="transparent" r="240" cx="260"
                cy="260" />
        </svg>

        <div class="timer-circle d-flex text-white">
            <span class="time fs-2 mx-auto my-auto" id="time">30:00</span>
        </div>
    </div>

    <?php if ($_GET['test'] == 1) {
        $position = 13;
        $test_description = "Comunicación Interna necesita tu gran apoyo para evaluar a tus administradores de jefatura y reconocer su liderazgo.";
        $test_title = "¿Cómo es el liderazgo en tu equipo?";
        $label_1 = "VERDADERO";
        $label_2 = "FALSO";
    } else {
        $position = 2;
        $test_description = "Comunicación Interna necesita tu gran apoyo para evaluar a tus administradores de proyectos y reconocer su liderazgo.";
        $test_title = "¿Cómo es el liderazgo en tu equipo?";
        $label_1 = "SÍ";
        $label_2 = "NO";
    } ?>

    <?php if ($_GET['test'] != 3) { ?>
        <div class="test-container-1 rounded-4 shadow overflow-hidden mx-auto mb-4" style="max-width: 800px;">
            <form class="test-1 mb-2 letraNavBar">
                <div class="test-title text-white p-4" style="background: #5eb130;">
                    <h1 class="letraNavBar fs-5 fw-bold">
                        ¡Hola
                        <?php echo $row['firstname'] ?>!✨🙌
                    </h1>
                    <p>
                        <?php echo $test_description ?>
                    </p>
                    <p>Tus opiniones son valiosas y nos ayudarán a crear un clima saludable y productivo en la empresa. La
                        encuesta es completamente anónima 💙💚</p>
                    <label class="mt-2 me-3">Selecciona tu Administrador:</label>
                    <select name="nombre" id="select_target" class="rounded-2" required>
                        <option selected disabled value="">Seleccione...</option>
                        <?php
                        $_GET['test'] == 1
                            ? $sql = "SELECT * FROM employees WHERE position_id = $position"
                            : $sql = "SELECT * FROM employees WHERE negocio_id = {$row['negocio_id']} AND position_id = $position";
                        $query = $conn->query($sql);

                        while ($rowAdm = $query->fetch_assoc()) { ?>
                            <option value="<?php echo $rowAdm['id'] ?>">
                                <?php echo $rowAdm['firstname'] . " " . $rowAdm['lastname'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="test-questions d-flex flex-column">
                    <input type="hidden" class="negocio_id" value="<?php echo $row['negocio_id'] ?>">
                    <input type="hidden" class="employee_id" value="<?php echo $row['id'] ?>">
                    <h5 class="fw-bold m-4">
                        <?php echo $test_title ?>
                    </h5>
                    <?php $sql = "SELECT * FROM preguntas_test WHERE test = '{$_GET['test']}'";
                    $query = $conn->query($sql);

                    for ($i = 0; $i < $query->num_rows; $i++) {
                        $rowPreg = $query->fetch_assoc(); ?>
                        <li data-idpregunta="<?php echo $rowPreg['id'] ?>" class="list-group-item text-white py-3 px-4 fs-6"
                            style="background: #1e3d8f;">
                            <?php echo $i + 1 . ". " . $rowPreg['pregunta1'] ?>
                        </li>
                        <div class="mx-4 my-3">
                            <?php 
                            if ($_GET['test'] == 1){?>
                            <label style="font-size: 14px;">
                                <input type="radio" name="p<?php echo $i ?>" value="<?php echo $rowPreg['valor_1'] ?>" required>
                                <?php echo $label_1 ?>
                            </label>
                            <br>
                            <label style="font-size: 14px;">
                                <input type="radio" name="p<?php echo $i ?>" value="<?php echo $rowPreg['valor_2'] ?>">
                                <?php echo $label_2 ?>
                            </label>
                            <?php } else { ?>
                            <label style="font-size: 14px;">
                                <input type="radio" name="p<?php echo $i ?>" value="<?php echo $rowPreg['valor_1'] ?>" required>
                                <?php echo $rowPreg['opc_1'] ?>
                            </label>
                            <br>
                            <label style="font-size: 14px;">
                                <input type="radio" name="p<?php echo $i ?>" value="<?php echo $rowPreg['valor_2'] ?>">
                                <?php echo $rowPreg['opc_2'] ?>
                            </label>
                            <br>
                            <label style="font-size: 14px;">
                                <input type="radio" name="p<?php echo $i ?>" value="<?php echo $rowPreg['valor_3'] ?>">
                                <?php echo $rowPreg['opc_3'] ?>
                            </label>
                            <br>
                            <label style="font-size: 14px;">
                                <input type="radio" name="p<?php echo $i ?>" value="<?php echo $rowPreg['valor_4'] ?>">
                                <?php echo $rowPreg['opc_4'] ?>
                            </label>
                            <br>
                            <label style="font-size: 14px;">
                                <input type="radio" name="p<?php echo $i ?>" value="<?php echo $rowPreg['valor_5'] ?>">
                                <?php echo $rowPreg['opc_5'] ?>
                            </label>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <input type="submit" class="btn text-white letraNavBar rounded-pill px-4 ms-auto m-4 mt-2"
                        value="Enviar" style="background: #5eb130;">
                </div>
            </form>
        </div>

        <script>
            const formTest = document.querySelector(".test-1");
            const negocioId = document.querySelector(".negocio_id").value;
            const employeeId = document.querySelector(".employee_id").value;
            const cantidadPreguntas = formTest.querySelectorAll('input[type="radio"]');
            const condicion = cantidadPreguntas.length / 2;
            const preguntasId = formTest.querySelectorAll('li');
            const selectAdm = document.querySelector("#select_target");

            let admId = null;
            selectAdm.addEventListener("change", (e) => {
                admId = selectAdm.value;
            })

            let arrayPreguntasId = [];
            preguntasId.forEach(el => {
                arrayPreguntasId = [...arrayPreguntasId, parseInt(el.dataset.idpregunta)];
            });

            let puntaje = []
            formTest.addEventListener("submit", (e) => {
                e.preventDefault();
                for (let i = 0; i < condicion; i++) {
                    const respuesta = document.querySelector(`input[name="p${i}"]:checked`);
                    if (respuesta) {
                        puntaje = [...puntaje, parseInt(respuesta.value)];
                    }
                }

                async function postTest() {
                    try {
                        const res = await fetch('includes/respuestas-test.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                preguntaId: arrayPreguntasId,
                                empleadoId: employeeId,
                                admId: admId,
                                negocioId: negocioId,
                                valor: puntaje
                            })
                        });
                        const json = await res.json();

                        Swal.mixin({
                            toast: true,
                            position: 'top',
                            showConfirmButton: false,
                        }).fire({
                            icon: 'success',
                            title: 'Se ha enviado correctamente.',
                            background: '#00975bd7',
                            color: '#fff',
                            width: '355px'
                        });

                        setTimeout(() => {
                            redirectForm("confirmacion-test.php");
                        }, 1500);
                    } catch (err) {
                        console.log(err);
                    }
                }
                postTest();
                puntaje = [];
                formTest.reset();
            })
        </script>
    <?php } else { ?>
        <div class="test-container-2 rounded-4 shadow overflow-hidden mx-auto mb-4" style="max-width: 800px;">
            <div class="test-info mb-2 letraNavBar">
                <div class="test-title text-white p-4" style="background: #5eb130;">
                    <h1 class="letraNavBar fs-5 fw-bold">
                        ¡Hola
                        <?php echo $row['firstname'] ?>!✨🙌
                    </h1>
                    <p class="m-0">El siguiente test busca conocerlos un poco mejor y su rol como administradores.</p>
                </div>
                <form class="test-2 d-flex flex-column">
                    <input type="hidden" class="negocio_id" value="<?php echo $row['negocio_id'] ?>">
                    <input type="hidden" class="employee_id" value="<?php echo $row['id'] ?>">
                    <h5 class="fw-bold m-4">TEST DE EVALUACION DE MANEJO DE CONFLICTOS</h5>
                    <?php
                    $sql = "SELECT * FROM preguntas_test WHERE test = 3";
                    $query = $conn->query($sql);

                    for ($i = 0; $i < $query->num_rows; $i++) {
                        $rowPreg = $query->fetch_assoc(); ?>
                        <li data-idpregunta="<?php echo $rowPreg['id'] ?>" class="list-group-item text-white py-3 px-4 fs-6"
                            style="background: #1e3d8f;">
                            Seleccione una de las dos opciones:</li>
                        <div class="mx-4 my-3">
                            <label style="font-size: 14px;">
                                <input type="radio" name="p<?php echo $i ?>" value="<?php echo $rowPreg['valor_1'] ?>" required>
                                <?php echo $rowPreg['pregunta1'] ?>
                            </label>
                            <br>
                            <label style="font-size: 14px;">
                                <input type="radio" name="p<?php echo $i ?>" value="<?php echo $rowPreg['valor_2'] ?>">
                                <?php echo $rowPreg['pregunta2'] ?>
                            </label>
                        </div>
                    <?php } ?>
                    <input type="submit" class="btn text-white letraNavBar rounded-pill px-4 ms-auto m-4 mt-2"
                        value="Enviar" style="background: #5eb130;">
                </form>
            </div>
        </div>

        <script>
            const formTest = document.querySelector(".test-2");
            const negocioId = document.querySelector(".negocio_id").value;
            const employeeId = document.querySelector(".employee_id").value;
            const cantidadPreguntas = formTest.querySelectorAll('input[type="radio"]');
            const condicion = cantidadPreguntas.length / 2;
            const preguntasId = formTest.querySelectorAll('li');

            let arrayPreguntasId = [];
            preguntasId.forEach(el => {
                arrayPreguntasId = [...arrayPreguntasId, parseInt(el.dataset.idpregunta)];
            });

            let puntaje = []
            formTest.addEventListener("submit", (e) => {
                e.preventDefault();
                for (let i = 0; i < condicion; i++) {
                    const respuesta = document.querySelector(`input[name="p${i}"]:checked`);
                    if (respuesta) {
                        puntaje = [...puntaje, parseInt(respuesta.value)];
                    }
                }

                async function postTest() {
                    try {
                        const res = await fetch('includes/respuestas-test.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                preguntaId: arrayPreguntasId,
                                empleadoId: employeeId,
                                admId: null,
                                negocioId: negocioId,
                                valor: puntaje
                            })
                        });
                        const json = await res.json();

                        Swal.mixin({
                            toast: true,
                            position: 'top',
                            showConfirmButton: false,
                        }).fire({
                            icon: 'success',
                            title: 'Se ha enviado correctamente.',
                            background: '#00975bd7',
                            color: '#fff',
                            width: '355px'
                        });

                        setTimeout(() => {
                            redirectForm("confirmacion-test.php");
                        }, 1500);
                    } catch (err) {
                        console.log(err);
                    }
                }
                postTest();
                puntaje = [];
                formTest.reset();
            })
        </script>
    <?php } ?>
    </div>

    <style>
        .progress-ring-circle {
            stroke-dasharray: 1602;
            stroke-dashoffset: 0;
            transform: rotate(-90deg);
            transform-origin: center;
            transition: all 1s linear;
        }

        .timer-circle {
            width: 140px;
            height: 140px;
            border-radius: 100%;
            background: radial-gradient(71.4% 71.4% at 51.7% 28.6%,
                    #284248 0%,
                    #0a1b1f 100%);
            box-shadow: -5px 14px 44px #000000,
                5px -16px 50px #ffffff26;
        }

        .swal2-success-circular-line-left,
        .swal2-success-fix,
        .swal2-success-circular-line-right {
            background-color: transparent !important;
        }
    </style>

    <script>
        let totalTime = 30 * 60 * 1000;
        let timerTime = totalTime;

        const redirectForm = (url) => {
            const form = document.createElement('form');
            form.method = 'post';
            form.action = url;
            document.body.appendChild(form);

            const inputEmployeeId = document.createElement('input');
            inputEmployeeId.type = 'hidden';
            inputEmployeeId.name = 'employee_id';
            inputEmployeeId.value = '<?php echo $_POST["employee_id"] ?>';

            form.appendChild(inputEmployeeId);
            form.submit();
        };

        setInterval(() => {
            timerTime = timerTime - 1000;
            updateTime(timerTime);

            if (timerTime === 0) {
                redirectForm("confirmacion-test.php");
            }
        }, 1000);

        const convertMstoMinutesSeconds = (timeInMs) => {
            let seconds = Math.floor((timeInMs / 1000) % 60);
            let minutes = Math.floor((timeInMs / (1000 * 60)) % 60);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            return `${minutes}:${seconds}`;
        };

        const updateProgress = (timeLeft) => {
            const percentageLeft = 1 - timeLeft / totalTime;
            const offset = 1602 * percentageLeft;
            document.querySelector("circle").style.strokeDashoffset = offset;
            document.querySelector("circle").setAttribute("stroke", "#1AFFAC");
        };

        const updateTime = (timeInMs) => {
            const formattedTime = convertMstoMinutesSeconds(timeInMs);
            document.getElementById("time").innerText = formattedTime;
            updateProgress(timeInMs);
        };
    </script>
</body>