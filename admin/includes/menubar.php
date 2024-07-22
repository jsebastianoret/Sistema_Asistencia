<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo (!empty($user['photo'])) ? '../images/' . $user['photo'] : '../images/profile.jpg'; ?>"
          class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>
          <?php echo $user['firstname'] . ' ' . $user['lastname']; ?>
        </p>
        <a><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">REPORTES</li>
      <li class=""><a href="home.php"><i class="fa fa-dashboard"></i> <span>Panel de Control</span></a></li>
      <li class="header">ADMINISTRACIÓN</li>

      <?php
      include 'includes/conn.php';
      include 'includes/gestion_permisos.php';
      $permisoAsistenciaLeer = $permisoAsistencia['leer'];
      $permisoPracticantesLeer = $permisoPracticantes['leer'];
      $permisoCargosLeer = $permisoCargos['leer'];
      $permisoUnidadLeer = $permisoUnidad['leer'];
      $permisoVistaLeer = $permisoVista['leer'];
      $permisoUsuariosLeer = $permisoUsuarios['leer'];
      $permisoCriteriosLeer = $permisoCriterios['leer'];
      $permisoHorariosLeer = $permisoResumen['leer'];
      $permisoExportarLeer = $permisoExportar['leer'];
      $permisoPublicacionesLeer = $permisoPublicaciones['leer'];
      $permisoPapeleraLeer = $permisoPapelera['leer'];

      if ($permisoAsistenciaLeer == "Sí") {
        echo '<li><a href="attendance.php"><i class="fa fa-calendar"></i> <span>Asistencia</span></a></li>';
      }

      if ($permisoPracticantesLeer == "Sí") {
        echo '<li class="treeview">
            <a href="#">
              <i class="fa fa-users"></i>
              <span>Practicantes</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="employee.php"><i class="fa fa-circle-o"></i> Lista de Practicantes</a></li>
              <li><a href="schedule.php"><i class="fa fa-circle-o"></i> Horarios</a></li>
            </ul>
          </li>';
      }

      if ($permisoCargosLeer == "Sí") {
        echo '<li><a href="#"><i class="fa fa-suitcase"></i><span>Cargos</span></a></li>';
      }

      if ($permisoUnidadLeer == "Sí") {
        echo '<li><a href="#"><i class="fa fa-suitcase"></i><span>Unidad de Negocio</span></a></li>';
      }

      if ($permisoVistaLeer == "Sí") {
        echo '<li><a href="#"><i class="fa fa-eye"></i><span>Vista de asistencia</span></a></li>';
      }

      if ($permisoHorariosLeer == "Sí") {
        echo '
            <li class="header">CONSULTAS</li>
            <li><a href="#"><i class="fa fa-clock-o"></i> <span>Horarios</span></a></li>
            ';
      }

      if ($permisoCriteriosLeer == "Sí") {
        echo '
            <li class="header">METRICAS DE EVALUACIÓN</li>
            <li><a href="#"><i class="fa fa-table"></i><span>Criterios</span></a></li>
            <li><a href="#"><i class="fa fa-list"></i><span>Subcriterios</span></a></li>
            ';
      }

      if ($permisoExportarLeer == "Sí") {
        echo '
            <li class="header">EXPORTAR</li>
            <li><a href="#"><i class="glyphicon glyphicon-cloud-download"></i> <span>Exportar Asistencias</span></a></li>
            <li><a href="#"><i class="glyphicon glyphicon-cloud-download"></i> <span>Exportar por Practicantes</span></a></li>
          ';
      }

      if ($permisoPublicacionesLeer == "Sí") {
        echo '
            <li class="header">FORO O MURAL</li>
            <li><a href="#"><i class="fa fa-solid fa-camera-retro"></i> <span>Publicaciones</span></a></li>
          ';
      }

      if ($permisoUsuariosLeer == "Sí") {
        echo '
            <li class="header">USUARIOS</li>
            <li><a href="usuario.php"><i class="fa fa-light fa-user"></i> <span>Lista de Usuarios</span></a></li>
            ';
      }

      if ($permisoPapeleraLeer == "Sí") {
        echo '
              <li><a href="#"><i class="fa fa-light fa-trash"></i> <span>Papelera</span></a></li>
            ';
      }
      ?>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>