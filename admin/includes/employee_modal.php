<!-- Add -->
<?php include 'includes/scripts.php'; ?>
<div class="modal" id="addnew">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center"><b>Agregar Practicante</b></h4>
      </div>
      <form class="form-horizontal" method="POST" action="employee_add.php" enctype="multipart/form-data">
        <div class="modal-body modal-tamanio">
          <div class="form-group">
            <label for="photo" class="col-sm-5 control-label">Foto del practicante</label>
            <div class="col-sm-7">
              <input type="file" name="photo" id="photo">
            </div>
          </div>
          <div class="form-group">
            <label for="date_in" class="col-sm-1 control-label">Fecha Ingreso</label>
            <div class="col-sm-3">
              <input type="date" class="form-control" id="date_in" name="date_in" required>
            </div>
            <label for="date_out" class="col-sm-1 control-label">Fecha Salida</label>
            <div class="col-sm-3">
              <input type="date" class="form-control" id="date_out" name="date_out" required>
            </div>
            <label for="time_practice" class="col-sm-1 control-label">Tiempo </label>
            <div class="col-sm-3">
              <select class="form-control" name="time_practice" id="time_practice" required>
                <option value="" selected>- Seleccionar -</option>
                <option value="3">3 meses</option>
                <option value="5">5 meses</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="type_practice" class="col-sm-1 control-label">Tipo </label>

            <div class="col-sm-3">
              <select class="form-control" name="type_practice" id="type_practice" required>
                <option value="" selected>- Seleccionar -</option>
                <option value="PREPROFESIONALES">PREPROFESIONALES</option>
                <option value="PROFESIONALES">PROFESIONALES</option>
              </select>
            </div>
            <label for="dni" class="col-sm-1 control-label">DNI</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="dni" name="dni" required>
            </div>
            <label for="contact" class="col-sm-1 control-label">Celular</label>

            <div class="col-sm-3">
              <input type="text" class="form-control" id="contact" name="contact">
            </div>
          </div>
          <div class="form-group">
            <label for="firstname" class="col-sm-1 control-label">Nombre</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
            <label for="lastname" class="col-sm-1 control-label">Apellido</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
            <label for="gender" class="col-sm-1 control-label">Género</label>
            <div class="col-sm-3">
              <select class="form-control" name="gender" id="gender" required>
                <option value="" selected>- Seleccionar -</option>
                <option value="Male">Hombre</option>
                <option value="Female">Mujer</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="birthday" class="col-sm-2 control-label">Cumpleaños</label>
            <div class="col-sm-3">
              <input type="date" class="form-control" id="birthday" name="birthday" required>
            </div>
            <label for="address" class="col-sm-2 control-label">Dirección</label>
            <div class="col-sm-5">
              <textarea class="form-control" name="address" id="address"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label for="personal_email" class="col-sm-2 control-label">Correo Personal</label>
            <div class="col-sm-4">
              <input type="email" class="form-control" id="personal_email" name="personal_email" required>
            </div>
            <label for="institutional_email" class="col-sm-2 control-label">Correo Institucional</label>
            <div class="col-sm-4">
              <input type="email" class="form-control" id="institutional_email" name="institutional_email" required>
            </div>
          </div>
          <div class="form-group">
            <label for="university" class="col-sm-2 control-label">Universidad</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="university" name="university" required>
            </div>
            <label for="career" class="col-sm-2 control-label">Carrera</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="career" name="career" required>
            </div>
          </div>
          <div class="form-group">
            <label for="negocio" class="col-sm-2 control-label">Unidad de Negocio</label>
            <div class="col-sm-4">
              <select class="form-control" name="negocio" id="negocio" required>
                <option value="" selected>- Seleccionar -</option>
                <?php
                $sql = "SELECT * FROM negocio";
                $query = $conn->query($sql);
                while ($prow = $query->fetch_assoc()) {
                  echo "
                        <option value='" . $prow['id'] . "'>" . $prow['nombre_negocio'] . "</option>";
                }
                ?>
              </select>
            </div>
            <label for="position" class="col-sm-2 control-label">Cargo</label>
            <div class="col-sm-4">
              <select class="form-control" name="position" id="position" required>
                <option value="" selected>- Seleccionar -</option>
                <?php
                $sql = "SELECT * FROM position";
                $query = $conn->query($sql);
                while ($prow = $query->fetch_assoc()) {
                  echo "
                        <option value='" . $prow['id'] . "'>" . $prow['description'] . "</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="schedule" class="col-sm-3 control-label">Horario semanal</label>
            <div class="col-sm-9">
              <div class="row" style="margin-bottom: 10px;">
                <div class="col-sm-3">&nbsp;</div>
                <div class="col-sm-4">Entrada</div>
                <div class="col-sm-4">Salida</div>
              </div>
              <div class="row" style="margin-bottom: 10px;">
                <div class="col-sm-4">
                  <select class="form-control" id="time_in_select" onchange="updateScheduleOut(this)">
                    <option value="" selected>- Seleccionar -</option>
                    <?php
                    $sql = "SELECT * FROM schedules";
                    $query = $conn->query($sql);
                    while ($srow = $query->fetch_assoc()): ?>
                      <option value="<?= $srow['id'] ?>">
                        <?= $srow['time_in'] ?>
                      </option>
                    <?php endwhile; ?>
                    <option value="Personalizado">Personalizado</option>
                  </select>
                </div>
                <div class="col-sm-4">
                  <select class="form-control" id="time_out_select" onchange="updateScheduleIn(this)">
                    <option value="" selected>- Seleccionar -</option>
                    <?php
                    $query->data_seek(0);
                    while ($srow = $query->fetch_assoc()): ?>
                      <option value="<?= $srow['id'] ?>">
                        <?= $srow['time_out'] ?>
                      </option>
                    <?php endwhile; ?>
                    <option value="Personalizado">Personalizado</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
              class="fa fa-close"></i> Cerrar</button>
          <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  var rowsPerDay = {};

  function addNewRow(button, day) {
    var container = button.parentNode.parentNode;
    var dayLower = day.toLowerCase();

    if (!rowsPerDay[dayLower]) {
      rowsPerDay[dayLower] = 0;
    }

    if (rowsPerDay[dayLower] >= 2) {
      button.style.display = 'none';
      return;
    }

    var newRow = document.createElement('div');
    newRow.className = 'row new-row';
    newRow.style.marginBottom = '10px';

    var column = document.createElement('div');
    column.className = 'col-sm-3';
    column.textContent = day.charAt(0).toUpperCase() + day.slice(1);
    newRow.appendChild(column);

    var inputColumnIn = document.createElement('div');
    inputColumnIn.className = 'col-sm-4';

    var inputIn = document.createElement('div');
    inputIn.className = 'bootstrap-timepicker';
    var inputElementIn = document.createElement('input');
    inputElementIn.type = 'text';
    inputElementIn.className = 'form-control timepicker';
    inputElementIn.name = 'schedule[' + dayLower + '_in]';
    inputElementIn.id = 'schedule_' + dayLower + '_in';

    inputIn.appendChild(inputElementIn);
    inputColumnIn.appendChild(inputIn);

    newRow.appendChild(inputColumnIn);

    var inputColumnOut = document.createElement('div');
    inputColumnOut.className = 'col-sm-4';

    var inputOut = document.createElement('div');
    inputOut.className = 'bootstrap-timepicker';
    var inputElementOut = document.createElement('input');
    inputElementOut.type = 'text';
    inputElementOut.className = 'form-control timepicker';
    inputElementOut.name = 'schedule[' + dayLower + '_out]';
    inputElementOut.id = 'schedule_' + dayLower + '_out';

    inputOut.appendChild(inputElementOut);
    inputColumnOut.appendChild(inputOut);

    newRow.appendChild(inputColumnOut);

    var originalRow = button.parentNode.parentNode;
    var newTableContainer = originalRow.querySelector('.new-row-container');
    if (!newTableContainer) {
      newTableContainer = document.createElement('div');
      newTableContainer.className = 'new-row-container';
      originalRow.parentNode.insertBefore(newTableContainer, originalRow.nextSibling);
    }
    newTableContainer.appendChild(newRow);

    $(inputElementIn).timepicker();
    $(inputElementOut).timepicker();

    rowsPerDay[dayLower]++;

    if (rowsPerDay[dayLower] >= 2) {
      button.style.display = 'none';
    }
  }
</script>

<script>
  const timeInSelect = document.getElementById('time_in_select');
  const timeOutSelect = document.getElementById('time_out_select');

  timeInSelect.addEventListener('change', handleSelectChange);
  timeOutSelect.addEventListener('change', handleSelectChange);

  function handleSelectChange() {
    const timeInSelectedValue = timeInSelect.value;
    const timeOutSelectedValue = timeOutSelect.value;

    if (timeInSelectedValue === 'Personalizado' || timeOutSelectedValue === 'Personalizado') {
      $('#secondmodal').modal('show');

    }
  }

  function updateScheduleOut(selectElement) {
    var selectedValue = selectElement.value;
    var timeOutSelect = document.getElementById('time_out_select');
    var timeOutOptions = timeOutSelect.options;

    for (var i = 0; i < timeOutOptions.length; i++) {
      var option = timeOutOptions[i];
      if (option.value === selectedValue) {
        option.selected = true;
        break;
      }
    }
  }

  function updateScheduleIn(selectElement) {
    var selectedValue = selectElement.value;
    var timeInSelect = document.getElementById('time_in_select');
    var timeInOptions = timeInSelect.options;

    for (var i = 0; i < timeInOptions.length; i++) {
      var option = timeInOptions[i];
      if (option.value === selectedValue) {
        option.selected = true;
        break;
      }
    }
  }
</script>

<!--Edit horario-->
<div class="modal fade" id="secondmodal" tabindex="-1" role="dialog" aria-labelledby="secondmodalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-center"><b>Personalizar horario</b></h4>
      </div>
      <div class="modal-body modal-tamanio">
        <form class="form-horizontal" method="POST" action="employee_add_custom.php" enctype="multipart/form-data"
          id="second-modal-form">
          <div class="form-group">
            <label for="customschedule" class="col-sm-3 control-label">Horario semanal</label>
            <div class="col-sm-9">
              <div class="row" style="margin-bottom: 10px;">
                <div class="col-sm-3">&nbsp;</div>
                <div class="col-sm-4"><b style="margin-bottom: 10px;">Entrada</b></div>
                <div class="col-sm-4"><b style="margin-bottom: 10px;">Salida</b></div>
              </div>
              <div class="table-container" id="schedule-table-container">
                <?php
                $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

                foreach ($days as $index => $day) {
                  $day_lower = strtolower($day); ?>

                  <div class="row original-row" style="margin-bottom: 10px;">
                    <div class="col-sm-3" style="margin-top: 10px;">
                      <?php echo $day; ?>
                    </div>
                    <div class="col-sm-4">
                      <div class="bootstrap-timepicker" style="margin-bottom: 10px;">
                        <input type="text" class="form-control timepicker" name="schedule[<?php echo $day_lower; ?>_in]"
                          id="schedule_<?php echo $day_lower; ?>_in">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="bootstrap-timepicker" style="margin-bottom: 10px;">
                        <input type="text" class="form-control timepicker" name="schedule[<?php echo $day_lower; ?>_out]"
                          id="schedule_<?php echo $day_lower; ?>_out">
                      </div>
                    </div>
                    <div class="col-sm-1" style="margin-top: 10px;">
                      <button type="button" class="btn btn-primary btn-sm"
                        onclick="addNewRow(this, '<?php echo $day_lower; ?>')"><i class="fa fa-plus"></i></button>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                class="fa fa-close"></i> Cerrar</button>
            <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  var rowsPerDay = {};

  function addNewRow(button, day) {
    var container = button.parentNode.parentNode;
    var dayLower = day.toLowerCase();

    if (!rowsPerDay[dayLower]) {
      rowsPerDay[dayLower] = 0;
    }

    if (rowsPerDay[dayLower] >= 2) {
      button.style.display = 'none';
      return;
    }

    var newRow = document.createElement('div');
    newRow.className = 'row new-row';
    newRow.style.marginBottom = '10px';

    var column = document.createElement('div');
    column.className = 'col-sm-3';
    column.textContent = day.charAt(0).toUpperCase() + day.slice(1);
    newRow.appendChild(column);

    var inputColumnIn = document.createElement('div');
    inputColumnIn.className = 'col-sm-4';

    var inputIn = document.createElement('div');
    inputIn.className = 'bootstrap-timepicker';
    var inputElementIn = document.createElement('input');
    inputElementIn.type = 'text';
    inputElementIn.className = 'form-control timepicker';
    inputElementIn.name = 'schedule[' + dayLower + '_in]';
    inputElementIn.id = 'schedule_' + dayLower + '_in';

    inputIn.appendChild(inputElementIn);
    inputColumnIn.appendChild(inputIn);

    newRow.appendChild(inputColumnIn);

    var inputColumnOut = document.createElement('div');
    inputColumnOut.className = 'col-sm-4';

    var inputOut = document.createElement('div');
    inputOut.className = 'bootstrap-timepicker';
    var inputElementOut = document.createElement('input');
    inputElementOut.type = 'text';
    inputElementOut.className = 'form-control timepicker';
    inputElementOut.name = 'schedule[' + dayLower + '_out]';
    inputElementOut.id = 'schedule_' + dayLower + '_out';

    inputOut.appendChild(inputElementOut);
    inputColumnOut.appendChild(inputOut);

    newRow.appendChild(inputColumnOut);

    var originalRow = button.parentNode.parentNode;
    var newTableContainer = originalRow.querySelector('.new-row-container');
    if (!newTableContainer) {
      newTableContainer = document.createElement('div');
      newTableContainer.className = 'new-row-container';
      originalRow.parentNode.insertBefore(newTableContainer, originalRow.nextSibling);
    }
    newTableContainer.appendChild(newRow);

    $(inputElementIn).timepicker();
    $(inputElementOut).timepicker();

    rowsPerDay[dayLower]++;

    if (rowsPerDay[dayLower] >= 2) {
      button.style.display = 'none';
    }
  }
</script>

<!-- Edit -->
<div class="modal fade" id="edit">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center"><b><span class="employee_id"></span></b></h4>
      </div>
      <div class="modal-body modal-tamanio">
        <form class="form-horizontal" method="POST" action="employee_edit.php">
          <input type="hidden" class="empid" name="id">
          <div class="form-group">
            <label for="edit_photo" class="col-sm-5 control-label">Foto del practicante</label>
            <div class="col-sm-7">
              <input type="file" name="photo" id="edit_photo">
            </div>
          </div>
          <div class="form-group">
            <label for="edit_date_in" class="col-sm-1 control-label">Fecha Ingreso</label>
            <div class="col-sm-3">
              <input type="date" class="form-control" id="edit_date_in" name="date_in" required>
            </div>
            <label for="edit_date_out" class="col-sm-1 control-label">Fecha Salida</label>
            <div class="col-sm-3">
              <input type="date" class="form-control" id="edit_date_out" name="date_out" required>
            </div>
            <label for="edit_time_practice" class="col-sm-1 control-label">Tiempo</label>
            <div class="col-sm-3">
              <select class="form-control" name="time_practice" id="edit_time_practice" required>
                <option id="timepractice_val" selected></option>
                <option value="3">3 meses</option>
                <option value="5">5 meses</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="edit_type_practice" class="col-sm-1 control-label">Tipo</label>
            <div class="col-sm-3">
              <select class="form-control" name="type_practice" id="edit_type_practice" required>
                <option id="typepractice_val" selected></option>
                <option value="Pre Profesionales">Pre Profesionales</option>
                <option value="Profesionales">Profesionales</option>
              </select>
            </div>
            <label for="edit_dni" class="col-sm-1 control-label">DNI</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="edit_dni" name="dni" required>
            </div>
            <label for="edit_contact" class="col-sm-1 control-label">Celular</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="edit_contact" name="contact">
            </div>
          </div>
          <div class="form-group">
            <label for="edit_firstname" class="col-sm-1 control-label">Nombre</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="edit_firstname" name="firstname">
            </div>
            <label for="edit_lastname" class="col-sm-1 control-label">Apellido</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="edit_lastname" name="lastname">
            </div>
            <label for="edit_gender" class="col-sm-1 control-label">Género</label>
            <div class="col-sm-3">
              <select class="form-control" name="gender" id="edit_gender">
                <option selected id="gender_val"></option>
                <option value="Hombre">Hombre</option>
                <option value="Mujer">Mujer</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="edit_birthday" class="col-sm-2 control-label">Cumpleaños</label>
            <div class="col-sm-3">
              <input type="date" class="form-control" id="edit_birthday" name="birthday" required>
            </div>
            <label for="edit_address" class="col-sm-2 control-label">Dirección</label>
            <div class="col-sm-5">
              <textarea class="form-control" name="address" id="edit_address"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label for="edit_personal_email" class="col-sm-2 control-label">Correo Personal</label>
            <div class="col-sm-4">
              <input type="email" class="form-control" id="edit_personal_email" name="personal_email" required>
            </div>

            <label for="edit_institutional_email" class="col-sm-2 control-label">Correo Institucional</label>
            <div class="col-sm-4">
              <input type="email" class="form-control" id="edit_institutional_email" name="institutional_email"
                required>
            </div>
          </div>
          <div class="form-group">
            <label for="edit_university" class="col-sm-2 control-label">Universidad</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="edit_university" name="university" required>
            </div>
            <label for="edit_career" class="col-sm-2 control-label">Carrera</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="edit_career" name="career" required>
            </div>
          </div>
          <div class="form-group">
            <label for="edit_negocio" class="col-sm-2 control-label">Unidad de Negocio</label>
            <div class="col-sm-4">
              <select class="form-control" name="negocio" id="edit_negocio" required>
                <option selected id="negocio_val"></option>
                <?php
                $sql = "SELECT * FROM negocio";
                $query = $conn->query($sql);
                while ($prow = $query->fetch_assoc()) {
                  echo "
                        <option value='" . $prow['id'] . "'>" . $prow['nombre_negocio'] . "</option>";
                }
                ?>
              </select>
            </div>
            <label for="edit_position" class="col-sm-2 control-label">Cargo</label>
            <div class="col-sm-4">
              <select class="form-control" name="position" id="edit_position">
                <option selected id="position_val"></option>
                <?php
                $sql = "SELECT * FROM position";
                $query = $conn->query($sql);
                while ($prow = $query->fetch_assoc()) {
                  echo "
                        <option value='" . $prow['id'] . "'>" . $prow['description'] . "</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="edit_schedule" class="col-sm-2 control-label">Horario</label>
            <div class="col-sm-10">
              <select class="form-control" id="edit_schedule" name="schedule">
                <option selected id="schedule_val"></option>
                <?php
                $sql = "SELECT * FROM schedules";
                $query = $conn->query($sql);
                while ($srow = $query->fetch_assoc()) {
                  echo "
                        <option value='" . $srow['id'] . "'>" . $srow['time_in'] . ' - ' . $srow['time_out'] . "</option>";
                }
                ?>
              </select>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
            class="fa fa-close"></i> Cerrar</button>
        <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i>
          Actualizar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b><span class="employee_id"></span></b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="employee_delete.php">
          <input type="hidden" class="empid" name="id">
          <div class="text-center">
            <p>ELIMINAR PRACTICANTE</p>
            <h2 class="bold del_employee_name"></h2>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
            class="fa fa-close"></i> Cerrar</button>
        <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i>
          Eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Update Photo -->
<div class="modal fade" id="edit_photo">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b><span class="del_employee_name"></span></b></h4>
      </div>
      <form class="form-horizontal" method="POST" action="employee_edit_photo.php" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="hidden" class="empid" name="id">
          <div class="form-group">
            <label for="photo" class="col-sm-3 control-label">Foto</label>

            <div class="col-sm-9">
              <input type="file" id="photo" name="photo" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
              class="fa fa-close"></i> Cerrar</button>
          <button type="submit" class="btn btn-success btn-flat" name="upload"><i class="fa fa-check-square-o"></i>
            Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ADD GRADES -->
<div class="modal fade" id="add_grades">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-center" style="margin-left: 10px;"><b>AGREGAR NOTAS</b></h4>
        <p class="text-center"><span class="del_employee_name"></span></p>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="employee_add_grades.php">
          <input type="hidden" class="empid" name="id">
          <div class="text-center">
            <div class="row" style="display: inline-block;">
              <div class="col-xs-5 text-center">
                <input type="date" class="form-control" id="fecha1" name="fecha1">
                <label for="fecha1">Fecha Inicio</label>
              </div>
              <div class="col-xs-5 text-center">
                <input type="date" class="form-control" id="fecha2" name="fecha2">
                <label for="fecha2">Fecha Final</label>
              </div>
              <div class="col-xs-2 text-center">
                <button type="submit" class="btn btn-success btn-flat" name="addGrades"><i
                    class="fa fa-check-square-o"></i> Guardar</button>
              </div>
            </div>
          </div>
          <div style="display: flex; justify-content: center;">
            <div class="form-group" style="padding-top: 20px; padding-bottom: 20px;">
              <label for="criterio12" class="col-sm-5 control-label">Nota Final: </label>
              <div class="col-sm-7">
                <input type="text" class="form-control text-center" name="total" id="total" readonly>
              </div>
            </div>
          </div>
          <?php
          $sqlCriterios = "SELECT * FROM criterios";
          $queryCriterios = $conn->query($sqlCriterios);
          $numCriterio = 1;

          while ($criterio = $queryCriterios->fetch_assoc()) {
            echo '<div class="criterio-container">
                      <h4 class="text-center"><b>' . $numCriterio . '. ' . $criterio['nombre_criterio'] . '</b></h4>
                      <div style="display: flex; justify-content: center;">
                        <div class="col-xs-8 text-center">';

            $sqlSubcriterios = "SELECT * FROM subcriterios WHERE id_criterio = " . $criterio['id'];
            $querySubcriterios = $conn->query($sqlSubcriterios);

            while ($subcriterio = $querySubcriterios->fetch_assoc()) {
              echo '<div class="form-group">
                        <label for="criterio' . $subcriterio['id'] . '" class="col-sm-7 control-label" style="text-align: left;">' . $subcriterio['nombre_subcriterio'] . ':</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control text-center subcriterio-input" name="criterio' . $subcriterio['id'] . '" id="criterio' . $subcriterio['id'] . '" required>
                        </div>
                      </div>';
            }

            echo '</div>
                    <div class="col-sm-3" style="margin-top: 80px;">
                      <input type="text" class="form-control text-center" value="Promedio" readonly>
                      <input type="text" class="form-control text-center subtotal-input" name="subtotal" id="subtotal" readonly style="background-color: white;">
                    </div>
                  </div>
                </div>';

            $numCriterio++;
          }
          ?>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
            class="fa fa-close"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT GRADES -->
<div class="modal fade" id="edit_grades" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #54af0c; border-radius: 0;">
        <h2 class="modal-title text-center letraNavBar" style="color: white; margin-inline-start: auto;">Editar Nota
        </h2>
      </div>
      <div class="modal-body">
        <form action="employee_grades_edit.php" method="post">
          <div class="form-group" style="text-align: -webkit-center;padding-bottom: 20px;">
            <input type="hidden" id="id" name="id" readonly>
            <label for="edit_nota" class="letraNavBar">Nota:</label>
            <div style="display: flex;">
              <input type="number" class="form-control letraNavBar" style="text-align-last: center; margin-right: 10px;"
                id="nota" name="nota" required>
              <button type="submit" class="btn btn-primary letraNavBar">Guardar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- DELETE GRADES -->
<div class="modal fade" id="delete_grades" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #54af0c; border-radius: 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-center letraNavBar" style="color: white; margin-inline-start: auto;"><b>ELIMINAR
            NOTAS</b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="employee_grades_delete.php">
          <input type="hidden" class="empid" name="id">
          <div style="display: flex; justify-content: center; align-items: end;">
            <div class="text-center" style="margin-right: 15px;">
              <label for="fecha_fin_semana" class="letraNavBar">Fecha Final</label>
              <select class="form-control letraNavBar text-center" id="fecha_fin_semana" name="fecha_fin_semana">
                <?php
                if (isset($_GET['id']) && !empty($_GET['id'])) {
                  $employee = $_GET['id'];
                  $sql = "SELECT DISTINCT fecha_fin_semana FROM grades WHERE employee_id = $employee";
                  $query = $conn->query($sql);
                  while ($prow = $query->fetch_assoc()) {
                    echo "
                                    <option value='" . $prow['fecha_fin_semana'] . "'>" . $prow['fecha_fin_semana'] . "</option>
                                 ";
                  }
                }
                ?>
              </select>
            </div>

            <div>
              <button type="submit" class="btn letraNavBar" style="background-color: #FF0000; color:white;"
                name="deletegrades"><i class="fa fa-trash"></i>Eliminar Nota</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    // Calcula el promedio al cambiar los valores de los subcriterios de cada criterio
    $(".subcriterio-input").on("input", function () {
      var criterio = $(this).closest(".criterio-container");
      var subcriterios = criterio.find(".subcriterio-input");
      var subtotal = 0;
      var count = 0;

      subcriterios.each(function () {
        var value = $(this).val();
        if (value !== "") {
          subtotal += parseFloat(value);
          count++;
        }
      });

      var promedio = subtotal / count;
      criterio.find(".subtotal-input").val(promedio.toFixed(2));
    });
  });
</script>

<script>
  $(document).ready(function () {
    // Calcula el promedio al cambiar los valores de los subcriterios de cada criterio
    $(".subcriterio-input").on("input", function () {
      var criterio = $(this).closest(".criterio-container");
      var subcriterios = criterio.find(".subcriterio-input");
      var subtotal = 0;
      var count = 0;

      subcriterios.each(function () {
        var value = $(this).val();
        if (value !== "") {
          subtotal += parseFloat(value);
          count++;
        }
      });

      var promedio = subtotal / count;
      criterio.find(".subtotal-input").val(promedio.toFixed(2));

      // Calcular el promedio de los subtotales
      var total = 0;
      var criterios = $(".criterio-container");
      var criteriosCount = 0;

      criterios.each(function () {
        var subtotalValue = parseFloat($(this).find(".subtotal-input").val());
        if (!isNaN(subtotalValue)) {
          total += subtotalValue;
          criteriosCount++;
        }
      });

      var totalPromedio = total / criteriosCount;
      $("#total").val(totalPromedio.toFixed(2));
    });
  });
</script>