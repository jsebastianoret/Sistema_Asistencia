<!-- Edit -->
<div class="modal fade" id="edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><b><span id="employee_name"></span></b></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3" method="POST" action="attendance_edit_comuinterna.php">
          <input type="hidden" id="attid" name="id">
          <div class="col-md-12">
            <label for="datepicker_edit" class="form-label">Fecha</label>
            <input type="text" class="form-control" id="datepicker_edit" name="datepicker_edit">
          </div>
          <div class="col-md-12">
            <label for="edit_time_in" class="form-label">Hora Entrada</label>
            <div class="bootstrap-timepicker">
              <input type="text" class="form-control timepicker" id="edit_time_in" name="edit_time_in">
            </div>
          </div>
          <div class="col-md-12">
            <label for="edit_time_out" class="form-label">Hora Salida</label>
            <div class="bootstrap-timepicker">
              <input type="text" class="form-control timepicker" id="edit_time_out" name="edit_time_out">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-close"></i>
              Cerrar</button>
            <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Actualizar</button>
          </div>
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
        <h5 class="modal-title"><b><span id="attendance_date"></span></b></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="attendance_delete_comuinterna.php">
          <input type="hidden" id="del_attid" name="id">
          <div class="text-center">
            <p class="mb-0">ELIMINAR EMPLEADO</p>
            <h2 id="del_employee_name" class="font-weight-bold"></h2>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-close"></i>
          Cerrar</button>
        <button type="submit" class="btn btn-danger" name=delete><i class="fa fa-trash"></i> Eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>