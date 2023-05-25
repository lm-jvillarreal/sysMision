<div class="modal fade" id="modal-entregado">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Entrega de impresiones</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="hidden" id="ide">
          <label for="comentario">*Nombre de quien recibe impresiones:</label>
          <textarea name="nombre_recibe" id="nombre_recibe" class="form-control"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger" id="btn-entrega">Actualizar datos</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->