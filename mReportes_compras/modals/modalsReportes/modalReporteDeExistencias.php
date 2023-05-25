<div class="modal fade" id="modal-ReporteExistencias" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button style="float: right;" type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
                <div>
                    <h4 class="modal-title" id="exampleModalLabel">Compras | Reporte de existencias</h4>
                </div>
            </div>
            <div class="modal-body" style="max-height: calc(200vh - 210px); overflow-y: auto;">
				<form method="POST"  id="COM012">
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<table id="tablaReportesConsolidados" class="table table-bordered">
									<thead>
										<tr>
											<th width='10%'>Clave</th>
											<th>Reporte</th>
											<th width='5%'></th>
										</tr>
									</thead>
									<tbody>
										<tr><form action="" method="POST"></form>
											<td>001</td>
											<td>Generar reporte (Baja)</td>
											<form action="reportes2/rpt_COM012_teoricos_baja.php" method="POST">
												<th><button id="btn-reporte_baja" class="btn btn-danger"><i class="fa fa-file-excel-o"></i></button></th>
											</form>
										</tr>
										<tr>
											<td>002</td>
											<td>Generar reporte (Restaurant)</td>
											<form action="reportes2/rpt_COM012_teoricos_restaurant.php" method="POST">
											<th><button id="btn-reporte_baja" class="btn btn-success"><i class="fa fa-file-excel-o"></i></button></th>
											</form>
										</tr>
										<tr>
											<td>003</td>
											<td>Generar reporte (Alta)</td>
											<form action="reportes2/rpt_COM012_teoricos.php" method="POST">
											<th><button id="btn-reporte" class="btn btn-warning"><i class="fa fa-file-excel-o"></i></button></th>
											</form>
										</tr>
										<tr>
											<td>004</td>
											<td>Generar reporte (Separados)</td>
											<form action="reportes2/rpt_COM012_teoricos_separados.php" method="POST">
											<th><button id="btn-reporte_separados" class="btn btn-primary"><i class="fa fa-file-excel-o"></i></button></th>
											</form>
										</tr>
										<tr>
											<td>005</td>
											<td>Generar reporte (203 - Ropa)</td>
											<form action="reportes2/rpt_COM012_teoricos_cedisRopa.php" method="POST">
											<th><button id="btn-reporte_separados" class="btn btn-default"><i class="fa fa-file-excel-o"></i></button></th>
											</form>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</form>
			</div>
        </div>
    </div>
</div>
