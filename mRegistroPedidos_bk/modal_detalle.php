<div class="modal fade" id="modal-articulos">
  <div class="modal-dialog" id="modal_articulos">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Detalle del pedido | Búsqueda de artículos</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="descripcion">*Descripción</label>
              <input type="text" name="descripcion" id="descripcion" class="form-control">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="lista_articulos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <th width='5%'>#</th>
                  <th width="10%">Código</th>
                  <th>Descripción</th>
                  <th width='5%'>Exist.</th>
                  <th width='10%'>U.M.</th>
                  <th width='15%'>Cant.</th>
                  <th width='10%'>Precio</th>
                  <th width='5%'></th>
                </thead>
              </table>
            </div>
          </div>
        </div>
        <div id="tabla"></div>
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