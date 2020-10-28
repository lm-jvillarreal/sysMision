<div class="modal fade" id="modal-default2">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Datos de Proveedor:</h4>
        </div>
        <div class="modal-body">
            <form method="POST" id="form_datos_proveedor">
                <input type="hidden" id="id_proveedor" name="id_proveedor" value="0">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="">*Tipo:</label><br>
                                <button class="btn btn-success tipo" type="button">Nuevo</button>
                                <input type="hidden" id="tipo" name="tipo" value="1">
                            </div>
                        </div>
                        <div class="col-md-6" id="nuevo">
                            <div class="form-group">
                                <label for="">*Nombre:</label>
                                <input type="text" class="form-control" name="nombre_proveedor" id="nombre_proveedor" placeholder="Nombre de Proveedor">
                                <input type="hidden" name="id_cotizacion_proveedor" id="id_cotizacion_proveedor">
                            </div>
                        </div>
                        <div class="col-md-6" id="infofin" style="display: none;">
                            <div class="form-group">
                                <label for="">*Proveedor:</label><br>
                                <select name="proveedor" id="proveedor" class="form-control" style="width: 100%"></select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">*Fecha Entrega:</label>
                                <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                                  <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_entrega" name="fecha_entrega" >
                                  <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">*Plazo de Pago:</label>
                                <div class="input-group">
                                    <input type="text" name="plazo_dias" id="plazo_dias" class="form-control" placeholder="Plazo">
                                    <div class="input-group-addon">Dias</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">*Descuento:</label>
                                <div class="input-group">
                                    <input type="text" name="descuento" id="descuento" class="form-control" placeholder="Descuento">
                                    <div class="input-group-addon">%</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">*Adjuntar Archivo:</label><br>
                                <input type="file" id="documento" name="documento">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">*Garantias:</label><br>
                                <textarea name="garantias" id="garantias" cols="108" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-danger pull-right" id="btn_guardar_proveedor">Guardar Proveedor</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->