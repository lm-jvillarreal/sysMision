<div class="modal fade" id="modal-articulos">
  <div class="modal-dialog" id="modal_articulos">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Mercancía sin cargo | Búsqueda de artículos</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="artc_articulo">*Artículo</label>
              <input type="text" name="artc_articulo" id="artc_articulo" class="form-control">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="artc_descripcion">*Descripción</label>
              <input type="text" id="artc_descripcion" name="artc_descripcion" class="form-control" readonly="true">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <label for="cantidad">*Cantidad</label>
            <input type="text" id="artc_cantidad" name="artc_cantidad" class="form-control">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-6 text-left">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
          <div class="col-md-6 text-right">
            <button class="btn btn-warning" id="btn-agregarArticulo">Agregar artículo</button>
            <button class="btn btn-danger" id="btn-finalizaEscarg">Finalizar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->