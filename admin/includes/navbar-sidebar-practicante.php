<!-- NAVBAR INICIO -->
<nav class="navbar navbar-expand-lg bg-nav nav-modelo">
    <div class="container-fluid">
        <div class="input-group mb-3 diseño-escribir-aqui">
            <input type="text" class="form-control" placeholder="Escribe aqui...">
            <span class="ps-5"></span>
        </div>
        <div class="d-flex posicion">
            <h6 class="pe-3 letraNavBar posicion-fecha">
                <?php echo $diaActual . " de " . $mesActual; ?>
            </h6>
            <div class="modal fade notificaciones-2" id="miModal" tabindex="-1" role="dialog"
                aria-labelledby="miModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-right" role="document">
                    <div class="modal-content notificaciones">
                        <h3 class="modal-title title-md" id="miModalLabel">Notificaciones</h3>
                        <div class="modal-body modal-c-nt">
                            <?php include 'notificaciones-notas-eventos.php'; ?>
                            <?php include 'notificaciones-sugerencias.php'; ?>
                            <?php include 'notificaciones archivos.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
            <img data-toggle="modal" data-target="#miModal" src="../img/notificacion.webp" alt="notificacion"
                height="40" width="40">
            <?php echo '<span class="notiCount">' . $notiCount . '</span>' ?>
        </div>
        <div class="circle-container d-flex me-5 posicion-perfil">
            <?php include 'includes/fotoperfil.php'; ?>
            <h6 class="ps-3 letraNavBar posicion-fecha">
                <?php echo $row['firstname']; ?>
            </h6>
        </div>
    </div>
</nav>
<!-- NAVBAR FIN -->

<!-- BARRA LATERAL INICIO -->
<aside class="main-sidebar color-menubar-practicante aside-modelo">
    <div class="siderbar-practicantes">
        <?php include 'includes/cambio_logo.php' ?>
    </div>
    <div class="nav-items">
        <div class="mb-2 enlaces <?php echo isset($home_click) ? $home_click : "" ?>" href="home-practicante.php"
            id="button1">
            <form method="post" action="home-practicante.php" class="form__ver-perfil">
                <input id="idPracticante" type="hidden" name="employee_id" value="<?php if (isset($row['employee_id'])) {
                    echo $row['employee_id'];
                } else {
                    echo "";
                } ?>">
                <button type="submit" class="enlaces__btn text-light" id="button1">
                    <i class="fa-solid fa-house fa-xl mt-3"></i>
                    <h6 class="text-center letraNavBar">INICIO</h6>
                </button>
            </form>
        </div>
        <div class="mb-2 enlaces <?php echo isset($perfil_click) ? $perfil_click : "" ?>" href="perfil-practicante.php"
            id="button1">
            <form method="post" action="perfil-practicante.php" class="form__ver-perfil">
                <input type="hidden" name="employee_id" value="<?php if (isset($row['employee_id'])) {
                    echo $row['employee_id'];
                } else {
                    echo "";
                } ?>">
                <button type="submit" class="enlaces__btn text-light" id="button1">
                    <i class="fa-solid fa-user fa-xl mt-3"></i>
                    <h6 class="text-center letraNavBar">MI PERFIL</h6>
                </button>
            </form>
        </div>
        <div class="mb-2 enlaces <?php echo isset($estadisticas_click) ? $estadisticas_click : "" ?>"
            href="estadisticas-y-logros-practicante.php" id="button1">
            <form method="post" action="estadisticas-y-logros-practicante.php" class="form__ver-perfil">
                <input type="hidden" name="employee_id" value="<?php if (isset($row['employee_id'])) {
                    echo $row['employee_id'];
                } else {
                    echo "";
                } ?>">
                <button type="submit" class="enlaces__btn text-light" id="button1">
                    <i class="fa-solid fa-chart-simple fa-xl mt-3"></i>
                    <h6 class="text-center letraNavBar" style="width: 120px; margin-left: 15px;">ESTADISTICAS
                        Y
                        LOGROS</h6>
                </button>
            </form>
        </div>
        <div class="mb-2 enlaces <?php echo isset($calendario_click) ? $calendario_click : "" ?>"
            href="calendario-practicante.php" id="button1">
            <form method="post" action="calendario-practicante.php" class="form__ver-perfil">
                <input type="hidden" name="employee_id" value="<?php if (isset($row['employee_id'])) {
                    echo $row['employee_id'];
                } else {
                    echo "";
                } ?>">
                <button type="submit" class="enlaces__btn text-light" id="button1">
                    <i class="fa-solid fa-calendar-check fa-xl mt-3"></i>
                    <h6 class="text-center letraNavBar" style="width: 110px; margin-left: 20px;">CALENDARIO O
                        AGENDA</h6>
                </button>
            </form>
        </div>
        <div class="mb-2 enlaces <?php echo isset($buzon_click) ? $buzon_click : "" ?>" id="button1">
            <form method="post" action="buzon.php" class="form__ver-perfil">
                <input type="hidden" name="employee_id" value="<?php if (isset($row['employee_id'])) {
                    echo $row['employee_id'];
                } else {
                    echo "";
                } ?>">
                <button type="submit" class="enlaces__btn text-light" id="button1">
                    <i class="fa-solid fa-comments fa-xl mt-3"></i>
                    <h6 class="text-center letraNavBar" style="width: 110px; margin-left: 20px;">BUZON DE
                        SUGERENCIAS</h6>
                </button>
            </form>
        </div>
        <div class="mb-2 enlaces <?php echo isset($archivos_click) ? $archivos_click : "" ?>" id="button1">
            <form method="post" action="archivos-practicante.php" class="form__ver-perfil">
                <input type="hidden" name="employee_id" value="<?php if (isset($row['employee_id'])) {
                    echo $row['employee_id'];
                } else {
                    echo "";
                } ?>">
                <button type="submit" class="enlaces__btn text-light" id="button1">
                    <i class="fa-regular fa-folder-open fa-xl mt-3"></i>
                    <h6 class="text-center letraNavBar" style="width: 110px; margin-left: 20px;">ARCHIVOS
                    </h6>
                </button>
            </form>
        </div>
        <div class="enlaces <?php echo isset($organigrama_click) ? $organigrama_click : "" ?>" id="button1">
            <form method="post" action="organigrama-practicante.php" class="form__ver-perfil">
                <input type="hidden" name="employee_id" value="<?php if (isset($row['employee_id'])) {
                    echo $row['employee_id'];
                } else {
                    echo "";
                } ?>">
                <button type="submit" class="enlaces__btn text-light" id="button1">
                    <i class="fa-solid fa-users fa-xl mt-3"></i>
                    <h6 class="text-center letraNavBar" style="width: 110px; margin-left: 20px;">ORGANIGRAMA
                    </h6>
                </button>
            </form>
        </div>
    </div>
    <div class="mb-2 salir">
        <a class="enlaces text-center text-danger" onclick="salirMiPerfil()">
            <div class="text-center">
                <i class="fa-solid fa-right-from-bracket fa-xl"></i>
                <h6 class="letraNavBar">SALIR</h6>
            </div>
        </a>
    </div>
</aside>
<!-- BARRA LATERAL FIN -->