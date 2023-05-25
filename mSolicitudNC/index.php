<?php
include '../global_seguridad/verificar_sesion.php';
$fecha_inicio = date("Y-m-01");
$fecha_fin = date("Y-m-d");
?>
<!DOCTYPE html>
<html>

<head>
	<?php include '../head.php'; ?>
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
			<?php include 'menuV.php'; ?>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<!-- Main content -->
			<section class="content">
				<div class="box box-danger" id="div-nc" <?php echo $solo_lectura; ?>>
					<div class="box-header">
						<h3 class="box-title">Solicitud de Notas de Crédito | Registro</h3>
					</div>
					<div class="box-body">
						<form action="" method="POST" id="form_datos">
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<label for="sucursal">*Sucursal</label>
										<select name="sucursal" id="sucursal" class="form-control select2">
											<option value=""></option>
											<option value="1">Díaz Ordaz</option>
											<option value="2">Arboledas</option>
											<option value="3">Villegas</option>
											<option value="4">Allende</option>
											<option value="5">La Petaca</option>
											<option value="6">Montemorelos</option>
											<option value="99">CEDIS</option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="concepto">*Concepto</label>
										<select name="concepto" id="concepto" class="form-control">
											<option value=""></option>
											<option value="APORTACION ANIVERSARIO">Aportación Aniversario</option>
											<option value="APORTACION POR DIA DEL NIÑO">Aportación Día del Niño</option>
											<option value="PLAN COMERCIAL">Plan Comercial</option>
											<option value="FONDOS">Fondos</option>
											<option value="DESCUENTO POR BONIFICACION">Descuento por bonificación</option>
											<option value="DESCUENTO LOGISTICO">Descuento Logístico</option>
											<option value="DESCUENTO POR CEDIS">Descuento por CEDIS</option>
											<option value="CORRECCION DE ENTRADAS">Corrección de entradas</option>
											<option value="APERTURA DE MONTEMORELOS">Apertura Montemorelos</option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="proveedor">*Proveedor</label>
										<select name="proveedor" id="proveedor" class="form-control">
											<option value=""></option>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<label for="valor">*Valor</label>
									<input type="text" name="valor" id="valor" class="form-control">
								</div>
								<div class="col-md-2">
									<label for="valor">*Impuestos</label>
									<select name="impuesto" id="impuesto" class="form-control">
										<option value=""></option>
										<option value="EXCENTO">EXCENTO</option>
										<option value="IVA">IVA</option>
										<option value="IEPS">IEPS</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="comentarios">*Comentarios</label>
										<input type="text" name="comentarios" id="comentarios" class="form-control">
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="box-footer text-right">
						<button type="submit" class="btn btn-warning" id="btn-insertar">Registrar Solicitud</button>
					</div>
				</div>

				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Control de Aportaciones | Lista de aportaciones</h3>
					</div>
					<div class="box-body">
						<dsiv class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="fecha_inicio">*Fecha Inicial:</label>
									<div class="input-group date form_date" data-date="<?php echo $fecha_inicio ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
										<input class="form-control" size="16" type="text" value="<?php echo $fecha_inicio ?>" id="fecha_inicio" name="fecha_inicio">
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="fecha_fin">*Fecha Final:</label>
									<div class="input-group date form_date" data-date="<?php echo $fecha_fin ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
										<input class="form-control" size="16" type="text" value="<?php echo $fecha_fin ?>" id="fecha_fin" name="fecha_fin">
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									</div>
								</div>
							</div>
						</dsiv>
						<div class="row">
							<div id="totales"></div><br><br>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="lista_solicitud" class="table table-striped table-bordered" cellspacing="0" width="130%">
										<thead>
											<tr>
												<th width='5%'>#</th>
												<th>Descripcion</th>
												<th width='5%'>Sucursal</th>
												<th>Proveedor</th>
												<th width='5%'>Monto</th>
												<th width='5%'>Impuesto</th>
												<th width='15%'>Solicita</th>
												<th width='15%'>Comentario</th>
												<th width='5%'>Estatus</th>
												<th width='7%'>Liberar</th>
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
		<?php //include 'modal.php'; 
		?>
		<?php //include 'modal_nc.php'; 
		?>
		<?php //include 'modal_manual.php'; 
		?>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/fixedcolumns/3.2.4/js/dataTables.fixedColumns.min.js"></script>
	<!-- Page script -->
	<script>
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
		$('#sucursal').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: Infinity
		});
		$('#concepto').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: Infinity
		});
		$('#impuesto').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: Infinity
		});
		$('#proveedor').select2({
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
		});
		$("#btn-insertar").click(function() {
			var url = "insertar_solicitud.php";
			var sucursal = $("#sucursal").val();
			var concepto = $("#concepto").val();
			var proveedor = $("#proveedor").val();
			var valor = $("#valor").val();
			var impuesto = $("#impuesto").val();
			var comentarios = $("#comentarios").val();

			if (sucursal == "" || concepto == "" || proveedor == "" || valor == "" || impuesto == "" || comentarios == "") {
				swal("Existen campos vacíos que son requeridos", "Solicitud de Notas de Crédito", "error");
			}
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: $('#form_datos').serialize(),
				success: function(respuesta) {
					alertify.success("Registro insertado correctamente");
					cargar_tabla();
					$("#form_datos")[0].reset();

				},
				error: function(xhr, status) {
					alert("error");
					//alert(xhr);
				},
			});
			return false;
		});

		function cargar_tabla() {
			var fecha_inicio = $("#fecha_inicio").val();
			var fecha_fin = $("#fecha_fin").val();
			$('#lista_solicitud').dataTable().fnDestroy();
			$('#lista_solicitud').DataTable({
				'language': {
					"url": "../plugins/DataTables/Spanish.json"
				},
				"paging": false,
				fixedColumns: {
					leftColumns: 2,
					rightColumns: 2
				},
				"scrollX": true,
				"scrollY": "300px",
				"scrollCollapse": true,
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
					},
				],
				"ajax": {
					"type": "POST",
					"url": "tabla_nc.php",
					"dataSrc": "",
					"data": {
						fecha_inicio: fecha_inicio,
						fecha_fin: fecha_fin
					}
				},
				"columns": [{
						"data": "id"
					},
					{
						"data": "concepto"
					},
					{
						"data": "sucursal"
					},
					{
						"data": "proveedor"
					},
					{
						"data": "monto"
					},
					{
						"data": "impuesto"
					},
					{
						"data": "comprador"
					},
					{
						"data": "comentario"
					},
					{
						"data": "estatus"
					},
					{
						"data": "liberar"
					}
				]
			});
		}
		$(document).ready(function() {
			cargar_tabla();
		});

		function asocia(id_formato) {
			var url = "libera_nc.php";
			swal({
					title: "Folio de NC",
					text: "Ingresa un folio de NC para asociar",
					content: "input",
				})
				.then((value) => {
					if (value == null || value == "") {
						swal("Error", "Debes ingresar un folio de NC", "error");
					} else {
						$.ajax({
							type: "POST",
							url: url,
							data: {
								id_formato: id_formato,
								folio: value
							}, // Adjuntar los campos del formulario enviado.
							success: function(respuesta) {
								swal("Finalizado", "La NC ha sido asociada correctamente", "success");
								cargar_tabla();
							}
						});
					}

				});
		}

		function eliminar(id_solicitud) {
			var url = 'eliminar_solicitud.php';
			$.ajax({
				type: "POST",
				url: url,
				data: {
					id_solicitud: id_solicitud
				}, // Adjuntar los campos del formulario enviado.
				success: function(respuesta) {
					alertify.success("La solicitud ha sido eliminada");
				}
			});
			// Evitar ejecutar el submit del formulario.
			cargar_tabla();
			return false;
		};
		$("#fecha_inicio").change(function() {
			if ($("#fecha_inicio").val() > $("#fecha_fin").val()) {
				alertify.error("Rango de fechas inválido");
			} else {
				cargar_tabla();
			}
		});
		$("#fecha_fin").change(function() {
			if ($("#fecha_inicio").val() > $("#fecha_fin").val()) {
				alertify.error("Rango de fechas inválido");
			} else {
				cargar_tabla();
			}
		})
	</script>
</body>

</html>