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
          <div class="col-md-2">
            <div class="form-group">
              <label for="folio">Pedido:</label>
              <input type="text" name="folio" id="folio" class="form-control" readonly='true'>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="traspaso_salida">T. Salida:</label>
              <input type="text" name="traspaso_salida" id="traspaso_salida" class="form-control" readonly='true'>
            </div>
          </div>
          <div class="col-md-8">
            <label for="acotaciones">Acotaciones:</label>
            <div class="table-responsive">
              <table id="acotaciones" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <td bgcolor="#F7DC6F"></td>
                    <td>No enviado</td>
                    <td bgcolor="#EDBB99"></td>
                    <td>Dif. Vs. Pedido</td>
                    <td bgcolor="#E74C3C"></td>
                    <td>Dif. Vs. Traspaso</td>
                  </tr>
                </thead>
              </table>
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
                  <th>Pedido</th>
                  <th>Salida</th>
                  <th>Entrada</th>
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