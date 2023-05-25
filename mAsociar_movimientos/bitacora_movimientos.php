<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha      = date('Y-m-d');
$nuevafecha = strtotime('+1 day', strtotime($fecha));
$nuevafecha = date('Y-m-d', $nuevafecha);
$hora       = date('h:i:s');
$prim_dia   = date('Y-m-01');
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
						<h3 class="box-title">Lista de faltantes registrados</h3>
					</div>
					<div class="box-body">
                		<form method="POST" id = "form_datos">
                  			<div class="row">
                    			<div class="col-md-3">
                      				<div class="form-group">
                        				<label for="fecha_inicio">*Fecha Inicio: </label>
                        				<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicial" data-link-format="yyyy-mm-dd">
                          					<input class="form-control" size="16" type="text" value="<?php echo $prim_dia?>" id="fecha_inicial" name="fecha_inicial">
                          					<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                          					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        				</div>
                      				</div>
                    			</div>
                    			<div class="col-md-3">
                      				<div class="form-group">
                        				<label for="fecha_final">*Fecha final:</label>
                        				<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_final" data-link-format="yyyy-mm-dd">
                          					<input class="form-control" size="16" type="text" value="<?php echo $fecha?>" id="fecha_final" name="fecha_final">
                          					<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                          					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        				</div>
                      				</div>
                    			</div>
                  			</div>
                		</form>
						<div class="box-footer text-right">
						<button class="btn btn-danger" id="btn-generar">Generar</button>
              		</div>
              		</div>
				</div>
				<div class="box box-danger">
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
												<th width='10%'>Fecha</th>
												<th width='20%'>Solicita</th>
												<th width='20%'>Imprime</th>
												<th width='5%'>Infofin</th>
												<th width='5%'>Acciones</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>#</th>
												<th>Movimiento</th>
												<th>Sucursal</th>
												<th>Estatus</th>
												<th>Fecha</th>
												<th>Solicita</th>
												<th>Imprime</th>
												<th>Infofin</th>
												<th>Acciones</th>
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
		<?php include 'modal_comentario.php'; ?>
		<?php include 'modal_registro.php'; ?>
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

		$("#btn-generar").click(function() {
			cargar_tabla(1);
		});

		$(function () {
      		$('#comentarios').select2({
        		placeholder: 'Seleccione una opcion',
        		lenguage: 'es',
        		//minimumResultsForSearch: Infinity
        		ajax: { 
        			url: "combo_comentarios.php",
        			type: "post",
        			dataType: 'json',
        			delay: 250,
        			data: function (params) {
        				return {
        					searchTerm: params.term
        				};
        			},
        			processResults: function (response) {
        				return {
            				results: response
        				};
        			},
        			cache: true
        		}
    		})
    	});

		$(function () {
    		$('#error').select2({
        		placeholder: 'Seleccione una opcion',
        		lenguage: 'es',
        		//minimumResultsForSearch: Infinity
        		ajax:({ 
        			url: "consulta_errores.php",
        			type: "post",
        			dataType: 'json',
        			delay: 250,
        			data: function (params) {
        				return {
            				searchTerm: params.term
        				};
        			},
        			processResults: function (response) {
        				return {
            				results: response
        				};
        			},
        			cache: true
        		})
      		})
    	});

		function guardar(){
    		var comentario = $('#comentario').val();
    		var id_registro_modal = $('#id_registro_modal').val();
      		$.trim(comentario);
      		if(comentario == ""){
        		alertify.error("Verifica Campos");
      		}else{
        		$.ajax({
          		url: 'insertar_comentario.php',
        		type: "POST",
          		dateType: "html",
          		data: {'comentario':comentario,'id_registro_modal':id_registro_modal},
          			success: function(respuesta) {
            			if (respuesta == "ok") {
              				alertify.success("Registro Guardado Correctamente");
              				$('#form_datos_comentario')[0].reset();
              				$('#comentario').focus();
              				cargar_tabla_comentarios();
            			}else if (respuesta == "duplicado") {
              				alertify.error("Registro Duplicado");
            			}
          			},
          			error: function(xhr, status) {
            			alert("error");
            			alert(xhr);
          			},
        		})
      		}
      	return
    }
	function cargar_tabla_comentarios(){
      $('#lista_comentarios').dataTable().fnDestroy();
      $('#lista_comentarios').DataTable({
        'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   true,
        "pageLength" : 5,
		"searching": true,
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
			}
		],
        "ajax": {
          "type": "POST",
          "url": "tabla_comentarios.php",
          "dataSrc": "",
          "data":""
        },
        "columns": [
          { "data": "#" },
          { "data": "Nombre" },
          { "data": "Editar" },
          { "data": "Eliminar" }
        ]
      });
    }
	function editar_comentario(id){
      $.ajax({
        url: 'editar_comentario.php',
        type: "POST",
        dateType: "html",
        data: {'id':id},
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#id_registro_modal').val(array[0]);
          $('#comentario').val(array[1]);
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      })
    }
	$('#modal-default').on('show.bs.modal', function(e) {
      cargar_tabla_comentarios();
      $('#form_datos_comentario')[0].reset();
    });
	$('#modal-registroErrores').on('show.bs.modal', function(e) {
		var id_registro = $(e.relatedTarget).data().id;
		var url ="consulta_datos_movimientos.php";
		$.ajax({
			type: "POST",
			url:url,
			data: {'id_registro':id_registro},
			success: function(respuesta)
			{
				var array = eval(respuesta);
				$('#id_registroError').val(array[0]);
				$('#SucursalError').val(array[2]);
				$('#EmpleadoError').val(array[3]);
				$('#MovimientoError').val(array[1]);
			}
		})
    });
	$('#btn-guardar').click(function(){
		var id_registroError = $('#id_registroError').val();
		var MovimientoError = $('#MovimientoError').val();
		var comentarioError = $('#comentarioError').val();
		var SucursalError = $('#SucursalError').val();
		var EmpleadoError = $('#EmpleadoError').val();
		var error = $('#error').val();
        var url = "insertarError.php";
        $.ajax({
            type: "POST",
            url: url,
            data:{ id_registroError:id_registroError,MovimientoError:MovimientoError,SucursalError:SucursalError, EmpleadoError:EmpleadoError, error:error, comentarioError:comentarioError},
			success: function(respuesta) {
				if($('#error').val().length == 0){
					alertify.error("Verifica Campos");
				}else if (respuesta=="ok") {
					alertify.success("Registro Insertado");
					$(":text").val(''); //Limpiar los campos tipo Text
					$('#error').val("").trigger('change.select2');
					$('#modal-registroErrores').modal('hide');
				} else if(respuesta=="ok_actualizado"){
					alertify.success("Registro Actualizado.");
				}else{
					alertify.error("Ha Ocurrido un Error");
				}
			}
        });
    });

	function eliminar_comentario(id){
      $.ajax({
        url: 'eliminar_comentario.php',
        type: "POST",
        dateType: "html",
        data: {'id':id},
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Registro Eliminado Correctamente");
            cargar_tabla_comentarios();
          }else{
            alertify.error("Ha Ocurrido un Error");
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      })
    }
	
		function cargar_tabla(parametro) {
			var fecha_inicial = $("#fecha_inicial").val();
			var fecha_final = $("#fecha_final").val();
			$('#lista_codigos').dataTable().fnDestroy();
			$('#lista_codigos').DataTable({
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
					"url": "tabla_bitacora.php",
					"dataSrc": "",
					"data": {
          				fecha_final: fecha_final,
          				fecha_inicial: fecha_inicial,
            			parametro: parametro
        			}
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
						"data": "fecha"
					},
					{
						"data": "solicita"
					},
					{
						"data": "imprime"
					},
					{
						"data": "folio"
					},
					{
						"data": "error"
					}
				]
			});
		}
		$('#tipo_formato').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			//minimumResultsForSearch: Infinity
		})
	</script>
	<script type="text/javascript">
      $('.form_datetime').datetimepicker({
          //language:  'fr',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 2,
          forceParse: 0,
          showMeridian: 1
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
      $('.form_time').datetimepicker({
          language:  'fr',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 1,
          minView: 0,
          maxView: 1,
          forceParse: 0
      });
  </script>
</body>

</html>