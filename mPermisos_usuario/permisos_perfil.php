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
						<h3 class="box-title">Administración de Permisos | Filtros</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="usuario">*Perfil de Usuario</label>
									<select name="perfil" id="perfil" class="form-control">
										<option value=""></option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer text-right">
						<button class="btn btn-warning" id="btn-buscar">Consultar</button>
					</div>
				</div>
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Administración de Permisos | Detalles</h3>
					</div>
					<div class="box-body">
						<div class="row">
						<div class="col-md-6">
								<div class="table-responsive">
									<table id="lista_personas" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th width="5%">#</th>
												<th>Persona</th>
												<th>Usuario</th>
												<th></th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th width="5%">#</th>
												<th>Persona</th>
												<th>Usuario</th>
												<th></th>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
							<div class="col-md-6">
								<div class="table-responsive">
									<table id="lista_modulos" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th width="5%">#</th>
												<th>Módulo</th>
												<th width="10%">Solo Suc.</th>
												<th width="10%">Reg. Prop.</th>
												<th width="10%">Solo lec.</th>
												<th width="10%">Acceso</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th width="5%">#</th>
												<th>Módulo</th>
												<th>Solo Suc.</th>
												<th>Reg. Prop.</th>
												<th>Solo lec.</th>
												<th>Acceso</th>
											</tr>
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
		$(document).ready(function() {
			$('#perfil').select2({
				placeholder: 'Seleccione una opcion',
				lenguage: 'es',
				//minimumResultsForSearch: Infinity
				ajax: {
					url: "consulta_perfil.php",
					type: "post",
					dataType: 'json',
					delay: 250,
					data: function(params) {
						return {
							searchTerm: params.term, // search term
							usuario: $("#usuario").val()
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
			cargar_tabla_modulos(0);
			cargar_tabla_personas();
		});

		function cargar_tabla_modulos(usuario) {
			var ide_usuario = usuario;
			$('#lista_modulos').dataTable().fnDestroy();
			$('#lista_modulos').DataTable({
				'language': {
					"url": "../plugins/DataTables/Spanish.json"
				},
				"paging": false,
				"ajax": {
					"type": "POST",
					"url": "tabla.php",
					"dataSrc": "",
					"data": {
						ide_usuario: ide_usuario
					}
				},
				"columns": [{
						"data": "id"
					},
					{
						"data": "modulo"
					},
					{
						"data": "solo_sucursal"
					},
					{
						"data": "registros_propios"
					},
					{
						"data": "solo_lectura"
					},
					{
						"data": "acceso"
					}
				]
			});
		}
		function cargar_tabla_personas() {
			var ide_perfil = $("#perfil").val();
			$('#lista_personas').dataTable().fnDestroy();
			$('#lista_personas').DataTable({
				'language': {
					"url": "../plugins/DataTables/Spanish.json"
				},
				"paging": false,
				"ajax": {
					"type": "POST",
					"url": "tabla_personas.php",
					"dataSrc": "",
					"data": {
						ide_perfil: ide_perfil
					}
				},
				"columns": [{
						"data": "id"
					},
					{
						"data": "persona"
					},
					{
						"data": "usuario"
					},
					{
						"data": "seleccionar"
					}
				]
			});
		}

		function solo_sucursal(registro) {
			var id_registro = registro;
			var url = 'solo_sucursal.php';
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: {
					id_registro: id_registro
				},
				success: function(respuesta) {
					if (respuesta == "ok") {
						alertify.success("Permiso modificado correctamente");
					}
				},
				error: function(xhr, status) {
					alert("error");
					//alert(xhr);
				},
			});
		}

		function solo_lectura(registro) {
			var id_registro = registro;
			var url = 'solo_lectura.php';
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: {
					id_registro: id_registro
				},
				success: function(respuesta) {
					if (respuesta == "ok") {
						alertify.success("Permiso modificado correctamente");
					}
				},
				error: function(xhr, status) {
					alert("error");
					//alert(xhr);
				},
			});
		}

		function registros_propios(registro) {
			var id_registro = registro;
			var url = 'registros_propios.php';
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: {
					id_registro: id_registro
				},
				success: function(respuesta) {
					if (respuesta == "ok") {
						alertify.success("Permiso modificado correctamente");
					}
				},
				error: function(xhr, status) {
					alert("error");
					//alert(xhr);
				},
			});
		}

		function revocar_permiso(registro) {
			var id_registro = registro;
			var url = 'revocar_permiso.php';
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: {
					id_registro: id_registro
				},
				success: function(respuesta) {
					if (respuesta == "ok") {
						alertify.success("Acceso al módulo revocado correctamente");
						cargar_tabla();
					}
				},
				error: function(xhr, status) {
					alert("error");
					//alert(xhr);
				},
			});
		}
		$("#btn-buscar").click(function() {
			cargar_tabla_personas();
			return false;
		});
	</script>
</body>

</html>