<div class="modal fade" id="modal_datos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
										<label for="">Concepto</label>
										<select name="" id="" class="form-control">
											<option value="Diferencia en precios">Diferencia en precios</option>
										</select>
										<label for="area">Proveedor:</label>
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
										</div>

										
									</div>
									<div class="col-sm-5">
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
						        </div>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<div class="modal-footer">
				<!-- <button type="button" class="btn btn-default"  data-dismiss="modal">Cerrar</button> -->
				<button class="btn btn-success" id="guardar" data-dismiss="modal" onclick="javascript:insertar();">Guardar</button>
				<!-- <a href="javascript:insert();" class="btn btn-danger">Guardar</a> -->
			</div>
		</div>
	</div>
</div>