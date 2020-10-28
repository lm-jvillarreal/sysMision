<div class="modal fade" id="modal_carta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4>Datos de Entrada</h4>
			</div>
			<div class="modal-body">
			<form action="" method="POST" id="formulario">
				<div class="">
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3>Inserte los datos solicitados</h3>
						        </div>
						        <div class="panel-body">
									<div class="form-group">
										<input type="hidden" name="folio_mov" id="folio">
										<input type="hidden" id="tipo_mov" name="tipo_mov">
										<input type="hidden" id="sucursal" name="sucursal">
										<label for="">Folio Carta</label>
										<input type="text" name="" onchange="javascript:consulta_carta($(this).val())" class="form-control" id="folio_carta">
										<label for="area">Proveedor:</label>
										<input readonly type="text" name="proveedor" class="form-control" id="proveedor2">
										<label for="">Factura:</label>
										<input name="factura" readonly id="factura2" type="text" class="form-control">
										<div class="col-sm-6">
											<label for="iva">Total Carta:</label>
											<input readonly type="text" id="total_carta" class="form-control">
										</div>
									</div>
						        </div>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<div class="modal-footer">
				<!-- <button type="button" class="btn btn-default"  data-dismiss="modal">Cerrar</button> -->
				<button class="btn btn-success" id="guardar" data-dismiss="modal" onclick="javascript:guardar_relacion($('#folio_carta').val(), $('#total_carta').val());">Guardar</button>
			</div>
		</div>
	</div>
</div>
