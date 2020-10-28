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
						<h3 class="box-title">Resumen de Piso de Venta | Faltantes</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="sucursal">*Sucursal</label>
									<select name="sucursal" id="sucursal" class="form-control">
										<option value=""></option>

									</select>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="info-box bg-aqua">
								<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Faltantes registrados</span>
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
									<span class="info-box-text">Resueltos por Gerencia</span>
									<span class="info-box-number" id="total_gerente"></span>

									<div class="progress">
										<div class="progress-bar" id="pgrs_gerente"></div>
									</div>
									<span class="progress-description" id="porc_gerente">
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
									<span class="info-box-text">Enviados a Compras</span>
									<span class="info-box-number" id="total_enviados"></span>

									<div class="progress">
										<div class="progress-bar" id="pgrs_enviados"></div>
									</div>
									<span class="progress-description" id="porc_enviados">
									</span>
								</div>
								<!-- /.info-box-content -->
							</div>
							<!-- /.info-box -->
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="info-box bg-aqua">
								<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Resueltos por Compras</span>
									<span class="info-box-number" id="total_resCompras"></span>

									<div class="progress">
										<div class="progress-bar" id="pgrs_resCompras"></div>
									</div>
									<span class="progress-description" id="porc_resCompras">
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
									<span class="info-box-text">Liberado por Entrada</span>
									<span class="info-box-number" id="total_entrada"></span>

									<div class="progress">
										<div class="progress-bar" id="pgrs_entrada"></div>
									</div>
									<span class="progress-description" id="porc_entrada">
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
									<span class="info-box-text">En Piso</span>
									<span class="info-box-number" id="total_piso"></span>

									<div class="progress">
										<div class="progress-bar" id="pgrs_piso"></div>
									</div>
									<span class="progress-description" id="porc_piso">
									</span>
								</div>
								<!-- /.info-box-content -->
							</div>
							<!-- /.info-box -->
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="info-box bg-aqua">
								<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Auditados</span>
									<span class="info-box-number" id="total_audita"></span>

									<div class="progress">
										<div class="progress-bar" id="pgrs_audita"></div>
									</div>
									<span class="progress-description" id="porc_audita">
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
									<span class="info-box-text">Auditados Positivos</span>
									<span class="info-box-number" id="total_auditaBien"></span>

									<div class="progress">
										<div class="progress-bar" id="pgrs_auditaBien"></div>
									</div>
									<span class="progress-description" id="porc_auditaBien">
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
									<span class="info-box-text">Auditados Negativos</span>
									<span class="info-box-number" id="total_auditaMal"></span>

									<div class="progress">
										<div class="progress-bar" id="pgrs_auditaMal"></div>
									</div>
									<span class="progress-description" id="porc_auditaMal">
									</span>
								</div>
								<!-- /.info-box-content -->
							</div>
							<!-- /.info-box -->
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="info-box bg-aqua">
								<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Artículos a ajuste</span>
									<span class="info-box-number" id="total_ajuste"></span>

									<div class="progress">
										<div class="progress-bar" id="pgrs_ajuste"></div>
									</div>
									<span class="progress-description" id="porc_ajuste">
									</span>
								</div>
								<!-- /.info-box-content -->
							</div>
						</div>
					</div>
					<!-- /.row -->
			</section>
			<!-- /.content -->
		</div>
		<?php include 'modal_ue.php'; ?>
		<?php include 'modal_comentario.php'; ?>
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
			var url = "consulta_resumen.php"; // El script a dónde se realizará la petición.
			var sucursal = $("#sucursal").val();
			$.ajax({
				type: "POST",
				url: url,
				data: {
					sucursal: sucursal
				}, // Adjuntar los campos del formulario enviado.
				success: function(respuesta) {
					var array = eval(respuesta);
					$("#total").html(array[0]);
					$("#total_gerente").html(array[1]);
					$("#pgrs_gerente").attr("style", "width: " + array[2]);
					$("#porc_gerente").html(array[3]);
					$("#total_enviados").html(array[4]);
					$("#pgrs_enviados").attr("style", "width: " + array[5]);
					$("#porc_enviados").html(array[6]);
					$("#total_resCompras").html(array[7]);
					$("#pgrs_resCompras").attr("style", "width: " + array[8]);
					$("#porc_resCompras").html(array[9]);
					$("#total_entrada").html(array[10]);
					$("#pgrs_entrada").attr("style", "width: " + array[11]);
					$("#porc_entrada").html(array[12]);
					$("#total_piso").html(array[13]);
					$("#pgrs_piso").attr("style", "width: " + array[14]);
					$("#porc_piso").html(array[15]);
					$("#total_audita").html(array[16]);
					$("#pgrs_audita").attr("style", "width: " + array[17]);
					$("#porc_audita").html(array[18]);
					$("#total_auditaBien").html(array[19]);
					$("#pgrs_auditaBien").attr("style", "width: " + array[20]);
					$("#porc_auditaBien").html(array[21]);
					$("#total_auditaMal").html(array[22]);
					$("#pgrs_auditaMal").attr("style", "width: " + array[23]);
					$("#porc_auditaMal").html(array[24]);
					$("#total_ajuste").html(array[25]);
					$("#pgrs_ajuste").attr("style", "width: " + array[26]);
					$("#porc_ajuste").html(array[27]);
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