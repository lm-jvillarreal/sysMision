<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Registro de Rubros</h4>
      </div>
      <div class="modal-body">
        <form method="POST" id="form_datos_rublo">
            <div class="row">
              <input type="number" id="id_registro_modal" name="id_registro_modal" value="0" class="hidden">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="rublo">*Nombre Rubro</label><br>
                        <input type="text" id="rublo_modal" class="form-control" name="rublo_modal" onkeyup="if(event.keyCode == 13)guardar();">
                    </div>
                </div>
            </div>                
        </form>
        <div class="row">
          <div class="col-md-12" id="tabla">
            <div class="table-responsive">
              <table id="lista_rublos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th width="5%">#</th>
                    <th>Nombre</th>
                    <th width="5%">Editar</th>
                    <th width="5%">Eliminar</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </tbody>  
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger pull-right" id="guardar_modal" onclick="guardar()">Guardar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->