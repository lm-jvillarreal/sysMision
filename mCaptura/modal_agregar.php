<div class="modal fade" id="agregar_p" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4>Modificar cantidad</h4>
			</div>
			<div class="modal-body">
			<form action="" method="POST" id="frmArticulo_extra">
				<div class="container">
					<div class="row">
						<div class="col-sm-5">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3>Inserte los datos solicitados</h3>
						        </div>
						        <div class="panel-body">
									<div class="form-group">
										<input type="hidden" id="id_mapeoModal" name="id_mapeo">
										<label for="codigo">Codigo</label>
										<input type="text" id="txtCodProd" onchange="javascript:consulta_codigo($(this).val())" name="codigo" class="form-control">
										<br>
										<label for="descripcion">Descripcion</label>
										<input type="text" readonly id="descripcionM" class="form-control" name="descripcion">
										<br>
										<label for="cantidad">Cantidad</label>
										<input type="text" id="cantidadM" name="cantidad" class="form-control">
									</div>
						        </div>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default"  data-dismiss="modal">Cerrar</button>
				<button class="btn btn-success" id="guardar" data-dismiss="modal" onclick="javascript:insert_extra($('#id_mapeoModal').val());">Agregar</button>
				<!-- <a href="javascript:insert();" class="btn btn-danger">Guardar</a> -->
			</div>
		</div>
	</div>
</div>
