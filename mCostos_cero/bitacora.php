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
						<h3 class="box-title">Control de Articulos | Costo Cero</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="lista_costosCero" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th width='5%'>#</th>
												<th width='10%'>Código</th>
												<th>Descripción</th>
												<th width='5%'>Costo</th>
												<th width='10%'>Sucursal</th>
												<th width='10%'>P. Venta</th>
												<th width='10%'>Resuelve</th>
												<th width='20%'>Comentarios</th>
												<th width='5%'>Baja</th>
												<th width='5%'>Estatus</th>
												<th width='5%'>Liberar</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>#</th>
												<th>Código</th>
												<th>Descripción</th>
												<th>Costo</th>
												<th>Sucursal</th>
												<th>P. Venta</th>
												<th>Resuelve</th>
												<th>Comentarios</th>
												<th>Baja</th>
												<th>Estatus</th>
												<th>Liberar</th>
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
		<?php include 'modal_costos.php'; ?>
		<?php include 'modal_ventas.php'; ?>
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
			$('#lista_costosCero').dataTable().fnDestroy();
			$('#lista_costosCero').DataTable({
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
						title: 'CostosCero',
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
					"url": "lista_bitacora.php",
					"dataSrc": ""
				},
				"columns": [{
						"data": "id"
					},
					{
						"data": "codigo"
					},
					{
						"data": "descripcion"
					},
					{
						"data": "costo"
					},
					{
						"data": "sucursal"
					},
					{
						"data": "pv"
					},
					{
						"data": "resuelve"
					},
					{
						"data": "comentario"
					},
					{
						"data": "baja"
					},
					{
						"data": "estatus"
					},
					{
						"data": "liberar"
					}
				]
			});
		}
		$(document).ready(function() {
			cargar_tabla();
		});
		$('#modal-costos').on('show.bs.modal', function(e) {
			var id = $(e.relatedTarget).data().id;
			$("#ide").val(id);
		});
		$("#btn-costos").click(function() {
			var url = "actualiza_costos.php";
			var id = $("#ide").val();
			var costo = $("#costo").val();
			var comentario = $("#comentario-verifica").val();
			$.ajax({
				type: "POST",
				url: url,
				data: {
					id: id,
					comentario: comentario,
					costo: costo
				}, // Adjuntar los campos del formulario enviado.
				success: function(respuesta) {
					$('#modal-costos').modal('hide');
					$("#ide").val("");
					$("#comentario-verifica").val("");
					$("#costo").val("");
					cargar_tabla();
				}
			});
		});

		function baja(codigo_artc) {
			var id_registro = codigo_artc;
			var url = 'baja_articulo.php';
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: {
					codigo_artc: codigo_artc
				},
				success: function(respuesta) {
					if (respuesta == "ok") {
						alertify.success("Artículo deshabilitado correctamente");
						//cargar_tabla();
					}
				},
				error: function(xhr, status) {
					alert("error");
					//alert(xhr);
				},
			});
			cargar_tabla();
		}

		function liberar(id_registro) {
			var id_registro = id_registro;
			var url = 'liberar_articulo.php';
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: {
					id_registro: id_registro
				},
				success: function(respuesta) {
					if (respuesta == "ok") {
						alertify.success("Registro liberado correctamente");
						//cargar_tabla();
					}
				},
				error: function(xhr, status) {
					alert("error");
					//alert(xhr);
				},
			});
			cargar_tabla();
		}
		$('#modal-ventas').on('show.bs.modal', function(e) {
			var articulo = $(e.relatedTarget).data().id;
			var suc = $(e.relatedTarget).data().suc;
			$('#res').html('<center><h4>Un momento, por favor...</h4><center>');
			var url = "contenido_modal_ventas.php"; // El script a dónde se realizará la petición.
			$.ajax({
				type: "POST",
				url: url,
				data: {
					articulo: articulo,
					suc: suc
				}, // Adjuntar los campos del formulario enviado.
				success: function(respuesta) {
					//$('#res').html(respuesta);
					$('#res').fadeIn(5000).html(respuesta);
				}
			});
		});
	</script>
</body>

</html>