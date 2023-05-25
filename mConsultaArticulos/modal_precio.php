<div class="modal fade" id="modal_precio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4>Detalle del artículo</h4>
			</div>
			<div class="modal-body">
			<form action="" method="POST" id="formulario_editar">
				<div class="container">
					<div class="row">
						<div class="col-sm-5">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3>Precio público</h3>
						        </div>
						        <div class="panel-body">
									<div class="form-group">
										<label for="">Diaz Ordaz</label>
										<input readonly type="text" class="form-control" id="do_precio">
										<label for="codigo">Arboledas</label>
										<input type="text" id="arb_precio" name="arb_precio" class="form-control" readonly>
										<br>
										<label for="descripcion">Villegas</label>
										<input type="text" readonly id="vill_precio" class="form-control">
										<br>
										<label for="cantidad">Allende</label>
										<input readonly type="text" id="all_precio" name="arb_precio" class="form-control">
                    					<br>
										<label for="cantidad">Petaca</label>
										<input readonly type="text" id="pet_precio" name="arb_precio" class="form-control">
										<br>
										<label for="cantidad">Montemorelos</label>
										<input readonly type="text" id="mm_precio" name="arb_precio" class="form-control">
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
