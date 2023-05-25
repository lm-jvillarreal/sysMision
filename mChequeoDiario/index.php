<?php
include '../global_seguridad/verificar_sesion.php';
$cadena_actividades = "SELECT id, actividad FROM catalogoActividades_vidvig WHERE activo = '1'";
$consulta_actividades = mysqli_query($conexion, $cadena_actividades);
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");

$valida = "SELECT * FROM actividadesDiarias_vidvig WHERE fecha_actividad = '$fecha'";
$consulta_valida = mysqli_query($conexion,$valida);
$row_valida = mysqli_fetch_array($consulta_valida);
$conteo = count($row_valida[0]);
if($conteo>0){
	$estilo = "display: none";
}else{
	$estilo = "";
}
?>
<!DOCTYPE html>
<html>

<head>
	<?php include '../head.php'; ?>
	<link rel="stylesheet" href="../d_plantilla/plugins/timepicker/bootstrap-timepicker.min.css">
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
				<div class="box box-danger" style="<?php echo $estilo;?>">
					<div class="box-header">
						<h3 class="box-title">Registro de perfiles de usuario</h3>
					</div>
					<div class="box-body">
						<form action="" method="POST" id="form-datos">
							<?php
							while ($row_actividades = mysqli_fetch_array($consulta_actividades)) {
								?>
								<div class="row">
									<div class="col-md-2">
										<div class="form-group">
											<label for="actividad">*Actividad</label>
											<input type="hidden" name="id[]" id="id" value="<?php echo $row_actividades[0] ?>">
											<input type="text" name="actividad[]" id="actividad" class="form-control" value="<?php echo $row_actividades[1] ?>" readonly="true">
										</div>
									</div>
									<div class="col-md-2">
										<div class="bootstrap-timepicker">
											<div class="form-group">
												<label>DO:</label>
												<div class="input-group">
													<input type="text" class="form-control timepicker" id="do" name="do[]">

													<div class="input-group-addon">
														<i class="fa fa-clock-o"></i>
													</div>
												</div>
												<!-- /.input group -->
											</div>
											<!-- /.form group -->
										</div>
									</div>
									<div class="col-md-2">
										<div class="bootstrap-timepicker">
											<div class="form-group">
												<label>ARB:</label>
												<div class="input-group">
													<input type="text" class="form-control timepicker" id="arb" name="arb[]">

													<div class="input-group-addon">
														<i class="fa fa-clock-o"></i>
													</div>
												</div>
												<!-- /.input group -->
											</div>
											<!-- /.form group -->
										</div>
									</div>
									<div class="col-md-2">
										<div class="bootstrap-timepicker">
											<div class="form-group">
												<label>Vill:</label>
												<div class="input-group">
													<input type="text" class="form-control timepicker" id="vill" name="vill[]">

													<div class="input-group-addon">
														<i class="fa fa-clock-o"></i>
													</div>
												</div>
												<!-- /.input group -->
											</div>
											<!-- /.form group -->
										</div>
									</div>
									<div class="col-md-2">
										<div class="bootstrap-timepicker">
											<div class="form-group">
												<label>All:</label>
												<div class="input-group">
													<input type="text" class="form-control timepicker" id="all" name="all[]">

													<div class="input-group-addon">
														<i class="fa fa-clock-o"></i>
													</div>
												</div>
												<!-- /.input group -->
											</div>
											<!-- /.form group -->
										</div>
									</div>
									<div class="col-md-2">
										<div class="bootstrap-timepicker">
											<div class="form-group">
												<label>Pet:</label>
												<div class="input-group">
													<input type="text" class="form-control timepicker" id="pet" name="pet[]">

													<div class="input-group-addon">
														<i class="fa fa-clock-o"></i>
													</div>
												</div>
												<!-- /.input group -->
											</div>
											<!-- /.form group -->
										</div>
									</div>
								</div>
							<?php
							}
							?>
						</form>
					</div>
					<div class="box-footer text-right">
						<button class="btn btn-warning" id="btn-guardar">Guardar</button>
					</div>
					</form>
				</div>
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Catálogo de Actividades | Lista de Registros Existentes</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id='lista_actividades' class='table table-striped table-bordered' cellspacing='0' width='100%'>
										<thead>
											<tr>
												<th width='5%'>#</th>
												<th>Actividad</th>
												<th width='12%'>DO</th>
												<th width='12%'>ARB</th>
												<th width='12%'>VILL</th>
												<th width='12%'>ALL</th>
												<th width='12%'>PET</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>#</th>
												<th>Actividad</th>
												<th>DO</th>
												<th>ARB</th>
												<th>VILL</th>
												<th>ALL</th>
												<th>PET</th>
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
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

	<!-- Page script -->
	<script src="../d_plantilla/plugins/timepicker/bootstrap-timepicker.min.js"></script>
	<script>
		$(document).ready(function(e) {
			cargar_tabla();
		});
		$('.timepicker').timepicker({
			showInputs: false,
			showMeridian: false,
			dynamic: false,
			dropdown: true,
			scrollbar: true
		});
		$("#btn-guardar").click(function() {
			var url = "insertar_chequeo.php";
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: $("#form-datos").serialize(),
				success: function(respuesta) {
					if(respuesta=="ya_existe"){
						alertify.error("Ya existe un registro con la fecha actual");
					}else{
						alertify.success("chequeo registrado correctamente");
						//$(":text").val("");
					}
					
				},
				error: function(xhr, status) {
					alert("error");
				}
			});
			//cargar_tabla();
			return false;

		});

		function cargar_tabla() {
			$('#lista_actividades').dataTable().fnDestroy();
			$('#lista_actividades').DataTable({
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
					},
				],
				"ajax": {
					"type": "POST",
					"url": "tabla_chequeo.php",
					"dataSrc": "",
					"data": ""
				},
				"columns": [{
						"data": "id"
					},
					{
						"data": "actividad"
					},
					{
						"data": "rango_do"
					},
					{
						"data": "rango_arb"
					},
					{
						"data": "rango_vill"
					},
					{
						"data": "rango_all"
					},
					{
						"data": "rango_pet"
					}
				]
			});
		}
	</script>
</body>

</html>