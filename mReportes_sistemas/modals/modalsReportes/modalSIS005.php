<div class="modal fade" id="modal-mSIS005" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
				<div>
					<h4 class="modal-title" id="exampleModalLabel">Reportes | Diestel</h4>
				</div>
			</div>
			<div class="modal-body" style="max-height: calc(200vh - 110px); overflow-y: auto;">
				<form method="POST" id="SIS005">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="fecha_inicio">*Fecha de inicio:</label>
								<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
									<input class="form-control" size="16" type="text" value="" readonly id="fecha_inicial_SIS005" name="fecha_inicial_SIS005" form="frmDatosRef_SIS005">
									<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="fecha_fin">*Fecha final:</label>
								<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
									<input class="form-control" size="16" type="text" value="" readonly id="fecha_final_SIS005" name="fecha_final_SIS005" form="frmDatosRef_SIS005">
									<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<label>Comentarios</label>
							<input value="<?php echo $row_SIS005[1] ?>" type="text" onblur="insertar_comentarios_diestel_SIS005($(this).val())" class="form-control">
						</div>
					</div>	
					<br>				
					<div class=" text-right">
						<a href="javascript:guardar_SIS005()" class="btn btn-danger">Guardar</a>
						<button type="button" class="btn btn-danger" id="btn_SIS005" onclick="generarReporte(this)">Descargar Reporte</button>
						<a href="javascript:cargar_datos_SIS005()" class="btn btn-danger">Mostrar Datos</a>
					</div>
				</form>
				<div class="">
					<div class="">
						<h3 class="box-title">Datos</h3>
					</div>
					<div class="">
						<form id="frmDatosRef_SIS005">
							<div class="row">
								<div class="col-md-3">
									<label>Referencia</label>
									<input type="text" class="form-control" name="referencia">
									<input type="hidden" name="tipo_SIS005" value="2">
								</div>
							</div>
							<br>
							<div class="table-responsive">
								<table id="datos_SIS005" class="table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th width="5%">Codigo</th>
											<th>Descripcion</th>
											<th width="5%">DO</th>
											<th width="5%">Arb</th>
											<th width="5%">Vill</th>
											<th width="5%">All</th>
											<th width="5%">Pet</th>
											<th width="5%">Total</th>
											<th width="10%">Cap</th>
											<th width="5%">Dif</th>
										</tr>
									</thead>
								</table>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>