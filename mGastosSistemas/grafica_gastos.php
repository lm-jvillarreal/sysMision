<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');

function _data_first_month_day()
{
	$month = date('m');
	$year = date('Y');
	return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
}
$primer_dia = _data_first_month_day($fecha);
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
				<div class="box-body">
					<div class="box box-danger">
						<div class="box-header">
							<h3 class="box-title">*Filtros Grafica</h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
								</button>
								<button type="button" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
							</div>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="llave_banorte">*Fecha Inicio</label>
										<div class="input-group date form_date" data-date="<?php echo $primer_dia ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
											<input class="form-control" size="16" type="text" value="<?php echo $primer_dia ?>" readonly id="fecha_inicio" name="fecha_inicio">
											<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="llave_banorte">*Fecha Fin</label>
										<div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
											<input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_fin" name="fecha_fin">
											<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="llave_banorte">*Rublo</label>
										<select name="rublo" id="rublo" class="form-control">
										</select>
									</div>
								</div>
								<br>
							</div>
						</div>
						<div class="box-footer text-right">
							<button class="btn btn-danger" id="btn-generar">Generar</button>
							<button class="btn btn-warning" id="btn-regresar">Regresar</button>
						</div>
					</div>
					<div class="box box-danger">
						<div class="box-header">
							<h3 class="box-title">Grafica Gastos</h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
								</button>
								<button type="button" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
							</div>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-md-3">
									<div class="info-box bg-green">
										<span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

										<div class="info-box-content">
											<span class="info-box-text">TOTAL DE GASTOS</span>
											<span class="info-box-number">
												<div id="total"></div>
											</span>

											<div class="progress">
												<div class="progress-bar" id="prgrs"></div>
											</div>
											<span class="progress-description">
												<div id="porciento"></div>
											</span>
										</div>
										<!-- /.info-box-content -->
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div id="grafica" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
								</div>
							</div>
						</div>
						<div class="box-footer"></div>
					</div>
					<div class="box box-danger">
						<div class="box-header">
							<h3 class="box-title">Tabla Gastos</h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
								</button>
								<button type="button" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
							</div>
						</div>
						<div class="box-body">
							<div class="table-responsive">
								<table id="lista_gastos_guardados" class="table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th width="5%">#</th>
											<th>Proveedor</th>
											<th width="10%">Fecha</th>
											<th width="10%">Gasto</th>
											<th width="10%">Rublo</th>
											<th width="10%">Documento</th>
											<th width="10%">Comentario</th>
										</tr>
									</thead>
									<tfooter>
										<tr>
											<th width="5%">#</th>
											<th>Proveedor</th>
											<th width="10%">Fecha</th>
											<th width="10%">Gasto</th>
											<th width="10%">Rublo</th>
											<th width="10%">Documento</th>
											<th width="10%">Comentario</th>
										</tr>
									</tfooter>
								</table>
							</div>
						</div>
						<div class="box-footer"></div>
					</div>
					<!-- /.row -->
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
		<?php include 'modal_rublo.php'; ?>
		<?php include '../footer2.php'; ?>
		<script src="http://code.highcharts.com/highcharts.js"></script>
		<script src="http://code.highcharts.com/modules/exporting.js"></script>

		<!-- Control Sidebar -->

		<!-- /.control-sidebar -->
		<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
		<div class="control-sidebar-bg"></div>
	</div>
	<!-- ./wrapper -->

	<?php include '../footer.php'; ?>
	<!-- Page script -->
	<script>
		$(document).ready(function() {
			cargar_tabla_gastos();
			generar();
		})
		$("#btn-regresar").click(function() {
			regresar();
		});
		$("#btn-generar").click(function() {
			cargar_tabla_gastos();
			generar();
			total_gastos();
		})
		$('#rublo').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: Infinity,
			ajax: {
				url: "consulta_rublos.php",
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

		function editar_rublo(id) {
			$.ajax({
				url: 'editar_registro.php',
				data: '&id=' + id,
				type: "POST",
				success: function(respuesta) {
					var array = eval(respuesta);
					nombre = array[0];

					$('#id_registro_modal').val(id);
					$('#rublo_modal').val(nombre);

				}
			});
		}

		function eliminar_rublo(id) {
			swal({
					title: "¿Está seguro de eliminar registro?",
					icon: "warning",
					buttons: ["No", "Si"],
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						$.ajax({
							url: 'eliminar_registro.php',
							data: '&id=' + id,
							type: "POST",
							success: function(respuesta) {
								if (respuesta = "ok") {
									alertify.success("Registro Eliminado Correctamente");
									cargar_tabla_modal();
								} else {
									alertify.error("Ha Ocurrido un Error");
								}
							}
						});
					}
				});
		}
	</script>
	<script>
		function cargar_tabla_modal() {
			$('#lista_rublos').dataTable().fnDestroy();
			$('#lista_rublos').DataTable({
				'language': {
					"url": "../plugins/DataTables/Spanish.json"
				},
				"ajax": {
					"type": "POST",
					"url": "tabla_rublos.php",
					"dataSrc": ""
				},
				"columns": [{
						"data": "#"
					},
					{
						"data": "Nombre"
					},
					{
						"data": "Editar"
					},
					{
						"data": "Eliminar"
					}
				]
			});
		}
		$('#modal-default').on('show.bs.modal', function(e) {
			cargar_tabla_modal();
		});
		$("#guardar_modal").click(function() {
			var url = "insertar_rublo.php";
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: $('#form_datos_rublo').serialize(),
				success: function(respuesta) {
					if (respuesta == "ok") {
						alertify.success("Registro Guardado Correctamente");
						$('#rublo_modal').val("");
						$('#id_registro_modal').val("0");
						cargar_tabla_modal();
					} else if (respuesta == "duplicado") {
						alertify.error("Registro Existente");
					} else {
						alertify.error("Ha Ocurrido un Error");
					}
				}
			});
			return false;
		});

		function generar() {
			var fecha1 = $('#fecha_inicio').val();
			var fecha2 = $('#fecha_fin').val();
			var rublo = $('#rublo').val();
			var url = "datos_grafica2.php"; // El script a dónde se realizará la petición.
			var dato = 1;
			$.ajax({
				type: "POST",
				dataType: "json",
				url: url,
				data: {
					'fecha1': fecha1,
					'fecha2': fecha2,
					'rublo': rublo
				}, // Adjuntar los campos del formulario enviado.
				// async: false,
				success: function(respuesta) {
					var options = {
						chart: {
							renderTo: 'grafica',
							type: 'column'
						},
						title: {
							text: 'Gastos Sistemas'
						},
						subtitle: {
							text: fecha1 + " - " + fecha2
						},
						xAxis: {
							type: 'category'
						},
						yAxis: {
							title: {
								text: 'Gastos Dpto. Sistemas'
							}
						},
						legend: {
							enabled: false
						},
						plotOptions: {
							series: {
								borderWidth: 0,
								dataLabels: {
									enabled: true,
									format: '${point.y:,.2f}'
								}
							}
						},
						tooltip: {
							headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
							pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>${point.y:,.2f}</b><br/>'
						},
						series: [{}]
					};
					options.series[0].data = respuesta;
					var chart = new Highcharts.Chart(options);
				}
			});
		}

		function regresar() {
			$("#rublo").select2("trigger", "select", {
				data: {
					id: '',
					text: ''
				}
			});
			cargar_tabla_gastos();
			generar();
		}

		function cargar_tabla_gastos() {
			var fecha1 = $('#fecha_inicio').val();
			var fecha2 = $('#fecha_fin').val();
			var rublo = $('#rublo').val();
			$('#lista_gastos_guardados').dataTable().fnDestroy();
			$('#lista_gastos_guardados').DataTable({
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
						title: 'Modulos-Lista',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'pdf',
						text: 'Exportar a PDF',
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
					}
				],
				"ajax": {
					"type": "POST",
					"url": "tabla_gastos_guardados2.php",
					"dataSrc": "",
					data: {
						'fecha1': fecha1,
						'fecha2': fecha2,
						'rublo': rublo
					}, // Adjuntar los campos del formulario enviado.
				},
				"columns": [{
						"data": "#"
					},
					{
						"data": "Proveedor"
					},
					{
						"data": "Fecha_m"
					},
					{
						"data": "Gasto"
					},
					{
						"data": "Rublo"
					},
					{
						"data": "Documento"
					},
					{
						"data": "Comentario"
					}
				]
			});
		}
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

		function total_gastos() {
			var fecha_inicio = $("#fecha_inicio").val();
			var fecha_fin = $("#fecha_fin").val();
			var url = "datos_total.php";
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: {
					fecha_inicio: fecha_inicio,
					fecha_fin: fecha_fin
				},
				success: function(respuesta) {
					var array = eval(respuesta);
					$("#total").html(array[0]);
					//$("#porciento" + div).html(array[1] + " del total general");
					//$("#prgrs" + div).attr("style", "width: " + array[1]);
				},
				error: function(xhr, status) {
					alert("error");
					//alert(xhr);
				},
			});
		}
	</script>
</body>

</html>