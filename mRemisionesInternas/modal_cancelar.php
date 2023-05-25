<div class="modal fade" id="modal-cancelar">
  <div class="modal-dialog" id="modal_cancelar">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remisiones Internas | Cancelar Remisión</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for='remision'>Remisión</label>
              <input type='text' id='remision_cancelar' name='remision_cancelar' class="form-control" readonly/>
              <input type="hidden" id="id_cancelar" name="id_cancelar">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="motivo">Motivo de cancelación</label>
              <textarea name="motivo" id="motivo" cols="100%" rows="5" class="form-control"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger pull-right" id="cancelar_remision">Finalizar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->