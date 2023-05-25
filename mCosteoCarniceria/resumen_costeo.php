<?php
include '../global_seguridad/verificar_sesion.php';
?>
<!DOCTYPE html>
<html>

<head>
	<?php include '../head.php'; ?>
	<link rel="stylesheet" href="../d_plantilla/plugins/timepicker/bootstrap-timepicker.min.css">
	<link href="https://cdn.datatables.net/fixedcolumns/3.2.4/css/fixedColumns.bootstrap4.min.css" rel="stylesheet" />
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
						<h3 class="box-title">Costeo de Carnicería | Filtros</h3>
					</div>
					<div class="box-body">
						<form action="" method="POST" id="form-datos">
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
						</form>
					</div>
					<div class="box-footer text-right">
						<button class="btn btn-danger" id="btn-guardar">Consultar</button>
					</div>
				</div>
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Costeo de carnicería | Bitácora</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id='lista_costeos' class='display table table-striped table-bordered nowrap' style="width:125%" cellspacing='0'>
										<thead>
											<tr>
												<th width='4%'>#</th>
												<th width='5%'>Artículo</th>
												<th>Descripción</th>
												<th>Proveedor</th>
												<th width='7%'>Peso Pza</th>
												<th width='7%'>Peso Cte</th>
												<th width='7%'>Merma Kg</th>
												<th width='7%'>Merma $</th>
												<th width='7%'>Costo KG</th>
												<th width='7%'>Cto. PZA.</th>
												<th width='7%'>Cto. neto</th>
												<th width='6%'>Cto. KG</th>
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
		<?php include 'modal_costeorenglones.php'; ?>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/fixedcolumns/3.2.4/js/dataTables.fixedColumns.min.js"></script>
	<script>
		$(document).ready(function() {
			cargar_tabla();
		});
		$("#sucursal").change(function() {
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

		function cargar_tabla() {
			var sucursal = $("#sucursal").val();
			$('#lista_costeos').dataTable().fnDestroy();
			$('#lista_costeos').DataTable({
				'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        fixedColumns: {
          leftColumns: 1,
          rightColumns: 1
        },
        'order': [
          [0, "desc"]
        ],
        "scrollX": true,
        "scrollY": "300px",
        "scrollCollapse": true,
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
				],
				"ajax": {
					"type": "POST",
					"url": "tabla_historialcosteos.php",
					"dataSrc": "",
					"data": {
						sucursal: sucursal
					}
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
						"data": "proc_proveedor"
					},
					{
						"data": "artc_pesoent"
					},
					{
						"data": "artc_pesocorte"
					},
					{
						"data": "merma_peso"
					},
					{
						"data": "merma_costo"
					},
					{
						"data": "artc_costokilo"
					},
					{
						"data": "artc_costototal"
					},
					{
						"data": "artc_costoglobal"
					},
					{
						"data": "artc_costokiloneto"
					},
					{
						"data": "opciones"
					}
				]
			});
		}
		$('#modal_costeorenglones').on('show.bs.modal', function(e) {
			$(".modal-dialog").css("width", "95%");
			var folio = $(e.relatedTarget).data().folio;
			cargar_tabla_modal(folio);
		});

		function cargar_tabla_modal(id_costeo) {
			$('#lista_costeorenglones').dataTable().fnDestroy();
			$('#lista_costeorenglones').DataTable({
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
							finalizar_costeo(id_costeo);
						},
						counter: 1
					},
				],
				"ajax": {
					"type": "POST",
					"url": "tabla_costeorenglones.php",
					"dataSrc": "",
					"data": {
						id_costeo: id_costeo
					}
				},
				"columns": [{
						"data": "numero"
					},
					{
						"data": "artc_articulo"
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

		function cambiar_precio(id_renglon) {
			var url = 'cambiar_precio.php';
			swal("Ingresa una precio", {
					content: "input",
				})
				.then((value) => {
					var cantidad = `${value}`;
					$.ajax({
						type: "POST",
						url: url,
						data: {
							id_renglon: id_renglon,
							cantidad: cantidad
						}, // Adjuntar los campos del formulario enviado.
						success: function(respuesta) {
							$("#lista_costeorenglones").DataTable().ajax.reload();
							swal("Listo!", "Precio y margen modificado", "success");

						}
					});
				});
		}

		function finalizar_costeo(id_costeo) {
			var url = "finalizar_margenes.php";
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
						$("#lista_costeos").DataTable().ajax.reload();
					}
				},
				error: function(xhr, status) {
					alert("error");
				}
			});
		}
	</script>
</body>

</html>