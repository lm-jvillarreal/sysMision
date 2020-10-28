<?php
include '../global_seguridad/verificar_sesion.php';
$hora = date("h:i:s");
function _datos_primer_dia_mes_pasado()
{
	$month = date('m');
	$year = date('Y');
	$day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));

	return date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
};

/** Actual month first day **/
function _datos_primer_dia_mes()
{
	$month = date('m');
	$year = date('Y');
	return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
}
$fecha1 = _datos_primer_dia_mes();
$fecha2 =  _datos_primer_dia_mes_pasado();
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
						<h3 class="box-title">Ordenes de Compra | Resumen</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="fecha1">*Fecha de inicio:</label>
									<div class="input-group date form_date" data-date="<?php echo $fecha1 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
										<input class="form-control" size="16" type="text" value="<?php echo $fecha1 ?>" readonly id="fecha_inicio" name="fecha_inicio">
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="fecha2">*Fecha final:</label>
									<div class="input-group date form_date" data-date="<?php echo $fecha2 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
										<input class="form-control" size="16" type="text" value="<?php echo $fecha2 ?>" readonly id="fecha_fin" name="fecha_fin">
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									</div>
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
						</div>
						<div class="row">
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="info-box bg-aqua">
									<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Órdenes de Compra</span>
										<span class="info-box-number" id="total"></span>

										<div class="progress">
											<div class="progress-bar" style="width: 100%"></div>
										</div>
										<span class="progress-description">
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="info-box bg-green">
									<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Con Orden de Compra</span>
										<span class="info-box-number" id="total_entcoc"></span>

										<div class="progress">
											<div class="progress-bar" id="pgrs_entcoc"></div>
										</div>
										<span class="progress-description" id="porc_entcoc">
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="info-box bg-yellow">
									<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Sin Orden de Compra</span>
										<span class="info-box-number" id="total_entsoc"></span>

										<div class="progress">
											<div class="progress-bar" id="pgrs_entsoc"></div>
										</div>
										<span class="progress-description" id="porc_entsoc">
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="info-box bg-aqua">
									<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Liberadas</span>
										<span class="info-box-number" id="total_liberadas"></span>

										<div class="progress">
											<div class="progress-bar" id="pgrs_liberadas"></div>
										</div>
										<span class="progress-description" id="porc_liberadas">
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="info-box bg-green">
									<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">ENTCOC Liberadas</span>
										<span class="info-box-number" id="total_libENTCOC"></span>

										<div class="progress">
											<div class="progress-bar" id="pgrs_libENTCOC"></div>
										</div>
										<span class="progress-description" id="porc_libENTCOC">
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>

							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="info-box bg-yellow">
									<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">ENTSOC Liberadas</span>
										<span class="info-box-number" id="total_libENTSOC"></span>

										<div class="progress">
											<div class="progress-bar" id="pgrs_libENTSOC"></div>
										</div>
										<span class="progress-description" id="porc_libENTSOC">
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="info-box bg-aqua">
									<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Pendientes</span>
										<span class="info-box-number" id="total_pendientes"></span>

										<div class="progress">
											<div class="progress-bar" id="pgrs_pendientes"></div>
										</div>
										<span class="progress-description" id="porc_pendientes">
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="info-box bg-green">
									<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Pendientes ENTCOC</span>
										<span class="info-box-number" id="total_pendENTCOC"></span>

										<div class="progress">
											<div class="progress-bar" id="pgrs_pendENTCOC"></div>
										</div>
										<span class="progress-description" id="porc_pendENTCOC">
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="info-box bg-yellow">
									<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Pendientes ENTSOC</span>
										<span class="info-box-number" id="total_pendENTSOC"></span>

										<div class="progress">
											<div class="progress-bar" id="pgrs_pendENTSOC"></div>
										</div>
										<span class="progress-description" id="porc_pendENTSOC">
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
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
		$(document).ready(function(e) {
			cargar_totales();
		});

		function cargar_totales() {
			var url = "cosulta_resumen.php"; // El script a dónde se realizará la petición.
			var sucursal = $("#sucursal").val();
      var fecha_inicio = $("#fecha_inicio").val();
      var fecha_fin = $("#fecha_fin").val();
			$.ajax({
				type: "POST",
				url: url,
				data: {
					sucursal: sucursal,
          fecha_inicio: fecha_inicio,
          fecha_fin: fecha_fin
				}, // Adjuntar los campos del formulario enviado.
				success: function(respuesta) {
					var array = eval(respuesta);
					$("#total").html(array[0]);
					$("#total_entcoc").html(array[1]);
					$("#pgrs_entcoc").attr("style", "width: " + array[2]);
					$("#porc_entcoc").html(array[3]);
          $("#total_entsoc").html(array[4]);
					$("#pgrs_entsoc").attr("style", "width: " + array[5]);
					$("#porc_entsoc").html(array[6]);
          $("#total_liberadas").html(array[7]);
					$("#pgrs_liberadas").attr("style", "width: " + array[8]);
					$("#porc_liberadas").html(array[9]);
          $("#total_libENTCOC").html(array[10]);
					$("#pgrs_libENTCOC").attr("style", "width: " + array[11]);
					$("#porc_libENTCOC").html(array[12]);
          $("#total_libENTSOC").html(array[13]);
					$("#pgrs_libENTSOC").attr("style", "width: " + array[14]);
					$("#porc_libENTSOC").html(array[15]);
          $("#total_pendientes").html(array[16]);
					$("#pgrs_pendientes").attr("style", "width: " + array[17]);
					$("#porc_pendientes").html(array[18]);
          $("#total_pendENTCOC").html(array[19]);
					$("#pgrs_pendENTCOC").attr("style", "width: " + array[20]);
					$("#porc_pendENTCOC").html(array[21]);
          $("#total_pendENTSOC").html(array[22]);
					$("#pgrs_pendENTSOC").attr("style", "width: " + array[23]);
					$("#porc_pendENTSOC").html(array[24]);
				}
			});
			return false;
		}
		$('#sucursal').select2({
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
		$("#sucursal").change(function() {
			cargar_totales();
		});
	</script>
</body>

</html>