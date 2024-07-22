<?php include 'includes/header-practicante.php'; ?>
<?php include 'includes/notas-logros-ultimo-mes.php' ?>
<?php
$sumaPromedios = 0;
$cantidadSemanas = 0;
$promedioTotal = 0;

foreach ($notas_por_semana as $semana => $notas) {
    $promedioNota1 = count($notas['criterio_1']) > 0 ? round(array_sum($notas['criterio_1']) / count($notas['criterio_1']), 0) : '-';
    $promedioNota2 = count($notas['criterio_2']) > 0 ? round(array_sum($notas['criterio_2']) / count($notas['criterio_2']), 0) : '-';
    $promedioNota3 = count($notas['criterio_3']) > 0 ? round(array_sum($notas['criterio_3']) / count($notas['criterio_3']), 0) : '-';
    $promedioSemanal = $promedioNota1 !== '-' && $promedioNota2 !== '-' && $promedioNota3 !== '-' ? round(($promedioNota1 + $promedioNota2 + $promedioNota3) / 3, 1) : '-';
    $fecha_inicio_semana = date('Y-m-d', strtotime('monday this week', strtotime($notas['fecha_promedio'])));
    $fecha_fin_semana = date('Y-m-d', strtotime('sunday this week', strtotime($notas['fecha_promedio'])));
    $fecha_inicio_semana_format = date('d/m/Y', strtotime($fecha_inicio_semana));
    $fecha_fin_semana_format = date('d/m/Y', strtotime($fecha_fin_semana));

    if ($promedioSemanal !== '-') {
        $sumaPromedios += $promedioSemanal;
        $cantidadSemanas++;
    }
}

if ($cantidadSemanas > 0) {
    $promedioTotal = round($sumaPromedios / $cantidadSemanas, 1);
} else {
    echo "";
}
?>
<?php include 'includes/logros-medallas.php' ?>

