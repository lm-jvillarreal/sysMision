<div class="modal fade" id="modal-comp">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Detalle del levantamiento</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 form-group">
              <select name="id_comprador" id="id_comprador" class="form-control" style="width:260px"></select>
              <input type="hidden" name="ide_rg" id="ide_rg">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-danger pull-right" id="btn-cambiaComprador">Guardar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->