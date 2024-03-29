<?php
include '../global_seguridad/verificar_sesion.php';
$cve_prov = (isset($_GET['cve_prov'])) ? $_GET['cve_prov'] : "";
?>
<!DOCTYPE html>
<html>

<head>
	<?php include '../head.php'; ?>
	<title> | Recibo | Cambios Fisicos Pendientes</title>
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
						<h3 class="box-title">Lista de Cambios Físicos | Cambios Pendientes</h3>
					</div>
					<div class="box-body">
						<div class="table-responsive">
							<table id="lista_cambios" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th width="5%">Folio</th>
										<th>Proveedor</th>
										<th width="30%">Producto</th>
										<th width='10%'>Sucursal</th>
										<th width="5%">Cantidad</th>
										<th width="5%">Usuario</th>
										<th width='5%'>Fecha</th>
										<th width="5%"></th>
									</tr>
								</thead>
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
	<!-- Page script -->
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
	<script>
		function liberar_cambioFisico(id_cambio) {
			//var id_devolucion = "";
			swal({
					title: "¿Está seguro de liberar el cambio fisico?",
					text: "No. cambio: " + id_cambio,
					icon: "warning",
					buttons: ["Cancelar", "Liberar"],
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						swal({
								closeOnClickOutside: false,
								closeOnEsc: false,
								title: "Cantidad del producto a cambiar",
								content: {
									element: "input",
									type: "text",
									required: "true",
								}
							})
							.then((value) => {
								cambiar_status(id_cambio, `${value}`);
							})
					} else {
						swal("El cambio físico no. " + id_cambio + " ha sido cancelado.", {
							icon: "error",
						});
						cargar_tabla();
					}
				});
		}

		function cambiar_status(id_cambio, cantidad) {
			var url = "liberar_cambioFisico.php"; // El script a dónde se realizará la petición.
			$.ajax({
				type: "POST",
				url: url,
				data: {
					id_cambio: id_cambio,
					cantidad: cantidad
				}, // Adjuntar los campos del formulario enviado.
				success: function(respuesta) {
					if (respuesta == "descuento") {
						swal("Cambios Pendientes", "Existen cambios para este proveedor", "warning");
						cargar_tabla();
					} else if (respuesta == "ok") {
						swal("Sin cambios restantes", "Todas los cambios quedaron liberados", "success");
						cargar_tabla();
					} else if (respuesta == "overflow") {
						swal("Error de cantidades", "La cantidad ingresada excede el numero de cambios registrados", "error");
						cargar_tabla();
					}

				}
			});
			// Evitar ejecutar el submit del formulario.
			return false;
		}

		function cargar_tabla() {
			$('#lista_cambios thead th').each(function() {
				var title = $(this).text();
				$(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
			});
			var proveedor = $("input[name='proveedor']").val();
			$('#lista_cambios').dataTable().fnDestroy();
			var table = $('#lista_cambios').DataTable({
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
						title: 'Devoluciones',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'Devoluciones',
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
					"data": {
						proveedor: proveedor
					}
				},
				"columns": [{
						"data": "folio"
					},
					{
						"data": "proveedor"
					},
					{
						"data": "producto"
					},
					{
						"data": "sucursal"
					},
					{
						"data": "cantidad"
					},
					{
						"data": "usuario"
					},
					{
						"data": "fecha_alta"
					},
					{
						"data": "liberar"
					}
				]
			});
			table.columns().every(function() {
				var that = this;
				$('input', this.header()).on('keyup change', function() {
					if (that.search() !== this.value) {
						that
							.search(this.value)
							.draw();
					}
				});
			});
		}
		$(document).ready(function() {
			cargar_tabla();

		})
	</script>
</body>

</html>