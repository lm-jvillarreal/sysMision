<?php
include '../global_seguridad/verificar_sesion.php';
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

			<?php include 'menuV2.php'; ?>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<!-- Main content -->
			<section class="content">
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Lista de Consultas | Complemento de Recetas</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="lista_recetas" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th width="5%">Turno</th>
												<th>Paciente</th>
												<th width='10%'>Edad</th>
												<th width='15%'>Malestar</th>
												<th width='15%'>Diagnostico</th>
												<th width='5%'>Fecha</th>
												<th width='5%'></th>
											</tr>
										</thead>
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
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
	<!-- Page script -->
	<script>
		function cargar_tabla() {
			var paciente = $("#Paciente").val();
			$('#lista_recetas').dataTable().fnDestroy();
			$('#lista_recetas').DataTable({
				'language': {
					"url": "../plugins/DataTables/Spanish.json"
				},
				"paging": true,
				"order": [
					[0, "desc"]
				],
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
						title: 'FaltantesComprador',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'CostosCero',
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
					},
				],
				"ajax": {
					"type": "POST",
					"url": "tabla_recetas.php",
					"dataSrc": "",
					"data": ""
				},
				"columns": [{
						"data": "turno"
					},
					{
						"data": "paciente"
					},
					{
						"data": "edad"
					},
					{
						"data": "malestar"
					},
					{
						"data": "diagnostico"
					},
					{
						"data": "fecha"
					},
					{
						"data": "editar"
					}
				]
			});
		}
		$(document).ready(function() {
			cargar_tabla();
		});

		function consulta_articulos() {
			var ancho_ventana = 750;
			var alto_ventana = 768;
			var window_left = (screen.width - ancho_ventana - 12) / 2;
			var window_top = (screen.height - alto_ventana - 57) / 2;
			pop2 = window.open("articulos_farmacia.php", "ventana", "width=" + ancho_ventana + ",height=" + alto_ventana + ",top=" + window_top + ",screenY=" + window_top + ",left=" + window_left + ",screenX=" + window_left + "");
			pop2.focus();
		}

		function historial_consultas() {
			var ancho_ventana = 750;
			var alto_ventana = 768;
			var window_left = (screen.width - ancho_ventana - 12) / 2;
			var window_top = (screen.height - alto_ventana - 57) / 2;
			pop2 = window.open("consultas_pacientes.php", "ventana", "width=" + ancho_ventana + ",height=" + alto_ventana + ",top=" + window_top + ",screenY=" + window_top + ",left=" + window_left + ",screenX=" + window_left + "");
			pop2.focus();
		}
	</script>
</body>

</html>