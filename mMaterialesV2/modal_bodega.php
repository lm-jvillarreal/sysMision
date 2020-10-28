<div class="modal fade" id="modal-bodega">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Registro de Tipo de Bodega</h4>
      </div>
      <div class="modal-body">
        <form method="POST" id="form_tb">
          <input type="hidden" id="id_registrotb" name="id_registrotb" value="0">
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">*Nombre:</label>
                  <input type="text" class="form-control" id="nombretb" name="nombretb" placeholder="Nombre de Bodega">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">*Encargado:</label>
                  <select name="encargadotb[]" id="encargadotb" class="form-control" multiple style="width: 100%"></select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">*Usuarios:</label>
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button class="btn btn-danger btn-flat tipo" type="button">Perfil</button>
                      <input type="hidden" id="tipotb" name="tipotb" value="1">
                    </div>
                    <!-- /btn-group -->
                    <div id="divtb">
                      <select name="perfiltb" id="perfiltb" class="form-control" multiple style="width: 100%"></select>
                    </div>
                    <div id="divtb2" style="display: none;">
                      <select name="usuariotb" id="usuariotb" class="form-control hidden" multiple style="width: 100%"></select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
        <div class="row" id="editar" style="display: none;">
          <div class="col-md-6">
            <div class="table-responsive">
              <table id="lista_tipos_encargados" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Eliminar</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </tbody>  
              </table>
            </div>
          </div>
          <div class="col-md-6">
            <div class="table-responsive">
              <table id="lista_tipos_usuarios" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Eliminar</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </tbody>  
              </table>
            </div>
          </div>
        </div>
        <br>
        <div class="row" id="insertar">
          <div class="col-md-12" id="tabla">
            <div class="table-responsive">
              <table id="lista_tipos_bodega" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Encargado</th>
                    <th>Usuarios</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th></th>
                    <th></th>
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
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-warning pull-right" id="guardartb">Guardar</button> 
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
