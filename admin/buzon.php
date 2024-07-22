<?php include 'includes/header-practicante.php'; ?>

<body class="bg-white">
    <?php $buzon_click = "clicked" ?>
    <?php include 'includes/fecha_actual.php' ?>
    <?php include 'includes/navbar-sidebar-practicante.php' ?>
    <?php include 'includes/conn.php' ?>

    <main class="buzon-container">
        <div class="buzon-btns">
            <!-- <a href="nueva-sugerencia.php">Nueva Sugerencia +</a> -->
            <form method="post" action="nueva-sugerencia.php">
                <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                <input type="submit" value="Nueva Sugerencia +">
            </form>
            <!-- <a href="borradores-buzon.php">Borradores</a> -->
            <form method="post" action="borradores-buzon.php">
                <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                <input type="submit" value="Borradores">
            </form>
        </div>
        <div class="buzon-table">
            <table>
                <thead>
                    <tr>
                        <th class="text-center" style="width: 190px;">Asunto
                            <svg width="13" height="5" viewBox="0 0 13 5" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path id="Polygon 7" d="M6.5 5L12.9952 0.5H0.00480938L6.5 5Z" fill="#464646" />
                            </svg>
                        </th>
                        <th class="text-center">
                            Tipo
                            <svg width="13" height="5" viewBox="0 0 13 5" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path id="Polygon 7" d="M6.5 5L12.9952 0.5H0.00480938L6.5 5Z" fill="#464646" />
                            </svg>
                        </th>
                        <th class="text-center" style="width: 120px;">
                            Fecha
                            <svg width="13" height="5" viewBox="0 0 13 5" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path id="Polygon 7" d="M6.5 5L12.9952 0.5H0.00480938L6.5 5Z" fill="#464646" />
                            </svg>
                        </th>
                        <th class="text-center" style="width: 110px;">
                            Estado
                            <svg width="13" height="5" viewBox="0 0 13 5" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path id="Polygon 7" d="M6.5 5L12.9952 0.5H0.00480938L6.5 5Z" fill="#464646" />
                            </svg>
                        </th>
                        <th class="text-center">
                            Respuesta
                            <svg width="13" height="5" viewBox="0 0 13 5" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path id="Polygon 7" d="M6.5 5L12.9952 0.5H0.00480938L6.5 5Z" fill="#464646" />
                            </svg>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $employee_id = $row['employee_id'];

                    $employee_query = "SELECT id FROM employees WHERE employee_id = '$employee_id'";
                    $employee_result = $conn->query($employee_query);

                    if ($employee_result->num_rows > 0) {
                        $employee_row = $employee_result->fetch_assoc();
                        $empleado_id = $employee_row["id"];

                        $consulta = "SELECT * FROM sugerencias WHERE employee_id = '$empleado_id'";
                        $resultado = $conn->query($consulta);

                        if ($resultado->num_rows > 0) {
                            while ($fila = $resultado->fetch_assoc()) {
                                $sugerencia_id = $fila["id"];
                                $consulta_respuesta = "SELECT respuesta FROM respuesta_sugerencias WHERE sugerencia_id = '$sugerencia_id'";
                                $resultado_respuesta = $conn->query($consulta_respuesta);

                                ?>
                                <tr>
                                    <td class="text-center">
                                        <?php echo $fila["asunto"]; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $fila["tipo"]; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $fila["fecha"]; ?>
                                    </td>
                                    <td class="text-center">enviado</td>
                                    <td class="text-center">
                                        <?php
                                        if ($resultado_respuesta->num_rows > 0) {
                                            $respuesta = $resultado_respuesta->fetch_assoc()["respuesta"];
                                            echo $respuesta;
                                        } else {
                                            echo "Sin respuesta";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5">No hay sugerencias registradas.</td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "No se encontró el empleado con el employee_id proporcionado.";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <script>
        let idPracticante = document.getElementById("idPracticante");
        if (idPracticante.value.length > 15) {
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