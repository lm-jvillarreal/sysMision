<div class="modal fade" id="modal-entradas">
  <div class="modal-dialog modal-lg" id="modal_entradas">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Desglose de Pagos | Detalle de entrada</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-2">
            <div class="form-group">
              <label for="almacen">Almacén</label>
              <input type="text" name="almacen" id="almacen" class="form-control" readonly>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="almacen">Movimiento</label>
              <input type="text" name="tipomov" id="tipomov" class="form-control" readonly>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="almacen">Folio</label>
              <input type="text" name="foliomov" id="foliomov" class="form-control" readonly>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="almacen">Fecha Entrada Almacén</label>
              <input type="text" name="fecha_sello" id="fecha_sello" class="form-control" readonly>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="almacen">Fecha Autorización</label>
              <input type="text" name="fecha_afectacion" id="fecha_afectacion" class="form-control" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="lista_entrada" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <th>Artículo</th>
                  <th>Descripción</th>
                  <th>UM</th>
                  <th>Cant.</th>
                  <th>C.U.</th>
                  <th>Total</th>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->