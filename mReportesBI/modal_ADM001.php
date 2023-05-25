<!-- Modal -->
<div class="modal fade" id="modal-ADM001" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Reporte consolidado ViDO | Parámetros de filtrado</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="fecha_inicio">*Fecha Incial:</label>
							<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
								<input class="form-control" size="16" type="text" value="" readonly id="ADM001_fecha_inicial" name="ADM001_fecha_inicial">
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="fecha_inicio">*Fecha Final:</label>
							<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
								<input class="form-control" size="16" type="text" value="" readonly id="ADM001_fecha_final" name="ADM001_fecha_final">
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="sucursal">*Sucursal:</label>
							<select name="ADM001_sucursal" id="ADM001_sucursal" class="form-control">
								<option value=""></option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				<button type="button" id="ADM001" onclick="GenerarReporte(this.id)" class="btn btn-danger">Generar reporte</button>
			</div>
		</div>
	</div>
</div>