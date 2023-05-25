<div class="modal fade" id="modal-detalle">
  <div class="modal-dialog modal-lg" id="modal_detalle">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Explosión | Detalle</h4>
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
                <label for="receta">*Tipo:</label>
                <input type="text" name="tipo" id="tipo" class="form-control" readonly>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id='lista_detalle' class='table table-striped table-bordered' cellspacing='0' width='100%'>
                  <thead>
                    <tr>
                      <th width='5%'>Articulo</th>
                      <th width='5%'>Descripcion</th>
                      <th width='5%'>Lunes</th>
                      <th width='5%'>Martes</th>
                      <th width='5%'>Miercoles</th>
                      <th width='5%'>Jueves</th>
                      <th width='5%'>Viernes</th>
                      <th width='5%'>Sabdado</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

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