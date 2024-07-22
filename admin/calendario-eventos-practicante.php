<?php include 'includes/header-practicante.php'; ?>

<body class="bg-white">
   <?php $calendario_click = "clicked" ?>
   <?php include 'includes/fecha_actual.php' ?>
   <?php include 'includes/navbar-sidebar-practicante.php' ?>

   <div class="container-fluid" id="calendario-agenda">
      <div class="buttons">
         <input type="hidden" id="idPracticanteActividad" value="<?php echo $row['id'] ?>">
         <input type="hidden" id="negocioPracticanteActividad" value="<?php echo $row['negocio']; ?>">

         <form method="post" action="calendario-practicante.php" class="form__calendar calendar-button-color">
            <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
            <input type="submit" value="MIS TAREAS" class="btn__calendar letraNavBar text-light">
         </form>
         <form method="post" action="calendario-eventos-practicante.php" class="form__calendar">
            <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
            <input type="submit" value="EVENTOS" class="btn__calendar--active letraNavBar text-light">
         </form>
         <form method="post" action="calendario-general-practicante.php" class="form__calendar calendar-button-color">
            <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
            <input type="submit" value="GENERAL" class="btn__calendar letraNavBar text-light">
         </form>

      </div>
      <div class="card" id="calendar">
         <div class="calendar_info">
            <div class="calendar_prev" id="prev-month"><img src="../img/flecha-izquierda.webp"
                  style="width: 10px; height:10px;"></div>
            <div class="letraNavBar colorletraperfil calendar_month" id="month"></div>
            <div class="calendar_next" id="next-month"><img src="../img/flecha-derecha.webp"
                  style="width: 10px; height:10px;"></div>
            <div class="letraNavBar colorletraperfil calendar_year" id="year"></div>
         </div>
         <div>
            <div id="daysN" class="days__n"></div>
            <div class="letraNavBar calendar_date" id="dates"></div>
         </div>
      </div>
      <br>
      <div class="modal" tabindex="-1" role="dialog" id="eventoModalEdit">
         <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content modal__calendar">
               <div class="modal-header" style="background-color: #54af0c; place-content: center;">
                  <h5 class="modal-title letraNavBar" style="color: white;"><b>Evento</b></h5>
                  <button type="button" class="close close-button-2" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>

               <div class="modal-body">
                  <form action="includes/Editar-eliminar-actividades.php" method="post">
                     <input readonly type="hidden" class="form-control" id="idModal" name="idModal">
                     <input readonly type="hidden" class="form-control" id="idModal" name="idModal">
                     <div class="fechasModal">
                        <label class="lavel-form letraNavBar">Titulo</label>
                        <input readonly type="text" class="form-control calendario-imput TituloModal letraNavBar"
                           id="TituloModal" name="TituloModal" placeholder="Ingrese el título del evento">
                     </div>
                     <div class="contendModal-tf">
                        <div class="contendModal-tf1">
                           <img src="" id="imagenModal2" class="Imagen-evento-md">
                        </div>
                        <div class="contendModal-tf2">
                           <div class="form__color-calendar2">
                              <input disabled type="color" class="form__color-calendar-container  coloModal-edit"
                                 id="colorModal" name="colorModal">
                           </div>
                           <label class="lavel-form letraNavBar">Color</label>
                        </div>
                     </div>
                     <div class="fechasModal">
                        <label class="lavel-form letraNavBar">Fecha</label>
                        <input readonly type="date" class="form-control calendario-imput fechaModal letraNavBar"
                           id="desdeModal" name="desdeModal">
                        <span class="separadorFecha"></span>
                        <label class="lavel-form letraNavBar">Hora</label>
                        <input readonly type="text" class="form-control calendario-imput fechaModal letraNavBar"
                           id="hastaModal" name="hastaModal">
                     </div>
                     <div class="form-group letraNavBar">
                        <textarea readonly class="form-control calendario-imput detallesModal" name="detallesModal"
                           id="detallesModal" rows="6"></textarea>
                     </div>
                     <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                  </form>
               </div>
            </div>
         </div>
      </div>
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
      <script src="../js/calendarioEventos.js"></script>
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>