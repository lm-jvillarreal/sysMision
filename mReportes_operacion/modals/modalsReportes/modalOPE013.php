<div class="modal fade" id="modal-mOPE013" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
				<div>
					<h4 class="modal-title" id="exampleModalLabel">Reportes | Existencias</h4>
				</div>
			</div>
			<div class="modal-body" style="max-height: calc(200vh - 110px); overflow-y: auto;">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label for="fecha_inicio">*Fecha de inicio:</label>
							<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
								<input class="form-control" size="16" type="text" value="" readonly id="fecha_inicial_OPE013" name="fecha_inicial_OPE013">
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="fecha_fin">*Fecha final:</label>
							<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
								<input class="form-control" size="16" type="text" value="" readonly id="fecha_final_OPE013" name="fecha_final_OPE013">
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="sucursal_OPE013">*Sucursal:</label>
							<select name="sucursal_OPE013" onchange="cargar_cajeros_OPE013()" id="sucursal_OPE013" class="form-control select">
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
						<div class="form-group">
							<label for="sucursal">*Cajero:</label>
							<select name="cajeros_OPE013" id="cajeros_OPE013" class="form-control select2">
								<option value=""></option>
							</select>
						</div>
					</div>
				</div>
				<div class="text-right">
					<button class="btn btn-danger" id="btnConsulta_OPE013">Consultar</button>
				</div>
				<br>
				<div class="row">
					<div class="">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="lista_cancelaciones" class="table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th width='10%'>AAAAMMDD</th>
											<th width="10%">Folio</th>
											<th width="10%">Fecha</th>
											<th width="10%">Cantidad</th>
											<th width='20%'>Cajero</th>
											<th>Causa</th>
											<th width='20%'>Autorizado</th>
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