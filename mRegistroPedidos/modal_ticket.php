<div class="modal fade" id="modal-ticket">
  <div class="modal-dialog modal-md" id="modal_ticket">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Surtido de Pedidos | Asociar ticket de compra</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="folio">Folio</label>
              <input type="text" name="folioPedido" id="folioPedido" class="form-control" readonly='true'>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="folio_ticket">Folio ticket:</label>
              <input type="number" id="folio_ticket" id="folio_ticket" class="form-control">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="metodo_pago">Método de pago:</label>
              <select name="metodo_pago" id="metodo_pago" class="form-control">
                <option value=""></option>
                <option value="EFECTIVO">Efectivo</option>
                <option value="ELECTRONICO">Electrónico</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="total_ticket">Total:</label>
              <input type="text" name="total_ticket" id="total_ticket" class="form-control" readonly>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="cantidad_boletos">Boletos:</label>
              <input type="text" name="cantidad_boletos" id="cantidad_boletos" class="form-control" readonly>
            </div>
          </div>
        </div>
        <div class="row">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger pull-right" id="btnFinaliza">Finalizar Pedido</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->