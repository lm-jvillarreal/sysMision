<div class="modal fade" id="modal-VentasDetallado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
                <div>
                    <h4 class="modal-title" id="exampleModalLabel">Reportes | Detalle de Ventas</h4>
                </div>
            </div>
            <div class="modal-body" style="max-height: calc(200vh - 110px); overflow-y: auto;">
               <form method="POST" id="COM009">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="fecha_inicio">*Fecha:</label>
								<div class="input-group date form_date" data-date="<?php echo $fecha_COM009 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha" data-link-format="yyyy-mm-dd">
									<input class="form-control" size="16" type="text" value="<?php echo $fecha_COM009 ?>" readonly id="fecha" name="fecha">
									<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="sucursal_COM009">*Sucursal:</label>
								<select name="sucursal_COM009" id="sucursal_COM009" class="form-control select2">
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
					</div>
					<div class="box-footer text-right">
					<button type="button" class="btn btn-danger" id="btn_COM009" onclick="generarReporte(this)">Descargar Reporte</button>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>