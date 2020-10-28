<div class="modal fade" id="modal_devoluciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4>Datos de Devolucion</h4>
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
										<label for="area">Folio Infofin</label>
										<input type="text" id="txtFilaDev" name="">
										<input type="text" name="txtFolio" class="form-control" id="txtFolioDev">
										<label for="">Tipo de movimiento:</label>
										<select class="form-control" id="cmbTipoDev">
											<option selected disabled>Seleccione...</option>
											<option value="DEVPRO">Devolucion a proveedor</option>
											
										</select>
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
				<button class="btn btn-success" id="guardar" data-dismiss="modal" onclick="javascript:consultar_devolucion($('#txtFolioDev').val(), $('#cmbTipoDev').val(), $('#txtFilaDev').val());">Guardar</button>
				<!-- <a href="javascript:insert();" class="btn btn-danger">Guardar</a> -->
			</div>
		</div>
	</div>
</div>