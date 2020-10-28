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
			<?php include 'menuV.php'; ?>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<!-- Main content -->
			<section class="content">
				<div class="box box-danger" <?php echo $solo_lectura ?>>
					<div class="box-header">
						<h3 class="box-title">Registro de Gastos</h3>
					</div>
					<div class="box-body">
						<form method="POST" id="form_datos" enctype="multipart/form-data">
							<input type="text" id="gasto_id" name="gasto_id" value="0" class="hidden">
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-5">
										<div class="form-group">
											<label for="fecha">*Proveedor:</label>
											<input type="text" id="proveedor" name="proveedor" readonly class="form-control">
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label for="fecha">*Fecha:</label>
											<input type="text" class="form-control" name="fecha" id="fecha" readonly>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label for="gasto">*Gasto:</label>
											<div class="input-group">
												<div class="input-group-addon">$</div>
												<input type="text" class="form-control" name="gasto" id="gasto" readonly>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="sucursal">*Rublo</label>
											<select name="rublo" id="rublo" class="form-control">
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="sucursal">*Folio Factura</label>
											<input type="text" class="form-control" name="folio_factura" id="folio_factura" readonly>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="sucursal">*Sucursal</label>
											<select name="sucursal" id="sucursal" class="form-control">
												<option value=""></option>
												<option value="1">Diaz Ordaz</option>
												<option value="2">Arboledas</option>
												<option value="3">Villegas</option>
												<option value="4">Allende</option>
												<option value="5">Petaca</option>
												<option value="99">CEDIS</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="sucursal">*Comentarios</label>
											<input type="text" class="form-control" id="comentario" name="comentario" placeholder="Ingresa Comentario">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-3">
										<div class="form-group">
											<label for="sucursal">*Documento</label>
											<input type="file" id="documento" name="documento">
										</div>
									</div>
									<div class="col-md-1">
										<br>
										<a href='' target='_blank' id="documento_editar"><i id="icono_editar" style='color: #DF0101;'></i></a>
									</div>
									<div class="col-md-3" id="evidencia" style="display:none;">
										<div class="form-group">
											<label for="sucursal">*Evidencia</label>
											<input type="file" id="imagen" name="imagen">
										</div>
									</div>
									<div class="col-md-1">
										<br>
										<a href='' target='_blank' id="evi_editar"><i id="evi_icono" style='color: #DF0101;'></i></a>
									</div>
								</div>
							</div>
							<div class="box-footer text-right">
								<button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
							</div>
						</form>
					</div>
				</div>
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Lista de Gastos</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
							<button type="button" class="btn btn-box-tool" onclick="limpiar()"><i class="fa fa-times"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-4">
									<div class="form-group">
										<label for="">*Proveedor</label>
										<select name="cve_proveedor" id="cve_proveedor" class="form-control"></select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="fecha">*Fecha Inicio:</label>
										<div class="input-group date form_date" data-date="<?php echo $fecha; ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
											<input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_inicio" name="fecha_inicio">
											<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="fecha">*Fecha Fin:</label>
										<div class="input-group date form_date" data-date="<?php echo $fecha; ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
											<input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_fin" name="fecha_fin">
											<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<br>
									<button onclick="cargar_tabla();" class="btn btn-danger" id="consultar_info">Consultar</button>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table id="lista_gastos" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th width="5%">#</th>
										<th>Proveedor</th>
										<th width="10%">Costo</th>
										<th width="10%">Fecha</th>
										<th width="10%">Folio Factura</th>
										<th width="10%">Seleccionar</th>
									</tr>
								</thead>
								<tfooter>
									<tr>
										<th>#</th>
										<th>Proveedor</th>
										<th>Costo</th>
										<th>Fecha</th>
										<th>Folio Factura</th>
										<th width="10%">Seleccionar</th>
									</tr>
								</tfooter>
							</table>
						</div>
					</div>
					<div class="box-footer"></div>
				</div>
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Lista de Gastos Guardados</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
							<button type="button" class="btn btn-box-tool" onclick="limpiar()"><i class="fa fa-times"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="table-responsive">
							<table id="lista_gastos_guardados" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th width="5%">#</th>
										<th>Proveedor</th>
										<th width='10%'>Sucursal</th>
										<th width="10%">Fecha</th>
										<th width="10%">Gasto</th>
										<th width="10%">Folio Factura</th>
										<th width="10%">Rubro</th>
										<th width="10%">Documento</th>
										<th width="10%">Comentario</th>
										<th width="10%">Editar</th>
										<th width="10%">Eliminar</th>
									</tr>
								</thead>
								<tfooter>
									<tr>
										<th width="5%">#</th>
										<th>Proveedor</th>
										<th width='10%'>Sucursal</th>
										<th width="10%">Fecha</th>
										<th width="10%">Gasto</th>
										<th width="10%">Folio Factura</th>
										<th width="10%">Rubro</th>
										<th width="10%">Documento</th>
										<th width="10%">Comentario</th>
										<th width="10%">Editar</th>
										<th width="10%">Eliminar</th>
									</tr>
								</tfooter>
							</table>
						</div>
					</div>
					<div class="box-footer"></div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="box box-danger">
							<div class="box-header">
								<h3 class="box-title">Grafica Totales</h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
									</button>
									<button type="button" class="btn btn-box-tool" onclick="limpiar()"><i class="fa fa-times"></i></button>
								</div>
							</div>
							<div class="box-body">
								<div id="grafica_total" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
							</div>
							<div class="box-footer"></div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="box box-danger">
							<div class="box-header">
								<h3 class="box-title">Grafica Por Rublo</h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
									</button>
									<button type="button" class="btn btn-box-tool" onclick="limpiar()"><i class="fa fa-times"></i></button>
								</div>
							</div>
							<div class="box-body">
								<div id="grafica" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
							</div>
							<div class="box-footer"></div>
						</div>
					</div>
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
		<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
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
		function cargar_tabla() {
			var fecha_inicio = $('#fecha_inicio').val();
			var fecha_fin = $('#fecha_fin').val();
			var proveedor = $('#cve_proveedor').val();
			if (fecha_inicio != "" && fecha_fin != "") {
				$('#lista_gastos').dataTable().fnDestroy();
				$('#lista_gastos').DataTable({
					'language': {
						"url": "../plugins/DataTables/Spanish.json"
					},
					'paging': false,
					"ajax": {
						"type": "POST",
						"url": "tabla_gastos.php",
						"dataSrc": "",
						"data": {
							'fecha_inicio': fecha_inicio,
							'fecha_fin': fecha_fin,
							'proveedor': proveedor
						}
					},
					"columns": [{
							"data": "#"
						},
						{
							"data": "Proveedor"
						},
						{
							"data": "Costo"
						},
						{
							"data": "Fecha"
						},
						{
							"data": "Folio Factura"
						},
						{
							"data": "Seleccionar"
						}
					]
				});
			}
		}
		$(function() {
			// cargar_tabla();
		})
		$.validator.setDefaults({
			submitHandler: function() {
				var f = $(this);
				var formData = new FormData(document.getElementById("form_datos"));
				formData.append("dato", "valor");
				var url = "insertar_gasto.php"; // El script a dónde se realizará la petición.
				$.ajax({
					type: "POST",
					url: url,
					dataType: "html",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(respuesta) {
						if (respuesta == "ok") {
							alertify.success("Registro guardado correctamente");
							$('#proveedor').val("");
							$('#fecha').val("");
							$('#gasto').val("");
							$('#comentario').val("");
							$('#documento').val("");
							cargar_tabla_gastos();
							generar();
							$("#rublo").select2("trigger", "select", {
								data: {
									id: '',
									text: ''
								}
							});
							$('#gasto_id').val("0");
							$('#evi_icono').removeAttr("class");
							$('#icono_editar').removeAttr("class");
							$('#imagen').val("");
							$('#evidencia').hide();
							$('#consultar_info').removeAttr("disabled");
							$('#sucursal').val("").trigger('change.select2');
						} else if (respuesta == "duplicado") {
							alertify.error("El registro ya existe");
						} else {
							alertify.error("Ha ocurrido un error");
						}
					}
				});
				// Evitar ejecutar el submit del formulario.
				return false;
			}
		});
		$(document).ready(function() {
			$("#form_datos").validate({
				rules: {
					proveedor: "required",
					fecha: "required",
					gasto: "required",
					rublo: "required",
					comentario: "required",
					sucursal: "required"
				},
				messages: {
					proveedor: "Campo requerido",
					fecha: "Campo requerido",
					gasto: "Campo requerido",
					rublo: "Campo requerido",
					comentario: "Campo requerido",
					sucursal: "Campo requerido"
				},
				errorElement: "em",
				errorPlacement: function(error, element) {
					// Add the `help-block` class to the error element
					error.addClass("help-block");
					if (element.prop("type") === "checkbox") {
						error.insertAfter(element.parent("label"));
					} else {
						error.insertAfter(element);
					}
				},
				highlight: function(element, errorClass, validClass) {
					$(element).parents(".col-md-3").addClass("has-error").removeClass("has-success");
					$(element).parents(".col-md-4").addClass("has-error").removeClass("has-success");
					$(element).parents(".col-md-6").addClass("has-error").removeClass("has-success");
				},
				unhighlight: function(element, errorClass, validClass) {
					$(element).parents(".col-md-3").addClass("has-success").removeClass("has-error");
					$(element).parents(".col-md-4").addClass("has-success").removeClass("has-error");
					$(element).parents(".col-md-6").addClass("has-success").removeClass("has-error");
				}
			});
		});

		function cargar_tabla_gastos() {
			$('#lista_gastos_guardados').dataTable().fnDestroy();
			$('#lista_gastos_guardados').DataTable({
				'language': {
					"url": "../plugins/DataTables/Spanish.json"
				},
				"paging": true,
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
						title: 'Control Equipos',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'Control Equipos',
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
					"url": "tabla_gastos_guardados.php",
					"dataSrc": "",
					"data": ""
				},
				"columns": [{
						"data": "#"
					},
					{
						"data": "Proveedor"
					},
					{
						"data": "Sucursal"
					},
					{
						"data": "Fecha_m"
					},
					{
						"data": "Gasto"
					},
					{
						"data": "Folio Factura"
					},
					{
						"data": "Rublo"
					},
					{
						"data": "Documento"
					},
					{
						"data": "Comentario"
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
		cargar_tabla_gastos();
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
		$('#cve_proveedor').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			//minimumResultsForSearch: Infinity
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
		})

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

		function editar_gasto(id) {
			$.ajax({
				url: 'editar_registro2.php',
				data: '&id=' + id,
				type: "POST",
				success: function(respuesta) {
					var array = eval(respuesta);

					$('#gasto_id').val(id);
					$('#proveedor').val(array[0]);
					$('#fecha').val(array[1]);
					$('#gasto').val(array[2]);
					$("#rublo").select2("trigger", "select", {
						data: {
							id: array[3],
							text: array[4]
						}
					});

					$('#documento_editar').attr("href", array[5]);
					$('#icono_editar').attr("class", "fa fa-" + array[7] + " fa-2x");
					$('#comentario').val(array[6]);

					$('#evi_editar').attr("href", array[8]);
					$('#evi_icono').attr("class", "fa fa-" + array[9] + " fa-2x");

					$('#consultar_info').attr("disabled", true);

					$('#evidencia').show();
					$('#sucursal').val(array[10]).trigger('change.select2');
					$('#folio_factura').val(array[11]);
				}
			});
		}

		function eliminar_gasto(id) {
			swal({
					title: "¿Está seguro de eliminar registro?",
					icon: "warning",
					buttons: ["No", "Si"],
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						$.ajax({
							url: 'eliminar_registro2.php',
							data: '&id=' + id,
							type: "POST",
							success: function(respuesta) {
								if (respuesta = "ok") {
									alertify.success("Registro Eliminado Correctamente");
									generar();
									cargar_tabla_gastos();
								} else {
									alertify.error("Ha Ocurrido un Error");
								}
							}
						});
					}
				});
		}

		function cargar_tabla_modal() {
			$('#lista_rublos').dataTable().fnDestroy();
			$('#lista_rublos').DataTable({
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
						title: 'Lista Rublos',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'Lista Rublos',
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
			$('#form_datos_rublo')[0].reset();
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

		function seleccionar(gasto, fecha, id_p) {
			var provee = $('#' + id_p).val();
			var ff = $('#ff' + id_p).val();
			$.ajax({
				url: 'consulta_datos.php',
				type: "POST",
				dateType: "html",
				data: {
					'gasto': gasto,
					'fecha': fecha,
					'provee': provee
				},
				success: function(respuesta) {
					var array = eval(respuesta);

					$('#proveedor').val(array[0]);
					$('#fecha').val(array[1]);
					$('#gasto').val(gasto);
					$('#folio_factura').val(ff);
				}
			});
		}

		function generar() {
			var url = "datos_grafica.php"; // El script a dónde se realizará la petición.
			var dato = 1;
			$.ajax({
				type: "POST",
				dataType: "json",
				url: url,
				data: {
					'dato': dato
				}, // Adjuntar los campos del formulario enviado.
				// async: false,
				success: function(respuesta) {
					var options = {
						chart: {
							renderTo: 'grafica',
							type: 'column'
						},
						title: {
							text: 'Gastos'
						},
						subtitle: {
							text: ''
						},
						xAxis: {
							type: 'category'
						},
						yAxis: {
							title: {
								text: 'Gasto por Rublo'
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
							pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:,.2f}</b><br/>'
						},
						series: [{}]
					};
					options.series[0].data = respuesta;
					var chart = new Highcharts.Chart(options);
				}
			});
		}

		function generar2() {
			var url = "datos_grafica3.php"; // El script a dónde se realizará la petición.
			var dato = 1;
			$.ajax({
				type: "POST",
				dataType: "json",
				url: url,
				data: {
					'dato': dato
				}, // Adjuntar los campos del formulario enviado.
				// async: false,
				success: function(respuesta) {
					var options = {
						chart: {
							renderTo: 'grafica_total',
							type: 'column'
						},
						title: {
							text: 'Gastos Totales'
						},
						subtitle: {
							text: ''
						},
						xAxis: {
							type: 'category'
						},
						yAxis: {
							title: {
								text: 'Gasto Total'
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
							pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:,.2f}</b><br/>'
						},
						series: [{}]
					};
					options.series[0].data = respuesta;
					var chart = new Highcharts.Chart(options);
				}
			});
		}
		generar();
		generar2();
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
		$(":file").filestyle('buttonText', 'Seleccionar');
		$(":file").filestyle('size', 'sm');
		$(":file").filestyle('input', true);
		$(":file").filestyle('disabled', false);

		$('#sucursal').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es'
		});
	</script>
</body>

</html>