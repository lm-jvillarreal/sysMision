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
				<div class="box box-danger" id="div-articulos" <?php echo $solo_lectura; ?>>
					<div class="box-header">
						<h3 class="box-title">Formatos de Movimientos | Solicitud</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-4">
								<label for="tipo_formato">*Selecciona un formato</label>
								<select name="tipo_formato" id="tipo_formato" class="form-control">
									<option value=""></option>
									<option value="ECHORI">CONVERSION CHORIZO</option>
									<option value="EXCONV">CONVERSION ARTICULOS</option>
									<option value="EXVIGI">ENTRADA POR VIGILANCIA</option>
									<option value="SXMBOD">MERMA BODEGA</option>
									<option value="SXMCAR">MERMA CARNICERIA</option>
									<option value="SXMFCI">MERMA FARMACIA</option>
									<option value="SXMFTA">MERMA FRUTAS Y VERDURAS</option>
									<option value="SXMEDO">MERMA MAL ESTADO</option>
									<option value="SXMPAN">MERMA PANADERIA/PASTELERIA</option>
									<option value="SXMTOR">MERMA TORTILLERIA</option>
									<option value="SXMVAR">MERMA VARIEDADES</option>
									<option value="SFAACC">FARMACIA ACCIDENTES</option>
									<option value="SFCBOT">FARMACIA BOTIQUIN</option>
									<option value="SXROB">SALIDA POR ROBO</option>
									<option value="TRADEP">TRANSFERENCIA DEPTOS.</option>
								</select>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="encargado">*Encargado</label>
									<select name="encargado" id="encargado" class="form-control">
										<option value=""></option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="auxiliar">*Auxiliar</label>
									<input type="text" name="auxiliar" id="auxiliar" class="form-control">
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer text-right">
						<button class="btn btn-danger" id="btn-guardar">Imprimir Formato</button>
					</div>
				</div>
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Lista de faltantes registrados</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="lista_codigos" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th width='5%'>#</th>
												<th>Movimiento</th>
												<th width='10%'>Sucursal</th>
												<th width='10%'>Estatus</th>
												<th width='5%'>Infofin</th>
												<th width='10%'>Fecha</th>
												<th width='10%'>Solicita</th>
												<th width='20%'>Liberar</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>#</th>
												<th>Movimiento</th>
												<th>Sucursal</th>
												<th>Estatus</th>
												<th>Infofin</th>
												<th>Fecha</th>
												<th>Solicita</th>
												<th>Liberar</th>
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
		<?php include 'modal.php'; ?>
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
			cargar_tabla();
		});

		function cargar_tabla() {
			$('#lista_codigos thead th').each(function() {
				var title = $(this).text();
				$(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
			});
			$('#lista_codigos').dataTable().fnDestroy();
			var table = $('#lista_codigos').DataTable({
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
					}
				],
				"ajax": {
					"type": "POST",
					"url": "tabla_movimientos.php",
					"dataSrc": "",
					"data": ""
				},
				"columns": [{
						"data": "id"
					},
					{
						"data": "movimiento"
					},
					{
						"data": "sucursal"
					},
					{
						"data": "estatus"
					},
					{
						"data": "infofin"
					},
					{
						"data": "fecha"
					},
					{
						"data": "solicita"
					},
					{
						"data": "liberar"
					}
				]
			});
			table.columns().every(function() {
				var that = this;
				$('input', this.header()).on('keyup change', function() {
					if (that.search() !== this.value) {
						that
							.search(this.value)
							.draw();
					}
				});
			});
		}
		$('#tipo_formato').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			//minimumResultsForSearch: Infinity
		})
		$('#btn-guardar').click(function() {
			if ($("#tipo_formato").val() == "" || $("#auxiliar").val()=="") {
				alertify.error("Campo requerido, rellena todo");
			} else {
				var tipo_movimiento = $("#tipo_formato").val();
				var auxiliar = $("#auxiliar").val();
				//alert(tipo_movimiento);
				var url = 'insertar_formato.php';
				$.ajax({
					type: "POST",
					url: url,
					data: {
						tipo_movimiento: tipo_movimiento,
						auxiliar: auxiliar
					}, // Adjuntar los campos del formulario enviado.
					success: function(respuesta) {
						if (respuesta == "pendiente") {
							alertify.error("Ya existe un folio pendiente");
						} else {
							alertify.success("El folio ha sido generado");

							if (respuesta == "ECHORI") {
								window.open('conversion_chorizo.php', '_blank');
							} else if (respuesta == "EXCONV") {
								window.open('conversion_articulos.php', '_blank');
							} else if (respuesta == "EXVIGI") {
								window.open('entrada_vigilancia.php', '_blank');
							} else if (respuesta == "SXMBOD") {
								window.open('merma_bodega.php', '_blank');
							} else if (respuesta == "SXMCAR") {
								window.open('merma_carniceria.php', '_blank');
							} else if (respuesta == "SXMFCI") {
								window.open('merma_farmacia.php', '_blank');
							} else if (respuesta == "SXMFTA") {
								window.open('merma_fta.php', '_blank');
							} else if (respuesta == "SXMEDO") {
								window.open('merma_medo.php', '_blank');
							} else if (respuesta == "SXMPAN") {
								window.open('merma_panaderia.php', '_blank');
							} else if (respuesta == "SXMTOR") {
								window.open('merma_tortilleria.php', '_blank');
							} else if (respuesta == "SXMVAR") {
								window.open('merma_variedades.php', '_blank');
							} else if (respuesta == "SFAACC") {
								window.open('transferencia_accidente.php', '_blank');
							} else if (respuesta == "SFCBOT") {
								window.open('transferencia_botiquin.php', '_blank');
							} else if (respuesta == "SXROB") {
								window.open('mermas_robo.php', '_blank');
							} else if (respuesta == "TRADEP") {
								window.open('transferencia_deptos.php', '_blank');
							}
						}
					}
				});
				cargar_tabla();
				return false;
			}
		});

		function asocia(id_formato) {
			var url = "libera_formato.php";
			var folio = $("#folio_" + id_formato).val();
			$.ajax({
				url: url,
				type: "POST",
				dateType: "html",
				data: {
					folio: folio,
					id_formato: id_formato
				},
				success: function(respuesta) {
					alertify.success("El formato ha sido liberado correctamente");
				},
				error: function(xhr, status) {
					alert("error");
					//alert(xhr);
				},
			});
			cargar_tabla();
			return false;
		}
		$(document).ready(function(e) {
			$('#modal-default').on('show.bs.modal', function(e) {
				var id = $(e.relatedTarget).data().id;
				var mov = $(e.relatedTarget).data().mov;
				var suc = $(e.relatedTarget).data().suc;
				//alert(id);
				var url = "tabla_modal.php"; // El script a dónde se realizará la petición.
				$.ajax({
					type: "POST",
					url: url,
					data: {
						ide: id,
						movi: mov,
						suc: suc
					}, // Adjuntar los campos del formulario enviado.
					success: function(respuesta) {
						$('#tabla').html(respuesta);
					}
				});
			});
		});
		$('#encargado').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			//minimumResultsForSearch: Infinity
			ajax: {
				url: "consulta_encargados.php",
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
		$("#encargado").change(function() {
			var texto = $('select[name="encargado"] option:selected').text();
			$("#auxiliar").val(texto);
		});
	</script>
</body>

</html>