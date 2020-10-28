<div class="modal fade" id="modal-usar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Usar Material</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="material">*Materiales</label>
                      <select style="width:100%" id="material" class="form-control" name="material" onchange="llenar(this.value);">
                      <option></option>
                      </select>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                  <label for="cantidad">*Cantidad a Usar</label>
                  <input type="text" name="cantidad" id="cantidad" class="form-control" onchange="verificar(this.value)">
                  </div>
              </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger pull-right" id="guardar_modal">Usar Material</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->