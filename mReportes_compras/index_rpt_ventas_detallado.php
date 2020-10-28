<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha = date("Y-m-d");
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
			<?php include 'menuV.php'; ?>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<!-- Main content -->
			<section class="content">
				<form method="POST" id="form-datos" action="rpt_ventas_detallado.php">
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Reportes | Detalle de Ventas</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="fecha_inicio">*Fecha:</label>
									<div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha" data-link-format="yyyy-mm-dd">
										<input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha" name="fecha">
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="sucursal">*Sucursal:</label>
									<select name="sucursal" id="sucursal" class="form-control select2">
										<option value=""></option>
										<option value="1">Díaz Ordaz</option>
										<option value="2">Arboledas</option>
										<option value="3">Villegas</option>
										<option value="4">Allende</option>
										<option value="5">Petaca</option>
                    <option value="99">CEDIS</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer text-right">
						<input type="submit" value="Generar Reporte" class="btn btn-danger">
					</div>
				</div>
				</form>
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
	<script type="text/javascript">
		$(document).ready(function() {
			$('#sucursal').select2({
				placeholder: 'Seleccione una opcion',
				lenguage: 'es',
				minimumResultsForSearch: Infinity
			});
		});

		function cargar_tabla() {
			var sucursal = $("#sucursal").val();
			var fech = $("#fecha").val();
			$('#lista_ventas').dataTable().fnDestroy();
			$('#lista_ventas').DataTable({
				'language': {
					"url": "../plugins/DataTables/Spanish.json"
				},
				"paging": false,
				select: {
					style: 'multi'
				},
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
						title: 'RepVentasDetalle',
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
					"url": "tabla_ventas_detallado.php",
					"dataSrc": "",
					"data": {sucursal: sucursal, fech: fech}
				},
				"columns": [{
						"data": "codigo"
					},
					{
						"data": "descripcion"
					},
					{
						"data": "cantidad"
					},
					{
						"data": "familia"
					},
					{
						"data": "operacion"
					},
					{
						"data": "fecha"
					},
					{
						"data": "hora"
					}
				]
			});
		}
		$('.form_date').datetimepicker({
			language: 'es',
			weekStart: 1,
			todayBtn: 1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			minView: 2,
			forceParse: 0
		});
	</script>
</body>

</html>