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
						<h3 class="box-title">Costo de materias primas | Registro</h3>
					</div>
					<form action="" method="POST" id="form-datos">
						<div class="box-body">
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<label for="artc_articulo">*Artículo:</label>
										<input type="text" name="artc_articulo" id="artc_articulo" class="form-control">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="artc_descripcion">*Descripción</label>
										<input type="text" name="artc_descripcion" id="artc_descripcion" class="form-control" readonly>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="proveedor">*Proveedor</label>
										<input type="text" name="proveedor" id="proveedor" class="form-control" readonly>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="costo_empaque">*Costo:</label>
										<input type="text" name="costo_empaque" id="costo_empaque" class="form-control" readonly>
									</div>
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<label for="unidad_empaque">*U.E.</label>
										<input type="text" name="unidad_empaque" id="unidad_empaque" class="form-control" readonly>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-1">
									<div class="form-group">
										<label for="unidad_medida">*U.M.</label>
										<select name="unidad_medida" id="unidad_medida" class="form-control">
											<option value=""></option>
											<option value="PZA.">PZA.</option>
											<option value="KG.">KG.</option>
											<option value="LT">LT.</option>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="factor_empaque">*F.E.</label>
										<input type="number" name="factor_empaque" id="factor_empaque" class="form-control">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="merma">*Merma:</label>
										<input type="text" name="merma" id="merma" class="form-control">
									</div>
								</div>
							</div>
						</div>
					</form>
					<div class="box-footer text-right">
						<button class="btn btn-danger" id="btn-guardar">Guardar Registro</button>
					</div>
				</div>
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Costo de materias primas | Lista de Registros Existentes</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id='lista_articulos' class='table table-striped table-bordered' cellspacing='0' width='100%'>
										<thead>
											<tr>
												<th width='5%'>#</th>
												<th width='15%'>Artículo</th>
												<th>Descripción</th>
												<th>Proveedor</th>
												<th width='5%'>Costo</th>
												<th width='5%'>F.E.</th>
												<th width='5%'>Merma</th>
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
		$("#unidad_medida").select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: Infinity
		});
		$("#artc_articulo").keypress(function(e) { //Función que se desencadena al presionar enter
			var code = (e.keyCode ? e.keyCode : e.which);
			if (code == 13) {
				swal("Consultando información, espere...", {
					icon: "info",
					closeOnClickOutside: false,
					buttons: false
				});
				var url = "consulta_datos.php"; // El script a dónde se realizará la petición.
				var artc_articulo = $("#artc_articulo").val();
				//alert(folio);
				$.ajax({
					type: "POST",
					url: url,
					data: {
						artc_articulo: artc_articulo
					}, // Adjuntar los campos del formulario enviado.
					success: function(respuesta) {
						if (respuesta == "no_existe") {
							$('#form-datos')[0].reset();
							$("#artc_articulo").focus();
							swal("el artículo no existe", "", "warning");
						} else {
							var array = eval(respuesta);
							$("#artc_descripcion").val(array[6]);
							$("#proveedor").val(array[3] + ' ' + array[4]);
							$("#costo_empaque").val(array[7]);
							$("#unidad_empaque").val(array[8]);
							swal.close();
						}
					}
				});
				return false;
			}
		});
		$("#btn-guardar").click(function() {
			if ($("#artc_articulo").val() == "" || $("#artc_descripcion").val() == "" || $("#proveedor").val() == "" || $("#costo_empaque").val() == "" || $("#unidad_empaque").val() == "" || $("#unidad_medida").val() == "" || $("#factor_empaqie").val() == "" || $("#merma").val() == "") {
				alertify.error("Existen campos vacíos");
			} else {
				var url = "insertar_articulo.php";
				$.ajax({
					url: url,
					type: "POST",
					dateType: "html",
					data: $("#form-datos").serialize(),
					success: function(respuesta) {
						alertify.success("Articulo insertado correctamente");
						//$(":text").val("");
						$('#form-datos').trigger("reset");
						$('#form-datos')[0].reset();
						$('#form-datos').get(0).reset();
						$("#artc_articulo").focus();
						cargar_tabla();
					},
					error: function(xhr, status) {
						alert("error");
					}
				});
			}
			//cargar_tabla();
			return false;
		});

		function cargar_tabla() {
			$('#lista_articulos').dataTable().fnDestroy();
			$('#lista_articulos').DataTable({
				'language': {
					"url": "../plugins/DataTables/Spanish.json"
				},
				"paging": false,
				"dom": 'Bfrtip',
				buttons: [
					{
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
					{
						text: 'Actualizar costos',
						className: 'red',
						action: function() {
							actualizar_costos();
						},
						counter: 1
					},
				],
				"ajax": {
					"type": "POST",
					"url": "tabla_articulos.php",
					"dataSrc": "",
					"data": ""
				},
				"columns": [{
						"data": "id"
					},
					{
						"data": "artc_articulo"
					},
					{
						"data": "artc_descripcion"
					},
					{
						"data": "proveedor"
					},
					{
						"data": "rmon_ultimoprecio"
					},
					{
						"data": "factor_empaque"
					},
					{
						"data": "porcentaje_merma"
					}
				]
			});
		}

		function actualizar_costos() {
			$('#lista_articulos').dataTable().fnClearTable();
			swal("Los registros se están actualizando, espere...", {
				icon: "info",
				closeOnClickOutside: false,
				buttons: false
			});
			var url = 'actualizar_costos.php';
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: {},
				success: function(respuesta) {
					if (respuesta == "ok") {
						swal("Los costos han sido actualizados correctamente", {
							icon: "success",
						});
						cargar_tabla();
					}
				},
				error: function(xhr, status) {
					alert("error");
					//alert(xhr);
				},
			});
		}
	</script>
</body>

</html>