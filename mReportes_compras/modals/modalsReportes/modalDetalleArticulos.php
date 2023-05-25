<div class="modal fade fullscreen-modal" id="modal-DetalleArticulos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
                <div>
                    <h4 class="modal-title" id="exampleModalLabel">Compras | Detalle de Artículos</h4>
                </div>
            </div>
            <div class="modal-body" >
              <form method="POST" id="COM011" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="documento">*Documento</label>
                      <input name="action" type="hidden" value="upload" id="action" />
                      <input type="file" name="file">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="descripcion">*Descripción</label>
                      <input type="text" name="descripcion" id="descripcion" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <label for="sucursal-DA">*Sucursal:</label>
                    <select name="sucursal-DA" class="form-control" id="sucursal-DA">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
                <br>
                <div class="box-footer text-right">
                <button class="btn btn-warning" id="btnCargarFolio">Importar códigos</button>
                </div>
            </div>
          <div class="">
            <div class="box-header">
              <h3 class="box-title">Lista de Folios Existentes</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table id="lista_folios-DA" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th width="5%">Folio</th>
                          <th>Descripción</th>
                          <th width="5%">Cantidad</th>
                          <th>Fecha</th>
                          <th width="15%">Sucursal</th>
                          <th width="15%">Usuario</th>
                          <th width="20%"></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
              </form>
        </div>
    </div>
</div>

<style>
  .fullscreen-modal .modal-dialog {
  margin: 0;
  margin-right: auto;
  margin-left: auto;
  width: 100%;
}
@media (min-width: 768px) {
  .fullscreen-modal .modal-dialog {
    width: 750px;
  }
}
@media (min-width: 992px) {
  .fullscreen-modal .modal-dialog {
    width: 970px;
  }
}
@media (min-width: 1200px) {
  .fullscreen-modal .modal-dialog {
     width: 1170px;
  }
}
</style>