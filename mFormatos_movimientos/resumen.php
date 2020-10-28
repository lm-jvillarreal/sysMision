<?php
include '../global_seguridad/verificar_sesion.php';
function _data_last_month_day()
{
	$month = date('m');
	$year = date('Y');
	$day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));

	return date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
};

/** Actual month first day **/
function _data_first_month_day()
{
	$month = date('m');
	$year = date('Y');
	return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
}
$fecha1 = _data_first_month_day();
$fecha2 =  _data_last_month_day();
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
				<div class="box box-danger" id="div-articulos">
					<div class="box-header">
						<h3 class="box-title">Formatos de Movimientos | Solicitud</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-4">
								<label for="tipo_formato">*Tipo</label>
								<select name="tipo" id="tipo" class="form-control" onchange="generar()">
									<option value=""></option>
									<option value="1">Movimientos</option>
									<option value="2">Sucursales</option>
									<option value="3">Estatus</option>
									<option value="4">Usuario Solicita</option>
									<option value="5">Usuario Libera</option>
								</select>
							</div>
							<div class="col-md-4">
								<label>*Fecha Inicio</label>
								<div class="input-group date form_date" data-date="<?php echo $fecha1 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
									<input class="form-control" size="16" type="text" value="<?php echo $fecha1 ?>" readonly name="fecha1" id="fecha1" onchange="generar()">
									<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="col-md-4">
								<label>*Fecha Final</label>
								<div class="input-group date form_date" data-date="<?php echo $fecha2 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
									<input class="form-control" size="16" type="text" value="<?php echo $fecha2 ?>" readonly name="fecha2" id="fecha2" onchange="generar()">
									<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer text-right">
						<button class="btn btn-danger" id="btn-guardar" onclick="generar()">Generar</button>
					</div>
				</div>
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Resumen</h3>
					</div>
					<div class="box-body">
						<div class="col-md-12" id="datos">

						</div>
					</div>
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
		function generar() {
			var tipo = $('#tipo').val();
			var fecha1 = $('#fecha1').val();
			var fecha2 = $('#fecha2').val();

			$.ajax({
				url: 'datos_resumen.php',
				type: "POST",
				dateType: "html",
				data: {
					'tipo': tipo,
					'fecha1': fecha1,
					'fecha2': fecha2
				},
				success: function(respuesta) {
					$('#datos').html(respuesta);
				},
				error: function(xhr, status) {
					alert("error");
					//alert(xhr);
				},
			});
		}
		$(function() {
			$('#tipo').select2({
				placeholder: 'Seleccione una opcion',
				lenguage: 'es'
			})
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
	</script>
</body>

</html>