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
			<?php include 'menuV2.php'; ?>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<!-- Main content -->
			<section class="content">
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Mis Datos Personales | Cambiar Fotografía</h3>
					</div>
					<div class="box-body">
					<form method="POST" id="form-imagen">
						<div class="row">
							<div class="col-md-5">
								<div class="form-group">
									<label for="documento">*Seleccionar Fotografía</label>
									<input name="action" type="hidden" value="upload" id="action" />
									<input type="file" name="archivos" id="archivos">
								</div>
							</div>
						</div>
					</form>
					</div>
					<div class="box-footer">
						<div class="text-right">
							<button class="btn btn-danger" id="btn-guardar">Guardar Fotografía</button>
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
	<script type="text/javascript">
		$(":file").filestyle('buttonText', 'Seleccionar');
		$(":file").filestyle('size', 'sm');
		$(":file").filestyle('input', true);
		$(":file").filestyle('disabled', false);
		$("#btn-guardar").click(function() {
			var parametros = new FormData($("#form-imagen")[0]);
			$.ajax({
				data: parametros, //datos que se envian a traves de ajax
				url: 'copiar_imagen.php', //archivo que recibe la peticion
				type: 'POST', //método de envio
				dateType: 'html',
				contentType: false,
				processData: false,
				success: function(response) {
					swal("Registro exitoso", "La imagen ha sido actualizada correctamente", "success");
				}
			});
		})
	</script>

</html>