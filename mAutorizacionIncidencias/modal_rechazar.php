<div class="modal fade" id="modal-rechazar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Rechazar Incidencia para: <label id="nombre_persona"></label></h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="form_datos_pagar">
        <div class="row">
        <div class="col-md-12">
            <div class="form-group">
              <label for="id_registroo"></label>
              <input type="hidden" name="id_registroo" id="id_registroo">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="registro">*Incidencia:</label>
              <input type="text" name="registro"  id="registro" class="form-control" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="sugerencia">*Acción Sugerida: </label>
              <input type="text" name="sugerencia" id="sugerencia" class="form-control" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="comentario_inicio">*Comentario</label>
                <input type="text" name="comentario_inicio" id="comentario_inicio" class="form-control" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="comentario_final">*Comentario Final</label>
                <input type="text" name="comentario_final" id="comentario_final" class="form-control">
            </div>
          </div>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" id="btn-rechazar">Rechazar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->