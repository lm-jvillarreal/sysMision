<?php
include '../global_seguridad/verificar_sesion.php';
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
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Catálogo de actividades | Registro</h3>
					</div>
					<div class="box-body">
						<form action="" method="POST" id="form-catalogo">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="actividad">*Actividad</label>
										<input type="text" name="actividad" id="actividad" class="form-control" placeholder="Inserta una actividad">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="areas">*Areas</label>
										<select name="areas" id="areas" class="form-control">
											<option value=""></option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="bootstrap-timepicker">
										<div class="form-group">
											<label>Límite Inferior - DO:</label>
											<div class="input-group">
												<input type="text" class="form-control timepicker" id="ini_do" name="ini_do">

												<div class="input-group-addon">
													<i class="fa fa-clock-o"></i>
												</div>
											</div>
											<!-- /.input group -->
										</div>
										<!-- /.form group -->
									</div>
								</div>
								<div class="col-md-3">
									<div class="bootstrap-timepicker">
										<div class="form-group">
											<label>Límite Superior - DO:</label>
											<div class="input-group">
												<input type="text" class="form-control timepicker" id="fin_do" name="fin_do">

												<div class="input-group-addon">
													<i class="fa fa-clock-o"></i>
												</div>
											</div>
											<!-- /.input group -->
										</div>
										<!-- /.form group -->
									</div>
								</div>
								<div class="col-md-3">
									<div class="bootstrap-timepicker">
										<div class="form-group">
											<label>Límite Inferior - ARB:</label>
											<div class="input-group">
												<input type="text" class="form-control timepicker" id="ini_arb" name="ini_arb">

												<div class="input-group-addon">
													<i class="fa fa-clock-o"></i>
												</div>
											</div>
											<!-- /.input group -->
										</div>
										<!-- /.form group -->
									</div>
								</div>
								<div class="col-md-3">
									<div class="bootstrap-timepicker">
										<div class="form-group">
											<label>Límite Superior - ARB:</label>
											<div class="input-group">
												<input type="text" class="form-control timepicker" id="fin_arb" name="fin_arb">

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
							<div class="row">
								<div class="col-md-3">
									<div class="bootstrap-timepicker">
										<div class="form-group">
											<label>Límite Inferior - Vill:</label>
											<div class="input-group">
												<input type="text" class="form-control timepicker" id="ini_vill" name="ini_vill">

												<div class="input-group-addon">
													<i class="fa fa-clock-o"></i>
												</div>
											</div>
											<!-- /.input group -->
										</div>
										<!-- /.form group -->
									</div>
								</div>
								<div class="col-md-3">
									<div class="bootstrap-timepicker">
										<div class="form-group">
											<label>Límite Superior - Vill:</label>
											<div class="input-group">
												<input type="text" class="form-control timepicker" id="fin_vill" name="fin_vill">

												<div class="input-group-addon">
													<i class="fa fa-clock-o"></i>
												</div>
											</div>
											<!-- /.input group -->
										</div>
										<!-- /.form group -->
									</div>
								</div>
								<div class="col-md-3">
									<div class="bootstrap-timepicker">
										<div class="form-group">
											<label>Límite Inferior - All:</label>
											<div class="input-group">
												<input type="text" class="form-control timepicker" id="ini_all" name="ini_all">

												<div class="input-group-addon">
													<i class="fa fa-clock-o"></i>
												</div>
											</div>
											<!-- /.input group -->
										</div>
										<!-- /.form group -->
									</div>
								</div>
								<div class="col-md-3">
									<div class="bootstrap-timepicker">
										<div class="form-group">
											<label>Límite Superior - All:</label>
											<div class="input-group">
												<input type="text" class="form-control timepicker" id="fin_all" name="fin_all">

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
							<div class="row">
								<div class="col-md-3">
									<div class="bootstrap-timepicker">
										<div class="form-group">
											<label>Límite Inferior - PETACA:</label>
											<div class="input-group">
												<input type="text" class="form-control timepicker" id="ini_pet" name="ini_pet">

												<div class="input-group-addon">
													<i class="fa fa-clock-o"></i>
												</div>
											</div>
											<!-- /.input group -->
										</div>
										<!-- /.form group -->
									</div>
								</div>
								<div class="col-md-3">
									<div class="bootstrap-timepicker">
										<div class="form-group">
											<label>Límite Superior - PETACA</label>
											<div class="input-group">
												<input type="text" class="form-control timepicker" id="fin_pet" name="fin_pet">

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
						</form>
					</div>
					<div class="box-footer text-right">
						<button class="btn btn-danger" id="btn-guardar">Guardar Registro</button>
					</div>
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
												<th>Area</th>
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
												<th>Area</th>
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
	<!-- Page script -->
	<script src="../d_plantilla/plugins/timepicker/bootstrap-timepicker.min.js"></script>
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
		$('#areas').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: Infinity,
			ajax: {
				url: "consulta_areas.php",
				type: "post",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						searchTerm: params.term // search term
					};
				},
				processResults: function(response) {
					return {
						results: response
					};
				},
				cache: true
			}
		});
		$('.timepicker').timepicker({
			showInputs: false,
			showMeridian: false,
			dynamic: false,
			dropdown: true,
			scrollbar: true
		});
		$("#btn-guardar").click(function() {
			var url = "insertar_actividades.php";
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: $("#form-catalogo").serialize(),
				success: function(respuesta) {
					alertify.success("Etiquetas solicitadas correctamente");
					$(":text").val("");
				},
				error: function(xhr, status) {
					alert("error");
				}
			});
			cargar_tabla();
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
					"url": "tabla_catalogo.php",
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
						"data": "area"
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