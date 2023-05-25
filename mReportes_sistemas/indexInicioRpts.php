<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
date_default_timezone_set('America/Monterrey');

function _data_last_month_day() { 
    $month_SIS007 = date('m');
    $year_SISI007 = date('Y');
    $day_SISI007 = date("d", mktime(0,0,0, $month_SIS007+1, 0, $year_SISI007));

    return date('Y-m-d', mktime(0,0,0, $month_SIS007, $day_SISI007, $year_SISI007));
};

/** Actual month first day **/
function _data_first_month_day() {
    $month_SIS007 = date('m');
    $year_SISI007 = date('Y');
    return date('Y-m-d', mktime(0,0,0, $month_SIS007, 1, $year_SISI007));
}
$fecha1_SISI007 = _data_first_month_day();
$fecha2_SISI007 =  _data_last_month_day();  

$qry_SIS004 = "SELECT * FROM comentarios_reportes";
$exQry_SIS004 = mysqli_query($conexion, $qry_SIS004);
$row_SIS004 = mysqli_fetch_row($exQry_SIS004);

$qry_SIS005 = "SELECT * FROM comentarios_reportes";
$exQry_SIS005 = mysqli_query($conexion, $qry_SIS005);
$row_SIS005 = mysqli_fetch_row($exQry_SIS005);

$fecha = date('Y-m-d');
$fecha_anterior = date("Y-m-d", strtotime($fecha . "- 1 year"));
$hora = date('H:i:s');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include '../head.php'; ?>
  <script src="funciones.js"></script>
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
                        <h3 class="box-title">Reportes Sistemas</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="tablaReportesConsolidados" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width='10%'>Clave</th>
                                            <th>Descripción</th>
                                            <th width='5%'></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>SIS001</td>
                                            <td>Reporte Cambio de precios con # de folio.</td>
                                            <th><button type="button" id="SIS001" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mSIS001"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
                                        </tr>
                                        <tr>
                                            <td>SIS002</td>
                                            <td>Reporte Cambio de precios por departamento.</td>
                                            <th><button type="button" id="SIS002" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mSIS002"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
                                        </tr>
                                        <tr>
                                            <td>SIS003</td>
                                            <td>Reporte Cambio de precios por departamento V2.</td>
                                            <th><button type="button" id="SIS003" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mSIS003"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
                                        </tr>
                                        <tr>
                                            <td>SIS004</td>
                                            <td>Reporte IMMEX.</td>
                                            <th><button type="button" id="SIS004" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mSIS004"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
                                        </tr>
                                        <tr>
                                            <td>SIS005</td>
                                            <td>Reporte DATALOGIC.</td>
                                            <th><button type="button" id="SIS005" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mSIS005"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
                                        </tr>
                                        <tr>
                                            <td>SIS006</td>
                                            <td>Consulta recargas.</td>
                                            <th><button type="button" id="SIS006" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mSIS006"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
                                        </tr>
                                        <tr>
                                            <td>SIS007</td>
                                            <td>Grafica Regarcas.</td>
                                            <th><button type="button" id="SIS007" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mSIS007"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include './modals/modalsReportes/modalSIS001.php' ?>
        <?php include './modals/modalsReportes/modalSIS002.php' ?>
        <?php include './modals/modalsReportes/modalSIS003.php' ?>
        <?php include './modals/modalsReportes/modalSIS004.php' ?>
        <?php include './modals/modalsReportes/modalSIS005.php' ?>
        <?php include './modals/modalsReportes/modalSIS006.php' ?>
        <?php include './modals/modalsReportes/modalSIS007.php' ?>
        <?php include 'modal.php' ?>
        <?php include '../footer2.php'; ?>
    </div>
    <!-- /.content-wrapper -->
    <!-- Control Sidebar -->
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
    <!-- ./wrapper -->
    <?php include '../footer.php'; ?>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    
    <!-- Page script -->
