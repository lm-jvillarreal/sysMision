<div class="modal fade" id="modal-mSIS006" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
				<div>
					<h4 class="modal-title" id="exampleModalLabel">Reportes | IMMEX & DIESTEL</h4>
				</div>
			</div>
			<div class="modal-body">
				<form method="POST" id="SIS006">					
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="fecha_inicio">*Fecha de inicio:</label>
								<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
									<input class="form-control" size="16" type="text" value="" readonly id="fecha_inicial_SIS006" name="fecha_inicial">
									<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="fecha_fin">*Fecha final:</label>
								<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
									<input class="form-control" size="16" type="text" value="" readonly id="fecha_final_SISOO6" name="fecha_final_SISOO6">
									<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
					</div>
					<div class="text-right">
						<a href="javascript:cargar_datos_SIS006()" class="btn btn-danger">Mostrar Datos</a>
					</div>
				</form>
				<div class="">
					<div class="">
						<h3 class="">Datos</h3>
					</div>
					<div class="">
						<form id="frmDatosRef">							
							<div class="table-responsive">
								<table id="datos_SIS006" class="table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th width="5%">Folio</th>
											<th>Referencia</th>
											<th width="15%">Tipo</th>
											<th width="20%">Rango Fechas</th>
											<th width="5%">Detalle</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Folio</th>
											<th>Referencia</th>
											<th>Tipo</th>
											<th>Rango Fechas</th>
											<th>Detalle</th>
										</tr>
									</tfoot>
								</table>
							</div>
						</form>
					</div>
				</div>				
			</div>
		</div>
	</div>
</div>
