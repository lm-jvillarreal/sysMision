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
			<?php include 'menuV3.php'; ?>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<!-- Main content -->
			<section class="content">
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Control de Consumo Preferente | Lista de Registros Existentes</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id='lista_caducidades' class='table table-striped table-bordered' cellspacing='0' width='100%'>
										<thead>
											<tr>
												<th width='10%'>Código</th>
												<th>Descripción</th>
												<th width='15%'>Depto</th>
												<th width='15%'>Fam.</th>
												<th width='10%'>Sucursal</th>
												<th width='5%'>Lote</th>
												<th width='10%'>Caducidad</th>
												<th width='10%'>Captura</th>
												<th width='3%'></th>
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
		<?php include 'modal_precios.php'; ?>
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
		$(document).ready(function(e) {
			$("#codigo").focus();
			cargar_tabla();
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
		$("#codigo").keypress(function(e) { //Función que se desencadena al presionar enter
			var code = (e.keyCode ? e.keyCode : e.which);
			if (code == 13) {
				var url = "consulta_articulos.php"; // El script a dónde se realizará la petición.
				var codigo = $("#codigo").val();
				$.ajax({
					type: "POST",
					url: url,
					data: {
						codigo: codigo
					}, // Adjuntar los campos del formulario enviado.
					success: function(respuesta) {
						var array = eval(respuesta);
						$('#descripcion').val(array[0]);
						$("#precio_venta").val(array[1]);
						$("#oferta").val(array[2]);
					}
				});
				return false;
			}
		});
		$("#btn-guardar").click(function() {
			var url = "insertar_caducidad.php";
			var codigo = $("#codigo").val();
			var descripcion = $("#descripcion").val();
			var caducidad = $("#fecha_caducidad").val();
			var cantidad = $("#cantidad").val();
			var precio_venta = $("#precio_venta").val();
			var oferta = $("#oferta").val();
			var lote = $("#lote").val();
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: {
					codigo: codigo,
					descripcion: descripcion,
					caducidad: caducidad,
					cantidad: cantidad,
					precio_venta: precio_venta,
					oferta: oferta,
					lote: lote
				},
				success: function(respuesta) {
					$(":text").val("");
					alertify.success("Registro insertado correctamente");
					$("#codigo").focus();
				},
				error: function(xhr, status) {
					alert("error");
					//alert(xhr);
				},
			})
			cargar_tabla();
			return false;
		});

		function cargar_tabla() {
			$('#lista_caducidades thead th').each(function() {
				var title = $(this).text();
				$(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
			});
			$('#lista_caducidades').dataTable().fnDestroy();
			var table = $('#lista_caducidades').DataTable({
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
					"url": "tabla_caducidades.php",
					"dataSrc": "",
					"data": ""
				},
				"columns": [{
						"data": "codigo"
					},
					{
						"data": "descripcion"
					},
					{
						"data": "depto"
					},
					{
						"data": "familia"
					},
					{
						"data": "sucursal"
					},
					{
						"data": "lote"
					},
					{
						"data": "caducidad"
					},
					{
						"data": "captura"
					},
					{
						"data": "cantidad"
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

		function descuenta_ventas() {
			$('#lista_codigos').dataTable().fnClearTable();
			swal("Los registros se están actualizando, espere...", {
				icon: "info",
				closeOnClickOutside: false,
				buttons: false
			});
			var url = 'descontar_ventas.php';
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: "",
				success: function(respuesta) {
					if (respuesta == "ok") {
						swal("La tabla ha sido actualizada correctamente", {
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
		$('#modal-precios').on('show.bs.modal', function(e) {
			var id = $(e.relatedTarget).data().id;
			var suc = $(e.relatedTarget).data().suc;
			var url = "consulta_datos_modal.php"; // El script a dónde se realizará la petición.
			$.ajax({
				type: "POST",
				url: url,
				data: {
					id: id,
					suc: suc
				}, // Adjuntar los campos del formulario enviado.
				success: function(respuesta) {
					var array = eval(respuesta);
					$('#ppublico').val(array[0]);
					$('#poferta').val(array[1]);
				}
			});
		});
	</script>
</body>

</html>