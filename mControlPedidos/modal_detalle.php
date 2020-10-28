<div class="modal fade" id="modal-detalle">
  <div class="modal-dialog" id="modal_detalle">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Surtido de Pedidos | Detalle del pedido</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="folio">Folio</label>
              <input type="text" name="folio" id="folio" class="form-control" readonly='true'>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="lista_articulos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <th>Código</th>
                  <th>Descripción</th>
                  <th>Existencia</th>
                  <th>Pedido</th>
                  <th>Surtido</th>
                  <th></th>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger pull-right" id="btn_finalizar">Finalizar pedido</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->