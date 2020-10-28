<div class="modal fade" id="modal-default">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <div>
                <h4 class="modal-title">Registro de Rancho</h4>
            </div>
        </div>
        <div class="modal-body">
            <form method="POST" id="form_rancho">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="hidden" id="id_rancho" name="id_rancho" value="0">
                        <label for="fecha_cambio">*Nombre del Rancho:</label>
                            <input type="text" name="nombre_rancho" id="nombre_rancho" class="form-control" placeholder="Nombre del Rancho">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                        <label for="fecha_cambio">*Tipo:</label>
                            <select id="tipo_rancho" name="tipo_rancho" style="width: 100%" class="form-control select2">
                                <option value=""></option>
                                <option value="1">Rancho</option>
                                <option value="2">Huerta</option>
                                <option value="2">Local</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="fecha_cambio">*Estado:</label>
                        <select id="estado" name="estado" style="width: 100%" class="form-control select2">
                            <option value=""></option>
                            <option value="1">Nuevo Leon</option>
                            <option value="2">Tamaulipas</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="fecha_cambio">*Municipio:</label>
                        <select id="municipio" name="municipio" style="width: 100%" class="form-control select2">
                            <option value=""></option>
                            <option value="1">Linares</option>
                            <option value="2">General Teran</option>
                            <option value="3">Villagran</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="">*Encargado</label>
                        <input type="text" id="encargado_rancho" name="encargado_rancho" class="form-control" placeholder="Nombre del Encargado">
                    </div>
                </div>
            </form>
            <br>
            <div class="row">
                <div class="col-md-12" id="tabla">
                    <div class="table-responsive">
                        <table id="lista_ranchos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Municipio</th>
                                    <th>Encargado</th>
                                    <th width="5%">Editar</th>
                                    <th width="5%">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th width="5%"></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th width="5%"></th>
                                    <th width="5%"></th>
                                </tr>
                            </tbody>  
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-danger pull-right" id="btn-guardar">Guardar</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->