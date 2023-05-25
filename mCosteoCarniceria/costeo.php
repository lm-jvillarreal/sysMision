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
						<h3 class="box-title">Costeo de Carnicería | Primarios</h3>
					</div>
					<form action="" method="POST" id="form-datos">
						<div class="box-body">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="sucursal">*Sucursal:</label>
										<select name="sucursal" id="sucursal" class="form-control">
											<option value=""></option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="artc_articulo">*Código:</label>
										<input type="hidden" id="id_corte" name="id_corte">
										<select name="artc_articulo" id="artc_articulo" class="form-control">
											<option value=""></option>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="artc_pesokilo">*Pieza KG.</label>
										<input type="text" name="artc_pesokilo" id="artc_pesokilo" class="form-control">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="artc_costokilo">*Costo KG:</label>
										<input type="text" name="artc_costokilo" id="artc_costokilo" class="form-control" readonly>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="entrada_tipoent">*Tipo:</label>
										<input type="text" name="entrada_tipoent" id="entrada_tipoent" class="form-control" readonly>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="entrada_folio">*Folio:</label>
										<input type="text" name="entrada_folio" id="entrada_folio" class="form-control" readonly>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<label for="clave_proveedor">*Proveedor:</label>
										<input type="text" name="clave_proveedor" id="clave_proveedor" class="form-control" readonly>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="nombre_proveedor">*Nombre:</label>
										<input type="text" name="nombre_proveedor" id="nombre_proveedor" class="form-control" readonly>
									</div>
								</div>
							</div>
						</div>
					</form>
					<div class="box-footer text-right">
						<button class="btn btn-danger" id="btn-guardar">Iniciar costeo</button>
					</div>
				</div>
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Costeo de carnicería | Detalle</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id='lista_articulos' class='table table-striped table-bordered' cellspacing='0' width='100%'>
										<thead>
											<tr>
												<th width='5%'>Artículo</th>
												<th>Descripción</th>
												<th width='10%'>Cantidad</th>
												<th width='10%'>%</th>
												<th width='10%'>Costo</th>
												<th width='10%'>Costo Kg.</th>
												<th width='10%'>Margen</th>
												<th width='10%'>P.P.</th>
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
		<?php include 'modal_detallecorte.php'; ?>
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
		$("#sucursal").select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			//minimumResultsForSearch: Infinity
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
		$("#artc_articulo").select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			//minimumResultsForSearch: Infinity
			ajax: {
				url: "consulta_primarios.php",
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
		$("#artc_articulo").change(function() {
			swal("Consultando información, espere...", {
				icon: "info",
				closeOnClickOutside: false,
				buttons: false
			});
			var url = 'validar_pendientes.php';
			var sucursal=$("#sucursal").val();
			var artc_articulo = $("#artc_articulo").val();
			var id_corte = $("#id_corte").val();
			$.ajax({
				url: url,
				type: "POST",
				data: {
					artc_articulo: $("#artc_articulo").val(),
					sucursal: sucursal
				},
				success: function(respuesta) {
					var array = eval(respuesta);
					if (array[8] == "") {
						$("#btn-guardar").removeAttr('disabled');
					} else {
						$("#btn-guardar").attr('disabled', "true");
						$("#id_corte").val(array[8]);
						cargar_tabla(artc_articulo);
					}
					$("#artc_costokilo").val(array[5]);
					$("#entrada_tipoent").val(array[0]);
					$("#entrada_folio").val(array[1]);
					$("#clave_proveedor").val(array[2]);
					$("#nombre_proveedor").val(array[3]);
					swal.close();
				},
				error: function(xhr, status) {
					alert("error");
				}
			})
		});
		$("#btn-guardar").click(function() {
			if ($("#artc_articulo").val() == "" || $("#artc_descripcion").val() == "" || $("#artc_pesokilo").val() == "" || $("#costo_costokilo").val() == "") {
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
						$("#id_corte").val(respuesta);
						cargar_tabla($("#artc_articulo").val());
					},
					error: function(xhr, status) {
						alert("error");
					}
				});
			}
			//cargar_tabla();
			return false;
		});

		function cargar_tabla(codigo_corte) {
			var id_costeo = $("#id_corte").val();
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
						text: 'Finalizar costeo',
						className: 'red',
						action: function() {
							finalizar_costeo();
						},
						counter: 1
					},
				],
				"ajax": {
					"type": "POST",
					"url": "tabla_articulos.php",
					"dataSrc": "",
					"data": {
						codigo_corte: codigo_corte,
						id_costeo: id_costeo
					}
				},
				"columns": [{
						"data": "artc_codigo"
					},
					{
						"data": "artc_descripcion"
					},
					{
						"data": "artc_cantidad"
					},
					{
						"data": "artc_porcentaje"
					},
					{
						"data": "artc_costototal"
					},
					{
						"data": "artc_costounitario"
					},
					{
						"data": "artc_margen"
					},
					{
						"data": "artc_precioventa"
					},
					{
						"data": "opciones"
					}
				]
			});
		}

		function cant(codigo_corte, id_articulo) {
			var id_costeo = $("#id_corte").val();
			var url = 'cantidad.php';
			swal("Ingresa una cantidad", {
					content: "input",
				})
				.then((value) => {
					var cantidad = `${value}`;
					$.ajax({
						type: "POST",
						url: url,
						data: {
							id_costeo: id_costeo,
							codigo_corte: codigo_corte,
							id_articulo: id_articulo,
							cantidad: cantidad
						}, // Adjuntar los campos del formulario enviado.
						success: function(respuesta) {
							$("#lista_articulos").DataTable().ajax.reload();
							swal("Listo!", "Pedido creado satisfactoriamente", "success");
						}
					});
				});
		}

		function finalizar_costeo() {
			var id_costeo = $("#id_corte").val();
			var artc_articulo = $("#artc_articulo").val();
			if (id_costeo == "" || id_costeo == null) {
				alertify.error("Debes tener un costeo iniciado");
			} else {
				var url = "finalizar_costeo.php";
				$.ajax({
					url: url,
					type: "POST",
					dateType: "html",
					data: {
						id_costeo: id_costeo
					},
					success: function(respuesta) {
						if (respuesta == 'ok') {
							swal("Listo!", "Costeo finalizado correctamente", "success");
							cargar_tabla(artc_articulo);
						}
					},
					error: function(xhr, status) {
						alert("error");
					}
				});
			}
		}
	</script>
</body>

</html>