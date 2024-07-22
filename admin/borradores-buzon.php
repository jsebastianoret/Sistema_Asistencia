<?php include 'includes/header-practicante.php'; ?>

<body class="bg-white">
    <?php $buzon_click = "clicked" ?>
    <?php include 'includes/fecha_actual.php' ?>
    <?php include 'includes/navbar-sidebar-practicante.php' ?>

    <main class="buzon-container">
        <div class="regresar">
            <form method="post" action="buzon.php">
                <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                <input class="volver" type="submit" value="< VOLVER">
            </form>
        </div>
        <div class="buzon-table">
            <p>Lista de borradores</p>
            <table>
                <thead>
                    <tr>
                        <th>Asunto</th>
                        <th>
                            Tipo
                            <svg width="13" height="5" viewBox="0 0 13 5" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path id="Polygon 7" d="M6.5 5L12.9952 0.5H0.00480938L6.5 5Z" fill="#464646" />
                            </svg>
                        </th>
                        <th>
                            Fecha
                            <svg width="13" height="5" viewBox="0 0 13 5" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path id="Polygon 7" d="M6.5 5L12.9952 0.5H0.00480938L6.5 5Z" fill="#464646" />
                            </svg>
                        </th>
                        <th>
                            Estado
                            <svg width="13" height="5" viewBox="0 0 13 5" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path id="Polygon 7" d="M6.5 5L12.9952 0.5H0.00480938L6.5 5Z" fill="#464646" />
                            </svg>
                        </th>
                        <th>
                            Acción
                            <svg width="13" height="5" viewBox="0 0 13 5" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path id="Polygon 7" d="M6.5 5L12.9952 0.5H0.00480938L6.5 5Z" fill="#464646" />
                            </svg>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $jsonFile = "usuarios.json";
                    $existingData = json_decode(file_get_contents($jsonFile), true);
                    $loggedInUserId = $row['employee_id'];

                    if (!empty($existingData) && is_array($existingData)) {
                        foreach ($existingData as $key => $data) {
                            if ($data['employee_id'] === $loggedInUserId) {
                                $incomplete = false;

                                $requiredFields = array('nombre', 'fecha', 'asunto', 'tipo', 'unidad', 'sugerencia');
                                foreach ($requiredFields as $field) {
                                    if (empty($data[$field])) {
                                        $incomplete = true;
                                        break;
                                    }
                                }

                                echo "<tr data-id='{$data['id']}'>";
                                echo "<td>{$data['asunto']}</td>";
                                echo "<td>{$data['tipo']}</td>";
                                echo "<td>{$data['fecha']}</td>";

                                if ($incomplete) {
                                    echo "<td>Incompleto</td>";
                                    echo '<td><div class="btn-group">';
                                    echo '<form method="post" action="completar-sugerencia.php">';
                                    echo '<input type="hidden" name="employee_id" value="' . $loggedInUserId . '">';
                                    echo '<button class="btn btn-warning" style="margin-right: 10px;" type="submit" name="completar" value="' . $data['id'] . '">Completar</button>';
                                    echo '</form>';
                                    echo '</div>';
                                    echo '<div class="btn-group">';
                                    echo '<button class="btn btn-danger eliminar-sugerencia" data-id="' . $data['id'] . '">Eliminar</button>';
                                    echo '</div></td>';
                                } else {
                                    echo "<td>No enviado</td>";
                                    echo '<td><div class="btn-group">';
                                    echo '<form method="post" action="procesar-borrador.php">';
                                    echo '<input type="hidden" name="sugerencia_id" value="' . $data['id'] . '">';
                                    echo '<input type="hidden" name="employee_id" value="' . $loggedInUserId . '">';
                                    echo '<button type="submit" class="btn btn-success" style="margin-right: 5px;">Enviar</button>';
                                    echo '</form>';
                                    echo '</div>';
                                    echo '<div class="btn-group">';
                                    echo '<button class="btn btn-danger eliminar-sugerencia" style="margin-left: 5px;" data-id="' . $data['id'] . '">Eliminar</button>';
                                    echo '</div></td>';
                                }
                                echo "</tr>";
                            }
                        }

                        if (empty($existingData)) {
                            echo '<tr><td colspan="6">No hay borradores guardados</td></tr>';
                        }
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </main>
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
    <script>
        $(document).ready(function () {
            $(".eliminar-sugerencia").click(function () {
                var $this = $(this);
                var sugerenciaId = $this.closest("tr").data("id");
                $.ajax({
                    url: "eliminar-sugerencia.php",
                    method: "POST",
                    data: {
                        sugerencia_id: sugerenciaId
                    },
                    success: function (response) {
                        if (response === "success") {
                            $this.closest("tr").remove();
                        } else {
                            alert("Error al eliminar la sugerencia.");
                        }
                    }
                });
            });
        });
    </script>
</body>