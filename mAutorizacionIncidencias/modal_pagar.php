<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Autorizar Incidencia para: <label id="nombre"></label></h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="form_datos_pagar">
        <div class="row">
        <div class="col-md-12">
            <div class="form-group">
              <label for="id_registro"></label>
              <input type="hidden" name="id_registro" id="id_registro">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="incidencia">*Incidencia:</label>
              <input type="text" name="incidencia"  id="incidencia" class="form-control" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="accion">*Acción Sugerida: </label>
              <input type="text" name="accion" id="accion" class="form-control" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="comentario">*Comentario</label>
                <input type="text" name="comentario" id="comentario" class="form-control" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="decision">*Decisión</label>
              <select style="width:100%" name="decision" id="decision" class="form-control select2">
                  <option value=""></option>
                </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="comentario_fin">*Comentario</label>
                <input type="text" name="comentario_fin" id="comentario_fin" class="form-control">
            </div>
          </div>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success pull-right" id="btn-autorizar">Autorizar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->