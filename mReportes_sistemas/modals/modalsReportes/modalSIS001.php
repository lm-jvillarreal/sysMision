<div class="modal fade" id="modal-mSIS001" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
				<div>
					<h4 class="modal-title" id="exampleModalLabel">Reportes | Cambio de precios con # de folio</h4>
				</div>
			</div>
			<div class="modal-body" style="max-height: calc(200vh - 110px); overflow-y: auto;">
				<form method="POST" id="SIS001">
					<div class="row">
						<div class="col-md-3">
							<label>*Folio:</label>
							<input type="text" name="folio_SIS001" class="form-control">
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="sucursal_SIS001">*Sucursal:</label>
								<select name="sucursal_SIS001" id="sucursal_SIS001" class="form-control">
									<option value=""></option>
									<option value="1">Díaz Ordaz</option>
									<option value="2">Arboledas</option>
									<option value="3">Villegas</option>
									<option value="4">Allende</option>
									<option value="5">Petaca</option>
									<option value="6">Montemorelos</option>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<label>*Tipo de entrada:</label>
							<select class="form-control" name="tipo_SIS001" id="tipo_SIS001">
								<option value=""></option>
								<option value="ENTSOC">Entrada sin orden de compra</option>
								<option value="ENTCOC">Entrada con orden de compra</option>
							</select>
						</div>
					</div>
					
					<div class=" text-right">
						<button type="button" class="btn btn-danger" id="btn_SIS001" onclick="generarReporte(this)">Descargar Reporte</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>