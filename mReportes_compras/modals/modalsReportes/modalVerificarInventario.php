<div class="modal fade fullscreen-modal" id="modal-VerificadorInventario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
                <div>
                    <h4 class="modal-title" id="exampleModalLabel">Compras | Historial de Movimientos</h4>
                </div>
            </div>
            <div class="modal-body">
				<div class="box-body">
					<!-- <form method="POST" id="form-catalogo-VI" enctype="multipart/form-data"> -->
					<form method="POST" id="COM010" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="documento">*Documento</label>
									<input name="action" type="hidden" value="upload" id="action" />
									<input type="file" name="file">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="fecha_inicio">*Fecha inicial:</label>
									<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicial" data-link-format="yyyy-mm-dd">
										<input class="form-control" size="16" type="text" value="" readonly id="fecha_inicial" name="fecha_inicial">
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="fecha_fin">*Fecha final:</label>
									<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_final" data-link-format="yyyy-mm-dd">
										<input class="form-control" size="16" type="text" value="" readonly id="fecha_final" name="fecha_final">
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									</div>
								</div>
							</div>
							<div class="col-lg-3">
								<label for="sucursal-VI">*Sucursal:</label>
								<select name="sucursal-VI" class="form-control" id="sucursal-VI">
									<option value=""></option>
								</select>
							</div>
						</div>
						<br>
						<div class="box-footer text-right">
							<button class="btn btn-warning" id="btnCargarFolio">Importar códigos</button>
						</div>
					</div>
					<div class=" ">
						<div class="box-header">
							<h3 class="box-title">Lista de Folios Existentes</h3>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-md-12">
									<div class="table-responsive">
										<table id="lista_folios-VI" class="table table-striped table-bordered" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th width="10%">Folio</th>
													<th>Rango de fechas</th>
													<th width="10%">Cantidad</th>
													<th width="15%">Fecha</th>
													<th width="15%">Sucursal</th>
													<th width="15%">Usuario</th>
													<th width="10%"></th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>