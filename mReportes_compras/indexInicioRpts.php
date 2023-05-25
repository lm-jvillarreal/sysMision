<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
?>
<!DOCTYPE html>
<html>

<head>
	<?php include '../head.php'; ?>
	<script src="funciones.js"></script>

</head>
<style>
	#modal_kardex {
		width: 100% !important;
	}

	.box-footer {
		padding: 0px;
	}
</style>
<style>
	#modal_detalle {
		width: 100% !important;
	}
</style>

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
						<h3 class="box-title">Reportes | Reporte de ventas por tienda</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<table id="tablaReportesConsolidados" class="table table-bordered">
									<thead>
										<tr>
											<th width='10%'>Clave</th>
											<th>Descripción</th>
											<th width='5%'></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>COM001</td>
											<td>Reporte Detalle Compra</td>
											<th><button type="button" id="COM001" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-DetalleCompra"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
										<tr>
											<td>COM002</td>
											<td>Reporte Devoluciones</td>
											<th><button type="button" id="COM002" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-Devoluciones"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
										<tr>
											<td>COM003</td>
											<td>Reporte Ofertas Vigentes</td>
											<th><button type="button" id="COM003" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-OfertasVigentes"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
										<tr>
											<td>COM004</td>
											<td>Reporte Lista de Articulos por proveedor</td>
											<th><button type="button" id="COM004" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-ArticulosProvedor"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
										<tr>
											<td>COM005</td>
											<td>Reporte Compras vs Ventas</td>
											<th><button type="button" id="COM005" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-ComprasVentas"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
										<tr>
											<td>COM006</td>
											<td>Reporte Compras vs Ventas Filtros</td>
											<th><button type="button" id="COM006" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-ComprasVentasFiltros"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
										<tr>
											<td>COM007</td>
											<td>Reporte Existencias por codigo</td>
											<th><button type="button" id="COM007" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-ExistenciasPorCodigo"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
										<tr>
											<td>COM008</td>
											<td>Reporte Mermas por codigo</td>
											<th><button type="button" id="COM008" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-MermasPorCodigo"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>

										<tr>
											<td>COM009</td>
											<td>Reporte Ventas detallado</td>
											<th><button type="button" id="COM009" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-VentasDetallado"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
										<tr>
											<td>COM010</td>
											<td>Reporte Verificador Inventarios</td>
											<th><button type="button" id="COM010" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-VerificadorInventario"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
										<tr>
											<td>COM011</td>
											<td>Reporte Detalle de Artículos</td>
											<th><button type="button" id="COM011" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-DetalleArticulos"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
										<tr>
											<td>COM012</td>
											<td>Reporte de Existencias</td>
											<th><button type="button" id="COM012" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-ReporteExistencias"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
										<tr>
											<td>COM013</td>
											<td>Reporte Desplazamiento por Proveedor</td>
											<th><button type="button" id="COM013" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-DesplazaminetoCEDIS"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- /.row -->
			</section>
			<!-- /.content -->
		</div>
		<?php include 'modals/modalsReportes/modalDetalleCompra.php' ?>
		<?php include 'modals/modalsReportes/modalDevoluciones.php' ?>
		<?php include 'modals/modalsReportes/modalOfertasVigentes.php' ?>
		<?php include 'modals/modalsReportes/modalListaArticulosProvedor.php' ?>
		<?php include 'modals/modalsReportes/modalComprasVentas.php' ?>
		<?php include 'modals/modalsReportes/modalComprasVentasFiltros.php' ?>
		<?php include 'modals/modalsReportes/modalExistenciasPorCodigo.php' ?>
		<?php include 'modals/modalsReportes/modalMermasPorCodigo.php' ?>
		<?php include 'modals/modalsReportes/modalVentasDetallado.php' ?>
		<?php include 'modals/modalsReportes/modalVerificarInventario.php' ?>
		<?php include 'modals/modalsReportes/modalDetalleArticulos.php' ?>
		<?php include 'modals/modalsReportes/modalReporteDeExistencias.php' ?>
		<?php include 'modals/modalsReportes/modalDesplazaminetoProvedor.php' ?>
		<!-- /.content-wrapper -->
		<?php include 'modal_detalle.php'; ?>

		<?php include '../footer2.php'; ?>


		<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>


		<!-- Control Sidebar -->

		<!-- /.control-sidebar -->
		<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
		<div class="control-sidebar-bg"></div>
	</div>
	<!-- ./wrapper -->
	<?php include 'modal_kardex.php'; ?>

	<?php include '../footer.php'; ?>
	<!-- Page script -->


	<script>
	//<!--LEER MODALS-->
		$(document).ready(function() {
			$("modal-DetalleCompra").modal();
		});
		$(document).ready(function() {
			$("modal-Devoluciones").modal();
		});
		$(document).ready(function() {
			$("modal-OfertasVigentes").modal();
		});
		$(document).ready(function() {
			$("modal-ComprasVentas").modal();
		});
		$(document).ready(function() {
			$("modal-ComprasVentasFiltros").modal();
		});
		$(document).ready(function() {
			$("modal-ExistenciasPorCodigo").modal();
		});
		$(document).ready(function() {
			$("modal-MermasPorCodigo").modal();
		});
		$(document).ready(function() {
			$("modal-VentasDetallado").modal();
		});
		$(document).ready(function() {
			$("modal-VerificadorInventario").modal();
		});
		$(document).ready(function() {
			$("modal-DetalleArticulos").modal();
		});
		$(document).ready(function() {
			$("modal-ReporteExistencias").modal();
		});
		$(document).ready(function() {
			$("modal-DesplazaminetoCEDIS").modal();
		});
	//<!--TEXT FOR SELECT'S-->
		$('.select').select2({
			width: '100%',
			placeholder: 'Seleccione una opcion',
			lenguage: 'es'
		});
	// FUINCIONES MODAL 1
		$(document).ready(function() {
		$("#sucursal_COM001").select2({
			dropdownParent: $("#modal-DetalleCompra"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
		$('#proveedor_COM001').select2({
		width: '100%',
		placeholder: 'Seleccione una opción',
		language: 'es',
		minimumResultsForSearch: 0,
		dropdownParent: $('#modal-DetalleCompra'),
		ajax: {
			url: 'consulta_proveedores.php',
			type: 'post',
			dataType: 'json',
			delay: 250,
			data: function (params) {
			return {
				searchTerm: params.term
			};
			},
			processResults: function (response) {
			return {
				results: response
			};
			},
			cache: true
		}
		});
		$('#departamento_COM001').select2({
		width: '100%',
		placeholder: 'Seleccione una opción',
		language: 'es',
		minimumResultsForSearch: 0,
		dropdownParent: $('#modal-DetalleCompra'),
		ajax: {
			url: 'consulta_departamentos.php',
			type: 'post',
			dataType: 'json',
			delay: 250,
			data: function (params) {
			return {
				searchTerm: params.term
			};
			},
			processResults: function (response) {
			return {
				results: response
			};
			},
			cache: true
		}
		});
		$(document).ready(function() {
		$("#tipo_entrada_COM001").select2({
			dropdownParent: $("#modal-DetalleCompra"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
	// FUINCIONES MODAL 2
		$(document).ready(function() {
		$("#sucursal_COM002").select2({
			dropdownParent: $("#modal-Devoluciones"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
		$('#proveedor_COM002').select2({
		width: '100%',
		placeholder: 'Seleccione una opción',
		language: 'es',
		minimumResultsForSearch: 0,
		dropdownParent: $('#modal-Devoluciones'),
		ajax: {
			url: 'consulta_proveedores.php',
			type: 'post',
			dataType: 'json',
			delay: 250,
			data: function (params) {
			return {
				searchTerm: params.term
			};
			},
			processResults: function (response) {
			return {
				results: response
			};
			},
			cache: true
		}
		});
		$(document).ready(function() {
		$("#tipo_COM002").select2({
			dropdownParent: $("#modal-Devoluciones"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
	// FUINCIONES MODAL 3
		$(document).ready(function() {
		$("#sucursal_COM003").select2({
			dropdownParent: $("#modal-OfertasVigentes"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
		$('#proveedor_COM003').select2({
		width: '100%',
		placeholder: 'Seleccione una opción',
		language: 'es',
		minimumResultsForSearch: 0,
		dropdownParent: $('#modal-OfertasVigentes'),
		ajax: {
			url: 'consulta_proveedores.php',
			type: 'post',
			dataType: 'json',
			delay: 250,
			data: function (params) {
			return {
				searchTerm: params.term
			};
			},
			processResults: function (response) {
			return {
				results: response
			};
			},
			cache: true
		}
		});
		$('#departamento_COM003').select2({
		width: '100%',
		placeholder: 'Seleccione una opción',
		language: 'es',
		minimumResultsForSearch: 0,
		dropdownParent: $('#modal-OfertasVigentes'),
		ajax: {
			url: 'consulta_departamentos.php',
			type: 'post',
			dataType: 'json',
			delay: 250,
			data: function (params) {
			return {
				searchTerm: params.term
			};
			},
			processResults: function (response) {
			return {
				results: response
			};
			},
			cache: true
		}
		});
	// FUINCIONES MODAL 4
		$('#proveedor_COM004').select2({
		width: '100%',
		placeholder: 'Seleccione una opción',
		language: 'es',
		minimumResultsForSearch: 0,
		dropdownParent: $('#modal-ArticulosProvedor'),
		ajax: {
			url: 'consulta_proveedores.php',
			type: 'post',
			dataType: 'json',
			delay: 250,
			data: function (params) {
			return {
				searchTerm: params.term
			};
			},
			processResults: function (response) {
			return {
				results: response
			};
			},
			cache: true
		}
		});
	// FUINCIONES MODAL 5
		$(document).ready(function() {
		$("#sucursal_COM005").select2({
			dropdownParent: $("#modal-ComprasVentas"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
		$('#proveedor_COM005').select2({
		width: '100%',
		placeholder: 'Seleccione una opción',
		language: 'es',
		minimumResultsForSearch: 0,
		dropdownParent: $('#modal-ComprasVentas'),
		ajax: {
			url: 'consulta_proveedores.php',
			type: 'post',
			dataType: 'json',
			delay: 250,
			data: function (params) {
			return {
				searchTerm: params.term
			};
			},
			processResults: function (response) {
			return {
				results: response
			};
			},
			cache: true
		}
		});
	// FUINCIONES MODAL 6
		$(document).ready(function() {
		$("#sucursal_COM006").select2({
			dropdownParent: $("#modal-ComprasVentasFiltros"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
		$('#departamento_COM006').select2({
		width: '100%',
		placeholder: 'Seleccione una opción',
		language: 'es',
		minimumResultsForSearch: 0,
		dropdownParent: $('#modal-ComprasVentasFiltros'),
		ajax: {
			url: 'consulta_departamentos.php',
			type: 'post',
			dataType: 'json',
			delay: 250,
			data: function (params) {
			return {
				searchTerm: params.term
			};
			},
			processResults: function (response) {
			return {
				results: response
			};
			},
			cache: true
		}
		});
		$('#familia_COM006').select2({
			width: '100%',
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: 0,
			dropdownParent: $("#modal-ComprasVentasFiltros"),
			ajax: {
				url: "consulta_familias.php",
				type: "post",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						searchTerm: params.term
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
		$(document).ready(function() {
		$("#tipo_COM006").select2({
			dropdownParent: $("#modal-ComprasVentasFiltros"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
	// FUINCIONES MODAL 7
		$(document).ready(function() {
		$("#sucursal_COM007").select2({
			dropdownParent: $("#modal-ExistenciasPorCodigo"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});

		$('#departamento_COM007').select2({
			width: '100%',
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: 0,
			dropdownParent: $("#modal-ExistenciasPorCodigo"),
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
		$('#familia_COM007').select2({
			width: '100%',
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: 0,
			dropdownParent: $("#modal-ExistenciasPorCodigo"),
			ajax: {
				url: "consulta_familias.php",
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
	// FUINCIONES MODAL 8
		$(document).ready(function() {
		$("#sucursal_COM008").select2({
			dropdownParent: $("#modal-MermasPorCodigo"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
		$('#departamento_COM008').select2({
			width: '100%',
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: 0,
			dropdownParent: $("#modal-MermasPorCodigo"),
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
		$('#familia_COM008').select2({
			width: '100%',
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: 0,
			dropdownParent: $("#modal-MermasPorCodigo"),
			ajax: {
				url: "consulta_familias.php",
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
	// FUINCIONES MODAL 9
		$(document).ready(function() {
		$("#sucursal_COM009").select2({
			dropdownParent: $("#modal-VentasDetallado"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
		
		function cargar_tabla() {
			var sucursal_VD = $("#sucursal_COM009").val();
			var fech = $("#fecha").val();
			$('#lista_ventas').dataTable().fnDestroy();
			$('#lista_ventas').DataTable({
				'language': {
					"url": "../plugins/DataTables/Spanish.json"
				},
				"paging": false,
				select: {
					style: 'multi'
				},
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
						title: 'RepVentasDetalle',
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
					"url": "tabla_ventas_detallado.php",
					"dataSrc": "",
					"data": {
						sucursal_VD: sucursal_VD,
						fech: fech
					}
				},
				"columns": [{
						"data": "codigo"
					},
					{
						"data": "descripcion"
					},
					{
						"data": "cantidad"
					},
					{
						"data": "familia"
					},
					{
						"data": "operacion"
					},
					{
						"data": "fecha"
					},
					{
						"data": "hora"
					}
				]
			});
		}
	// FUINCIONES MODAL 10
		$(document).ready(function() {
			cargar_tabla_VI();
		})
		$(":file").filestyle('buttonText', 'Seleccionar');
		$(":file").filestyle('size', 'sm');
		$(":file").filestyle('input', true);
		$(":file").filestyle('disabled', false);
		$('#sucursal-VI').select2({
			width: '100%',
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: 0,
			dropdownParent: $("#modal-VerificadorInventario"),
			ajax: {
				url: "consulta_sucursales.php",
				type: "POST",
				dataType: 'JSON',
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
		})
		$('#form-catalogo-VI').submit(function(e) {
			if ($("#action").val() == "" || $("#fecha_inicial").val() == "" || $("#fecha_final").val() == "" || $("#sucursal-VI").val() == "") {
				alertify.error("Datos incompletos.");
			} else {
				var data = new FormData(this); //Creamos los datos a enviar con el formulario
				$.ajax({
					url: 'importar_folio.php', //URL destino
					data: data,
					processData: false, //Evitamos que JQuery procese los datos, daría error
					contentType: false, //No especificamos ningún tipo de dato
					type: 'POST',
					success: function(resultado) {
						if (resultado == "ok") {
							swal("Completado", "El folio se importó correctamente", "success");
						} else if (resultado == "invalido") {
							alertify.error("El archivo que intenta subir no es válido");
						}
						$(":text").val("");
						cargar_tabla_VI();
					}
				});
			}
			e.preventDefault(); //Evitamos que se mande del formulario de forma convencional
		});
		$("#btnCargarFolio").click(function() {
			$("#form-catalogo-VI").submit();
		});
		$('#modal-kardex').on('show.bs.modal', function(e) {
			var folio = $(e.relatedTarget).data().folio;
			$("#folio_modal_VI").val(folio);
			tabla_modal_VI(folio);
		});

		function cargar_tabla_VI() {
			$('#lista_folios-VI').dataTable().fnDestroy();
			$('#lista_folios-VI').DataTable({
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
					"url": "tabla_folios.php",
					"dataSrc": ""
				},
				"columns": [{
						"data": "folio"
					},
					{
						"data": "rango"
					},
					{
						"data": "cantidad"
					},
					{
						"data": "fecha"
					},
					{
						"data": "sucursal"
					},
					{
						"data": "usuario"
					},
					{
						"data": "opciones"
					}
				]
			});
		}

		function tabla_modal_VI(folio) {
			$('#lista_detalle-VI').dataTable().fnDestroy();
			$('#lista_detalle-VI').DataTable({
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
						text: 'Actualizar datos',
						action: function() {
							actualizaDetalle_VI();
						},
						counter: 1
					},
				],
				"ajax": {
					"type": "POST",
					"url": "tabla_detalle.php",
					"dataSrc": "",
					data: {
						folio: folio
					}
				},
				"columns": [{
						"data": "artc_articulo"
					},
					{
						"data": "artc_descripcion"
					},
					{
						"data": "costo"
					},
					{
						"data": "ppublico"
					},
					{
						"data": "poferta"
					},
					{
						"data": "inicial"
					},
					{
						"data": "compra"
					},
					{
						"data": "etrans"
					},
					{
						"data": "exdev"
					},
					{
						"data": "entradas"
					},
					{
						"data": "totent"
					},
					{
						"data": "salxve"
					},
					{
						"data": "strans"
					},
					{
						"data": "devol"
					},
					{
						"data": "salidas"
					},
					{
						"data": "totsal"
					},
					{
						"data": "teorico"
					}
				]
			});
		}

		function actualizaDetalle_VI() {
			var folio_modal_VI = $("#folio_modal_VI").val();
			$('#lista_detalle-VI').dataTable().fnClearTable();
			swal("Los registros se están actualizando, espere...", {
				icon: "info",
				closeOnClickOutside: false,
				buttons: false
			});
			var url = "actualizar_detalle.php"; // El script a dónde se realizará la petición.
			$.ajax({
				type: "POST",
				url: url,
				data: {
					folio_modal_VI: folio_modal_VI
				}, // Adjuntar los campos del formulario enviado.
				success: function(respuesta) {
					if (respuesta == "ok") {
						swal("La tabla ha sido actualizada correctamente", {
							icon: "success",
						});
						tabla_modal_VI(folio_modal_VI);
					}
				}
			});
			// Evitar ejecutar el submit del formulario.
			return false;
		}

		function eliminar_folio(folio) {
			var url = "eliminar_folio.php";
			$.ajax({
				type: "POST",
				url: url,
				data: {
					folio: folio
				}, // Adjuntar los campos del formulario enviado.
				success: function(respuesta) {
					alertify.success("Folio eliminado correctamente");
					cargar_tabla();
				}
			});
		}
	// FUINCIONES MODAL 11
		$(document).ready(function() {
			cargar_tabla();
		})
		$(":file").filestyle('buttonText', 'Seleccionar');
		$(":file").filestyle('size', 'sm');
		$(":file").filestyle('input', true);
		$(":file").filestyle('disabled', false);
		$('#sucursal-DA').select2({
			width: '100%',
			dropdownParent: $("#modal-DetalleArticulos"),
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: Infinity,
			ajax: {
				url: "consulta_sucursales.php",
				type: "POST",
				dataType: 'JSON',
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
		})
		$('#form-catalogo').submit(function(e) {
			if ($("#action").val() == "" || $("#descripcion").val() == "" || $("#sucursal-DA").val() == "") {
				alertify.error("Datos incompletos.");
			} else {
				var data = new FormData(this); //Creamos los datos a enviar con el formulario
				$.ajax({
					url: 'importar_folio_detalle.php', //URL destino
					data: data,
					processData: false, //Evitamos que JQuery procese los datos, daría error
					contentType: false, //No especificamos ningún tipo de dato
					type: 'POST',
					success: function(resultado) {
						if (resultado == "ok") {
							swal("Completado", "El folio se importó correctamente", "success");
						} else if (resultado == "invalido") {
							alertify.error("El archivo que intenta subir no es válido");
						}
						$(":text").val("");
						cargar_tabla();
					}
				});
			}
			e.preventDefault(); //Evitamos que se mande del formulario de forma convencional
		});
		$("#btnCargarFolio").click(function() {
			$("#form-catalogo").submit();
		});
		$('#modal-detalle').on('show.bs.modal', function(e) {
			var folio = $(e.relatedTarget).data().folio;
			$("#folio_modal").val(folio);
			tabla_modal(folio);
		});

		function cargar_tabla() {
			$('#lista_folios-DA').dataTable().fnDestroy();
			$('#lista_folios-DA').DataTable({
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
					"url": "tabla_folios_detalle.php",
					"dataSrc": ""
				},
				"columns": [{
						"data": "folio"
					},
					{
						"data": "descripcion"
					},
					{
						"data": "cantidad"
					},
					{
						"data": "fecha"
					},
					{
						"data": "sucursal"
					},
					{
						"data": "usuario"
					},
					{
						"data": "opciones"
					}
				]
			});
		}

		function tabla_modal(folio) {
			$('#lista_detalle').dataTable().fnDestroy();
			$('#lista_detalle').DataTable({
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
					"url": "tabla_detalle_articulo.php",
					"dataSrc": "",
					data: {
						folio: folio
					}
				},
				"columns": [{
						"data": "artc_articulo"
					},
					{
						"data": "artc_descripcion"
					},
					{
						"data": "costo_anterior"
					},
					{
						"data": "costo_ultimo"
					},
					{
						"data": "ppublico"
					},
					{
						"data": "margen_publico"
					},
					{
						"data": "poferta"
					},
					{
						"data": "margen_oferta"
					},
					{
						"data": "vigencia_oferta"
					},
					{
						"data": "do"
					},
					{
						"data": "arb"
					},
					{
						"data": "vill"
					},
					{
						"data": "all"
					},
					{
						"data": "lp"
					},
					{
						"data": "cedis"
					},
					{
						"data": "total"
					},
					{
						"data": "depto"
					},
					{
						"data": "familia"
					}
				]
			});
		}

		function actualizaDetalle() {
			var folio_modal = $("#folio_modal").val();
			$('#lista_detalle').dataTable().fnClearTable();
			swal("Los registros se están actualizando, espere...", {
				icon: "info",
				closeOnClickOutside: false,
				buttons: false
			});
			var url = "actualizar_detalle.php"; // El script a dónde se realizará la petición.
			$.ajax({
				type: "POST",
				url: url,
				data: {
					folio_modal: folio_modal
				}, // Adjuntar los campos del formulario enviado.
				success: function(respuesta) {
					if (respuesta == "ok") {
						swal("La tabla ha sido actualizada correctamente", {
							icon: "success",
						});
						tabla_modal(folio_modal);
					}
				}
			});
			// Evitar ejecutar el submit del formulario.
			return false;
		}

		function eliminar(folio) {
			var url = 'eliminar_folios.php';
			$.ajax({
				type: "POST",
				url: url,
				data: {
					folio: folio
				}, // Adjuntar los campos del formulario enviado.
				success: function(respuesta) {
					alertify.success("Registro eliminado correctamente");
				}
			});
			return false;
		}

	// FUINCIONES MODAL 13
		$('#proveedor_COM013').select2({
			width: '100%',
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: 0,
			dropdownParent: $("#modal-DesplazaminetoCEDIS"),
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
	// FUINCIONES VALIDAR CAMPOS VACIONS EN MODALS		
		function generarReporte(boton) {
			var idFormulario = $(boton).closest('form').attr('id');
			var formularioValido = true;
			//$( idFormulario ).each(function() {
			$('#' + idFormulario + '  input:not(.no-validar), #' + idFormulario + ' select:not(.no-validar)').each(function() {
				if ($(this).val() == '') {
					formularioValido = false;
					return false;
				}
			});
			// Mostrar mensaje de validación
			if (formularioValido) {
				// Serializar datos del formulario
				var datosFormulario = $('#' + idFormulario + ' input, #' + idFormulario + ' select').serialize();
				console.log(datosFormulario);
				// Hacer la petición AJAX
				$.ajax({
					url: 'reportes2/rpt_' + idFormulario + '.php',
					method: 'POST',
					data: datosFormulario,
					xhrFields: {
						responseType: 'blob'
					},
					success: function(data, textStatus, jqXHR) {
						// Obtener el nombre del archivo del encabezado Content-Disposition
						var nombreArchivo = jqXHR.getResponseHeader('Content-Disposition').match(/filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/)[1].replace(/['"]/g, '');
						// Crea un objeto URL para el archivo descargado
						var url = URL.createObjectURL(data);
						// Crea un enlace para descargar el archivo y haz clic en él para iniciar la descarga
						var a = document.createElement('a');
						a.href = url;
						a.download = nombreArchivo;
						a.click();
						// Libera el objeto URL
						URL.revokeObjectURL(url);
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert('Error al descargar el reporte:', errorThrown);
					}
				});
			} else {
				alertify.error("Existen campos vacíos");
			}
		}
	//<!--SCRIPT'S FOR DATE-->
	$('.form_datetime').datetimepicker({
		//language:  'fr',
		weekStart: 1,
		todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
		showMeridian: 1
	});
	$('.form_date').datetimepicker({
		language:  'es',
		weekStart: 1,
		todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
	});
	$('.form_time').datetimepicker({
		language:  'fr',
		weekStart: 1,
		todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
	});
	//FIN
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>