<div class="modal fade" id="modal-default">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> -->
            <center>
                <h4 class="modal-title" id="t1"><b>¿Desea Añadir Cronómetro?</b></h4>
                <h4 class="modal-title" id="t2" style="display: none"><b>Seleccione Usuario a Asignar</b></h4>
            </center>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group btn-group-justified" role="group" aria-label="...">
                      <div class="btn-group" role="group">
                        <button class="btn btn-primary btn-lg" onclick="activar()">Usuario</button>
                      </div>
                      <div class="btn-group" role="group">
                        <button class="btn btn-success btn-lg" id='btn1' onclick="guardar1(1)">Si</button>
                      </div>
                      <div class="btn-group" role="group">
                        <button class="btn btn-danger btn-lg" id='btn2' onclick="guardar1(0)">No</button>
                      </div>
                    </div>
                </div>
            </div>
            <br>
            <div id="form_usuario" class="row" style="display: none">
                <div class="col-md-12">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="">Usuario</label>
                            <select name="usuario" id="usuario" class="form-control" style="width: 100%"></select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <br>
                            <button class="btn btn-danger" onclick="guardar1(0)">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->