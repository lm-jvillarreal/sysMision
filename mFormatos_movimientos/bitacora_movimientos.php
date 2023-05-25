<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha      = date('Y-m-d');
$nuevafecha = strtotime('+1 day', strtotime($fecha));
$nuevafecha = date('Y-m-d', $nuevafecha);
$hora       = date('h:i:s');
$prim_dia   = date('Y-m-01');
?>
<!DOCTYPE html>
<html>

<head>
	<?php include '../head.php'; ?>
</head>

<body class="hold-transition skin-red sidebar-mini">
	<div class="wrapper">

		<header class="main-header">
			<?php include '../header.php'; ?>
		</header>
		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<?php include 'menuV3.php'; ?>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<!-- Main content -->
			<section class="content">
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Lista de faltantes registrados</h3>
					</div>
					<div class="box-body">
						<form method="POST" id = "form_datos">
                  			<div class="row">
                    			<div class="col-md-3">
                      				<div class="form-group">
                        				<label for="fecha_inicio">*Fecha Inicio: </label>
                        				<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicial" data-link-format="yyyy-mm-dd">
                          					<input class="form-control" size="16" type="text" value="<?php echo $prim_dia?>" id="fecha_inicial" name="fecha_inicial">
                          					<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                          					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        				</div>
                      				</div>
                    			</div>
                    			<div class="col-md-3">
                      				<div class="form-group">
                        				<label for="fecha_final">*Fecha final:</label>
                        				<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_final" data-link-format="yyyy-mm-dd">
                          					<input class="form-control" size="16" type="text" value="<?php echo $fecha?>" id="fecha_final" name="fecha_final">
                          					<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                          					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        				</div>
                      				</div>
                    			</div>
                  			</div>
                		</form>
					</div>
					<div class="box-footer text-right">
						<button class="btn btn-danger" id="btn-generar">Generar</button>
              		</div>
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="lista_codigos" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th width='5%'>#</th>
												<th>Movimiento</th>
												<th width='10%'>Sucursal</th>
												<th width='10%'>Estatus</th>
												<th width='10%'>Fecha</th>
												<th width='20%'>Solicita</th>
												<th width='20%'>Libera</th>
												<th width='5%'>Infofin</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>#</th>
												<th>Movimiento</th>
												<th>Sucursal</th>
												<th>Estatus</th>
												<th>Fecha</th>
												<th>Solicita</th>
												<th>Libera</th>
												<th>Infofin</th>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /.row -->
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
		<?php include '../footer2.php'; ?>

		<!-- Control Sidebar -->

		<!-- /.control-sidebar -->
		<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
		<div class="control-sidebar-bg"></div>
	</div>
	<!-- ./wrapper -->

	<?php include '../footer.php'; ?>
	<!-- Page script -->
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
	<script>
		$(document).ready(function(e) {
			cargar_tabla();
		});
		$("#btn-generar").click(function() {
			cargar_tabla(1);
		})
		function cargar_tabla(parametro) {
			var fecha_inicial = $("#fecha_inicial").val();
			var fecha_final = $("#fecha_final").val();
			$('#lista_codigos').dataTable().fnDestroy();
			$('#lista_codigos').DataTable({
				'language': {
					"url": "../plugins/DataTables/Spanish.json"
				},
				"paging": false,
				"dom": 'Bfrtip',
				buttons: [{
						extend: 'pageLength',
						text: 'Registros',
						className: 'btn btn-default'
					},
					{
						extend: 'excel',
						text: 'Exportar a Excel',
						className: 'btn btn-default',
						title: 'FaltantesLista',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'FaltantesLista',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'copy',
						text: 'Copiar registros',
						className: 'btn btn-default',
						copyTitle: 'Ajouté au presse-papiers',
						copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
						copySuccess: {
							_: '%d lignes copiées',
							1: '1 ligne copiée'
						}
					}
				],
				"ajax": {
					"type": "POST",
					"url": "tabla_bitacora.php",
					"dataSrc": "",
					"data": {
          				fecha_final: fecha_final,
          				fecha_inicial: fecha_inicial,
            			parametro: parametro
        			}
				},
				"columns": [{
						"data": "id"
					},
					{
						"data": "movimiento"
					},
					{
						"data": "sucursal"
					},
					{
						"data": "estatus"
					},
					{
						"data": "fecha"
					},
					{
						"data": "solicita"
					},
					{
						"data": "libera"
					},
					{
						"data": "folio"
					}
				]
			});
		}
		$('#tipo_formato').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			//minimumResultsForSearch: Infinity
		})
	</script>
</body>

</html>