<script>
    //<!--LEER MODALS-->
        $(document).ready(function() {
			$("modal-default").modal();
		});
		$(document).ready(function() {
			$("modal-mSIS001").modal();
		});
        $(document).ready(function() {
			$("modal-mSIS002").modal();
		});
        $(document).ready(function() {
			$("modal-mSIS003").modal();
		});       
        $(document).ready(function() {
			$("modal-mSIS004").modal();
		});
        $(document).ready(function() {
			$("modal-mSIS005").modal();
		});
        $(document).ready(function() {
			$("modal-mSIS006").modal();
		});
        $(document).ready(function() {
			$("modal-mSIS007").modal();
		});
    // FUNCIONES MODAL 1
		$(document).ready(function() {
		$("#sucursal_SIS001").select2({
			dropdownParent: $("#modal-mSIS001"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
        $(document).ready(function() {
		$("#tipo_SIS001").select2({
			dropdownParent: $("#modal-mSIS001"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
    // FUNCIONES MODAL 2
		$(document).ready(function() {
		$("#sucursal_SIS002").select2({
			dropdownParent: $("#modal-mSIS002"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
        $('#departamento_SIS002').select2({
		width: '100%',
		placeholder: 'Seleccione una opción',
		language: 'es',
		minimumResultsForSearch: 0,
		dropdownParent: $('#modal-mSIS002'),
		ajax: {
			url: 'consulta_departamentos.php',
			type: 'post',
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
		});
        
		$('#proveedor_SIS002').select2({
			width: '100%',
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: 0,
			dropdownParent: $("#modal-mSIS002"),
			ajax: {
				url: "consulta_proveedores.php",
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
        function subir_excel_SIS002(id, input) {
        var parametros_SIS002 = new FormData($("#SIS002")[0]);
        $.ajax({
            data: parametros_SIS002, //datos que se envian a traves de ajax
            url: 'importar.php', //archivo que recibe la peticion
            type: 'post', //método de envio
            contentType: false,
            processData: false,
            success: function(response) {
                var array = eval(response);
                $('#array_cambio_SIS002').val(array);
                var jObject = array.toString();
                alertify.success("Codigos cargados");
            }
        });
        }
    // FUNCIONES MODAL 3
        $(document).ready(function() {
		$("#sucursal_SIS003").select2({
			dropdownParent: $("#modal-mSIS003"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
        $('#departamento_SIS003').select2({
		width: '100%',
		placeholder: 'Seleccione una opción',
		language: 'es',
		minimumResultsForSearch: 0,
		dropdownParent: $('#modal-mSIS003'),
		ajax: {
			url: 'consulta_departamentos.php',
			type: 'post',
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
		});
        $("#btnDatos_SIS003").click(function() {
        cargar_tabla_SIS003();
        });
        $(document).ready(function(){
        cargar_tabla_SIS003();
        })
        function cargar_tabla_SIS003() {
        var sucursal_SIS003=$("#sucursal_SIS003").val();
        var departamento_SIS003=$("#departamento_SIS003").val();
        $('#lista_articulos_SIS003').dataTable().fnDestroy();
        $('#lista_articulos_SIS003').DataTable({
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
            "url": "tabla_articulos.php",
            "dataSrc": "",
            "data": {
                sucursal: sucursal_SIS003,
                departamento: departamento_SIS003
            }
            },
            "columns": [{
                "data": "artc_articulo"
            },
            {
                "data": "artc_descripcion"
            },
            {
                "data": "fecha_penultima"
            },
            {
                "data": "fecha_ultima"
            },
            {
                "data": "costo_penultimo"
            },
            {
                "data": "costo_ultimo"
            },
            {
                "data": "diferencia"
            },
            {
                "data": "cantidad_ultima"
            },
            {
                "data": "unidad_medida"
            },
            {
                "data": "iva"
            },
            {
                "data": "ieps"
            },
            {
                "data": "ppublico"
            },
            ]
        });
        }
        // document.on('buttons-action', function(e, buttonApi, dataTable, node, config) {
        // if (buttonApi.text() === 'Exportar a PDF') {           
        //     config.orientation = 'landscape';
        //     config.pageSize = 'A4';
        //     config.pageMargins = [ 30, 30, 30, 30 ];
        //     config.styles.table.fontSize = 8;
        //     config.styles.table.cellPadding = 2;
        // }
        // });
    // FUNCIONES MODAL 4
        function insertar_comentarios_immex_SIS004(comentario) {
			var tipo_SIS004 = 2;
			$.ajax({
				data: {
					'comentario': comentario,
					'tipo': tipo_SIS004
				}, //datos que se envian a traves de ajax
				url: 'comentarios.php', //archivo que recibe la peticion
				type: 'POST', //método de envio
				dateType: 'html',
				success: function(response) {
				}
			});
		}

		function guardar_SIS004() {
			//alert(comentario);
			var tipo_SIS004 = 2;
			$.ajax({
				data: $('#frmDatosRef_SIS004').serialize(), //datos que se envian a traves de ajax
				url: 'totales_renglon.php', //archivo que recibe la peticion
				type: 'POST', //método de envio
				dateType: 'html',
				success: function(response) {
				alert("Información guardada");
				location.reload();
				}
			});
		}
		function cargar_datos_SIS004(){
		var fecha_inicial_SIS004 = $('#fecha_inicial_SIS004').val();
		var fecha_final_SIS004 = $('#fecha_final_SIS004').val();
		$('#datos').dataTable().fnDestroy();
		$('#datos').DataTable( {
			'language': {"url": "../plugins/DataTables/Spanish.json"},
			"paging":   false,
			"ajax": {
				"type": "POST",
				"url": "tabla_immex.php",
				"dataSrc": "",
				"data": {
					"fecha_inicial": fecha_inicial_SIS004,
					"fecha_final": fecha_final_SIS004
				},
			},
			"columns": [
				{ "data": "codigo" },
				{ "data": "descripcion" },
				{ "data": "do" },
				{ "data": "arb" },
				{ "data": "vil" },
				{ "data": "all"},
				{ "data": "total"},
				{ "data": "cantidad"}
			]
		});
		}
    // FUNCIONES MODAL 5
        function insertar_comentarios_diestel_SIS005(comentario) {
        var tipo_SIS005 = 1;
        $.ajax({
        data: {
            'comentario': comentario,
            'tipo': tipo_SIS005
        }, //datos que se envian a traves de ajax
        url: 'comentarios.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) {}
        });
        }
        function guardar_SIS005() {
        var tipo_SIS005 = 2;
        $.ajax({
            data: $('#frmDatosRef_SIS005').serialize(), //datos que se envian a traves de ajax
            url: 'totales_renglon.php', //archivo que recibe la peticion
            type: 'POST', //método de envio
            dateType: 'html',
            success: function(response) {
            // alert("Información guardada");
            location.reload();
            }
        });
        }
        function cargar_datos_SIS005() {
        var fecha_inicial_SIS005 = $("#fecha_inicial_SIS005").val();
        var fecha_final_SIS005 = $("#fecha_final_SIS005").val();
        $('#datos_SIS005').dataTable().fnDestroy();
        $('#datos_SIS005').DataTable({
            'language': {
            "url": "../plugins/DataTables/Spanish.json"
            },
            "paging": false,
            "ajax": {
            "type": "POST",
            "url": "tabla_diestel.php",
            "dataSrc": "",
            "data": {
                fecha_inicial: fecha_inicial_SIS005,
                fecha_final: fecha_final_SIS005
            }
            },
            "columns": [{
                "data": "codigo"
            },
            {
                "data": "descripcion"
            },
            {
                "data": "do"
            },
            {
                "data": "arb"
            },
            {
                "data": "vil"
            },
            {
                "data": "all"
            },
            {
                "data": "pet"
            },
            {
                "data": "total"
            },
            {
                "data": "cantidad"
            },
            {
                "data": "dif"
            }
            ]
        });
        };
    // FUNCIONES MODAL 6
        function cargar_datos_SIS006() {
        var fecha_inicial_SIS006 = $('#fecha_inicial_SIS006').val();
        var fecha_final_SISOO6 = $('#fecha_final_SISOO6').val();
        $('#datos_SIS006').dataTable().fnDestroy();
        $('#datos_SIS006').DataTable({
            'language': {
            "url": "../plugins/DataTables/Sp_SIS006anish.json"
            },
            "paging": false,
            "ajax": {
            "type": "POST",
            "url": "tabla_consulta.php",
            "dataSrc": "",
            "data": {
                "fecha_inicial": fecha_inicial_SIS006,
                "fecha_final": fecha_final_SISOO6
            },
            },
            "columns": [{
                "data": "folio"
            },
            {
                "data": "referencia"
            },
            {
                "data": "tipo"
            },
            {
                "data": "Rango"
            },
            {
                "data": "detalle"
            }
            ]
        });
        }
        $(document).ready(function(e) {
		$('#modal-default').on('show.bs.modal', function(e) {
			var id_referencia = $(e.relatedTarget).data().id;
			var url = "tabla_modal.php"; // El script a dónde se realizará la petición.
			$.ajax({
			type: "POST",
			url: url,
			data: {
				id_referencia: id_referencia
			}, // Adjuntar los campos del formulario enviado.
			success: function(respuesta) {
				$('#tabla').html(respuesta);
			}
			});
		});
		})
		function estilo_tablas() {
		$('#lista_modulos').DataTable({
			'paging': true,
			'lengthChange': true,
			'searching': true,
			'ordering': true,
			'info': true,
			'autoWidth': false,
			'language': {
			"url": "../plugins/DataTables/Spanish.json"
			}
		})
		}
		$(function() {
		estilo_tablas();
		})
    // FUNCIONES MODAL 7
        function generar_SISI007(){
        swal("Se esta generando la grafica, espere...", {
        icon: "info",
        closeOnClickOutside: false,
        buttons: false
        });
        var fecha1_SISI007 = $('#fecha1_SISI007').val();
        var fecha2_SISI007 = $('#fecha2_SISI007').val();

        $.ajax({
        type: "POST",
        dataType: "json",
        url: 'datos.php',
        data: {'fecha1':fecha1_SISI007,'fecha2':fecha2_SISI007}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
            swal("La grafica se ha generado correctamente", {
            icon: "success",
            buttons: false
            });
            var options = {
            chart: {
                renderTo: 'grafica',
                type: 'column'
            },
            title: {
                text: 'RECARGAS TOTALES'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Cantidad de Recargas'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                    enabled: true
                    }
                },
                column: { colorByPoint: true }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
            },
            series: [{}]
            };
            options.series[0].data= respuesta;
            var chart = new Highcharts.Chart(options);
        }
        });
        }
    // FUNCIONES VALIDAR CAMPOS VACIONS EN MODALS		
        function generarReporte(boton) {
			var idFormulario = $(boton).closest('form').attr('id');
			var formularioValido = true;
			//$( idFormulario ).each(function() {
			$('#' + idFormulario + '  input:not(.no-validar), #' + idFormulario + ' select:not(.no-validar)').each(function() {
				if ($(this).val() == '') {
					formularioValido = false;
					return false;
				}
			});
			// Mostrar mensaje de validación
			if (formularioValido) {
				// Serializar datos del formulario
				var datosFormulario = $('#' + idFormulario + ' input, #' + idFormulario + ' select').serialize();
				console.log(datosFormulario);
				// Hacer la petición AJAX
				$.ajax({
					url: 'reportes2/rpt_' + idFormulario + '.php',
					method: 'POST',
					data: datosFormulario,
					xhrFields: {
						responseType: 'blob'
					},
					success: function(data, textStatus, jqXHR) {
						// Obtener el nombre del archivo del encabezado Content-Disposition
						var nombreArchivo = jqXHR.getResponseHeader('Content-Disposition').match(/filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/)[1].replace(/['"]/g, '');
						// Crea un objeto URL para el archivo descargado
						var url = URL.createObjectURL(data);
						// Crea un enlace para descargar el archivo y haz clic en él para iniciar la descarga
						var a = document.createElement('a');
						a.href = url;
						a.download = nombreArchivo;
						a.click();
						// Libera el objeto URL
						URL.revokeObjectURL(url);
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert('Error al descargar el reporte:', errorThrown);
					}
				});
			} else {
				alertify.error("Existen campos vacíos");
			}
		}

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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>