<div class="modal fade" id="modal-costos">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Registro de Costo</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="ide" id="ide">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="costo">*Costo</label>
              <input type="number" class="form-control" name="costo" id="costo">
            </div>
          </div>
        </div>
            <label for="comentario">*Comentario</label>
            <textarea name="comentario-verifica" id="comentario-verifica" class="form-control"></textarea>          
      </div>
      <div class="modal-footer">
        <button class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-danger pull-right" id="btn-costos">Actualizar código</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->