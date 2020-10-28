<?php
include '../global_seguridad/verificar_sesion.php';
if ($id_sede == '1') {
	$do = "active";
} elseif ($id_sede == '2') {
	$arb = "active";
} elseif ($id_sede == '3') {
	$vill = "active";
} elseif ($id_sede == '4') {
	$all = "active";
}
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
						<h3 class="box-title">Control de Consumo Preferente | Registro de Medicamentos</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="tabbable">
									<ul class="nav nav-tabs">
										<li class="<?php echo $do; ?>"><a href="#1" data-toggle="tab">Diaz Ordaz</a></li>
										<li class="<?php echo $arb; ?>"><a href="#2" data-toggle="tab">Arboledas</a></li>
										<li class="<?php echo $vill; ?>"><a href="#3" data-toggle="tab">Villegas</a></li>
										<li class="<?php echo $all; ?>"><a href="#4" data-toggle="tab">Allende</a></li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="1">
											<div class="row">
												<div class="col-md-12">
													<div class="row">
														<div class="col-md-12">
															<br>
															<div class="table-responsive">
																<table id='lista_caducidades_do' class='table table-striped table-bordered' cellspacing='0' width='100%'>
																	<thead>
																		<tr>
																			<th width='10%'>Código</th>
																			<th>Descripción</th>
																			<th width='15%'>Depto</th>
																			<th width='15%'>Fam.</th>
																			<th width='5%'>Lote</th>
																			<th width='10%'>Caducidad</th>
																			<th width='10%'>Captura</th>
																			<th width='5%'>Cant.</th>
																			<th width='5%'></th>
																		</tr>
																	</thead>
																	<tfoot>
																		<tr>
																			<th>Código</th>
																			<th>Descripción</th>
																			<th>Depto</th>
																			<th>Fam.</th>
																			<th>Lote</th>
																			<th>Caducidad</th>
																			<th>Captura</th>
																			<th>Cant.</th>
																			<th></th>
																		</tr>
																	</tfoot>
																</table>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="tab-pane" id="2">
											<div class="row">
												<div class="col-md-12">
													<br>
													<div class="table-responsive">
														<table id='lista_caducidades_arb' class='table table-striped table-bordered' cellspacing='0' width='100%'>
															<thead>
																<tr>
																	<th width='10%'>Código</th>
																	<th>Descripción</th>
																	<th width='15%'>Depto</th>
																	<th width='15%'>Fam.</th>
																	<th width='5%'>Lote</th>
																	<th width='10%'>Caducidad</th>
																	<th width='10%'>Captura</th>
																	<th width='5%'>Cant.</th>
																	<th width='5%'></th>
																</tr>
															</thead>
															<tfoot>
																<tr>
																	<th>Código</th>
																	<th>Descripción</th>
																	<th>Depto</th>
																	<th>Fam.</th>
																	<th>Lote</th>
																	<th>Caducidad</th>
																	<th>Captura</th>
																	<th>Cant.</th>
																	<th></th>
																</tr>
															</tfoot>
														</table>
													</div>
												</div>
											</div>
										</div>
										<div class="tab-pane" id="3">
											<div class="row">
												<div class="col-md-12">
													<br>
													<div class="table-responsive">
														<table id='lista_caducidades_vill' class='table table-striped table-bordered' cellspacing='0' width='100%'>
															<thead>
																<tr>
																	<th width='10%'>Código</th>
																	<th>Descripción</th>
																	<th width='15%'>Depto</th>
																	<th width='15%'>Fam.</th>
																	<th width='5%'>Lote</th>
																	<th width='10%'>Caducidad</th>
																	<th width='10%'>Captura</th>
																	<th width='5%'>Cant.</th>
																	<th width='5%'></th>
																</tr>
															</thead>
															<tfoot>
																<tr>
																	<th>Código</th>
																	<th>Descripción</th>
																	<th>Depto</th>
																	<th>Fam.</th>
																	<th>Lote</th>
																	<th>Caducidad</th>
																	<th>Captura</th>
																	<th>Cant.</th>
																	<th></th>
																</tr>
															</tfoot>
														</table>
													</div>
												</div>
											</div>
										</div>
										<div class="tab-pane" id="4">
											<div class="row">
												<div class="col-md-12">
													<br>
													<div class="table-responsive">
														<table id='lista_caducidades_all' class='table table-striped table-bordered' cellspacing='0' width='100%'>
															<thead>
																<tr>
																	<th width='10%'>Código</th>
																	<th>Descripción</th>
																	<th width='15%'>Depto</th>
																	<th width='15%'>Fam.</th>
																	<th width='5%'>Lote</th>
																	<th width='10%'>Caducidad</th>
																	<th width='10%'>Captura</th>
																	<th width='5%'>Cant.</th>
																	<th width='5%'></th>
																</tr>
															</thead>
															<tfoot>
																<tr>
																	<th>Código</th>
																	<th>Descripción</th>
																	<th>Depto</th>
																	<th>Fam.</th>
																	<th>Lote</th>
																	<th>Caducidad</th>
																	<th>Captura</th>
																	<th>Cant.</th>
																	<th></th>
																</tr>
															</tfoot>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /.row -->
			</section>
			<!-- /.content -->
		</div>
		<?php include 'modal_traspaso.php'; ?>
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
		$(document).ready(function(e) {
			$("#codigo").focus();
			cargar_tabla_do();
			cargar_tabla_arb();
			cargar_tabla_vill();
			cargar_tabla_all();
		});

		function cargar_tabla_do() {
			$('#lista_caducidades_do thead th').each(function() {
				var title = $(this).text();
				$(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
			});
			$('#lista_caducidades_do').dataTable().fnDestroy();
			var table_do = $('#lista_caducidades_do').DataTable({
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
					}
				],
				"ajax": {
					"type": "POST",
					"url": "tabla_caducidades_do.php",
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
					},
					{
						"data": "traspaso"
					}
				]
			});
			table_do.columns().every(function() {
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

		function cargar_tabla_arb() {
			$('#lista_caducidades_arb thead th').each(function() {
				var title = $(this).text();
				$(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
			});
			$('#lista_caducidades_arb').dataTable().fnDestroy();
			var table_arb = $('#lista_caducidades_arb').DataTable({
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
					}
				],
				"ajax": {
					"type": "POST",
					"url": "tabla_caducidades_arb.php",
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
					},
					{
						"data": "traspaso"
					}
				]
			});
			table_arb.columns().every(function() {
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

		function cargar_tabla_vill() {
			$('#lista_caducidades_vill thead th').each(function() {
				var title = $(this).text();
				$(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
			});
			$('#lista_caducidades_vill').dataTable().fnDestroy();
			var table_vill = $('#lista_caducidades_vill').DataTable({
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
					}
				],
				"ajax": {
					"type": "POST",
					"url": "tabla_caducidades_vill.php",
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
					},
					{
						"data": "traspaso"
					}
				]
			});
			table_vill.columns().every(function() {
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

		function cargar_tabla_all() {
			$('#lista_caducidades_all thead th').each(function() {
				var title = $(this).text();
				$(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
			});
			$('#lista_caducidades_all').dataTable().fnDestroy();
			var table_all = $('#lista_caducidades_all').DataTable({
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
					}
				],
				"ajax": {
					"type": "POST",
					"url": "tabla_caducidades_all.php",
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
					},
					{
						"data": "traspaso"
					}
				]
			});
			table_all.columns().every(function() {
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
		$('#modal-traspaso').on('show.bs.modal', function(e) {
			var id = $(e.relatedTarget).data().id;
			var suc = $(e.relatedTarget).data().suc;
			var max = $(e.relatedTarget).data().max;
			$("#ide").val(id);
			$("#suc").val(suc);
			$("#max").val(max);
		});
		$("#btn-traspasar").click(function() {
			var url = "insertar_traspaso.php";
			var ide = $("#ide").val();
			var suc = $("#suc").val();
			var max = $("#max").val();
			var cantidad = $("#cantidad").val();
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: {
					ide: ide,
					suc: suc,
					max: max,
					cantidad: cantidad
				},
				success: function(respuesta) {
					if (respuesta == "excedido") {
						alertify.error("El número de unidades a solicitar, excede el número de unidades disponibles");
					} else if (respuesta == "ok") {
						alertify.success("Los cambios han sido realizados correctamente");
					}
				},
				error: function(xhr, status) {
					alert("error");
					//alert(xhr);
				},
			})
			$('#modal-traspaso').modal('hide');
			cargar_tabla_do();
			cargar_tabla_arb();
			cargar_tabla_vill();
			cargar_tabla_all();
			return false;
		});
	</script>
</body>

</html>