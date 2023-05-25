<div class="modal fade" id="modal-registroErrores">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Registro de Errores</h4>
      </div>
      <div class="modal-body">
        <form method="POST" id="form_datos_comentarioError">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="error">Error:</label>
                <input type="hidden" name="id_registroError" id="id_registroError">
                <input type="hidden" name="MovimientoError" id="MovimientoError">
                <input type="hidden" name="SucursalError" id="SucursalError">
                <input type="hidden" name="EmpleadoError" id="EmpleadoError">
                <select id="error" name="error" class="form-control" style="width: 100%">
                  <option></option>
                </select>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="comentarioError">Comentario:</label>
                <textarea name="comentarioError" id="comentarioError" class="form-control" cols="10" rows="1"></textarea>
              </div>
            </div>
          </div>   
          <div class="modal-footer text-right">
            <button type="button" class="btn btn-success pull-right" id="btn-guardar">Guardar</button>
          </div>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->