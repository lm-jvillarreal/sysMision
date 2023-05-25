<div class="modal fade" id="modal-pedido">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cantidad por Producir  <label id=""></label>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="form-modal">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="articulo">*Artículo:</label>
                <!-- codigo -->
                <input type="hidden" name="id_receta" id="id_receta">
                <!-- codigo -->
                <input type="number" name="articulo" id="articulo" class="form-control"readonly >
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="pedido">*Pedido:</label>
                <input type="number" name="pedido" id="pedido" class="form-control" >
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success pull-right" id="btn-Guardar">Guardar</button>
          </div>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->