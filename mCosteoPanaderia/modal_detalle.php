<div class="modal fade" id="modal-detalle">
  <div class="modal-dialog modal-lg" id="modal_detalle">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Subrecetas | Detalle</h4>
      </div>
      <div class="modal-body">

        <form action="" method="POST" id="form-modal">
          <div class="row">
            <div class="col-md-1">
              <div class="form-group">
                <label for="clave_receta">*Código:</label>
                <input type="hidden" name="id_receta" id="id_receta">
                <input type="hidden" name="modal_subreceta" id="modal_subreceta">
                <input type="text" name="clave_receta" id="clave_receta" class="form-control" readonly>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="receta">*Receta:</label>
                <input type="text" name="receta" id="receta" class="form-control" readonly>
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
                      <th width='6%'>Cto. E.</th>
                      <th width='7%'>U.M.</th>
                      <th width='5%'>F.E.</th>
                      <th width='6%'>Cto. U.</th>
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
                <label for="costo_bruto">Costo bruto:</label>
                <input type="text" name="costo_bruto" id="costo_bruto" class="form-control" value='0'readonly>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="merma_s">Merma S. 3%</label>
                <input type="text" name="merma_s" id="merma_s" class="form-control" readonly>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="costo_neto">Costo Neto:</label>
                <input type="text" name="costo_neto" id="costo_neto" class="form-control" readonly>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="rendimiento">Rendimiento:</label>
                <input type="text" name="rendimiento_modal" id="rendimiento_modal" class="form-control" value='0' readonly>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="unimedida">UM KG/LT:</label>
                <input type="text" name="unimedida" id="unimedida" class="form-control" readonly>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="costo_um">Costo UM:</label>
                <input type="text" name="costo_um" id="costo_um" class="form-control" readonly>
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