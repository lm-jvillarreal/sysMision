<div class="modal fade" id="modal-mOPE011" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
				<div>
					<h4 class="modal-title" id="exampleModalLabel">Ventas por departamento | Parámetros</h4>
				</div>
			</div>
			<div class="modal-body" style="max-height: calc(200vh - 110px); overflow-y: auto;">
				<div class="row">
					<div class="col-md-3">
						<label>Periodo 1</label>
					</div>
					<div class="col-md-3">
					</div>
					<div class="col-md-3">
						<label>Periodo 2</label>
					</div>
					<div class="col-md-3">
					</div>
				</div>
				<div class="row">				<!-- INICIO FECHAS -->
					<div class="col-md-3">						
						<div class="form-group">
							<label for="fecha_inicio">*Fecha de inicio:</label>
							<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fi_now" data-link-format="yyyy-mm-dd">
								<input class="form-control" size="16" type="text" value="<?php echo $fecha; ?>" readonly id="fi_now" name="fi_now">
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
					</div>
					<div class="col-md-3">						
						<div class="form-group">
							<label for="fecha_fin">*Fecha final:</label>
							<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="ff_now" data-link-format="yyyy-mm-dd">
								<input class="form-control" size="16" type="text" value="<?php echo $fecha; ?>" readonly id="ff_now" name="ff_now">
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
					</div>
					<div class="col-md-3">						
						<div class="form-group">
							<label for="fecha_inicio">*Fecha de inicio:</label>
							<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="ff_agi" data-link-format="yyyy-mm-dd">
								<input class="form-control" size="16" type="text" value="<?php echo $fecha_anterior; ?>" readonly id="fi_ago" name="fi_ago">
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
					</div>
					<div class="col-md-3">						
						<div class="form-group">
							<label for="fecha_fin">*Fecha final:</label>
							<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="ff_ago" data-link-format="yyyy-mm-dd">
								<input class="form-control" size="16" type="text" value="<?php echo $fecha_anterior; ?>" readonly id="ff_ago" name="ff_ago">
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
					</div>
				</div>
				<div class="text-right">
					<button id="btn-generar_OPE011" class="btn btn-danger">Generar reporte</button>
				</div>
				<div class="">
					<div class="box-header">
						<h3 class="box-title">Ventas por Departamento</h3>
					</div>					
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="lista_ventas_OPE011" class="table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>DO</th>
											<th>ARB</th>
											<th>VILL</th>
											<th>ALL</th>
											<th>PET</th>
											<th>MMORELOS</th>
											<th>Total</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>DO</th>
											<th>ARB</th>
											<th>VILL</th>
											<th>ALL</th>
											<th>PET</th>
											<th>MMORELOS</th>
											<th>Total</th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>					
				</div><!--Tabla-->
			</div>
		</div>
	</div>
</div>