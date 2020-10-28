<?php
  include '../global_seguridad/verificar_sesion.php';
  function _data_last_month_day() { 
    $month = date('m');
    $year = date('Y');
    $day = date("d", mktime(0,0,0, $month+1, 0, $year));
    return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
  };
  /** Actual month first day **/
  function _data_first_month_day() {
    $month = date('m');
    $year = date('Y');
    return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
  }
  $fecha1 = _data_first_month_day();
  $fecha2 = _data_last_month_day();
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
						<h3 class="box-title">Resumen de Cambios</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-4">
									<div class="form-group">
										<label for="sucursal">*Sucursal</label>
										<select name="sucursal" id="sucursal" class="form-control" onchange="cargar()">
											<option value=""></option>

										</select>
									</div>
								</div>
								<div class="col-md-4">
					                <div class="form-group">
					                  <label for="fecha">*Fecha:</label>
					                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha" data-link-format="yyyy-mm-dd" >
					                    <input class="form-control" size="16" type="text"  id="fecha1" name="fecha1" value="<?php echo $fecha1?>" onchange='cargar()'>
					                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					                  </div>
					                </div>
					              </div>
					              <div class="col-md-4">
					                <div class="form-group">
					                  <label for="fecha">*Fecha:</label>
					                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha" data-link-format="yyyy-mm-dd" >
					                    <input class="form-control" size="16" type="text"  id="fecha2" name="fecha2" value="<?php echo $fecha2?>" onchange='cargar()'>
					                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					                  </div>
					                </div>
					              </div>
					        </div>
						</div>
						<!-- <br> -->
						<div class="row">
							<div class="col-md-12">
								<h4 for="" class="box-title">Totales</h4>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="info-box bg-aqua">
										<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
										<div class="info-box-content">
											<span class="info-box-text">Cambios Registrados</span>
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
											<span class="info-box-text">Cantidad de Ofertas</span>
											<span class="info-box-number" id="total_ofertas"></span>

											<div class="progress">
												<div class="progress-bar" id="pgrs_ofertas"></div>
											</div>
											<span class="progress-description" id="porc_ofertas">
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
											<span class="info-box-text">Cantidad de Cambios</span>
											<span class="info-box-number" id="total_cambios"></span>

											<div class="progress">
												<div class="progress-bar" id="pgrs_cambios"></div>
											</div>
											<span class="progress-description" id="porc_cambios">
											</span>
										</div>
										<!-- /.info-box-content -->
									</div>
									<!-- /.info-box -->
								</div>
							</div>
						</div>
						<!-- <br> -->
						<div class="row">
							<div class="col-md-12">
								<h4 for="">Validados / Liberados </h4>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="info-box bg-green">
										<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
										<div class="info-box-content">
											<span class="info-box-text">Cantidad de Validados</span>
											<span class="info-box-number" id="total_validados"></span>

											<div class="progress">
												<div class="progress-bar" id="pgrs_validados"></div>
											</div>
											<span class="progress-description" id="porc_validados">
											</span>
										</div>
										<!-- /.info-box-content -->
									</div>
									<!-- /.info-box -->
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="info-box bg-red">
										<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
										<div class="info-box-content">
											<span class="info-box-text">Cantidad de Liberados </span>
											<span class="info-box-number" id="total_liberados"></span>

											<div class="progress">
												<div class="progress-bar" id="pgrs_liberados"></div>
											</div>
											<span class="progress-description" id="porc_liberados">
											</span>
										</div>
										<!-- /.info-box-content -->
									</div>
									<!-- /.info-box -->
								</div>
							</div>
						</div>
						<!-- <br> -->
						<div class="row">
							<div class="col-md-12">
								<h4 for="">Gerentes Activos</h4>
								<div id="div2"></div>
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
			cargar_totales2();
		});

		function cargar(){
			cargar_totales();
			cargar_totales2();
		}

		function cargar_totales() {
			var url = "consulta_resumen.php"; // El script a dónde se realizará la petición.
			var sucursal = $("#sucursal").val();
			var fecha1   = $("#fecha1").val();
			var fecha2   = $("#fecha2").val();
			$.ajax({
				type: "POST",
				url: url,
				data: {
					sucursal: sucursal,
					fecha1: fecha1,
					fecha2: fecha2
				}, // Adjuntar los campos del formulario enviado.
				success: function(respuesta) {
					var array = eval(respuesta);
					$("#total").html(array[0]);
					$("#total_ofertas").html(array[1]);
					$("#pgrs_ofertas").attr("style", "width: " + array[2]);
					$("#porc_ofertas").html(array[3]);
					$("#total_cambios").html(array[4]);
					$("#pgrs_cambios").attr("style", "width: " + array[5]);
					$("#porc_cambios").html(array[6]);
					$("#total_validados").html(array[7]);
					$("#pgrs_validados").attr("style", "width: " + array[8]);
					$("#porc_validados").html(array[9]);
					$("#total_liberados").html(array[10]);
					$("#pgrs_liberados").attr("style", "width: " + array[11]);
					$("#porc_liberados").html(array[12]);
				}
			});
			return false;
		}
		function cargar_totales2() {
			var url = "consulta_resumen2.php"; // El script a dónde se realizará la petición.
			var sucursal = $("#sucursal").val();
			var fecha1   = $("#fecha1").val();
			var fecha2   = $("#fecha2").val();
			$.ajax({
				type: "POST",
				url: url,
				data: {
					sucursal: sucursal,
					fecha1: fecha1,
					fecha2: fecha2
				}, // Adjuntar los campos del formulario enviado.
				success: function(respuesta) {
					$('#div2').html(respuesta);
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
	</script>
</body>

</html>