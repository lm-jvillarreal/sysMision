<div class="modal fade" id="modal-historial">
  <div class="modal-dialog modal-lg" id="modal_historial">
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
          <div class="col-md-3">
            <div class="form-group">
              <label for="cantidad_modal">Cantidad:</label>
              <input type="number" id="modal_cantidad" id="modal_cantidad" class="form-control">
            </div>
          </div>
          <div class="col-md-9">
            <div class="form-group">
              <label for="descripcion_modal">Descripción</label>
              <input type="text" id="descripcion_modal" id="descripcion_modal" class="form-control">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="lista_detalleResumen" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <th width='5%'>Cant.</th>
                  <th>Descripción</th>
                  <th width='5%'></th>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->