<div class="modal fade" id="modal_editar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Editar Catálogo</h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="form-actualizaCatalogo">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="comentario">*Código</label>
              <input type="text" name="codigo_prod" id="codigo_prod" class="form-control" onkeydown="datos_producto()">
            </div>
          </div>
          <div class="col-md-9">
            <div class="form-group">
              <label for="comentario">*Producto</label>
              <input type="text" name="desc_prod" id="desc_prod" class="form-control">
            </div>
          </div>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" id="btn-insertCodigo">Guardar registro</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->