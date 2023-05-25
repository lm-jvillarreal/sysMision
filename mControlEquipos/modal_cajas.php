<div class="modal fade" id="modal-defaultcajas">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <div id="t_caja" style="">
                <h4 class="modal-title">Registro de Cajas</h4>
            </div>
        </div>
        <div class="modal-body">
            <div id="form_caja" style="">
                <form action="" method="POST" id="form_datos_caja">
                    <input type="text" name="id_registro_caja" id="id_registro_caja" class="hidden">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_cambio">*Sucursal:</label>
                                <select name="sucursal_m" id="sucursal_m" style="width:250px" class="form-control select2"></select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_cambio">*Caja:</label>
                                <input type="text" id="caja_m" name="caja" class="form-control" placeholder="Número de Caja">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_cambio">*Tipo:</label>
                                <select name="tipo_caja" id="tipo_caja" style="width:100%" class="select2">
                                    <option value=""></option>
                                    <option value="1">Caja</option>
                                    <option value="2">Administrativa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12" id="tabla">
                        <div class="table-responsive">
                            <table id="lista_cajas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Sucursal</th>
                                        <th>Caja</th>
                                        <th>Tipo</th>
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
        </div>
        <div class="modal-footer">
            <div id="btn_caja" style="">
                <button type="submit" class="btn btn-danger pull-right" id="btn-guardar_caja">Guardar Caja</button>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->