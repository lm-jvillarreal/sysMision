<div class="modal fade" id="modal_detallecedula">
  <div class="modal-dialog modal-lg" id="modal_detallecedula">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cédula de costos | Detalle</h4>
      </div>
      <div class="modal-body">

        <form action="" method="POST" id="form-modal">
          <div class="row">
            <div class="col-md-1">
              <div class="form-group">
                <label for="modal_claveproducto">*Código:</label>
                <input type="hidden" name="id_producto" id="id_producto">
                <input type="hidden" name="subreceta" id="subreceta">
                <input type="text" name="modal_claveproducto" id="modal_claveproducto" class="form-control" readonly>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="modal_descripcionproducto">*Descripción:</label>
                <input type="text" name="modal_descripcionproducto" id="modal_descripcionproducto" class="form-control" readonly>
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
            <div class="col-md-1">
              <div class="form-group">
                <label for="modal_cantidad">*Cantidad</label>
                <input type="text" name="modal_cantidad" id="modal_cantidad" class="form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id='lista_detalle' class='table table-striped table-bordered' cellspacing='0' width='100%'>
                  <thead>
                    <tr>
                      <th width='5%'>Artículo</th>
                      <th>Descripción</th>
                      <th>Proveedor</th>
                      <th width='5%'>Cto. E.</th>
                      <th width='5%'>U.M.</th>
                      <th width='5%'>F.E.</th>
                      <th width='5%'>Cto. U.</th>
                      <th width='5%'>Cantidad</th>
                      <th width='5%'>Merma</th>
                      <th width='5%'>P.U.</th>
                      <th width='5%'>Activo</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                <label for="cedula_costobruto">Costo bruto:</label>
                <input type="text" name="cedula_costobruto" id="cedula_costobruto" class="form-control" value='0' readonly>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="cedula_merma">Merma S. 3%</label>
                <input type="text" name="cedula_merma" id="cedula_merma" class="form-control" readonly>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="cedula_costoneto">Costo Neto:</label>
                <input type="text" name="cedula_costoneto" id="cedula_costoneto" class="form-control" readonly>
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