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
						<h3 class="box-title">Registro de Personal</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="persona">*Selecciona una persona</label>
									<select name="persona" id="persona" class="form-control">
										<option value=""></option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="sucursal">*Sucursal</label>
									<select name="sucursal" id="sucursal" class="form-control">
										<option value=""></option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="nombre">*Nombre</label>
									<input type="text" name="nombre" id="nombre" class="form-control">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="ap_paterno">*Ap. Paterno</label>
									<input type="text" name="ap_paterno" id="ap_paterno" class="form-control">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="nombre">*Ap, Materno</label>
									<input type="text" name="ap_materno" id="ap_materno" class="form-control">
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer text-right">
						<button type="submit" class="btn btn-warning" id="btn-guardar">Guardar</button>
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
		$('#persona').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			//minimumResultsForSearch: Infinity,
			ajax: {
				url: "consulta_personas.php",
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
		$("#persona").change(function() {
			var url = "consulta_editar_sucursal.php"; // El script a dónde se realizará la petición.
			var persona = $("#persona").val();
			$.ajax({
				type: "POST",
				url: url,
				data: {
					persona: persona
				}, // Adjuntar los campos del formulario enviado.
				success: function(respuesta) {
					var array = eval(respuesta);
					ide = array[0];
					suc = array[1];
					$("#sucursal").select2("trigger", "select", {
						data: {
							id: ide,
							text: suc
						}
					});
					$("#nombre").val(array[2]);
					$("#ap_paterno").val(array[3]);
					$("#ap_materno").val(array[4]);
				}
			});
			return false;
		});
		$("#btn-guardar").click(function() {
			var url = "actualizar_sucursal.php";
			var persona = $("#persona").val();
			var sucursal = $("#sucursal").val();
			var nombre = $("#nombre").val();
			var ap_paterno = $("#ap_paterno").val();
			var ap_materno = $("#ap_materno").val();
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: {
					persona: persona,
					sucursal: sucursal,
					nombre: nombre,
					ap_paterno: ap_paterno,
					ap_materno: ap_materno
				},
				success: function(respuesta) {
					if (respuesta == "ok") {
						alertify.success("Datos actualizados correctamente");
					}
				},
				error: function(xhr, status) {
					alert("error");
					//alert(xhr);
				},
			})
			return false;
		});
	</script>
</body>

</html>