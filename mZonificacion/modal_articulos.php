<div class="modal fade" id="modal-articulos">
  <div class="modal-dialog modal-lg" id="modal_articulos">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Zonificación | Agregar Área</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for='id'>Fracción</label>
              <input type='text' id='id_fraccion' name='id_fraccion' class="form-control" readonly/>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="lista_articulos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th width='5%'>#</th>
                    <th width='8%'>Sucursal</th>
                    <th width='5%'>Area</th>
                    <th width='5%'>Zona</th>
                    <th width='5%'>Tipo Mueble</th>
                    <th width='5%'>Mueble</th>
                    <th width='5%'>Cara</th>
                    <th width='5%'>Fracción</th>
                    <th width='5%'>Nivel</th>
                    <th width='10%'>Articulo</th>
                    <th>Descripción</th>
                    <th width='5%'>Frente</th>
                    <th width='5%'>Fondo</th>
                    <th width='5%'>Calculado</th>
                    <th width='5%'></th>
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