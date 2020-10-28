<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
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
						<h3 class="box-title">PV | Ofertas vigentes</h3>
					</div>
					<div class="box-body">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="sucursal">*Sucursal:</label>
										<select name="sucursal" id="sucursal" class="form-control">
											<option value=""></option>
											<option value="1">Díaz Ordaz</option>
											<option value="2">Arboledas</option>
											<option value="3">Villegas</option>
											<option value="4">Allende</option>
											<option value="5">Petaca</option>
                    	<option value="99">CEDIS</option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="departamento">Departamento</label>
										<select name="departamento" class="form-control" id="departamento">
											<option></option>
										</select>
									</div>
								</div>
							</div>
					</div>
					<div class="box-footer text-right">
						<button class="btn btn-warning" id="mostrar_datos">Mostrar datos</button>
					</div>
				</div>
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Ofertas vigentes | Listado</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="lista_codigos" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th width='10%'>Departamento</th>
												<th width='15%'>Familia</th>
												<th width='5%'>Artículo</th>
												<th>Descripción</th>
												<th width='5%'>Precio</th>
												<th width='5%'>Costo</th>
												<th width='5%'>Folio</th>
												<th width='5%'>Vigencia</th>
												<th width='5%'>Oferta</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Departamento</th>
												<th>Familia</th>
												<th>Artículo</th>
												<th>Descripción</th>
												<th>Precio</th>
												<th>Costo</th>
												<th>Folio</th>
												<th>Vigencia</th>
												<th>Oferta</th>
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
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
	<!-- Page script -->
	<script>
		$("#mostrar_datos").click(function(){
			cargar_tabla();
		})
		$('#sucursal').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: Infinity
		});
		$('#departamento').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			//minimumResultsForSearch: Infinity
			ajax: {
				url: "consulta_departamentos.php",
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

		function cargar_tabla() {
			var departamento = $("#departamento").val();
			var sucursal = $("#sucursal").val();
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
					"url": "tabla_ofertas.php",
					"dataSrc": "",
					"data":{departamento: departamento, sucursal: sucursal}
				},
				"columns": [{
						"data": "depto"
					},
					{
						"data": "familia"
					},
					{
						"data": "codigo"
					},
					{
						"data": "descripcion"
					},
					{
						"data": "precio"
					},
					{
						"data": "costo"
					},
					{
						"data": "folio_oferta"
					},
					{
						"data": "vigencia_oferta"
					},
					{
						"data": "oferta"
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
	</script>
</body>

</html>