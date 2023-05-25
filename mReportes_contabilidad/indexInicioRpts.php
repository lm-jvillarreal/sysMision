<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<?php include '../head.php'; ?>
	<script src="funciones.js"></script>
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
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<!-- Main content -->
			<section class="content">
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Reportes</h3>
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
											<td>CON001</td>
											<td>Reporte Compras y pagos</td>
											<th><button type="button" id="CON001" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mCON001"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
									</tbody>
									<tbody>
										<tr>
											<td>CON002</td>
											<td>Reporte Facturas UUID</td>
											<th><button type="button" id="CON002" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mCON002"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
									</tbody>
									<tbody>
										<tr>
											<td>CON003</td>
											<td>Reporte Facturas-Ingresos</td>
											<th><button type="button" id="CON003" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mCON003"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
									</tbody>
									<tbody>
										<tr>
											<td>CON004</td>
											<td>Reporte Comprobantes-Cheques</td>
											<th><button type="button" id="CON004" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mCON004"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
									</tbody>
									<tbody>
										<tr>
											<td>CON005</td>
											<td>Reporte Comprobantes-Transferencias</td>
											<th><button type="button" id="CON005" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mCON005"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
									</tbody>
									<tbody>
										<tr>
											<td>CON006</td>
											<td>Reporte Creditos</td>
											<th><button type="button" id="CON006" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mCON006"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<?php include './modals/modalsReportes/modalCON001.php' ?>
		<?php include './modals/modalsReportes/modalCON002.php' ?>
		<?php include './modals/modalsReportes/modalCON003.php' ?>
		<?php include './modals/modalsReportes/modalCON004.php' ?>
		<?php include './modals/modalsReportes/modalCON005.php' ?>
		<?php include './modals/modalsReportes/modalCON006.php' ?>
		<?php include '../footer2.php'; ?>
	</div><!-- ./wrapper -->
	<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
	<div class="control-sidebar-bg"></div>
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
		//<!--LEER MODALS-->
			$(document).ready(function() {
				$("modal-mCON001").modal();
			});
			$(document).ready(function() {
				$("modal-mCON002").modal();
			});
			$(document).ready(function() {
				$("modal-mCON003").modal();
			});
			$(document).ready(function() {
				$("modal-mCON004").modal();
			});
			$(document).ready(function() {
				$("modal-mCON005").modal();
			});
			$(document).ready(function() {
				$("modal-mCON006").modal();
			});
		// FUNCIONES MODAL 1
			$('#proveedor_CON001').select2({
			width: '100%',
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: 0,
			dropdownParent: $("#modal-mCON001"),
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
		// FUNCIONES MODAL 4
			function cargar_tabla_CON004() {
			var fecha_inicial_CON004 = $("#fecha_inicial_CON004").val();
			var fecha_final_CON004 = $("#fecha_final_CON004").val();
			$('#lista_cheques_CON004').dataTable().fnDestroy();
			$('#lista_cheques_CON004').DataTable({
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
				"url": "tabla_cheques.php",
				"dataSrc": "",
				"data": {
					fecha_inicial: fecha_inicial_CON004,
					fecha_final: fecha_final_CON004
				}
				},
				"columns": [{
					"data": "conteo"
				},
				{
					"data": "numero_cheque"
				},
				{
					"data": "proveedor"
				},
				{
					"data": "monto"
				}
				]
			});
			}
			$(document).ready(function() {
			//cargar_tabla_CON004();
			});
			$("#btn-cargar_CON004").click(function(){
			cargar_tabla_CON004();
			return false;
			})
		// FUNCIONES MODAL 5
			function cargar_tabla_CON005() {
			var fecha_inicial_CON005 = $("#fecha_inicial_CON005").val();
			var fecha_final_CON005 = $("#fecha_final_CON005").val();
			$('#lista_cheques_CON005').dataTable().fnDestroy();
			$('#lista_cheques_CON005').DataTable({
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
				"url": "tabla_transferencias.php",
				"dataSrc": "",
				"data": {
					fecha_inicial: fecha_inicial_CON005,
					fecha_final: fecha_final_CON005
				}
				},
				"columns": [{
					"data": "conteo"
				},
				{
					"data": "numero_cheque"
				},
				{
					"data": "proveedor"
				},
				{
					"data": "monto"
				},
				{
					"data": "fecha"
				}
				]
			});
			}
			$("#btn-cargar").click(function(){
			cargar_tabla_CON005();
			return false;
			})
		// FUNCIONES MODAL 6
			$(document).ready(function() {
			$("#sucursal_CON006").select2({
				dropdownParent: $("#modal-mCON006"),
				width: '100%',
				placeholder: 'Seleccione una opcion',
			});
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
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>