<div class="modal fade" id="modal-fraccion">
  <div class="modal-dialog modal-lg" id="modal_fraccion">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Planograma | Agregar artículo</h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="frmDatos">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="" id="lblArea"></label>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="" id="lblZona"></label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="" id="lblMueble"></label>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="" id="lblCara"></label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="fraccion">*Fracción:</label>
                <input type="text" name="fraccion" id="fraccion" class="form-control" readonly="true">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="nivel">*Nivel:</label>
                <div class="input-group" style="width: 100%">
                  <input type="number" class="form-control" id="nivel" name="nivel" readonly="true">
                  <span class="input-group-btn">
                    <button class="btn btn-danger" type="button" id="btnNivel"><span class="fa fa-arrow-up" aria-hidden="true"></span></button>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="artc_articulo">*Artículo:</label>
                <input type="text" name="artc_articulo" id="artc_articulo" class="form-control" autofocus="true">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="artc_descripcion">*Descripción</label>
                <input type="text" name="artc_descripcion" id="artc_descripcion" class="form-control" readonly>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="frente">*Frente:</label>
                <input type="number" name="frente" id="frente" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="fondo">*Fondo:</label>
                <input type="number" name="fondo" id="fondo" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="alto">*Alto:</label>
                <input type="number" name="alto" id="alto" class="form-control">
              </div>
            </div>
          </div>
        </form>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="lista_ultimo" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th width='5%'>Articulo</th>
                    <th>Descripción</th>
                    <th width='5%'>Frente</th>
                    <th width='5%'>Fondo</th>
                    <th width='5%'>Alto</th>
                    <th width='5%'>Total</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-success pull-right" id="btnArticulo">Guardar artículo</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->