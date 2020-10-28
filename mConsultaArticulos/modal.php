<div class="modal fade" id="modificar_cantidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4>Detalles del codigo</h4>
			</div>
			<div class="modal-body">
			<form action="" method="POST" id="formulario_editar">
				<div class="container">
					<div class="row">
						<div class="col-sm-5">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3>Detalle del articulo</h3>
						        </div>
						        <div class="panel-body">
									<div class="form-group">
										<label for="">Estatus</label>
										<input readonly type="text" class="form-control" id="estatus">
										<label for="codigo">Departamento</label>
										<input  type="text" id="modal_dpto" name="codigo" class="form-control" readonly>
										<br>
										<label for="descripcion">Familia</label>
										<input  type="text" readonly id="modal_familia" class="form-control">
										<br>
										<label for="cantidad">Unidad de medida</label>
										<input readonly type="text" id="modal_um" name="cantidad" class="form-control">
										<label for="">Fecha de alta</label>
										<input readonly type="text" class="form-control" id="fecha_alta">
										<label for="">Clave SAT</label>
										<input readonly type="text" class="form-control" id="cve_sat">
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
				
			</div>
		</div>
	</div>
</div>
