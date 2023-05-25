<div class="modal fade" id="modal-default2">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <div id="t_modelo">
                <h4 class="modal-title">Registro de Modelos</h4>
            </div>
        </div>
        <div class="modal-body">
            <div id="form_modelo">
                <div class="row">

                    <form action="" method="POST" id="form_datos_terminal">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="hidden" id="id_registro_m" name="id_registro_m" value="" >
                                <input type="hidden" id="id_registro_mo" name="id_registro_mo" value="" >
                                <label for="marca_m">*Marca:</label>
                                <input type="text" id="marca_m" name="marca_m" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="modelo">*Modelo:</label>
                                <input type="text" id="modelo_terminal" name="modelo_terminal" class="form-control">
                                <input type="hidden" id="id_marca" name="id_marca" class="fform-control">
                            </div>
                        </div>
                        <div class="col-md-3" id="tipo_modal">
                            <div class="form-group">
                                <label for="tipo">*Tecnología:</label>
                                <select name="tipo_terminal" id="tipo_terminal" style="width:200px" class="form-control select2">
                                    <option value="">Seleccione una opción</option>
                                    <option value="1">PINPAD</option>
                                    <option value="2">DUAL-UP</option>
                                    <option value="3">GPRS</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-md-12" id="tabla_modelos">
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
            <div id="btn_modelo" style="">
                <button type="submit" class="btn btn-danger pull-right" id="btn-guardar_modelo">Guardar Modelo</button>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->