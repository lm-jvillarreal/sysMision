<div class="modal fade" id="modal-comentario">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Comentario de liberación</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="hidden" id="id_cambio">
          <label for="comentario">*Comentario</label>
          <textarea name="comentario" id="comentario_cambio" class="form-control"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger" id="btn-comentario">Actualizar Comentario</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->