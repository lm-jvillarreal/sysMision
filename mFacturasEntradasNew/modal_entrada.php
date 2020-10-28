<div class="modal fade" id="modal_entrada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4>Datos de Entrada</h4>
			</div>
			<div class="modal-body">
			<form action="" method="POST" id="frmDatosEntradaDos">
				<div class="">
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3>Inserte los datos solicitados</h3>
						        </div>
						        <div class="panel-body">
									<div class="form-group">
											<!-- <input type="hidden" name="folio_mov" id="folio"> -->
											<!-- <input type="hidden" id="tipo_mov" name="tipo_mov"> -->
											<!-- <input type="hidden" id="sucursal" name="sucursal"> -->
											<label>Sucursal</label>
											<select name="sucursal" class="form-control
												<option value="1">Diaz Ordaz</option>
												<option value="2">Arboledas</option>
												<option value="3">Villegas</option>
												<option value="4">Allende</option>
											</select>
											<label>Tipo entrada</label>
											<select name="tipo_mov" class="form-control">
												<option value="ENTSOC">Entrada sin orden</option>
												<option value="ENTCOC">Entrada con orden</option>
											</select>
											<label>Folio entrada</label>
											<input type="text" name="folio_mov" class="form-control" id="folio_entrada_dos">
											<label>Total entrada</label>
											<input type="text" class="form-control" name="total_entrada">
										
										<!-- <label for="area">Proveedor:</label>
										<input readonly type="text" name="proveedor" class="form-control" id="proveedor">
										<label for="">Referencia:</label>
										<input name="factura" readonly id="factura" type="text" class="form-control">
										<div class="col-sm-6">
											<label for="iva">IVA:</label>
											<input readonly type="text" id="iva" class="form-control">
										</div>
										<div class="col-sm-6">
											<label for="iva">IEPS:</label>
											<input readonly type="text" id="ieps" class="form-control">
										</div> -->

										
									</div>
<!-- 									<div class="col-sm-5">
										<label for="">Subtotal:</label>
										<input name="subtotal" id="subtotal" type="text" readonly class="form-control">
									</div>
									<div class="col-sm-5">
										<label for="">Total de Factura:</label>
										<input name="total_factura" id="total_fac" type="text" class="form-control">
									</div>
									<div class="col-sm-5">
										<label for="">Total:</label>
										<input name="total_entrada" id="total_entrada" readonly type="text" class="form-control">
									</div>
						        </div> -->
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<div class="modal-footer">
				<!-- <button type="button" class="btn btn-default"  data-dismiss="modal">Cerrar</button> -->
				<button class="btn btn-success" id="guardar" data-dismiss="modal" onclick="javascript:insertar_otra();">Guardar</button>
				<!-- <a href="javascript:insert();" class="btn btn-danger">Guardar</a> -->
			</div>
		</div>
	</div>
</div>