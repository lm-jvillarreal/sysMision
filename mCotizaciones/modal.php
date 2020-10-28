<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Preferencias</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <h4 for="">*Costo: <b id="demo"></b></h4>
                            <div class="slidecontainer">
                              <input type="range" min="1" max="100" value="50" class="slider" id="myRange">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-danger pull-right" id="btn-guardar_modelo">Guardar Modelo</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->