<div class="modal fade" id="modal-mSIS002" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
				<div>
					<h4 class="modal-title" id="exampleModalLabel">Reportes | Cambio de precios por departamento</h4>
				</div>
			</div>
			<div class="modal-body" style="max-height: calc(200vh - 110px); overflow-y: auto;">
				<form method="POST" id="SIS002">		
					<div class="row">
						<div class="col-lg-3">
							<div class="form-group">
								<label for="sucursal_SIS002">*Sucursal:</label>
								<select name="sucursal_SIS002" id="sucursal_SIS002" class="form-control select">
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
						<div class="col-lg-3">
							<div class="form-group">
								<label>Departamento:</label>
								<select class="form-control no-validar" id="departamento_SIS002" name="departamento_SIS002">
									<option value=""></option>
								</select>
							</div>												
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="proveedor_SIS002">Proveedor:</label>
								<select name="proveedor_SIS002" id="proveedor_SIS002" class="form-control select2 no-validar">
									<option value=""></option>
								</select>
							</div>							
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Archivo:</label>
                                <input class="form-control no-validar" type="file" name="excel">
                            </div>
                        </div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="">Codigos</label>
								<input type="text" name="array_SIS002" class="form-control no-validar" id="array_cambio_SIS002">
							</div>							
						</div>
					</div>
						
					<div class=" text-right">
						<a href="javascript:subir_excel_SIS002($('#frmDatosComprasVsVentas').attr('id'), $('#array_compras_vs').attr('id'))" class="btn btn-danger">Subir</a>
						<button type="button" class="btn btn-danger" id="btn_SIS002" onclick="generarReporte(this)">Descargar Reporte</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>