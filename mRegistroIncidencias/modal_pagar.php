<div class="modal fade" id="modal-pagar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Incidencia de: <label id="Nombre"></label></h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="form_datos_pagar">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="id_registroO"></label>
                <input type="hidden" name="id_registroO" id="id_registroO">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="incidenciaA">*Incidencia:</label>
                <input type="text" name="incidencia"  id="incidenciaA" class="form-control" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="accionS">*Acción Sugerida: </label>
                <input type="text" name="accion" id="accionN" class="form-control" readonly>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="comentarioO">*Comentario</label>
                  <input type="text" name="comentario" id="comentarioO" class="form-control" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="fecha">*Fecha</label>
                  <input type="text" name="fecha" id="fecha" class="form-control" readonly>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="decisionN">*Decisión</label>
                <select style="width:100%" name="decision" id="decisionN" class="form-control select2">
                  <option value=""></option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="comentario_finN">*Comentario</label>
                  <input type="text" name="comentario_fin" id="comentario_finN" class="form-control">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success pull-right" id="btn-aceptar">Autorizar</button>
        <button type="button" class="btn btn-danger pull-left" id="btn-Rechazar">Rechazar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->