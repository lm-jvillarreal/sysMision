<div class="modal fade" id="modal_opciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
									<h3>Seleccione una opcion</h3>
						        </div>
						        <div class="panel-body">
									<div class="form-group">
										<input type="hidden" name="folio_mov" id="folio">
										<input type="hidden" id="tipo_mov" name="tipo_mov">
										<input type="hidden" id="sucursal" name="sucursal">
										<input type="text" id="id_nota" name="id_nota">
									</div>
									<div class="col-md-12">
										<input type="radio" name="seleccion" value="1">Registrar diferencia
										<input type="radio" name="seleccion" value="2">Carta faltante
										<input type="radio" name="seleccion" value="3">Descuento global
										<input type="radio" name="seleccion" value="4">Otra entrada
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
				<button class="btn btn-success" id="guardar" data-dismiss="modal" onclick="javascript:filtro();">Guardar</button>
				<!-- <a href="javascript:insert();" class="btn btn-danger">Guardar</a> -->
			</div>
		</div>
	</div>
</div>