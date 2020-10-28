<?php
  include '../global_seguridad/verificar_sesion.php';
  function _data_last_month_day() { 
    $month = date('m');
    $year = date('Y');
    $day = date("d", mktime(0,0,0, $month+1, 0, $year));
    return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
  };
  /** Actual month first day **/
  function _data_first_month_day() {
    $month = date('m');
    $year = date('Y');
    return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
  }
  $fecha1 = _data_first_month_day();
  $fecha2 = _data_last_month_day();
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
						<h3 class="box-title">Notas de Cargo | Resumen</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-3">
					                <div class="form-group">
					                  <label for="fecha">*Fecha:</label>
					                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha" data-link-format="yyyy-mm-dd" >
					                    <input class="form-control" size="16" type="text"  id="fecha1" name="fecha1" value="<?php echo $fecha1?>" onchange='cargar()'>
					                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					                  </div>
					                </div>
					            </div>
					            <div class="col-md-3">
					                <div class="form-group">
					                  <label for="fecha">*Fecha:</label>
					                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha" data-link-format="yyyy-mm-dd" >
					                    <input class="form-control" size="16" type="text"  id="fecha2" name="fecha2" value="<?php echo $fecha2?>" onchange='cargar()'>
					                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					                  </div>
					                </div>
					            </div>
					            <div class="col-md-3">
									<div class="form-group">
										<label for="sucursal">*Sucursal</label>
										<select name="sucursal" id="sucursal" class="form-control" onchange="">
											<option value=""></option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="sucursal">*Proveedor</label>
										<select name="proveedor" id="proveedor" class="form-control" onchange="">
											<option value=""></option>
										</select>
									</div>
								</div>
					        </div>
						</div>
						<div class="box-footer text-right">
		                  <button type="button" class="btn btn-warning" id="guardar1" onclick="limpiar()">Limpiar</button>
		                  <button type="button" class="btn btn-danger" id="guardar1" onclick="cargar()">Generar</button>
		                </div>
						<!-- <br> -->
						<div class="row">
							<div class="col-md-12">
								<h4 for="" class="box-title">Totales</h4>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="info-box bg-aqua">
										<span class="info-box-icon"><i class="fa fa-file-text-o"></i></span>
										<div class="info-box-content">
											<span class="info-box-text">Notas de Cargo</span>
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
										<span class="info-box-icon"><i class="fa fa-usd"></i></span>
										<div class="info-box-content">
											<span class="info-box-text">Monto Total</span>
											<span class="info-box-number" id="total_monto"></span>

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
							</div>
						</div>
					</div>
				</div>
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Lista de Proveedores</h3>
					</div>
					<div class="box-body">
						<div class="row">
						  <div class="col-md-12">
						    <div class="table-responsive">
						      <table id='lista_proveedores' class='table table-striped table-bordered' cellspacing='0' width='100%'>
						        <thead>
						          <tr>
						            <th width="5%">#</th>
						            <th >Proveedor</th>
						            <th width="12%">Notas de Cargo</th>
						            <th width="10%">Monto Total</th>
						          </tr>
						        </thead>
						        <tfoot>
						          <tr>
						            <th>#</th>
						            <th>Proveedor</th>
						            <th>Notas de Cargo</th>
						            <th>Monto Total</th>
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
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
	<script>
		function tabla(){
			var sucursal  = $("#sucursal").val();
			var fecha1    = $("#fecha1").val();
			var fecha2    = $("#fecha2").val();
			var proveedor = $('#proveedor').val();
			$('#lista_proveedores').dataTable().fnDestroy();
			$('#lista_proveedores').DataTable({
				'language': {"url": "../plugins/DataTables/Spanish.json"},
				"paging": true,
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
		            title: 'Notas de Cargo',
		            exportOptions: {
		              columns: ':visible'
		            }
		          },
		          {
		            extend: 'pdf',
		            text: 'Exportar a PDF',
		            className: 'btn btn-default',
		            title: 'Notas de Cargo',
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
					"url": "tabla_proveedores.php",
					"dataSrc": "",
					"data":{
						'sucursal': sucursal,
						'fecha1': fecha1,
						'fecha2': fecha2,
						'proveedor': proveedor
					}
				},
				"columns": [
					{ "data": "#" },
					{ "data": "Proveedor" },
					{ "data": "Cartas Faltantes" },
					{ "data": "Monto Total" }
				]
			});
		}
		$(document).ready(function(e) {
			cargar_totales();
			tabla();
		});
		function cargar(){
			cargar_totales();
			tabla();
		}
		function limpiar(){
			$("#sucursal").select2("trigger", "select", {
		        data: { id: '', text:'' }
		    });
		    $("#proveedor").select2("trigger", "select", {
		    	data: { id: '', text:'' }
		    });
		    cargar();
		}
		function cargar_totales() {
			var sucursal = $("#sucursal").val();
			var fecha1   = $("#fecha1").val();
			var fecha2   = $("#fecha2").val();
			var proveedor = $('#proveedor').val();
			$.ajax({
				type: "POST",
				url: 'consulta_resumen.php',
				data: {
					sucursal: sucursal,
					fecha1: fecha1,
					fecha2: fecha2,
					proveedor: proveedor
				}, // Adjuntar los campos del formulario enviado.
				success: function(respuesta) {
					var array = eval(respuesta);
					$("#total").html(array[0]);
					$("#total_monto").html(array[1]);
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
		$('#proveedor').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			//minimumResultsForSearch: Infinity,
			ajax: {
				url: "consulta_proveedor2.php",
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
		$('.form_date').datetimepicker({
	      language:  'es',
	      weekStart: 1,
	      todayBtn:  1,
	      autoclose: 1,
	      todayHighlight: 1,
	      startView: 2,
	      minView: 2,
	      forceParse: 0
	    }); 
	</script>
</body>

</html>