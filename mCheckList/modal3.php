<div class="modal fade" id="modal-default3">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Registro de Sub-Departamentos:</h4>
            <input type="hidden" name="id_sub_departamento_modal" id="id_sub_departamento_modal">
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <label for="">*Sub-Departamento</label>
                        <input type="text" class="form-control" name="sub_departamento_modal" id="sub_departamento_modal" placeholder="Nombre del Sub-Departamento">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12" id="tabla">
                    <div class="table-responsive">
                        <table id="lista_sub_departamentos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nombre</th>
                                    <th width="20%">Editar</th>
                                    <th width="20%">Eliminar</th>
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
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-warning pull-right" id="guardar_sub">Guardar</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->