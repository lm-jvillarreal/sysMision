<?php
include '../global_seguridad/verificar_sesion.php';
?>
<!DOCTYPE html>
<html>

<head>
	<?php include '../head.php'; ?>
	<link rel="stylesheet" href="../d_plantilla/plugins/timepicker/bootstrap-timepicker.min.css">
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
						<h3 class="box-title">Explosión de Materiales | Ventas</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="fecha_inicio">*Fecha de inicio:</label>
									<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
										<input class="form-control" size="16" type="text" value="" readonly id="fecha_inicial" name="fecha_inicial">
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="fecha_fin">*Fecha final:</label>
									<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
										<input class="form-control" size="16" type="text" value="" readonly id="fecha_final" name="fecha_final">
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-right">
								<button class="btn btn-danger text-right" id="btn-filtrar">Mostrar datos</button>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<br />
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id='lista_ventas' class='table table-striped table-bordered' cellspacing='0' width='100%'>
										<thead>
											<tr>
												<th width='10%'>Artículo</th>
												<th>Descripción</th>
												<th width='10%'>Vta.X Período</th>
												<th width='10%'>Porcentaje</th>
												<th width='10%'>N. piezas si venta = 0</th>
												<th width='10%'>Proy. de vtas.</th>
												<!-- <th>Acciones</th> -->
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
		<?php include 'modal_proyeccion.php'; ?>
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
	<script src="../d_plantilla/plugins/timepicker/bootstrap-timepicker.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
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
		function lunes(){
			//Obtenemos la fecha actual
			var fecha_actual = new Date();

			//obtener el día de la semana
			var dia_semana = fecha_actual.getDay()-1;

			var lunes_anterior = new Date(fecha_actual.getTime()-dia_semana * 24 * 60 * 60 * 1000);
			//mostrar la fecha del lunes anterior
			var fecha_inicial = lunes_anterior.toISOString().substring(0,10);
			$("#fecha_inicial").val(fecha_inicial);
			$("#fecha_final").val(fecha_actual.toISOString().substring(0,10));
			//alert(fecha_actual);
		}
		$(document).ready(function(e) {
			cargar_tabla(0);
			lunes();
		});

		function cargar_tabla(parametro) {
			var fecha_inicial = $("#fecha_inicial").val();
			var fecha_final = $("#fecha_final").val();
			$('#lista_ventas').dataTable().fnDestroy();
			$('#lista_ventas').DataTable({
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
						title: 'FaltantesLista',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'FaltantesLista',
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
					// {
					//     text: 'Actualizar costos',
					//     className: 'red',
					//     action: function() {
					//         actualizar_costos();
					//     },
					//     counter: 1
					// },
				],
				"ajax": {
					"type": "POST",
					"url": "tabla_ventas.php",
					"dataSrc": "",
					"data": {
						fecha_final: fecha_final,
						fecha_inicial: fecha_inicial,
						parametro: parametro
					}
				},
				"columns": [{
						"data": "ARTC_ARTICULO"
					},
					{
						"data": "descripcion"
					},
					{
						"data": "cantidad"
					},
					{
						"data": "porcentaje"
					},
					{
						"data": "numero_piezas"
					},
					{
						"data": "total_unidades"
					}
					// ,
					// {
					// 	"data": "acciones"
					// }
				]
			});
		}
		$("#btn-filtrar").click(function() {
			cargar_tabla(1);
		});
		$('#modal-proyeccion').on('show.bs.modal', function(e) {
			$(".modal-dialog").css("width", "50%");
			var tipo = $(e.relatedTarget).data().tipo;
			var idreg = $(e.relatedTarget).data().idreg;
			var idprod = $(e.relatedTarget).data().idprod;
			var url = "consulta_modal_proyeccion.php"; //por crear
			$.ajax({
				type: "POST",
				url: url,
				data: {
					tipo: tipo,
					idreg: idreg,
					idprod: idprod
				},
				success: function(respuesta) {
					var array = eval(respuesta);
					$("#id_receta").val(array[0]);
					$("#articulo").val(array[1]);
					$("#proyeccion").val(array[2]);
					$("#piezas").val("");
				}
			})
		})
		$('#btn-Guardar').click(function() {
			if ($("#proyeccion").val() == "" || $("#piezas").val() == "") {
				alertify.error("Existen campos vacíos");
			} else {
				var url = "insertar_proyeccion.php";
				$.ajax({
					url: url,
					type: "POST",
					dataType: "html",
					data: $("#form-modal").serialize(),
					success: function(respuesta) {
						if (respuesta == "ok") {
							alertify.success("Proyección añadida correctamente");
							$('#modal-proyeccion').modal('hide');
						} else if (respuesta == "ok_modifica") {
							alertify.success("Proyeccion añadida correctamente");
							$('#modal-proyeccion').modal('hide');
						} else {
							alertify.error("Se produjo un error");
						}
						cargar_tabla();
					},
					error: function(xhr, status) {
						alert("Error");
					}
				})
			}
		});

		$('#lista_ventas').on('change', 'input', function() {
			var val = $(this).val();

			var data = $('#lista_ventas').DataTable().row($(this).parents('tr')).data();
			var porcentaje = $('#lista_ventas').DataTable().cell($(this).parents('tr'), 3).nodes().to$().find('input').val();
			var n_igual_cero = $('#lista_ventas').DataTable().cell($(this).parents('tr'), 4).nodes().to$().find('input').val();
			if (val == "" || porcentaje == "" || n_igual_cero == "") {
				alertify.error("Existen campos vacíos");
			} else {
				var url = "insertar_proyeccion.php";
				$.ajax({
					url: url,
					type: "POST",
					dataType: "html",
					data: {
						articulo: data["ARTC_ARTICULO"],
						proyeccion: porcentaje,
						piezas: n_igual_cero
					},
					success: function(respuesta) {
						if (respuesta == "ok") {
							alertify.success("Proyección añadida correctamente");
							$('#modal-proyeccion').modal('hide');
						} else if (respuesta == "ok_modifica") {
							alertify.success("Proyeccion añadida correctamente");
							$('#modal-proyeccion').modal('hide');
						} else {
							alertify.error("Se produjo un error");
						}
						//cargar_tabla();
						$('#lista_ventas').DataTable().ajax.reload();
					},
					error: function(xhr, status) {
						alert("Error");
					}
				})
			}
		});
	</script>
</body>

</html>