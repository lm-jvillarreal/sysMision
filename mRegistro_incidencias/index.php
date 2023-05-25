<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha_hoy = date("Y-m-d");
$fecha_inicial = date("Y-m-01");

$hora = date("h:i:s");
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
						<h3 class="box-title">Control de Incidencias | Registro</h3>
					</div>
					<div class="box-body">
						<form action="" mmethod='POST' id="form-datos">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="sucursal">*Sucursal</label>
										<select name="sucursal" id="sucursal" class="form-control">
											<option value=""></option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="momento">*Momento</label>
										<select name="momento" id="momento" class="form-control">
											<option value=""></option>
											<option value="APERTURA">APERTURA</option>
											<option value="INTERMEDIO">INTERMEDIO</option>
											<option value="CIERRE">CIERRE</option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="desc_incidencia">*Descripción</label>
										<input type="text" name="desc_incidencia" id="desc_incidencia" class="form-control">
									</div>
								</div>
							</div>
							<div class="row">

								<div class="col-md-2">
									<div class="form-group">
										<label for="sucursal">*Categoría</label>
										<select name="categoria" id="categoria" class="form-control">
											<option value=""></option>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="incidencia">*Incidencia</label>
										<select name="incidencia" id="incidencia" class="form-control">
											<option value=""></option>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="areas">*Areas</label>
										<select name="areas" id="areas" class="form-control">
											<option value=""></option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="fecha_inicio">*Fecha:</label>
										<div class="input-group date form_date" data-date="<?php echo $fecha_hoy ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha" data-link-format="yyyy-mm-dd">
											<input class="form-control" size="16" type="text" value="<?php echo $fecha_hoy ?>" id="fecha" name="fecha">
											<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="url">*URL</label>
										<input type="text" name="url" id="url" class="form-control">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label for="">*Comentario</label>
									<textarea name="comentario" id="comentario" cols="100%" rows="5" class="form-control"></textarea>
								</div>
							</div>
						</form>
					</div>
					<div class="box-footer text-right">
						<button class="btn btn-warning" id="btn-guardar">Registrar Incidencia</button>
					</div>
				</div>
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Listado | Control de Incidencias</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="fecha_inicial">*Fecha inicial:</label>
									<div class="input-group date form_date" data-date="<?php echo $fecha_inicial ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicial" data-link-format="yyyy-mm-dd">
										<input class="form-control" size="16" type="text" value="<?php echo $fecha_inicial ?>" id="fecha_inicial" name="fecha_inicial">
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="fecha_final">*Fecha final:</label>
									<div class="input-group date form_date" data-date="<?php echo $fecha_hoy ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_final" data-link-format="yyyy-mm-dd">
										<input class="form-control" size="16" type="text" value="<?php echo $fecha_hoy ?>" id="fecha_final" name="fecha_final">
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="lista_movimientos" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th width='5%'>#</th>
												<th width='5%'>Sucursal</th>
												<th width='5%'>Momento</th>
												<th>Descripcion</th>
												<th width='10%'>Categoría</th>
												<th width='10%'>Tipo</th>
												<th width='10%'>Area</th>
												<th width='10%'>Fecha</th>
												<th width='20%'>Detalle</th>
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
		<?php include 'modal_video.php'; ?>
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
	<script type="text/javascript">
		$('#sucursal').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: Infinity,
			ajax: {
				url: "consulta_sucursal.php",
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
		$('#categoria').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: Infinity,
			ajax: {
				url: "consulta_categoria.php",
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
		$('#incidencia').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: Infinity,
			ajax: {
				url: "consulta_incidencias.php",
				type: "post",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						searchTerm: params.term, // search term
						categoria: $("#categoria").val()
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
		$('#areas').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: Infinity,
			ajax: {
				url: "consulta_departamentos.php",
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
		$('#momento').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: Infinity
		})
		$("#sucursal").change(function() {
			//alert("hola");
		});
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

		function cargar_tabla() {
			var fi = $("#fecha_inicial").val();
			var ff = $("#fecha_final").val();
			var suc = $("#sucursal").val();
			$('#lista_movimientos').dataTable().fnDestroy();
			$('#lista_movimientos').DataTable({
				'language': {
					"url": "../plugins/DataTables/Spanish.json"
				},
				"order": [
					[0, "desc"]
				],
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
					"url": "tabla_incidencias.php",
					"dataSrc": "",
					"data": {
						fi: fi,
						ff: ff
					}
				},
				"columns": [{
						"data": "id"
					},
					{
						"data": "sucursal"
					},
					{
						"data": "momento"
					},
					{
						"data": "descripcion"
					},
					{
						"data": "categoria"
					},
					{
						"data": "incidencia"
					},
					{
						"data": "area"
					},
					{
						"data": "fecha_incidencia"
					},
					{
						"data": "detalle"
					}
				]
			});
		}
		$("#btn-guardar").click(function() {
			guardar("<?php echo $fecha_inicial ?>","<?php echo $fecha_hoy?>");
		})
		$(document).ready(function(e) {
			cargar_tabla();
		});

		function guardar(fecha_inicio, fecha_fin) {
			var url = "insertar_incidencia.php";
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: $("#form-datos").serialize(),
				success: function(respuesta) {
					alertify.success("Incidencia registrada correctamente");
					$("#form-datos")[0].reset();
					$("#fecha_inicial").val(fecha_inicio);
					$("#fecha_final").val(fecha_fin);
					$("#fecha").val(fecha_fin);
				},
				error: function(xhr, status) {
					alert("error");
				}
			});
			cargar_tabla();
			return false;

		}
		$('#modal-video').on('show.bs.modal', function(e) {
			var id = $(e.relatedTarget).data().id;
			var url = "consulta_video.php"; // El script a dónde se realizará la petición.
			$.ajax({
				type: "POST",
				url: url,
				data: {
					id: id
				}, // Adjuntar los campos del formulario enviado.
				success: function(respuesta) {
					//$('#res').html(respuesta);
					$('#contenedor').html(respuesta);
				}
			});
		});
		$('#modal-video').on('hidden.bs.modal', function(e) {
			$('#contenedor').html("");
		});
		$("#fecha_inicial").change(function() {
			if ($("#fecha_inicial").val() > $("#fecha_final").val()) {
				alertify.error("rango de fechas inválido");
			} else {
				cargar_tabla();
			}
		});
		$("#fecha_final").change(function() {
			if ($("#fecha_inicial").val() > $("#fecha_final").val()) {
				alertify.error("rango de fechas inválido");
			} else {
				cargar_tabla();
			}
		});
	</script>
</body>

</html>