<div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4>Editar renglon</h4>
			</div>
			<div class="modal-body">
			<form action="" method="POST" id="frmDatosRenglon">
				<div class="">
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3>Inserte los datos solicitados</h3>
						        </div>
						        <div class="panel-body">
									<div class="form-group">
										<input type="hidden" name="txtIdRenglon" id="txtIdRenglon">
										<label for="area">Codigo del producto</label>
										<input type="text" id="txtCodProd" onchange="javascript:consulta_codigo()" name="txtCodProd" class="form-control">
										<label>Descripcion</label>
										<input type="text" name="txtDescripcion" readonly class="form-control" id="txtDescripcionM">
										<label>Consecutivo</label>
										<input type="text" class="form-control" name="txtConsecutivo" id="txtConsecutivo">					
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
				<button class="btn btn-success" id="guardar" data-dismiss="modal" onclick="javascript:edit_renglon();">Guardar</button>
				<!-- <a href="javascript:insert();" class="btn btn-danger">Guardar</a> -->
			</div>
		</div>
	</div>
</div>