<div class="modal fade" id="modal-agregar">
  <div class="modal-dialog modal-lg" id="modal_agregar">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remisiones Internas | Agregar Artículo</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for='remision'>Remisión</label>
              <input type='text' id='remision' name='remision' class="form-control" readonly/>
              <input type="hidden" id="id" name="id">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="cantidad">*Cant:</label>
              <input type="number" id="cantidad" name="cantidad" class="form-control">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="artc_articulo">Artículo</label>
              <input type="text" name="artc_articulo" id="artc_articulo" class="form-control">
            </div>
          </div>
          <div class="col-md-3">
            <label for="costo_unitario">*Costo Unitario:</label>
            <input type="number" name="costo_unitario" id="costo_unitario" class="form-control">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="lista_articulos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th width='10%'>Cant.</th>
                    <th width='70%'>Artículo</th>
                    <th width='10%'>C.U.</th>
                    <th width='10%'>Total</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger pull-right" id="finalizar">Finalizar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->