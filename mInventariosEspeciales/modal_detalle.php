<div class="modal fade" id="modal-detalle">
  <div class="modal-dialog modal-lg" id="modal_detalle">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Inventarios Especiales | Registro de categoría</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="artc_articulo">Agregar artículo</label>
              <input type="hidden" id="folio">
              <input type="hidden" id="categoria">
              <input type="text" name="artc_articulo" id="artc_articulo" class="form-control">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="detalle_categoria" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <th width='25%'>Código</th>
                  <th width='45%'>Descripción</th>
                  <th width='20%'>Categoría</th>
                  <th width='10%'></th>
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