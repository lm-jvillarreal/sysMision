<div class="modal fade" id="modal-fotografia">
  <div class="modal-dialog" id="modal_fotografia">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cierre de Departamentos | Evidencia</h4>
      </div>
      <div class="modal-body">
        <form method="POST" id="form-evidencia" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="folio">Folio</label>
                <input type="text" name="folio" id="folio" class="form-control" readonly='true'>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="documento">*Documento</label>
                <input name="action" type="hidden" value="upload" id="action" />
                <input type="file" accept="image/*" id="camera">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <img id="frame" width="200px" height="200px">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger pull-right" id="btn_evidencia">Guardar Evidencia</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->