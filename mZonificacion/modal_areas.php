<div class="modal fade" id="modal-area">
  <div class="modal-dialog" id="modal_area">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Zonificación | Agregar Área</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="area">*Área:</label>
              <input type="hidden" name="id" id="id">
              <input type="text" name="area" id="area" class="form-control">
            </div>
          </div>
          <fiv class="col-md-6">
            <div class="form-group">
              <label for="sucursal">*Sucursal:</label>
              <select name="sucursal" id="sucursal" class="form-control">
                <option value=""></option>
              </select>
            </div>
          </fiv>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-danger pull-right" id="btn-guardar">Guardar Área</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->