<div class="modal fade" id="modal-subrecetas">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Insertar Cantidad  <label id=""></label>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="form-modal">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="clave_receta">*Código:</label>
                <input type="hidden" name="id_registro" id="id_registro">
                <input type="text" name="id_articulo" id="id_articulo" class="form-control" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="descripcion">*Descripción:</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control" readonly>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="cantidad_subr">*Cantidad:</label>
                <input type="number" name= "cantidad_subr" id="cantidad_subr" class="form-control">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success pull-right" id="btn-Guardar">Aceptar</button>
          </div>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->