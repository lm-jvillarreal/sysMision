<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Abonar a Prestamo de Semana: <label id="semana"></label></h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="form_datos_abonar">
          <input type="text" name="folio" id="folio" class="hidden">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <center>
                  <label>*Prestamo Total</label><br>
                  <label id="prestamo_total"></label>
                </center>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <center>
                  <label>*Prestamo Restante</label> <br>
                  <label id="prestamo_restante"></label>
                </center>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>*Cantidad a Abonar</label>
                <div class="input-group">
                  <span class="input-group-addon">$</span>
                  <input type="text" name="abono" id="abono" class="form-control">
                </div>                            
              </div>
            </div>
          </div>
        </form>
        <div class="row">
          <div class="col-md-12" id="tabla">
            <div class="table-responsive">
              <table id="lista_abonos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th width="5%">#</th>
                    <th>Usuario</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </tbody>  
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" id="btn-abonar">Abonar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->