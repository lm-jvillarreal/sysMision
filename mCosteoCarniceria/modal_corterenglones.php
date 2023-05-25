<div class="modal fade" id="modal_corterenglones">
  <div class="modal-dialog modal-lg" id="modal_corterenglones">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Corte Primario | Renglones</h4>
      </div>
      <div class="modal-body">

        <form action="" method="POST" id="form-modal">
          <div class="row">
            <div class="col-md-1">
              <div class="form-group">
                <label for="modal_claveproducto">*Corte:</label>
                <input type="hidden" name="id_corte" id="id_corte">
                <input type="text" name="modal_clavecorte" id="modal_clavecorte" class="form-control" readonly>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="modal_descripcioncorte">*Descripción:</label>
                <input type="text" name="modal_descripcioncorte" id="modal_descripcioncorte" class="form-control" readonly>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                <label for="modal_articulo">*Artículo:</label>
                <input type="text" name="modal_articulo" id="modal_articulo" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="modal_descripcion">*Descripción</label>
                <input type="text" name="modal_descripcion" id="modal_descripcion" class="form-control" readonly>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id='lista_detalle' class='table table-striped table-bordered' cellspacing='0' width='100%'>
                  <thead>
                    <tr>
                      <th width='5%'>#</th>
                      <th width='5%'>Artículo</th>
                      <th>Descripción</th>
                      <th width='5%'></th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </form>
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