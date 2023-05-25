<div class="modal fade fullscreen-modal" id="modal-mSIS003" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
				<div>
					<h4 class="modal-title" id="exampleModalLabel">Reportes | Cambio de precios por departamento V2</h4>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label for="sucursal_SIS003">*Sucursal:</label>
							<select name="sucursal_SIS003" id="sucursal_SIS003" class="form-control select">
								<option value=""></option>
								<option value="1">Díaz Ordaz</option>
								<option value="2">Arboledas</option>
								<option value="3">Villegas</option>
								<option value="4">Allende</option>
								<option value="5">Petaca</option>
								<option value="6">Montemorelos</option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<label>Departamento</label>
						<select class="form-control" id="departamento_SIS003" name="departamento_SIS003">
							<option value=""></option>
						</select>
					</div>
				</div>
				<br>
				<div class="text-right">
					<button id="btnDatos_SIS003" class="btn btn-danger">Mostrar Datos</button>
				</div>
				<div class="">
					<div class="">
						<h3 class="box-title">Lista de artículos</h3>
					</div>
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="lista_articulos_SIS003" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>Código</th>
												<th>Descripción</th>
												<th>F. Penúltima Ent.</th>
												<th>F. Última Ent.</th>
												<th>Costo Penúltima Ent.</th>
												<th>Costo Última Ent.</th>
												<th>Diferencia</th>
												<th>Cant. Última Ent.</th>
												<th>U.M.</th>
												<th>IVA</th>
												<th>IEPS</th>
												<th>P. Público</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
  .fullscreen-modal .modal-dialog {
  margin: 0;
  margin-right: auto;
  margin-left: auto;
  width: 100%;
}
@media (min-width: 768px) {
  .fullscreen-modal .modal-dialog {
    width: 750px;
  }
}
@media (min-width: 992px) {
  .fullscreen-modal .modal-dialog {
    width: 970px;
  }
}
@media (min-width: 1200px) {
  .fullscreen-modal .modal-dialog {
     width: 1170px;
  }
}
</style>