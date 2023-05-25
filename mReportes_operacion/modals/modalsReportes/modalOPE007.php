<div class="modal fade" id="modal-mOPE007" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
				<div>
					<h4 class="modal-title" id="exampleModalLabel">Reportes | Días de inventario</h4>
				</div>
			</div>
			<div class="modal-body" style="max-height: calc(190vh - 110px); overflow-y: auto;">
				<form method="POST" id="OPE007">
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
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Proveedor:</label>
								<select class="form-control select no-validar" name="proveedor_OPE007" id="proveedor_OPE007">
									<option></option>
								</select>
								<input type="hidden" id="array_compras_vs" name="array" class="no-validar">
							</div>
						</div>						
					</div>
					<div class="row">
						<div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Archivo:</label>
                                <input class="form-control no-validar" type="file" name="excel">
                            </div>
                        </div>
					</div>
					<div class=" text-right">
						<a href="javascript:subir_excel_OPE007($('#form_datoss').attr('id'), $('#array_compras_vs').attr('id'))" class="btn btn-danger">Subir</a>
						<button type="button" class="btn btn-danger" id="btn_OPE007" onclick="generarReporte(this)">Descargar Reporte</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>