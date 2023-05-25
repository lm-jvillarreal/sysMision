<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
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
											<th>Reporte</th>
											<th width='5%'></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>ADM001</td>
											<td>Reporte consolidado de requerimientos ViDO</td>
											<th><button type="button" id="ADM001" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-ADM001"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
										<tr>
											<td>ADM001-Nuevo</td>
											<td>Reporte consolidado de requerimientos ViDO</td>
											<th><button type="button" id="ADM001" class="btn btn-danger btn-sm"data-toggle="modal" data-target="#modal-mADM001"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
										<tr>
											<td>ADM002</td>
											<td>Reporte consolidado de ventas por tienda</td>
											<th><button type="button" id="ADM002" class="btn btn-danger btn-sm"data-toggle="modal" data-target="#modal-mADM002"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
										<tr>
											<td>ADM003</td>
											<td>Reporte consolidado de ventas por familia</td>
											<th><button type="button" id="ADM003" class="btn btn-danger btn-sm"data-toggle="modal" data-target="#modal-mADM003"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
										<tr>
											<td>ADM004</td>
											<td>Reporte consolidado de ventas por departamento</td>
											<th><button type="button" id="ADM004" class="btn btn-danger btn-sm"data-toggle="modal" data-target="#modal-mADM004"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
										</tr>
										<tr>
											<td>ADM005</td>
											<td>Reporte consolidado de ventas por proveedor</td>
											<th><button type="button" id="ADM005" class="btn btn-danger btn-sm"data-toggle="modal" data-target="#modal-mADM005"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
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
		<?php include 'modal_ADM001.php' ?>
		<?php include './modals/modalsReportes/modalADM001.php' ?>
		<?php include './modals/modalsReportes/modalADM002.php' ?>
		<?php include './modals/modalsReportes/modalADM003.php' ?>
		<?php include './modals/modalsReportes/modalADM004.php' ?>
		<?php include './modals/modalsReportes/modalADM005.php' ?>
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
		$(document).ready(function() {
			$("modal-mADM003").modal();
		})		
	//FUNCIONES BASE MODAL 1		
		$('#ADM001_sucursal').select2({
			width: '100%',
			dropdownParent: $("#modal-ADM001"),
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: Infinity,
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
		function GenerarReporte(claveReporte) {
			var sucursal = $("#" + claveReporte + "_sucursal").val();
			var fechaInicio = $("#" + claveReporte + "_fecha_inicial").val();
			var fechaFin = $("#" + claveReporte + "_fecha_final").val();
			alert(sucursal);
			$.ajax({
				url: 'reportes/rpt_' + claveReporte + '.php',
				method: 'POST',
				xhrFields: {
					responseType: 'blob'
				},
				data: {
					sucursal: sucursal,
					fechaInicio: fechaInicio,
					fechaFin: fechaFin
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
					console.log('Error al descargar el reporte:', errorThrown);
				}
			});
		}
	//MODAL 1
		$(document).ready(function() {
		$("#sucursal_ADM001").select2({
			dropdownParent: $("#modal-mADM001"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
	//MODAL 2
		$(document).ready(function() {
		$("#sucursal_ADM002").select2({
			dropdownParent: $("#modal-mADM002"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
	//MODAL 3
		$(document).ready(function() {
		$("#sucursal_ADM003").select2({
			dropdownParent: $("#modal-mADM003"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
	//MODAL 4
		$(document).ready(function() {
		$("#sucursal_ADM004").select2({
			dropdownParent: $("#modal-mADM004"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
	//MODAL 5
		$(document).ready(function() {
		$("#sucursal_ADM005").select2({
			dropdownParent: $("#modal-mADM005"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
	//FUNCIONES NEW MODAL
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
					url: 'rpt_' + idFormulario + '.php',
					method: 'POST',
					data: datosFormulario,
					xhrFields: {
						responseType: 'blob'
					},
					success: function(data, textStatus, jqXHR) {
						// Obtener el nombre del archivo del encabezado Content-Disposition
						var nombreArchivo2 = jqXHR.getResponseHeader('Content-Disposition').match(/filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/)[1].replace(/['"]/g, '');
						// Crea un objeto URL para el archivo descargado
						var url = URL.createObjectURL(data);
						// Crea un enlace para descargar el archivo y haz clic en él para iniciar la descarga
						var a = document.createElement('a');
						a.href = url;
						a.download = nombreArchivo2;
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
	//FORMATO FECHAS
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