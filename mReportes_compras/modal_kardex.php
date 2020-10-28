<div class="modal fade" id="modal-kardex">
  <div class="modal-dialog modal-lg" id="modal_kardex">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Detalle de Folio | Kardex</h4>
      </div>
      <div class="modal-body">
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="folio_modal">Folio:</label>
            <input type="text" name="folio_modal" id="folio_modal" class="form-control" readonly="true">
          </div>
        </div>
      </div>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="lista_detalle" class="table table-striped table-bordered" cellspacing="0" width="200%">
                <thead>
                  <tr>
                    <th width="15%">Artículo</th>
                    <th>Descripción</th>
                    <th width="3%">Costo</th>
                    <th width="3%">P.Público</th>
                    <th width="3%">P.Oferta</th>
                    <th width="3%">inv. inicial</th>
                    <th width="3%">Compra</th>
                    <th width="3%">Ent. Traspaso</th>
                    <th width="3%">Ent. Devolución</th>
                    <th width="3%">Otras Entradas</th>
                    <th width="3%">TOTAL ENTRADAS</th>
                    <th width="3%">Ventas</th>
                    <th width="3%">Sal. Traspaso</th>
                    <th width="3%">Dev. Prov.</th>
                    <th width="3%">Otras Salidas</th>
                    <th width="3%">TOTAL SALIDAS</th>
                    <th width="3%">TEÓRICO</th>
                  </tr>
                </thead>
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