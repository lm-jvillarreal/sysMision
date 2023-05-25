<div class="modal fade" id="modal-DetalleCompra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
				<div>
					<h4 class="modal-title" id="exampleModalLabel">Reporte | Detalle Compra</h4>
				</div>
			</div>
			<div class="modal-body" style="max-height: calc(200vh - 110px); overflow-y: auto;">
				<form method="POST" id="COM001">
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
								<label for="sucursal_COM001">*Sucursal:</label>
								<select style=" width: 100%;" name="sucursal_COM001" id="sucursal_COM001" class="form-control select select2">
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
						<div class="col-md-3">
							<div class="form-group">
								<label for="codigo_producto">Código de producto:</label>
								<input type="text" name="codigo_producto" id="codigo_producto" class="form-control no-validar">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
							<label for="proveedor_COM001">Proveedor:</label>
                            <select name="proveedor_COM001" id="proveedor_COM001" class="form-control select2 no-validar">
                                <option value=""></option>
                            </select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="departamento_COM001">Departamento:</label>
								<select name="departamento_COM001" class= "form-control select2 no-validar" id="departamento_COM001" required >
								<option value=""></option>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="tipo_entrada_COM001">*Tipo de Entrada:</label>
								<select style=" width: 100%;" name="tipo_entrada_COM001" id="tipo_entrada_COM001" class="form-control select select2">
									<option value=""></option>
									<option value="ENTCOC">Con Orden de compra</option>
									<option value="ENTSOC">Sin orden de compra</option>
								</select>
							</div>
						</div>
					</div>
					<div class="text-right">
                        <button type="button" class="btn btn-danger" id="btn_COM001" onclick="generarReporte(this)">Descargar Reporte</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>