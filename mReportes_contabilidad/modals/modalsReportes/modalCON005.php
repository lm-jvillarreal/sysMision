<div class="modal fade" id="modal-mCON005" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
				<div>
					<h4 class="modal-title" id="exampleModalLabel">Reportes | Comprobantes-Transferencias</h4>
				</div>
			</div>
			<div class="modal-body">
				<form method="POST" id="CON005">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="fecha_inicio">*Fecha de inicio:</label>
								<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
									<input class="form-control" size="16" type="text" value="" readonly id="fecha_inicial_CON005" name="fecha_inicial_CON005">
									<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="fecha_fin">*Fecha final:</label>
								<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
									<input class="form-control" size="16" type="text" value="" readonly id="fecha_final_CON005" name="fecha_final_CON005">
									<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
					</div>					
					<div class="">
						<button style="float: lefth;" class="btn btn-warning" id="btn-cargar">Generar Tabla</button>
						<button style="float: right;" type="button" class="btn btn-danger" id="btn_CON005" onclick="generarReporte(this)">Descargar Reporte</button>
					</div>
				</form>
				<br>
				<br>
				<div class="">
					<div class="">
						<h4>Reporte de Transferencias | Listado</h4>
					</div>
					<div class="">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="lista_cheques_CON005" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th width='5%'>#</th>
												<th width='15%'>No. Transferencia</th>
												<th>Proveedor</th>
												<th width='15%'>Monto</th>
												<th width='15%'>Fecha</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>														
			</div>
		</div>
	</div>
</div>