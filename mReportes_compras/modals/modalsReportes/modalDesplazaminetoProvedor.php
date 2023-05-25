<div class="modal fade" id="modal-DesplazaminetoCEDIS" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
                <div>
                    <h4 class="modal-title" id="exampleModalLabel">Reportes | Desplazamiento por proveedor</h4>
                </div>
            </div>
            <div class="modal-body" style="max-height: calc(200vh - 110px); overflow-y: auto;">
               <form id="COM013" method="POST">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fecha_inicio">*Fecha de inicio:</label>
                                <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                                    <input class="form-control" size="16" type="text" value="" readonly id="fecha_inicial" name="fecha_inicial">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fecha_fin">*Fecha final:</label>
                                <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                                    <input class="form-control" size="16" type="text" value="" readonly id="fecha_final" name="fecha_final">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                            <label for="proveedor_COM013">*Proveedor:</label>
                            <select name="proveedor_COM013" id="proveedor_COM013" class="form-control select2">
                                <option value=""></option>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="factor_aumento">*Crecimiento %</label>
                                <input type="text"name='factor_aumento' id="factor_aumento" class="form-control">
                            </div>
                        </div>                    
                    </div>
                    <div class="box-footer text-right">
                        <!-- <button class="btn btn-warning" id="btn_COM013">Mostrar datos</button> -->
                        <button type="button" class="btn btn-danger" id="btn_COM013" onclick="generarReporte(this)">Descargar Reporte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>