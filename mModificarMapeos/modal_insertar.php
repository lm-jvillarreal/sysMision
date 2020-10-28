<div class="modal fade" id="modal_insertar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4>Modificar mapeo</h4>
			</div>
			<div class="modal-body">
			<form action="" method="POST" id="frmInsertFields">
				<div class="container">
					<div class="row">
						<div class="col-sm-5">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3>Inserte los datos solicitados</h3>
						        </div>
						        <div class="panel-body">
									<div class="form-group">
										<label for="zona">Nivel:</label>
										<input type="text" name="estante" id="nivel_insert"  class="form-control">
										<label for="mueble">Consecutivo:</label>
										<input type="text" name="consecutivo" id="consecutivo_insert" class="form-control">
										<label for="cara">Codigo del poducto</label>
										<input type="text" id="txtCodProd" onchange="javascript:consulta_codigo2($(this).val())" name="codigo" class="form-control">
										<label for="mueble">Descripcion:</label>
										<input type="text" name="descripcion" id="descripcion_insert" class="form-control" readonly="true">
										<input type="hidden" id="id_detalleN" name="id_detalleN">
										<input type="hidden" id="id_mapeo_modal" name="id_mapeo">
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
				<button class="btn btn-success" id="guardar" data-dismiss="modal" onclick="javascript:ex_insert_fields($('#id_mapeo_modal').val());">Guardar</button>
				<!-- <a href="javascript:insert();" class="btn btn-danger">Guardar</a> -->
			</div>
		</div>
	</div>
</div>
