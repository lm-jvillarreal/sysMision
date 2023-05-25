<div class="modal fade" id="modal-categorias">
  <div class="modal-dialog" id="modal_categorias">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Inventarios Especiales | Registro de categoría</h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="form-categorias" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nombre_categoria">Categoría:</label>
                <input type="text" name="nombre_categoria" id="nombre_categoria" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="archivo">Cargar archivo:</label>
                <input name="action" type="hidden" value="upload" id="action" />
                <input type="file" name="file">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-danger pull-right" id="btn-categoria">Guardar categoría</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->