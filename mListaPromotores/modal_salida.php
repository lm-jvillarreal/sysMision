<div class="modal fade" id="modal-salida">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Salida de Promotor</h4>
      </div>
      <div class="modal-body">
        <form method="POST" id="form_datos_rublo">
            <div class="row">
              <input type="number" id="id_promotor" name="id_promotor" value="0" class="hidden">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="rublo">*Razon de la Salida</label><br>
                        <input type="text" id="razon" class="form-control" name="razon">
                    </div>
                </div>
            </div>                
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger pull-right" id="guardar_modal">Guardar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->