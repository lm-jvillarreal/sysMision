<div class="modal fade" id="modal-escarg">
  <div class="modal-dialog modal-lg" id="modal_teoricos">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Detalle de Entrada | ESCARG</h4>
      </div>
      <div class="modal-body">
        <diw class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="nota_entrada">Nota de Entrada:</label>
              <input type="text" name="nota_entrada" id="nota_entrada" class="form-control" readonly="true">
            </div>
          </div>
        </diw>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id='detalle_escarg' class='table table-striped table-bordered' cellspacing='0' width='100%'>
                <thead>
                  <tr>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th></th>
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