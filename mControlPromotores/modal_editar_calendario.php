<div class="modal fade" id="modal-editar">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <div id="titulo">
              <div class="row">
                <div class="col-md-12">
                  <h4 class="modal-title">Editar Calendario</h4>
                </div>
              </div>
            </div>
        </div>
        <div class="modal-body">
          <form id="form_terminar" method="POST" >
            <div class="row">
              <div class="col-md-12">
                <input type="hidden" name="id_promotor_modal_ec" id="id_promotor_modal_ec" value="0">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>*Dia</label>
                      <select class="form-control" id="dia_ec" name="dia_ec" style="width: 100%">
                        <option value=""></option>
                        <option value="1">Lunes</option>
                        <option value="2">Martes</option>
                        <option value="3">Miercoles</option>
                        <option value="4">Jueves</option>
                        <option value="5">Viernes</option>
                        <option value="6">Sabado</option>
                        <option value="7">Domingo</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>*Sucursal</label>
                      <select name="sucursal_modal_calendario" id="sucursal_modal_calendario" style="width: 100%">
                        <option value=""></option>
                        <option value="1">Diaz Ordaz</option>
                        <option value="2">Arboledas</option>
                        <option value="3">Villegas</option>
                        <option value="4">Allende</option>
                        <option value="5">La Petaca</option>
                      </select>
                    </div>
                  </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-warning pull-right" id="btn-eliminar">Eliminar</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->