<body class="bg-white">
    <?php $estadisticas_click = "clicked" ?>
    <?php include 'includes/fecha_actual.php' ?>
    <?php include 'includes/navbar-sidebar-practicante.php' ?>

    <?php if (isset($row['employee_id'])) { ?>
        <div class="container-fluid" id="grid-estadistica-general">
            <div>
                <div class="card" id="logros-semanal">
                    <div class="circle-logro-semanal-1"></div>
                    <div class="line-logro-semanal-1"></div>
                    <div class="line-logro-semanal-1-1" style="width: <?php echo $barraMedalla ?>px;"></div>
                    <div class="circle-logro-semanal-2" style="<?php echo $colorcircle ?>"><img class="insignia-logro"
                            src="../img/bronce-insignia.webp"></div>
                    <div class="line-logro-semanal-2"></div>
                    <div class="line-logro-semanal-2-1" style="width: <?php echo $barraMedalla2 ?>px;"></div>
                    <div class="circle-logro-semanal-3" style="<?php echo $colorcircle2 ?>"><img class="insignia-logro"
                            src="../img/plata-insignia_1.webp"></div>
                    <div class="line-logro-semanal-3"></div>
                    <div class="line-logro-semanal-3-1" style="width: <?php echo $barraMedalla3 ?>px;"></div>
                    <div class="circle-logro-semanal-4" style="<?php echo $colorcircle3 ?>"><img class="insignia-logro"
                            src="../img/oro-insignia_1.webp"></div>
                    <div class="line-logro-semanal-4"></div>
                    <div class="line-logro-semanal-4-1" style="width: <?php echo $barraMedalla4 ?>px;"></div>
                    <div class="circle-logro-semanal-5" style="<?php echo $colorcircle4 ?>"><img class="insignia-logro"
                            src="../img/maxima-insignia.webp"></div>
                </div>
                <div class="buttons-estadistica">
                    <form method="post" action="estadisticas-y-logros-practicante.php"
                        class="form__calendar calendar-button-color">
                        <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                        <input type="submit" value="GENERAL" class="btn__calendar letraNavBar text-light">
                    </form>
                    <form method="post" action="estadisticas-logros-ultimo-mes.php"
                        class="form__calendar calendar-button-color">
                        <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                        <input type="submit" value="ÚLTIMO MES" class="btn__calendar letraNavBar text-light ">
                    </form>
                    <form method="post" action="estadisticas-logros-ultima-semana.php" class="form__calendar ">
                        <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                        <input type="submit" value="ÚLTIMA SEMANA" class="btn__calendar--active letraNavBar text-light">
                    </form>
                </div>
                <!-- RESUMEN SEMANAL INICIO -->
                <div class="statistics">
                    <?php include 'includes/notas-ultima-semana-vermas.php' ?>
                    <?php include 'includes/nota_ultimo-mes.php' ?>
                    <?php
                    $semanaN = 0;
                    foreach ($notas_por_semana as $semana => $notas) {
                        $promedioNota1 = count($notas['criterio_1']) > 0 ? round(array_sum($notas['criterio_1']) / count($notas['criterio_1']), 1) : '-';
                        $promedioNota2 = count($notas['criterio_2']) > 0 ? round(array_sum($notas['criterio_2']) / count($notas['criterio_2']), 1) : '-';
                        $promedioNota3 = count($notas['criterio_3']) > 0 ? round(array_sum($notas['criterio_3']) / count($notas['criterio_3']), 1) : '-';
                        $promedioSemanal = $promedioNota1 !== '-' && $promedioNota2 !== '-' && $promedioNota3 !== '-' ? round(($promedioNota1 + $promedioNota2 + $promedioNota3) / 3, 1) : '-';
                        $semanaN++;
                    }
                    $cadena = $mes_a_mostrar;
                    $elementos = explode("-", $cadena);
                    $meses = array(
                        '01' => 'ENERO',
                        '02' => 'FEBRERO',
                        '03' => 'MARZO',
                        '04' => 'ABRIL',
                        '05' => 'MAYO',
                        '06' => 'JUNIO',
                        '07' => 'JULIO',
                        '08' => 'AGOSTO',
                        '09' => 'SEPTIEMBRE',
                        '10' => 'OCTUBRE',
                        '11' => 'NOVIEMBRE',
                        '12' => 'DICIEMBRE'
                    );
                    $mesSelect = isset($meses[$elementos[1]]) ? $meses[$elementos[1]] : 'MES INVÁLIDO';
                    ?>
                    <div class="weekly-summary">
                        <p class="summary-month letraNavBar">RESUMEN
                            <?php echo $mesSelect; ?> - SEMANA
                            <?php echo $semanaN2 ?>
                        </p>
                        <div class="grid">
                            <div class="card-aspects border-blue-card-aspects">
                                <div class="card-aspects-title background-blue-card-aspects">
                                    <div class="card-aspects-title-text">
                                        <p class="letraNavBar">Estadísticas de desempeño</p>
                                        <span class="letraNavBar">Última semana</span>
                                    </div>
                                    <img src="../img/exclamacion-blanco.png" alt="mas información" />
                                </div>
                                <div id="resume-flower-graphic">
                                    <div>
                                        <div class="flower">
                                            <?php
                                            if ($result1->num_rows > 0) {
                                                $sum_criterio1 = 0;
                                                $count_criterio1 = 0;
                                                $notaN1 = 1;
                                                while ($row1 = $result1->fetch_assoc()) {
                                                    echo '
                                                <div class="petal petal-' . $notaN1 . '">
                                                    <div class="note' . $notaN1 . '">' . $row1["nota"] . '</div>
                                                </div>
                                                ';
                                                    $sum_criterio1 += $row1["nota"];
                                                    $count_criterio1++;
                                                    $notaN1++;
                                                }
                                                $promedio_criterio1 = round(($sum_criterio1 / $count_criterio1), 0);
                                            } else {
                                                echo '<div class="respuesta__vacio">
                                                    <div class="respuesta__vacio2"> No tienes notas en la ultima semana</div>
                                                </div>';
                                            }
                                            ?>

                                        </div>
                                    </div>
                                    <div id="graph-legend">
                                        <div class="d-flex legend card-summary-legend">
                                            <div class="resume-square-legend-1 "></div>
                                            <p class="letraNavBar colorletraperfil letra-resume-size-legend">Asistencia y
                                                puntualidad</p>
                                        </div>
                                        <div class="d-flex legend card-summary-legend">
                                            <div class="resume-square-legend-2"></div>
                                            <p class="letraNavBar colorletraperfil letra-resume-size-legend">Cumplimiento de
                                                metas</p>
                                        </div>
                                        <div class="d-flex legend card-summary-legend">
                                            <div class="resume-square-legend-3"></div>
                                            <p class="letraNavBar colorletraperfil letra-resume-size-legend">Responsabilidad
                                                y compromiso</p>
                                        </div>
                                        <div class="d-flex legend card-summary-legend">
                                            <div class="resume-square-legend-4"></div>
                                            <p class="letraNavBar colorletraperfil letra-resume-size-legend">Creatividad e
                                                iniciativa</p>
                                        </div>
                                        <div class="d-flex legend card-summary-legend">
                                            <div class="resume-square-legend-5"></div>
                                            <p class="letraNavBar colorletraperfil letra-resume-size-legend">Cumplimiento
                                                reglamento</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-aspects-average">
                                    <p class="letraNavBar">Promedio =
                                        <?php echo $promedio_criterio1 ?>
                                    </p>
                                </div>
                            </div>
                            <div class="card-aspects border-sky-blue-card-aspects">
                                <div class="card-aspects-title background-sky-blue-card-aspects">
                                    <div class="card-aspects-title-text">
                                        <p class="letraNavBar">Estadísticas de desempeño</p>
                                        <span class="letraNavBar">Última semana</span>
                                    </div>
                                    <img src="../img/exclamacion-blanco.png" alt="mas información" />
                                </div>
                                <div id="resume-flower-graphic">
                                    <div>
                                        <div class="flower">
                                            <?php
                                            if ($result2->num_rows > 0) {
                                                $sum_criterio2 = 0;
                                                $count_criterio2 = 0;
                                                $notaN2 = 1;
                                                while ($row2 = $result2->fetch_assoc()) {
                                                    echo '
                                        <div class="petal petal-' . $notaN2 . '">
                                            <div class="note' . $notaN2 . '">' . $row2["nota"] . '</div>
                                        </div>
                                        ';
                                                    $sum_criterio2 += $row2["nota"];
                                                    $count_criterio2++;
                                                    $notaN2++;
                                                }
                                                $promedio_criterio2 = round(($sum_criterio2 / $count_criterio2), 0);
                                            } else {
                                                echo '<div class="respuesta__vacio">
                                                    <div class="respuesta__vacio2"> No tienes notas en la ultima semana</div>
                                                </div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div id="graph-legend">
                                        <div class="d-flex legend card-summary-legend">
                                            <div class="resume-square-legend-1 "></div>
                                            <p class="letraNavBar colorletraperfil letra-resume-size-legend">Planeación y
                                                organización</p>
                                        </div>
                                        <div class="d-flex legend card-summary-legend">
                                            <div class="resume-square-legend-2"></div>
                                            <p class="letraNavBar colorletraperfil letra-resume-size-legend">Calidad del
                                                trabajo</p>
                                        </div>
                                        <div class="d-flex legend card-summary-legend">
                                            <div class="resume-square-legend-3"></div>
                                            <p class="letraNavBar colorletraperfil letra-resume-size-legend">Conocimiento
                                                del trabajo</p>
                                        </div>
                                        <div class="d-flex legend card-summary-legend">
                                            <div class="resume-square-legend-4"></div>
                                            <p class="letraNavBar colorletraperfil letra-resume-size-legend">Trabajo en
                                                equipo</p>
                                        </div>
                                        <div class="d-flex legend card-summary-legend">
                                            <div class="resume-square-legend-5"></div>
                                            <p class="letraNavBar colorletraperfil letra-resume-size-legend">Capacidad de
                                                liderazgo</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-aspects-average">
                                    <p class="letraNavBar">Promedio =
                                        <?php echo $promedio_criterio2 ?>
                                    </p>
                                </div>
                            </div>
                            <div class="card-aspects border-green-card-aspects">
                                <div class="card-aspects-title background-green-card-aspects">
                                    <div class="card-aspects-title-text">
                                        <p class="letraNavBar">Estadísticas de desempeño</p>
                                        <span class="letraNavBar">Última semana</span>
                                    </div>
                                    <img src="../img/exclamacion-blanco.png" alt="mas información" />
                                </div>
                                <div id="resume-flower-graphic">
                                    <div>
                                        <div class="flower">
                                            <?php
                                            if ($result3->num_rows > 0) {
                                                $sum_criterio3 = 0;
                                                $count_criterio3 = 0;
                                                $notaN3 = 1;
                                                while ($row3 = $result3->fetch_assoc()) {
                                                    echo '
                                        <div class="petal petal-' . $notaN3 . '">
                                            <div class="note' . $notaN3 . '">' . $row3["nota"] . '</div>
                                        </div>
                                        ';
                                                    $sum_criterio3 += $row3["nota"];
                                                    $count_criterio3++;
                                                    $notaN3++;
                                                }
                                                $promedio_criterio3 = round(($sum_criterio3 / $count_criterio3), 0);
                                            } else {
                                                echo '<div class="respuesta__vacio">
                                                    <div class="respuesta__vacio2"> No tienes notas en la ultima semana</div>
                                                </div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div id="graph-legend">
                                        <div class="d-flex legend card-summary-legend">
                                            <div class="resume-square-legend-1 "></div>
                                            <p class="letraNavBar colorletraperfil letra-resume-size-legend">Adaptación al
                                                cambio</p>
                                        </div>
                                        <div class="d-flex legend card-summary-legend">
                                            <div class="resume-square-legend-2"></div>
                                            <p class="letraNavBar colorletraperfil letra-resume-size-legend">Solución de
                                                problemass</p>
                                        </div>
                                        <div class="d-flex legend card-summary-legend">
                                            <div class="resume-square-legend-3"></div>
                                            <p class="letraNavBar colorletraperfil letra-resume-size-legend">Trabajo bajo
                                                presión</p>
                                        </div>
                                        <div class="d-flex legend card-summary-legend">
                                            <div class="resume-square-legend-4"></div>
                                            <p class="letraNavBar colorletraperfil letra-resume-size-legend">Comunicación y
                                                relaciones interpersonales</p>
                                        </div>
                                        <div class="d-flex legend card-summary-legend">
                                            <div class="resume-square-legend-5"></div>
                                            <p class="letraNavBar colorletraperfil letra-resume-size-legend">Capacidad
                                                innovadora</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-aspects-average">
                                    <p class="letraNavBar">Promedio =
                                        <?php echo $promedio_criterio3; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- RESUMEN SEMANAL FIN -->
            </div>

            <div class="card" id="logros-obtenidos-practicante">
                <h6 class="letraNavBar colorletraperfil">LOGROS</h6>
                <div>
                    <div class="circle-logros-a-obtener-1" style="<?php echo $colorcircle ?>"><img
                            src="../img/bronce-insignia.webp"></div>
                    <p class="letraNavBar colorletraperfil">
                        <?php echo $obtenido ?>
                    </p>
                    <div class="circle-logros-a-obtener-2" style="<?php echo $colorcircle2 ?>"><img
                            src="../img/plata-insignia_1.webp"></div>
                    <p class="letraNavBar colorletraperfil">
                        <?php echo $obtenido2 ?>
                    </p>
                    <div class="circle-logros-a-obtener-3" style="<?php echo $colorcircle3 ?>"><img
                            src="../img/oro-insignia_1.webp"></div>
                    <p class="letraNavBar colorletraperfil">
                        <?php echo $obtenido3 ?>
                    </p>
                    <div class="circle-logros-a-obtener-4" style="<?php echo $colorcircle4 ?>"><img
                            src="../img/maxima-insignia.webp"></div>
                    <p class="letraNavBar colorletraperfil">
                        <?php echo $obtenido4 ?>
                    </p>
                </div>
            </div>
        </div>
        </div>

        <?php
    } else {
        echo "";
    }
    ?>
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