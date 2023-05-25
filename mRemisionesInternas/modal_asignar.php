<div class="modal fade" id="modal-asociar">
  <div class="modal-dialog" id="modal_asociar">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remisiones Internas | Asociar Remisión</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for='remision'>Remisión</label>
              <input type='text' id='remision_asociar' name='remision_asociar' class="form-control" readonly/>
              <input type="hidden" id="id_asociar" name="id_asociar">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="movimiento">*Movimiento:</label>
              <select name="tipo_movimiento" id="tipo_movimiento" class="form-control">
                <option value=""></option>
                <option value="ENTCOC">Entrada con orden de compra</option>
                <option value="ENTSOC">Entrada sin orden de compra</option>
                <option value="ESCARG">Entrada sin cargo</option>
                <option value="ECHORI">Entrada por conversión de chorizo</option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="folio_movimiento">*Folio:</label>
              <input type="number" id="folio_movimiento" name="folio_movimiento" class="form-control">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-warning pull-left" id="no_aplica">No aplica</button>
        <button type="button" class="btn btn-danger pull-right" id="asociar_remision">Finalizar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->