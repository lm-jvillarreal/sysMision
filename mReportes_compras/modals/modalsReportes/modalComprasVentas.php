<div class="modal fade" id="modal-ComprasVentas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
                <div>
                    <h4 class="modal-title" id="exampleModalLabel">Reportes | Compras vs Ventas</h4>
                </div>
            </div>
            <div class="modal-body" style="max-height: calc(200vh - 110px); overflow-y: auto;">
                <form method="POST" id="COM005">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="fecha_inicio">*Fecha de inicio:</label>
                                <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                                    <input class="form-control" size="16" type="text" value="" readonly id="fecha_inicial" name="fecha_inicial">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="fecha_fin">*Fecha final:</label>
                                <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                                    <input class="form-control" size="16" type="text" value="" readonly id="fecha_final" name="fecha_final">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="proveedor_COM005">Proveedor:</label>
                                <select name="proveedor_COM005" id="proveedor_COM005" class="form-control select2 no-validar">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sucursal_COM005">*Sucursal:</label>
                                <select name="sucursal_COM005" id="sucursal_COM005" class="form-control select2 select">
                                <option value=""></option>
                                <option value="1">Diaz Ordaz</option>
                                <option value="2">Arboledas</option>
                                <option value="3">Villegas</option>
                                <option value="4">Allende</option>
                                <option value="5">Petaca</option>
                                <option value="6">Montemorelos</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Archivo:</label>
                                <input type="file" name="excel" class="form-control no-validar">
                            </div>
                        </div>
                    </div>
                    <input type="text" name="array" class="form-control no-validar" id="array_compras_vs">
                    <br>
                    <div class="text-right">
                        <!-- <button class="btn btn-warning" id="mostrar_datos">Mostrar datos</button> -->
                        <a href="javascript:subir_excel($('#frmDatosComprasVsVentas').attr('id'), $('#array_compras_vs').attr('id'))" class="btn btn-danger">Subir</a>
                        <!-- <button class="btn btn-warning" id="btn_COM005">Mostrar datos</button> -->
                        <button type="button" class="btn btn-danger" id="btn_COM005" onclick="generarReporte(this)">Descargar Reporte</button>
                    </div>
                </form>                
            </div>
        </div>
    </div>
</div>