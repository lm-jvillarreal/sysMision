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
			<?php include 'menuV4.php'; ?>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<!-- Main content -->
			<section class="content">
				<form action="" method="POST" id="form-datos">
					<div class="box box-danger" <?php echo $solo_lectura ?>>
						<div class="box-header">
							<h3 class="box-title">Registro de Devoluciones</h3>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="folio">*Folio</label>
										<input type="text" name="folio" id="folio" class="form-control" placeholder="No. Folio">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="sucursal">*Sucursal</label>
										<select name="sucursal" id="sucursal" class="form-control">
											<option value=""></option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="proveedor">*Proveedor</label>
										<select name="proveedor" id="proveedor" class="form-control">
											<option value=""></option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<label for="fecha_afectacion">*Fecha de Afectación</label>
										<input type="text" name="fecha_afectacion" id="fecha_afectacion" class="form-control" readonly="true">
										<input type="hidden" name="id_sucursal" id="id_sucursal">
									</div>
								</div>
							</div>
						</div>
						<div class="box-footer text-right">
							<button type="submit" class="btn btn-danger" id="btn-consultar">Consultar</button>
							<button type="submit" class="btn btn-warning" id="btn-guardar">Guardar</button>
						</div>
					</div>
				</form>
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Lista de Devoluciones</h3>
					</div>
					<div class="box-body">
						<div class="table-responsive">
							<table id="lista_devoluciones" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>

										<th width="5%">Folio</th>
										<th width="10%">Movimiento</th>
										<th>Proveedor</th>
										<th width="10%">Fecha</th>
										<th width="10%">Sucursal</th>
										<th width="5%">Liberar</th>
									</tr>
								</thead>
								<tfooter>
									<tr>

										<th>Folio</th>
										<th>Movimiento</th>
										<th>Proveedor</th>
										<th>Fecha</th>
										<th>Sucursal</th>
										<th>Liberar</th>
									</tr>
								</tfooter>
							</table>
						</div>
					</div>
					<div class="box-footer"></div>
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
		$('#sucursal').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: Infinity,
			ajax: {
				url: "consulta_sucursales.php",
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
		$('#proveedor').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			//minimumResultsForSearch: Infinity,
			ajax: {
				url: "consulta_proveedores.php",
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
		$('#movimiento').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: Infinity
		});

		function liberar_devolucion(id_devolucion) {
			//var id_devolucion = "";
			swal({
					title: "¿Está seguro de liberar la devolución?",
					text: "No. Devolución: " + id_devolucion,
					icon: "warning",
					buttons: ["Cancelar", "Iniciar"],
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						cambiar_status(id_devolucion);
						swal("La devolución no." + id_devolucion + " ha sido liberada.", {
							icon: "success",
						});
						cargar_tabla();
					} else {
						swal("La liberación de la devolución no. " + id_devolucion + " ha sido cancelada.", {
							icon: "error",
						});
					}
				});
		}
	</script>
	<script>
		function cambiar_status(id) {
			var url = "liberar_devolucion.php"; // El script a dónde se realizará la petición.
			$.ajax({
				type: "POST",
				url: url,
				data: {
					ide: id
				}, // Adjuntar los campos del formulario enviado.
				success: function(respuesta) {
					console.log(respuesta);
				}
			});
			// Evitar ejecutar el submit del formulario.
			return false;
		}
		$("#btn-consultar").click(function() {
			var url = "consulta_datos_centralizada.php"; // El script a dónde se realizará la petición.
			var no_folio = $("#folio").val();
			var sucursal = $("#sucursal").val();
			var proveedor = $("#proveedor").val();
			$(":text").val('');
			$.ajax({
				type: "POST",
				url: url,
				data: {
					no_folio: no_folio,
					sucursal: sucursal,
					proveedor: proveedor
				}, // Adjuntar los campos del formulario enviado.
				success: function(respuesta) {
					var array = eval(respuesta);
					$('#folio').val(no_folio);
					$('#fecha_afectacion').val(array[3]);
					$('#id_sucursal').val(array[8]);
					id_suc = array[9];
					nombre_suc = array[10];
					$("#sucursal").select2("trigger", "select", {
						data: {
							id: id_suc,
							text: nombre_suc
						}
					});
				}
			});
			return false;
		});
		$("#btn-guardar").click(function() {
			var url = "insertar_devolucion_centralizada.php";
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: $('#form-datos').serialize(),
				success: function(respuesta) {
					if (respuesta == "ok") {
						alertify.success("Devolución registrada correctamente");
					} else if (respuesta == "repetido") {
						alertify.error("El registro ya existe");
					}
				},
				error: function(xhr, status) {
					alert("error");
					//alert(xhr);
				},
			});
			cargar_tabla();
			$(":text").val('');
			return false;
		})

		function cargar_tabla() {
			$('#lista_devoluciones').dataTable().fnDestroy();
			$('#lista_devoluciones').DataTable({
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
						title: 'Modulos-Lista',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'Modulos-Lista',
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
					"url": "tabla.php",
					"dataSrc": "",
					"data": ""
				},
				"columns": [{
						"data": "folio"
					},
					{
						"data": "movimientos"
					},
					{
						"data": "proveedor"
					},
					{
						"data": "fecha"
					},
					{
						"data": "sucursal"
					},
					{
						"data": "liberar"
					}
				]
			});
		}
		$(document).ready(function() {
			cargar_tabla();
		})
	</script>
</body>

</html>