<?php
include 'includes/fecha_actual.php';
include 'includes/gestion_permisos.php';

$query = "SELECT COUNT(*) as total FROM papelera";

$result = $conn->query($query);
if (!$result) {
    die("Error al ejecutar la consulta: " . $conn->error);
}

$row = $result->fetch_assoc();
$totalDatos = $row['total'];

$permisoAsistenciaLeer = $permisoAsistencia['leer'];
$permisoPracticantesLeer = $permisoPracticantes['leer'];
$permisoCargosLeer = $permisoCargos['leer'];
$permisoUnidadLeer = $permisoUnidad['leer'];
$permisoVistaLeer = $permisoVista['leer'];
$permisoUsuariosLeer = $permisoUsuarios['leer'];
$permisoCriteriosLeer = $permisoCriterios['leer'];
$permisoResumenLeer = $permisoResumen['leer'];
$permisoExportarLeer = $permisoExportar['leer'];
$permisoPublicacionesLeer = $permisoPublicaciones['leer'];
$permisoPapeleraLeer = $permisoPapelera['leer'];
?>

<!-- SIDEBAR -->
<aside class="sidebar d-flex flex-column main-sidebar pt-0 pb-2">
    <div class="d-flex flex-column align-items-center gap-3 py-4 px-3 mt-2">
        <img class="rounded-circle bg-white" src="LOGO/LOGO-NHL.webp" alt="logo" height="80">
        <h6 class="text-white text-center fw-bolder">
            <?php echo $user['firstname'] . ' ' . $user['lastname'] ?>
        </h6>
    </div>
    <div class="nav-group d-flex flex-column gap-2">
        <hr>
        <div class="<?php echo isset($panel_click) ? $panel_click : "" ?>">
            <a class="text-decoration-none" href="panel-control.php">
                <div class="text-center text-white py-2">Panel de control</div>
            </a>
        </div>
        <hr>
        <?php if ($permisoAsistenciaLeer == "Sí") { ?>
            <div class="<?php echo isset($asistencia_click) ? $asistencia_click : "" ?>">
                <a class="text-decoration-none" href="asistencias.php">
                    <div class="text-center text-white py-2">Asistencias</div>
                </a>
            </div>
        <?php } ?>
        <?php if ($permisoCargosLeer == "Sí") { ?>
            <div class="<?php echo isset($cargos_click) ? $cargos_click : "" ?>">
                <a class="text-decoration-none" href="cargos.php">
                    <div class="text-center text-white py-2">Cargos</div>
                </a>
            </div>
        <?php } ?>
        <?php if ($permisoUnidadLeer == "Sí") { ?>
            <div class="<?php echo isset($negocio_click) ? $negocio_click : "" ?>">
                <a class="text-decoration-none" href="negocio.php">
                    <div class="text-center text-white py-2">Unidad de Negocio</div>
                </a>
            </div>
        <?php } ?>
        <?php if ($permisoVistaLeer == "Sí") { ?>
            <div class="<?php echo isset($vista_click) ? $vista_click : "" ?>">
                <a class="text-decoration-none" href="vista-asistencia.php">
                    <div class="text-center text-white py-2">Vista de Asistencia</div>
                </a>
            </div>
        <?php } ?>
        
        <?php if ($permisoUsuariosLeer == "Sí") { ?>
            <div class="<?php echo isset($rangos_click) ? $rangos_click : "" ?>">
                <a class="text-decoration-none" href="new-gestion_rango.php">
                    <div class="text-center text-white py-2">Administrar por Rangos</div>
                </a>
            </div>
        <?php } ?>
        
        <?php if ($permisoPracticantesLeer == "Sí") { ?>
            <div class="<?php echo isset($practicantes_click) ? $practicantes_click : "" ?>">
                <a class="text-decoration-none" href="practicantes.php">
                    <div class="text-center text-white py-2">Practicantes</div>
                </a>
            </div>
        <?php } ?>
        <?php if ($permisoPracticantesLeer == "Sí") { ?>
            <div class="<?php echo isset($list_finish_click) ? $list_finish_click : "" ?>">
                <a class="text-decoration-none" href="list_employee_finish.php">
                    <div class="text-center text-white py-2">Proximos a terminar</div>
                </a>
            </div>
        <?php } ?>
        <?php if ($permisoResumenLeer == "Sí") { ?>
            <div class="<?php echo isset($resumen_click) ? $resumen_click : "" ?>">
                <a class="text-decoration-none" href="resumen.php">
                    <div class="text-center text-white py-2">Resumen</div>
                </a>
            </div>
        <?php } ?>
        <?php if ($permisoCriteriosLeer == "Sí") { ?>
            <div class="<?php echo isset($horarios_click) ? $horarios_click : "" ?>">
                <a class="text-decoration-none" href="horarios.php">
                    <div class="text-center text-white py-2">Horarios</div>
                </a>
            </div>
        <?php } ?>
        <?php if ($permisoPublicacionesLeer == "Sí") { ?>
            <div class="<?php echo isset($publicacion_click) ? $publicacion_click : "" ?>">
                <a class="text-decoration-none" href="publicaciones.php">
                    <div class="text-center text-white py-2">Publicaciones</div>
                </a>
            </div>
        <?php } ?>
        <?php if ($user['id_rango'] == 4 || $user['id_rango'] == 1) { ?>
            <div class="<?php echo isset($programar_click) ? $programar_click : "" ?>">
                <a class="text-decoration-none" href="programacion-eventos.php">
                    <div class="text-center text-white py-2">Programación de Eventos</div>
                </a>
            </div>
            <div class="<?php echo isset($entrevistas_click) ? $entrevistas_click : "" ?>">
                <a class="text-decoration-none" href="entrevistas.php">
                    <div class="text-center text-white py-2">Entrevistas</div>
                </a>
            </div>
            <div class="<?php echo isset($buzon_click) ? $buzon_click : "" ?>">
                <a class="text-decoration-none" href="buzon-sugerencias.php">
                    <div class="text-center text-white py-2">Buzón de Sugerencias</div>
                </a>
            </div>
            <div class="<?php echo isset($archivos_click) ? $archivos_click : "" ?>">
                <a class="text-decoration-none" href="archivos.php">
                    <div class="text-center text-white py-2">Archivos</div>
                </a>
            </div>
        <?php } ?>
        <?php if ($permisoCriteriosLeer == "Sí") { ?>
            <div class="<?php echo isset($criterios_click) ? $criterios_click : "" ?>">
                <a class="text-decoration-none" href="criterios.php">
                    <div class="text-center text-white py-2">Criterios</div>
                </a>
            </div>
        <?php } ?>
        <?php if ($permisoCriteriosLeer == "Sí") { ?>
            <div class="<?php echo isset($subcriterios_click) ? $subcriterios_click : "" ?>">
                <a class="text-decoration-none" href="subcriterios.php">
                    <div class="text-center text-white py-2">Subcriterios</div>
                </a>
            </div>
        <?php } ?>
        <?php if ($permisoPapeleraLeer == "Sí") { ?>
            <div class="mx-4 <?php echo isset($papelera_click) ? $papelera_click : "" ?>">
                <a class="d-flex justify-content-center align-items-center text-decoration-none" href="papelera.php">
                    <div class="text-center text-white py-2">Historial de Practicantes</div>
                    <span class="text-white fw-bold rounded bg-danger" style="padding: 2px 7px;">
                        <?php echo $totalDatos; ?>
                    </span>
                </a>
            </div>
        <?php } ?>
        <div class="<?php echo isset($test_click) ? $test_click : "" ?>">
            <a class="text-decoration-none" href="test-panel.php">
                <div class="text-center text-white py-2">Test</div>
            </a>
        </div>
        <div class="<?php echo isset($organigrama_click) ? $organigrama_click : "" ?>">
            <a class="text-decoration-none" href="organigrama.php">
                <div class="text-center text-white py-2">organigrama</div>
            </a>
        </div>
        <?php if ($permisoExportarLeer == "Sí") { ?>
            <div class="<?php echo isset($exportar_area_click) ? $exportar_area_click : "" ?>">
                <a class="text-decoration-none" href="exportar-area.php">
                    <div class="text-center text-white py-2">Exportar Asistencias</div>
                </a>
            </div>
            <div class="<?php echo isset($exportar_practicante_click) ? $exportar_practicante_click : "" ?>">
                <a class="text-decoration-none" href="exportar-practicante.php">
                    <div class="text-center text-white py-2">Exportar por Practicante</div>
                </a>
            </div>
        <?php } ?>
        <?php if ($permisoUsuariosLeer == "Sí") { ?>
            <div class="<?php echo isset($usuarios_click) ? $usuarios_click : "" ?>">
                <a class="text-decoration-none" href="usuarios.php">
                    <div class="text-center text-white py-2">Usuarios</div>
                </a>
            </div>
        <?php } ?>
        <div>
            <a class="text-decoration-none" href="home.php">
                <div class="text-center text-white py-2">Panel Antiguo</div>
            </a>
        </div>
        <button class="btn text-center text-danger fw-bold py-2" onclick="salirMiPerfil()">
            Salir
        </button>
    </div>
</aside>

<!-- NAVBAR -->
<nav class="nav-comunicacion">
    <div class="d-flex">
        <button id="btn_menu" class="btn text-white d-none me-2 px-2">
            <i class="fa-solid fa-bars-staggered fa-2xl"></i>
        </button>
        <div class="text-white fs-3 mb-0 fw-bolder">Bienvenido</div>
    </div>
    <div>
        <h7 class="text-white">
            <?php echo $diaActual . " de " . $mesActual . ", " . $anioActual; ?>
        </h7>
        <div class="text-white" id="clock"></div>
    </div>
</nav>