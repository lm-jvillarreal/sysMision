<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Registro de Categorias</h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="form_datos">
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-6">
                <div class="form-group">
                  <input type="hidden" name="id_categoria" id="id_categoria" value="0">
                  <label for="fecha_cambio">*Nombre:</label>
                  <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre Categoria">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="fecha_cambio">*Descripcion:</label>
                  <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-12" id="invitar">
                <div class="form-group">
                  <label>*Compartir con :</label>
                  <select style="width: 100%" id="usuarios" name="usuarios[]" multiple="multiple">
                    
                  </select>
                </div>
              </div>
            </div>
          </div>
        </form>
        <div class="col-md-12" id="tabla_usuarios" style="display: none;">
          <div class="table-responsive">
            <table id="lista_usuarios" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th whidth="10%">#</th>
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
      <div class="modal-footer">
        <button type="button" class="btn btn-warning pull-right" id="btn-guardar">Guardar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->