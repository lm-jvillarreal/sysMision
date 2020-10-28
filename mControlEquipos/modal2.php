<div class="modal fade" id="modal-default2">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <div id="t_marca" style="display: none;">
                <h4 class="modal-title">Registro de Marcas</h4>
            </div>
            <div id="t_caja" style="display: none;">
                <h4 class="modal-title">Registro de Cajas</h4>
            </div>
            <div id="t_modelo">
                <h4 class="modal-title">Registro de Modelos</h4>
            </div>
        </div>
        <div class="modal-body">
            <div id="form_marca" style="display: none;">
                <form action="" method="POST" id="form_datos_marca">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="fecha_cambio">*Nombre de la Marca:</label>
                                <input type="hidden" id="id_marca_modal" name="id_marca_modal" value="0">
                                <input type="text" name="marca_r" id="marca_r" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="fecha_cambio">*Equipo:</label>
                                <select id="equipo_marca" name="equipo_marca" style="width: 100%">
                                    <option value=""></option>
                                    <option value="1">Terminal</option>
                                    <option value="2">Escaner</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12" id="tabla">
                        <div class="table-responsive">
                            <table id="lista_marcas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Nombre</th>
                                        <th>Equipo</th>
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
                                        <th></th>
                                    </tr>
                                </tbody>  
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="form_caja" style="display: none;">
                <form action="" method="POST" id="form_datos_caja">
                    <input type="text" name="id_registro_caja" id="id_registro_caja" value="0" class="hidden">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_cambio">*Sucursal:</label>
                                <select name="sucursal_m" id="sucursal_m" style="width:100%" class="select2"></select>
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
            <div id="form_modelo" style="display: none;">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_cambio">*Equipo:</label>
                            <select name="equipo_m" id="equipo_m" class="form-control" onchange="formulario_modelo(this.value)">
                                <option value=""></option>
                                <option value="1">Terminal</option>
                                <option value="2">Escáner</option>
                            </select>
                        </div>
                    </div>
                    <form action="" method="POST" id="form_datos_terminal">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="hidden" id="id_modelo_modal" name="id_modelo_modal" value="0">
                                <label for="marca">*Marca:</label>
                                <select id="marca_terminal" name="marca_terminal" class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="modelo">*Modelo:</label>
                                <input type="text" id="modelo_terminal" name="modelo_terminal" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3" id="tipo_modal">
                            <div class="form-group">
                                <label for="tipo">*Tipo:</label>
                                <select name="tipo_terminal" id="tipo_terminal" style="width:100%" class="select2">
                                    <option value=""></option>
                                    <option value="1">PINPAD</option>
                                    <option value="2">DUAL-UP</option>
                                    <option value="3">GPRS</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-md-12" id="tabla_terminales" style="display: none;">
                        <div class="table-responsive">
                            <table id="lista_modelos_terminal" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="20%">Marca</th>
                                        <th width="20%">Modelo</th>
                                        <th width="20%">Tipo</th>
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
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tbody>  
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12" id="tabla_escaner" style="display: none;">
                        <div class="table-responsive">
                            <table id="lista_modelos_escaner" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="20%">Marca</th>
                                        <th width="20%">Modelo</th>
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
            <div id="btn_marca" style="display: none;">
                <button type="submit" class="btn btn-danger pull-right" id="btn-guardar_marca">Guardar Marca</button>
            </div>
            <div id="btn_caja" style="display: none;">
                <button type="submit" class="btn btn-danger pull-right" id="btn-guardar_caja">Guardar Caja</button>
            </div>
            <div id="btn_modelo" style="display: none;">
                <button type="submit" class="btn btn-danger pull-right" id="btn-guardar_modelo">Guardar Modelo</button>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->