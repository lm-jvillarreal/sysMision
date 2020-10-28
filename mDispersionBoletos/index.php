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
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Dispersión de Boletos | Registro</h3>
					</div>
					<div class="box-body">
						<form action="" method="POST" id="form_dispersion">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="sucursal">*Sucursal</label>
										<select name="sucursal" id="sucursal" class="form-control">
											<option value=""></option>
											<option value="1">Diaz Ordaz</option>
											<option value="2">Arboledas</option>
											<option value="3">Villegas</option>
											<option value="4">Allende</option>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="folio_inicio">*F. Inicial</label>
										<input type="number" id="folio_inicial" name="folio_inicial" class="form-control">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="folio_fin">*F. Final</label>
										<input type="number" id="folio_final" name="folio_final" class="form-control">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="cantidad_blocks">*Cant. blocks</label>
										<input type="number" id="cantidad_blocks" name="cantidad_blocks" class="form-control" readonly="true">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="porcentaje">*Porcentaje</label>
										<input type="number" id="porcentaje" name="porcentaje" class="form-control" readonly="true">
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="box-footer text-right">
						<button class="btn btn-warning" id="guardar">Guardar Dispersión</button>
					</div>
				</div>
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Dispersión de Boletos | Listado</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-3">
								<div class="info-box bg-yellow">
									<span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

									<div class="info-box-content">
										<span class="info-box-text">DIAZ ORDAZ</span>
										<span class="info-box-number"><div id="restoDO"></div></span>

										<div class="progress">
											<div class="progress-bar" id="prgrsDO"></div>
										</div>
										<span class="progress-description">
											<div id="porcientoDO"></div>
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
							</div>
							<div class="col-md-3">
								<div class="info-box bg-red">
									<span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

									<div class="info-box-content">
										<span class="info-box-text">ARBOLEDAS</span>
										<span class="info-box-number"><div id="restoARB"></div></span>

										<div class="progress">
											<div class="progress-bar" id="prgrsARB"></div>
										</div>
										<span class="progress-description">
											<div id="porcientoARB"></div>
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
							</div>
							<div class="col-md-3">
								<div class="info-box bg-green">
									<span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

									<div class="info-box-content">
										<span class="info-box-text">VILLEGAS</span>
										<span class="info-box-number"><div id="restoVILL"></div></span>

										<div class="progress">
											<div class="progress-bar" id="prgrsVILL"></div>
										</div>
										<span class="progress-description">
											<div id="porcientoVILL"></div>
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
							</div>
							<div class="col-md-3">
								<div class="info-box bg-aqua">
									<span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

									<div class="info-box-content">
										<span class="info-box-text">ALLENDE</span>
										<span class="info-box-number"><div id="restoALL"></div></span>

										<div class="progress">
											<div class="progress-bar" id="prgrsALL"></div>
										</div>
										<span class="progress-description">
											<div id="porcientoALL"></div>
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="lista_dispersion" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<th width="5%">#</th>
											<th>Sucursal</th>
											<th width="20%">Folio Inicial</th>
											<th width="20%">Folio Final</th>
											<th width="10%">Blocks</th>
											<th width="10%">Porcentaje</th>
											<th width="10%">Fecha</th>
											<th width="5%"></th>
											<th width="5%"></th>
										</thead>
										<tbody></tbody>
										<tfoot>
											<th>#</th>
											<th>Sucursal</th>
											<th>Folio Inicial</th>
											<th>Folio Final</th>
											<th>Blocks</th>
											<th>Fecha</th>
											<th>Porcentaje</th>
											<th></th>
											<th></th>
										</tfoot>
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
	<!-- Page script -->
	<script>
		$(document).ready(function(e) {
			cargar_tabla();
			totales();
		});
		$('#sucursal').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: Infinity
		});

		function cargar_tabla() {
			$('#lista_dispersion').dataTable().fnDestroy();
			$('#lista_dispersion').DataTable({
				'language': {
					"url": "../plugins/DataTables/Spanish.json"
				},
				"paging": false,
				"order": [
					[2, "asc"]
				],
				"ajax": {
					"type": "POST",
					"url": "tabla.php",
					"dataSrc": ""
				},
				"columns": [{
						"data": "id"
					},
					{
						"data": "sucursal"
					},
					{
						"data": "folio_inicial"
					},
					{
						"data": "folio_final"
					},
					{
						"data": "blocks"
					},
					{
						"data": "porcentaje"
					},
					{
						"data": "fecha"
					},
					{
						"data": "opciones"
					},
					{
						"data": "activo"
					}
				]
			});
		}
		$("#folio_final").keypress(function(e) { //Función que se desencadena al presionar enter
			var code = (e.keyCode ? e.keyCode : e.which);
			if (code == 13) {
				var url = "consulta_totales.php"; // El script a dónde se realizará la petición.
				var sucursal = $("#sucursal").val();
				var folio_inicial = $("#folio_inicial").val();
				var folio_final = $("#folio_final").val();
				$.ajax({
					type: "POST",
					url: url,
					data: {
						sucursal: sucursal,
						folio_inicial: folio_inicial,
						folio_final: folio_final
					}, // Adjuntar los campos del formulario enviado.
					success: function(respuesta) {
						if (respuesta == "rango_invalido") {
							swal("Los boletos que intentas ingresar estan fuera de rango", "Dispersión de Boletos", "error");
							$("#form_dispersion")[0].reset();
							$("#folio_inicial").focus();
						} else if (respuesta == "rango_asignado") {
							swal("Los boletos que intentas ingresar ya fueron asignados", "Dispersión de Boletos", "error");
							$("#form_dispersion")[0].reset();
							$("#folio_inicial").focus();
						} else {
							var array = eval(respuesta);
							$('#cantidad_blocks').val(array[0]);
							$('#porcentaje').val(array[1]);
						}

					}
				});
				return false;
			}
		});
		$("#folio_inicial").keypress(function(e) { //Función que se desencadena al presionar enter
			var code = (e.keyCode ? e.keyCode : e.which);
			if (code == 13) {
				var url = "consulta_totales.php"; // El script a dónde se realizará la petición.
				var sucursal = $("#sucursal").val();
				var folio_inicial = $("#folio_inicial").val();
				var folio_final = $("#folio_final").val();
				$.ajax({
					type: "POST",
					url: url,
					data: {
						sucursal: sucursal,
						folio_inicial: folio_inicial,
						folio_final: folio_final
					}, // Adjuntar los campos del formulario enviado.
					success: function(respuesta) {
						if (respuesta == "rango_invalido") {
							swal("Los boletos que intentas ingresar estan fuera de rango", "Dispersión de Boletos", "error");
							$("#form_dispersion")[0].reset();
						} else if (respuesta == "rango_asignado") {
							swal("Los boletos que intentas ingresar ya fueron asignados", "Dispersión de Boletos", "error");
							$("#form_dispersion")[0].reset();
						} else {
							var array = eval(respuesta);
							$('#cantidad_blocks').val(array[0]);
							$('#porcentaje').val(array[1]);
						}

					}
				});
				return false;
			}
		});
		$("#guardar").click(function() {
			var url = "insertar_dispersion.php";
			var sucursal = $("#sucursal").val();
			var folio_inicial = $("#folio_inicial").val();
			var folio_final = $("#folio_final").val();
			var cantidad_blocks = $("#cantidad_blocks").val();
			var porcentaje = $("#porcentaje").val();
			if (sucursal == "" || folio_inicial == "" || folio_final == "" || cantidad_blocks == "") {
				swal("Existen campos vacíos que son requeridos", "Dispersión de Boletos", "error");
			} else {

				$.ajax({
					type: "POST",
					url: url,
					data: {
						sucursal: sucursal,
						folio_inicial: folio_inicial,
						folio_final: folio_final,
						cantidad_blocks: cantidad_blocks,
						porcentaje: porcentaje
					}, // Adjuntar los campos del formulario enviado.
					success: function(respuesta) {
						if (respuesta == "ok") {
							alertify.success("Dispersion realizada correctamente");
							$("#form_dispersion")[0].reset();
							cargar_tabla();
						} else {
							alertify.error("Ha sucedido un error");
							$("#form_dispersion")[0].reset();
						}
					}
				});
			}
		});

		function eliminar(id_registro) {
			var url = "eliminar_registro.php";
			$.ajax({
				type: "POST",
				url: url,
				data: {
					id_registro: id_registro
				},
				success: function(respuesta) {
					alertify.success("Registro eliminado correctamente");
					cargar_tabla();
				}
			});
		}
		function totales(){
			var url = "consulta_resto.php";
			$.ajax({
				type: "POST",
				url: url,
				data: {},
				success: function(respuesta) {
					var array = eval(respuesta);
					$("#restoDO").html(array[0]);
					$("#porcientoDO").html(array[1]+"% entregado");
					$("#prgrsDO").attr("style", "width: " + array[1]+"%");
					$("#restoARB").html(array[2]);
					$("#porcientoARB").html(array[3]+"% entregado");
					$("#prgrsARB").attr("style", "width: " + array[3]+"%");
					$("#restoVILL").html(array[4]);
					$("#porcientoVILL").html(array[5]+"% entregado");
					$("#prgrsVILL").attr("style", "width: " + array[5]+"%");
					$("#restoALL").html(array[6]);
					$("#porcientoALL").html(array[7]+"% entregado");
					$("#prgrsALL").attr("style", "width: " + array[7]+"%")
				}
			});
		}
		function estatus(registro) {
      var id_registro = registro;
      var url = 'cambiar_estatus.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_registro: id_registro
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Dispersión activada correctamente");
          }
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