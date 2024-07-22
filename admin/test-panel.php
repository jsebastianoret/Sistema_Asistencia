<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $test_click = "clicked" ?>
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
                    <h4><i class='icon fa fa-check'></i>�0�3Proceso Exitoso!</h4>
                    <?php echo $_SESSION['success'] ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php } ?>
            <div class="select-container d-flex flex-wrap justify-content-center align-items-center gap-3 mb-3">
                <div class="position-relative">
                    <select>
                        <option value="test-1">TEST ADM. JEFATURA</option>
                        <option value="test-2">TEST ADM. PROYECTO</option>
                        <option value="test-3">TEST ADMINISTRADORES</option>
                    </select>
                    <form method="post" id="t1" style="display:flex; top: 7px; width: 150px; position: relative; justify-content: baseline;" action="test_vista_previa.php?test=1">
                        <input type="submit" class="btn text-white letraNavBar rounded-pill px-6 "  value="Vista Previa"
                            style="background: #1e4da9;">
                    </form>
                    <form method="post" id="t1e" style="display:flex; bottom: 26px; width: 150px; left:80px; position: relative; justify-content: flex-end;" action="test-edit.php?test=1">
                        <input type="submit" class="btn text-white letraNavBar rounded-pill px-6 "  value="Editar Test"
                            style="background: #1e4da9;">
                    </form>
                    <form method="post" id="t2" style="display:flex; top: 7px; width: 150px; position: relative; justify-content: baseline;" action="test_vista_previa.php?test=2" class="d-none">
                        <input type="submit" class="btn text-white letraNavBar rounded-pill px-6" value="Vista Previa"
                            style="background: #1e4da9;">
                    </form>
                    <form method="post" id="t2e" style="display:flex; bottom: 26px; width: 150px; left:80px; position: relative; justify-content: flex-end;" action="test-edit.php?test=2" class="d-none">
                        <input type="submit" class="btn text-white letraNavBar rounded-pill px-6 "  value="Editar Test"
                            style="background: #1e4da9;">
                    </form>
                    <form method="post" id="t3" style="display:flex; top: 7px; width: 150px; position: relative; justify-content: baseline;" action="test_vista_previa.php?test=3" class="d-none">
                        <input type="submit" class="btn text-white letraNavBar rounded-pill px-6" value="Vista Previa"
                            style="background: #1e4da9;">
                    </form>
                    <form method="post" id="t3e" style="display:flex; bottom: 26px; width: 150px; left:80px; position: relative; justify-content: flex-end;" action="test-edit.php?test=3" class="d-none">
                        <input type="submit" class="btn text-white letraNavBar rounded-pill px-6 "  value="Editar Test"
                            style="background: #1e4da9;">
                    </form>
                    <div class="select-icon">
                        <svg width="20" height="12" viewBox="0 0 27 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="Group 44">
                                <path id="Polygon 1"
                                    d="M13.0886 17.0677L1.76371 4.37678L24.2801 4.25904L13.0886 17.0677Z"
                                    fill="white" />
                            </g>
                        </svg>
                    </div>
                </div>
                <?php
                $sql = "SELECT estado FROM preguntas_test LIMIT 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $estado = intval($row["estado"]);
                }
                ?>
                <button class="button-secondary ms-sm-auto">
                    <?php if ($estado === 0) { ?>
                        Activar Test<i class="fa-solid fa-toggle-off ms-2 fs-6"></i>
                    <?php } else { ?>
                        Desactivar Test<i class="fa-solid fa-toggle-on ms-2 fs-6"></i>
                    <?php } ?>
                </button>
            </div>
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered test-1">
                        <thead>
                            <th class="align-middle text-center">Nombre Administrador</th>
                            <th class="align-middle text-center">Unidad de Negocio</th>
                            <th class="align-middle text-center">Cantidad</th>
                            <th class="align-middle text-center">Nota Promedio</th>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT n.nombre_negocio, CONCAT(e.firstname, ' ', e.lastname) AS nombre, CAST(COUNT(r.pregunta_id)/15 AS SIGNED) AS cantidad, SUM(r.valor) AS suma_notas
                                        FROM negocio n
                                        LEFT JOIN preguntas_test p ON p.test = 1
                                        LEFT JOIN employees e ON n.id = e.negocio_id AND e.position_id = 13
                                        LEFT JOIN respuestas_test r ON p.id = r.pregunta_id AND e.id = r.adm_id
                                        GROUP BY n.nombre_negocio, e.id";
                            $query = $conn->query($sql);

                            while ($row = $query->fetch_assoc()) {
                                if (isset($row['nombre'])) {
                                    $row['suma_notas'] > 0 ? $nota = $row['suma_notas'] / $row['cantidad'] : $nota = 0; ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <?php echo $row['nombre'] ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo $row['nombre_negocio'] ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo $row['cantidad'] ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo round($nota, 2); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                    <table class="table table-bordered test-2 d-none">
                        <thead>
                            <th class="align-middle text-center">Nombre Administrador</th>
                            <th class="align-middle text-center">Unidad de Negocio</th>
                            <th class="align-middle text-center">Cantidad</th>
                            <th class="align-middle text-center">Nota Promedio</th>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT n.nombre_negocio, CONCAT(e.firstname, ' ', e.lastname) AS nombre, CAST(COUNT(r.pregunta_id)/30 AS SIGNED) AS cantidad, SUM(r.valor) AS suma_notas
                                        FROM negocio n
                                        LEFT JOIN preguntas_test p ON p.test = 2
                                        LEFT JOIN employees e ON n.id = e.negocio_id AND e.position_id = 2
                                        LEFT JOIN respuestas_test r ON n.id = r.negocio_id AND p.id = r.pregunta_id AND e.id = r.adm_id
                                        GROUP BY n.nombre_negocio, e.id";
                            $query = $conn->query($sql);

                            while ($row = $query->fetch_assoc()) {
                                if (isset($row['nombre'])) {
                                    $nota = 0;?>
                                    
                                    <tr>
                                        <td class="align-middle text-center">
                                            <?php echo $row['nombre'] ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo $row['nombre_negocio'] ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo $row['cantidad'] ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo round($nota, 2); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                    <table class="table table-bordered test-3 d-none">
                        <thead>
                            <th class="align-middle text-center">Nombre</th>
                            <th class="align-middle text-center">Posicion</th>
                            <th class="align-middle text-center">Unidad de Negocio</th>
                            <th class="align-middle text-center">Nota</th>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT CONCAT(e.firstname, ' ', e.lastname) AS nombre, n.nombre_negocio, po.description, SUM(r.valor) AS suma_notas
                                        FROM negocio n
                                        LEFT JOIN preguntas_test p ON p.test = 3
                                        LEFT JOIN employees e ON n.id = e.negocio_id AND (e.position_id = 2 or e.position_id = 13)
                                        LEFT JOIN respuestas_test r ON n.id = r.negocio_id AND p.id = r.pregunta_id AND e.id = r.employee_id
                                        LEFT JOIN position po ON e.position_id = po.id
                                        GROUP BY n.nombre_negocio, e.id";
                            $query = $conn->query($sql);

                            while ($row = $query->fetch_assoc()) {
                                if (isset($row['nombre'])) { ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <?php echo $row['nombre'] ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo $row['description'] ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo $row['nombre_negocio'] ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo round($row['suma_notas'], 2); ?>
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

    <script src="js/scripts.js"></script>

    <!-- ACTIVAR/DESACTIVAR TEST -->
    <script>
        const btnToogleTest = document.querySelector(".button-secondary");

        btnToogleTest.addEventListener("click", () => {
            if (btnToogleTest.textContent === 'Activar Test') {
                btnToogleTest.innerHTML = 'Desactivar Test<i class="fa-solid fa-toggle-on ms-2 fs-6"></i>';
                btnToogleTest.setAttribute("data-estado", "1");
            } else {
                btnToogleTest.innerHTML = 'Activar Test<i class="fa-solid fa-toggle-off ms-2 fs-6"></i>';
                btnToogleTest.setAttribute('data-estado', '0');
            }

            Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 3000
            }).fire({
                icon: 'success',
                title: btnToogleTest.getAttribute('data-estado') == 1 ? 'Se ha activado el test.' : 'Se ha desactivado el test.',
                background: '#00975bd7',
                color: '#fff',
                width: '355px'
            });

            async function toggleEstado() {
                try {
                    const res = await fetch('includes/estado-test.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            estado: btnToogleTest.getAttribute('data-estado')
                        })
                    }),
                        json = await res.json();
                } catch (err) {
                    console.log(err)
                }
            }
            toggleEstado();
        })
    </script>

    <!-- MOSTRAR TABLE DE TEST POR SELECT -->
    <script>
        const selectTests = document.querySelector("select");

        selectTests.addEventListener('change', (e) => {
            const option = event.target.value;
            const table = document.querySelectorAll("table");
            table.forEach(element => {
                element.classList.add("d-none");
            });
            document.querySelector(`.${option}`).classList.remove("d-none");
            switch(option){
                case "test-1":{
                    document.getElementById("t1").classList.remove("d-none");
                    document.getElementById("t2").classList.add("d-none");
                    document.getElementById("t3").classList.add("d-none");
                    document.getElementById("t1e").classList.remove("d-none");
                    document.getElementById("t2e").classList.add("d-none");
                    document.getElementById("t3e").classList.add("d-none");
                    break;
                }
                case "test-2":{
                    document.getElementById("t2").classList.remove("d-none");
                    document.getElementById("t1").classList.add("d-none");
                    document.getElementById("t3").classList.add("d-none");
                    document.getElementById("t2e").classList.remove("d-none");
                    document.getElementById("t1e").classList.add("d-none");
                    document.getElementById("t3e").classList.add("d-none");
                    break;
                }
                case "test-3":{
                    document.getElementById("t3").classList.remove("d-none");
                    document.getElementById("t1").classList.add("d-none");
                    document.getElementById("t2").classList.add("d-none");
                    document.getElementById("t3e").classList.remove("d-none");
                    document.getElementById("t1e").classList.add("d-none");
                    document.getElementById("t2e").classList.add("d-none");
                    break;
                }
            }
        });
    </script>
</body>

</html>