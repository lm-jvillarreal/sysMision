<?php
include '../global_seguridad/verificar_sesion.php';
$folio = $_GET['folio'];

$cadena_receta = "SELECT c.folio, 
								CONCAT(p.nombre, ' ',p.ap_paterno,' ',p.ap_materno) as 'Paciente',
								p.sexo,
								DATE_FORMAT(c.fecha, '%d/%m/%Y') as 'Dia Consulta'
								FROM receta as c INNER JOIN pacientes as p ON c.id_pacientes = p.id
								AND c.folio = '$folio'
								GROUP BY c.folio
								ORDER BY c.fecha DESC";
$consulta_receta = mysqli_query($conexion, $cadena_receta);
$row_receta = mysqli_fetch_array($consulta_receta);
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
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Lista de Recetas</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label for="folio_receta">*Folio</label>
									<input type="text" name="folio_receta" id="folio_receta" class="form-control" readonly='true' value="<?php echo $row_receta[0]; ?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="paciente">*Paciente</label>
									<input type="text" name="paciente" id="paciente" class="form-control" readonly='true' value="<?php echo $row_receta[1]; ?>">
								</div>
							</div>
						</div>
						<?php
						$cadena_detalle = "SELECT id, nombre_generico, nombre_farmacia, dosis, presentacion, via_adm, duracion_tratamiento, notas FROM receta WHERE folio = '$row_receta[0]'";
						//echo $cadena_detalle;
						$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
						while ($row_detalle = mysqli_fetch_row($consulta_detalle)) {
							?>
							<div class="row">
								<input type="hidden" name="id[]" value="<?php echo $row_detalle[0]; ?>" class="form-control">
								<div class="col-md-2">
									<div class="form-group">
										<input type="text" name="nombre_generico[]" id="nombre_generico" value="<?php echo $row_detalle[1]; ?>" class="form-control">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<input type="text" name="nombre_farmacia[]" id="nombre_farmacia" class="form-control" value="<?php echo $row_detalle[2]; ?>">
									</div>
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<input type="text" name="dosis[]" id="dosis" class='form-control' value="<?php echo $row_detalle[3]; ?>">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<input type="text" name="presentacion[]" id="presentacion" class='form-control' value="<?php echo $row_detalle[4]; ?>">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<input type="text" name="via_adm[]" id="via_adm" class='form-control' value="<?php echo $row_detalle[5]; ?>">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<input type="text" name="duracion[]" id="duracion" class='form-control' value="<?php echo $row_detalle[6]; ?>">
									</div>
								</div>
							</div>
						<?php
						}
						?>

					</div>
					<div class="box box-footer text-right">
						<button class="btn btn-warning" id="btn-guardar">Guardar cambios</button>
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
						"data": "id"
					},
					{
						"data": "paciente"
					},
					{
						"data": "sexo"
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
	</script>
</body>

</html>