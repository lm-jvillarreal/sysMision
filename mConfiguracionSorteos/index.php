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
						<h3 class="box-title">Configuración de Sorteos | Registro</h3>
					</div>
					<div class="box-body">
						<form action="" method="POST" id="form_configuracion">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="sorteo">*Sorteo</label>
										<input type="hidden" id="ide" name="ide">
										<input type="text" name="sorteo" id="sorteo" class="form-control">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="fecha_inicio">*Fecha inicial:</label>
										<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
											<input class="form-control" size="16" type="text" value="" readonly id="fecha_inicial" name="fecha_inicial">
											<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="fecha_inicio">*Fecha final:</label>
										<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
											<input class="form-control" size="16" type="text" value="" readonly id="fecha_final" name="fecha_final">
											<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="tiraje">*Tiraje</label>
										<input type="number" name="tiraje" id="tiraje" class="form-control">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<label for="dinero_boleto">Cant. por Boleto</label>
										<input type="number" name="cant_boleto" id="cant_boleto" class="form-control">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="boletos_block">*Boletos por block</label>
										<input type="number" name="boletos_block" id="boletos_block" class="form-control">
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="box-footer text-right">
						<button class="btn btn-warning" id="btn-guardar">Guardar Datos</button>
					</div>
				</div>
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Configuración de Sorteos | Lista de Registros</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="lista_sorteos" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<th width="5%">#</th>
											<th>Sorteo</th>
											<th width="10%">Año</th>
											<th width="15%">Tiraje</th>
											<th width="15%">Block</th>
											<th width="15%">Monto</th>
											<th width="10%"></th>
										</thead>
										<tbody></tbody>
										<tfoot>
											<th>#</th>
											<th>Sorteo</th>
											<th>Año</th>
											<th>Tiraje</th>
											<th>Block</th>
											<th>Monto</th>
											<th></th>
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
	<script>
		$(document).ready(function(e) {
			cargar_tabla();
		});
		$("#btn-guardar").click(function() {
			if ($("#sorteo").val() == "" || $("#tiraje").val() == "" || $("#cant_boleto").val() == "" || $("#boletos_block").val() == "") {
				alertify.error("Favor de rellenar todos los datos");
			} else {
				var url = "insertar_configuracion.php";
				$.ajax({
					url: url,
					type: "POST",
					dateType: "html",
					data: $("#form_configuracion").serialize(),
					success: function(respuesta) {
						cargar_tabla();
						alertify.success("Sorteo registrado correctamente");
						$("#form_configuracion")[0].reset();
					},
					error: function(xhr, status) {
						alert("error");
					}
				});
			}
		});

		function cargar_tabla() {
			$('#lista_sorteos').dataTable().fnDestroy();
			$('#lista_sorteos').DataTable({
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
						copySuccess: {
							_: '%d lignes copiées',
							1: '1 ligne copiée'
						}
					}
				],
				"ajax": {
					"type": "POST",
					"url": "tabla.php",
					"dataSrc": ""
				},
				"columns": [{
						"data": "id"
					},
					{
						"data": "sorteo"
					},
					{
						"data": "anio"
					},
					{
						"data": "tiraje"
					},
					{
						"data": "block"
					},
					{
						"data": "monto"
					},
					{
						"data": "opciones"
					}
				]
			});
		}

		function editar(id_registro) {
			var url = "consulta_registro.php";
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: {
					id_registro: id_registro
				},
				success: function(respuesta) {
					var array = eval(respuesta);
					$("#ide").val(array[0]);
					$("#sorteo").val(array[1]);
					$("#tiraje").val(array[3]);
					$("#cant_boleto").val(array[4]);
					$("#boletos_block").val(array[5]);
					$("#fecha_inicial").val(array[6]);
					$("#fecha_final").val(array[7]);
				},
				error: function(xhr, status) {
					alert("error");
				}
			});
		};

		function eliminar(id_registro) {
			var url = "eliminar_registro.php";
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: {
					id_registro: id_registro
				},
				success: function(respuesta) {
					alertify.success("Registro eliminado correctamente");
					cargar_tabla();
				},
				error: function(xhr, status) {
					alert("error");
				}
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