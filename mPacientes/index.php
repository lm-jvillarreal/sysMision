<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha = date("Y-m-d");
$hora = date("h:i:s");

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
						<h3 class="box-title">Registro de Paciente</h3>
					</div>
					<div class="box-body">
						<form method="POST" id="form_datos">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<input type="hidden" name="id_registro" id="id_registro" value="0">
										<label for="nombre">*Nombre</label>
										<input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingresa un nombre">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="ap_paterno">*Ap. Paterno</label>
										<input type="text" name="ap_paterno" id="ap_paterno" class="form-control" placeholder="Ingresa un apellido">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="ap_materno">*Ap. Materno</label>
										<input type="text" name="ap_materno" id="ap_materno" class="form-control" placeholder="Ingresa un apellido">
									</div>
								</div>
							</div>
							<!-- prueba-->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="sexo">*Sexo:</label>
										<select name="sexo" id="sexo" class="form-control select">
											<option value=""></option>
											<option value="Femenino">Femenino</option>
											<option value="Masculino">Masculino</option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="fecha_nacimiento">*Fecha de Nacimiento:</label>
										<div class="input-group date form_date" data-date="<?php echo $fecha; ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_nacimiento" data-link-format="yyyy-mm-dd">
											<input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" id="fecha_nacimiento" name="fecha_nacimiento" onchange='submitBday()'>
											<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="edad">*Edad</label>
										<input type="text" name="edad" id="edad" class="form-control" readonly>
									</div>
									<!--readonly es para no modificar el imput y si guarde en la db-->
								</div>
								<!--disabled es para deshabiliar los inputs-->
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="edad">*Alergico a algun medicamento</label>
										<br>
										<p> Si <input type="radio" id="alergia1" name="alergia" class="alergias" value="Si">
											No <input type="radio" id="alergia2" name="alergia" class="alergias" value="No">
										</p>
									</div>
								</div>
								<div id="DivDescAlergias" class="col-md-4" style="display: none">
									<div class="form-group">
										<label for="edad">*Descripción</label>
										<input type="text" name="desc_alergia" id="desc_alergia" class="form-control" placeholder="Medicamento al que es alergico">
									</div>
								</div>
							</div>
							<!--finprueb-->
							<div class="box-footer text-right">
								<button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
							</div>
						</form>
					</div>
				</div>
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Lista de Pacientes Existentes</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="lista_paciente" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th width="5%">#</th>
												<th>Paciente</th>
												<th width='5%'>Sexo</th>
												<th width='10%'>Fecha de nacimiento</th>
												<th width='5%'>Edad</th>
												<th width='20%'>Descripcion de alergias</th>
												<th width='5%'>Editar</th>
												<th width='5%'></th>
												<th width='10%'>Generar</th>
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
		function eliminar() {
			$('.remove-item').off().click(function(e) {
				$(this).parent('td').parent('tr').remove();
				if ($('#ProSelected tr.item').length == 0)
					$('#ProSelected .no-item').slideDown(300);
				RefrescaProducto();
			});
		}
	</script>
	<script>
		function cargar_tabla() {
			var paciente = $("#Paciente").val();
			$('#lista_paciente').dataTable().fnDestroy();
			$('#lista_paciente').DataTable({
				'language': {
					"url": "../plugins/DataTables/Spanish.json"
				},
				"paging": true,
				"order": [
					[0, "desc"]
				],
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
						title: 'FaltantesComprador',
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
					"url": "tabla_pacientes.php",
					"dataSrc": "",
					"data": ""
				},
				"columns": [{
						"data": "id"
					},
					{
						"data": "nombre_completo"
					},
					{
						"data": "sexo"
					},
					{
						"data": "fecha_nacimiento"
					},
					{
						"data": "edad"
					},
					{
						"data": "desc_alergia"
					},
					{
						"data": "editar"
					},
					{
						"data": "eliminar"
					},
					{
						"data": "consulta"
					}
				]
			});
		}
		cargar_tabla();

		function estilo_tablas() {
			$('#lista_pacientes').DataTable({
				'paging': true,
				'lengthChange': true,
				'searching': true,
				'ordering': true,
				'info': true,
				'autoWidth': true,
				'language': {
					"url": "../plugins/DataTables/Spanish.json"
				}
			});
		};
		$(function() {
			estilo_tablas();
		})
		$.validator.setDefaults({
			submitHandler: function() {
				var url = "insertar_paciente.php"; // El script a dónde se realizará la petición.
				$.ajax({
					type: "POST",
					url: url,
					data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
					success: function(respuesta) {
						if (respuesta == "ok") {
							alertify.success("Registro guardado correctamente");
							cargar_tabla();
							$(":text").val(''); //Limpiar los campos tipo Text
							$('#id_registro').val("0");
							$("#sexo").select2("trigger", "select", {
								data: {
									id: '',
									text: ''
								}
							});
							$('#fecha_nacimiento').val('');
						} else if (respuesta == "duplicado") {
							alertify.error("El Paciente ya existe");
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
					nombre: "required",
					ap_paterno: "required",
					ap_materno: "required",
					sexo: "required",
					fecha_nacimiento: "required",
					edad: "required",
					desc_alergia: "required"
				},
				messages: {
					nombre: "Campo requerido",
					ap_paterno: "Campo requerido",
					ap_materno: "Campo requerido",
					sexo: "campo requerido",
					fecha_nacimiento: "Campo requerido",
					edad: "Campo requerido",
					desc_alergia: "Campo Requerido"
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
					$(element).parents(".col-md-4").addClass("has-error").removeClass("has-success");
				},
				unhighlight: function(element, errorClass, validClass) {
					$(element).parents(".col-md-4").addClass("has-success").removeClass("has-error");
				}
			});
		});
	</script>
	<script>
		$(function() {
			$('.select').select2({
				placeholder: 'Seleccione una opcion',
				lenguage: 'es'
			})
		})
	</script>
	<!-- libreria para funcionamiento de calendario-->
	<script type="text/javascript">
		$('.form_datetime').datetimepicker({
			//language:  'fr',
			weekStart: 1,
			todayBtn: 1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			forceParse: 0,
			showMeridian: 1
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
		$('.form_time').datetimepicker({
			language: 'fr',
			weekStart: 1,
			todayBtn: 1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 1,
			minView: 0,
			maxView: 1,
			forceParse: 0
		});
	</script>
	<script>
		function eliminar(id_paciente) {
			swal({
					title: "¿Está seguro de eliminar registro?",
					icon: "warning",
					buttons: ["No", "Si"],
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						$.ajax({
							url: 'eliminar_paciente.php',
							data: '&id_paciente=' + id_paciente,
							type: "POST",
							success: function(respuesta) {
								if (respuesta == "ok") {
									alertify.success('Registro Eliminado');
									cargar_tabla();
								} else {
									alertify.error('Ha Ocurrido un Error');
								}
							}
						});
					} else {
						swal("No se ha eliminado el registro.", {
							icon: "error",
						});
					}
				});
		}

		function editar_registro(id) {
			$.ajax({
				url: 'editar_paciente.php',
				data: '&id=' + id,
				type: "POST",
				success: function(respuesta) {
					var array = eval(respuesta);

					$('#id_registro').val(id);
					$('#nombre').val(array[0]);
					$('#ap_paterno').val(array[1]);
					$('#ap_materno').val(array[2]);
					$("#sexo").select2("trigger", "select", {
						data: {
							id: array[3],
							text: array[3]
						}
					});
					$('#fecha_nacimiento').val(array[4]);
					$('#desc_alergia').val(array[5]);
					$('#edad').val(array[6]);
					if (array[7] != "No") {
						$("#alergia1").attr('checked', true);
						$("#alergia2").attr('checked', false);
						$('#DivDescAlergias').show();
						$('#alergia').val(array[7]);
					} else {
						$("#alergia2").attr('checked', true);
						$("#alergia1").attr('checked', false);
						$('#alergia').val("");
						$('#DivDescAlergias').hide();
					}
				}
			});
		}
	</script>
	<!-- fin de libreria funcion calendario-->
	<script>
		function submitBday() {
			var Bdate = document.getElementById('fecha_nacimiento').value;
			var Bday = +new Date(Bdate);
			$("#edad").val(~~((Date.now() - Bday) / (31557600000)));
		}
	</script>
	<script>
		$(document).ready(function() {
			$(".alergias").click(function(evento) {
				var valor = $(this).val();
				if (valor == 'Si') {
					$("#DivDescAlergias").css("display", "block");
				} else {
					$("#DivDescAlergias").css("display", "none");
				}
			});
		});

		function consulta_articulos() {
			var ancho_ventana = 750;
			var alto_ventana = 768;
			var window_left = (screen.width - ancho_ventana - 12) / 2;
			var window_top = (screen.height - alto_ventana - 57) / 2;
			pop2 = window.open("articulos_farmacia.php", "ventana", "width=" + ancho_ventana + ",height=" + alto_ventana + ",top=" + window_top + ",screenY=" + window_top + ",left=" + window_left + ",screenX=" + window_left + "");
			pop2.focus();
		}
		function historial_consultas() {
			var ancho_ventana = 750;
			var alto_ventana = 768;
			var window_left = (screen.width - ancho_ventana - 12) / 2;
			var window_top = (screen.height - alto_ventana - 57) / 2;
			pop2 = window.open("consultas_pacientes.php", "ventana", "width=" + ancho_ventana + ",height=" + alto_ventana + ",top=" + window_top + ",screenY=" + window_top + ",left=" + window_left + ",screenX=" + window_left + "");
			pop2.focus();
		}
	</script>
</body>

</html>