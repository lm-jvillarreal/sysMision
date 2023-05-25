<div class="modal fade" id="modal-ComprasVentasFiltros" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
                <div>
                    <h4 class="modal-title" id="exampleModalLabel">Reportes | Compras vs Ventas Filtros</h4>
                </div>
            </div>
            <div class="modal-body" style="max-height: calc(200vh - 110px); overflow-y: auto;">
                <form method="POST" id="COM006_2">
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
                        <div class="col-md-3">
							<div class="form-group">
								<label for="sucursal_COM006">*Sucursal:</label>
								<select style=" width: 100%;" name="sucursal_COM006" id="sucursal_COM006" class="form-control select select2">
									<option value=""></option>
									<option value="1">Díaz Ordaz</option>
									<option value="2">Arboledas</option>
									<option value="3">Villegas</option>
									<option value="4">Allende</option>
									<option value="5">Petaca</option>
									<option value="6">Montemorelos</option>
									<option value="99">CEDIS</option>
								</select>
							</div>
						</div>
                        <div class="col-lg-3">
                            <label for="departamento_COM006">Departamento:</label>
                            <select class="form-control select2 no-validar" name="departamento_COM006" id="departamento_COM006">
                            <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="familia_COM006">Familia:</label>
                            <select class="form-control select2 no-validar" name="familia_COM006" id="familia_COM006">
                            <option></option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="tipo_COM006">*Tipo entrada:</label>
                            <select class="form-control select" name="tipo_COM006" id="tipo_COM006">
                            <option value="" selected disabled>Seleccione...</option>
                            <option value="ENTSOC">Entrada sin orden</option>
                            <option value="ENTCOC">Entrada con orden</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="folio">Folio:</label>
                            <input type="text" name="folio" id="folio" class="form-control no-validar">
                        </div>                    
                    </div>  
                    <br>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" id="btn_COM006" onclick="generarReporte(this)">Descargar Reporte</button>
                    </div>                  
                </form>               
            </div>
        </div>
    </div>
</div>