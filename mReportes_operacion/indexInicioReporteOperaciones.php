<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
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
                        <h3 class="box-title">Reportes</h3>
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
                                            <td>OPE001</td>
                                            <td>Reporte Existencias.</td>
                                            <th><button type="button" id="OPE001" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mOPE001"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
                                        </tr>
                                        <tr>
                                            <td>OPE002</td>
                                            <td>Reporte Mermas.</td>
                                            <th><button type="button" id="OPE002" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mOPE002"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
                                        </tr>
                                        <tr>
                                            <td>OPE003</td>
                                            <td>Reporte Excedentes.</td>
                                            <th><button type="button" id="OPE003" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mOPE003"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
                                        </tr>
                                        <tr>
                                            <td>OPE004</td>
                                            <td>Reporte Excedentes por sucursal.</td>
                                            <th><button type="button" id="OPE004" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mOPE004"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
                                        </tr>
                                        <tr>
                                            <td>OPE005</td>
                                            <td>Reporte Recargas por cajero.</td>
                                            <th><button type="button" id="OPE005" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mOPE005"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
                                        </tr>
                                        <tr>
                                            <td>OPE006</td>
                                            <td>Reporte Días de inventario por sucursal.</td>
                                            <th><button type="button" id="OPE006" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mOPE006"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
                                        </tr>
                                        <tr>
                                            <td>OPE007</td>
                                            <td>Reportes Días de inventario.</td>
                                            <th><button type="button" id="OPE007" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mOPE007"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
                                        </tr>
                                        <tr>
                                            <td>OPE008</td>
                                            <td>Reporte Coincidencias por codigo.</td>
                                            <th><button type="button" id="OPE008" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mOPE008"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
                                        </tr>
                                        <tr>
                                            <td>OPE009</td>
                                            <td>Reporte Redondeos por Cajero.</td>
                                            <th><button type="button" id="OPE009" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mOPE009"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
                                        </tr>
                                        <tr>
                                            <td>OPE010</td>
                                            <td>Reporte Promedio de ventas.</td>
                                            <th><button type="button" id="OPE010" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mOPE010"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
                                        </tr>
                                        <tr>
                                            <td>OPE011</td>
                                            <td>Parámetros Ventas por departamento.</td>
                                            <th><button type="button" id="OPE011" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mOPE011"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
                                        </tr>
                                        <tr>
                                            <td>OPE012</td>
                                            <td>Reporte Faltantes y sobrantes.</td>
                                            <th><button type="button" id="OPE012" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mOPE012"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
                                        </tr>
                                        <tr>
                                            <td>OPE013</td>
                                            <td>Reporte Cancelaciones por cajero.</td>
                                            <th><button type="button" id="OPE013" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-mOPE013"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include './modals/modalsReportes/modalOPE001.php' ?>
        <?php include './modals/modalsReportes/modalOPE002.php' ?>
        <?php include './modals/modalsReportes/modalOPE003.php' ?>
        <?php include './modals/modalsReportes/modalOPE004.php' ?>
        <?php include './modals/modalsReportes/modalOPE005.php' ?>
        <?php include './modals/modalsReportes/modalOPE006.php' ?>
        <?php include './modals/modalsReportes/modalOPE007.php' ?>
        <?php include './modals/modalsReportes/modalOPE008.php' ?>
        <?php include './modals/modalsReportes/modalOPE009.php' ?>
        <?php include './modals/modalsReportes/modalOPE010.php' ?>
        <?php include './modals/modalsReportes/modalOPE011.php' ?>
        <?php include './modals/modalsReportes/modalOPE012.php' ?>
        <?php include './modals/modalsReportes/modalOPE013.php' ?>
        <?php include '../footer2.php'; ?>
    </div>

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
<!-- Page script -->
<script>
    //<!--LEER MODALS-->
		$(document).ready(function() {
			$("modal-mOPE001").modal();
		});
        $(document).ready(function() {
			$("modal-mOPE002").modal();
		});
        $(document).ready(function() {
			$("modal-mOPE003").modal();
		});
        $(document).ready(function() {
			$("modal-mOPE004").modal();
		});
        $(document).ready(function() {
			$("modal-mOPE005").modal();
		});
        $(document).ready(function() {
			$("modal-mOPE006").modal();
		});
        $(document).ready(function() {
			$("modal-mOPE007").modal();
		});
        $(document).ready(function() {
			$("modal-mOPE008").modal();
		});
        $(document).ready(function() {
			$("modal-mOPE009").modal();
		});
        $(document).ready(function() {
			$("modal-mOPE0010").modal();
		});
        $(document).ready(function() {
			$("modal-mOPE0011").modal();
		});
        $(document).ready(function() {
			$("modal-mOPE0012").modal();
		});
        $(document).ready(function() {
			$("modal-mOPE0013").modal();
		});
    // FUNCIONES MODAL 1
		$(document).ready(function() {
		$("#sucursal_OPE001").select2({
			dropdownParent: $("#modal-mOPE001"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
    // FUNCIONES MODAL 2
        $(document).ready(function() {
		$("#sucursal_OPE002").select2({
			dropdownParent: $("#modal-mOPE002"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
    // FUNCIONES MODAL 3
        $('#familia_OPE003').select2({
            width: '100%',
            placeholder: 'Seleccione una opcion',
            lenguage: 'es',
            minimumResultsForSearch: 0,
            dropdownParent: $("#modal-mOPE003"),
            ajax: {
                url: "consulta_familias.php",
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
    // FUNCIONES MODAL 4
        $(document).ready(function() {
		$("#sucursal_OPE004").select2({
			dropdownParent: $("#modal-mOPE004"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
        $('#familia_OPE004').select2({
			width: '100%',
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: 0,
			dropdownParent: $("#modal-mOPE004"),
			ajax: {
				url: "consulta_familias.php",
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
    // FUNCIONES MODAL 5
        $(document).ready(function() {
		$("#sucursal_OPE005").select2({
			dropdownParent: $("#modal-mOPE005"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
    // FUNCIONES MODAL 6
        $(document).ready(function() {
		$("#sucursal_OPE006").select2({
			dropdownParent: $("#modal-mOPE006"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
        $('#proveedor_OPE006').select2({
			width: '100%',
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: 0,
			dropdownParent: $("#modal-mOPE006"),
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
        function subir_excel_OPE006(id, input) {
        var parametros_OPE006 = new FormData($("#" + id)[0]);
        $.ajax({
            data: parametros_OPE006, //datos que se envian a traves de ajax
            url: 'importar.php', //archivo que recibe la peticion
            type: 'post', //método de envio
            contentType: false,
            processData: false,
            success: function(response) {
                var array = eval(response);
                $('#' + input).val(array);
                var jObject = array.toString();
                alertify.success("Codigos cargados");
            }
        });
        }
    //FUNCIONES MODAL 7
        $('#proveedor_OPE007').select2({
            width: '100%',
            placeholder: 'Seleccione una opcion',
            lenguage: 'es',
            minimumResultsForSearch: 0,
            dropdownParent: $("#modal-mOPE007"),
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
        function subir_excel_OPE007(id, input) {
        var parametros_OPE007 = new FormData($("#" + id)[0]);
        $.ajax({
            data: parametros_OPE007, //datos que se envian a traves de ajax
            url: 'importar.php', //archivo que recibe la peticion
            type: 'post', //método de envio
            contentType: false,
            processData: false,
            success: function(response) {
                var array = eval(response);
                $('#' + input).val(array);
                var jObject = array.toString();
                alertify.success("Codigos cargados");
            }

        });
        }
    // FUNCIONES MODAL 8
		$(document).ready(function() {
		$("#sucursal_OPE008").select2({
			dropdownParent: $("#modal-mOPE008"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});

    // FUNCIONES MODAL 9
		$(document).ready(function() {
		$("#sucursal_OPE009").select2({
			dropdownParent: $("#modal-mOPE009"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
        $('#concepto_OPE009').select2({
			width: '100%',
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: 0,
			dropdownParent: $("#modal-mOPE009"),
			ajax: {
                url: "consulta_conceptos_redondeo.php",
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
    // FUNCIONES MODAL 11
        $(document).ready(function(e) {
        cargar_tabla_OPE011();
        });   
        function cargar_tabla_OPE011() {
        var fi_now = $("#fi_now").val();
        var ff_now = $("#ff_now").val();
        var fi_ago = $("#fi_ago").val();
        var ff_ago = $("#ff_ago").val();

        $('#lista_ventas_OPE011').dataTable().fnDestroy();
        $('#lista_ventas_OPE011').DataTable({
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
            },
            ],
            "ajax": {
            "type": "POST",
            "url": "tabla_ventasDepto.php",
            "dataSrc": "",
            "data": {
                fi_now: fi_now,
                ff_now: ff_now,
                fi_ago: fi_ago,
                ff_ago: ff_ago
            }
            },
            "columns": [{
                "data": "do"
            },
            {
                "data": "arb"
            },
            {
                "data": "vill"
            },
            {
                "data": "all"
            },
            {
                "data": "pet"
            },
            {
                "data": "mm"
            },
            {
                "data": "total"
            }
            ]
        });
        }
        $("#btn-generar_OPE011").click(function() {
        cargar_tabla_OPE011();
        })
    // FUNCIONES MODAL 12 
        $(document).ready(function() {
		$("#sucursal_OPE012").select2({
			dropdownParent: $("#modal-mOPE012"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
    // FUNCIONES MODAL 13
        $(document).ready(function() {
		$("#sucursal_OPE013").select2({
			dropdownParent: $("#modal-mOPE013"),
			width: '100%',
			placeholder: 'Seleccione una opcion',
		});
		});
        function cargar_cajeros_OPE013() {
        var sucursal_OPE013 = $('#sucursal_OPE013').val();
        $('#cajeros_OPE013').select2({
            width: '100%',
            placeholder: 'Seleccione una opcion',
            lenguage: 'es',
			minimumResultsForSearch: 0,
            dropdownParent: $("#modal-mOPE013"),
            ajax: {
            url: "consulta_cajeros.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                searchTerm: params.term,
                sucursal: sucursal_OPE013 // search term
                };
            },
            processResults: function(response) {
                return {
                results: response
                };
            },
            cache: true
            }
        })
        }
        $("#btnConsulta_OPE013").click(function() {
        cargar_tabla_OPE013();
        });

        function cargar_tabla_OPE013() {
        var fecha_inicio_OPE013 = $("#fecha_inicial_OPE013").val();
        var fecha_fin_OPE013 = $("#fecha_final_OPE013").val();
        var sucursal_OPE013 = $("#sucursal_OPE013").val();
        var cajero_OPE013 = $("#cajeros_OPE013").val();
        $('#lista_cancelaciones').dataTable().fnDestroy();
        $('#lista_cancelaciones').DataTable({
            'language': {
            "url": "../plugins/DataTables/Spanish.json"
            },
            "paging": false,
            "order": [
            [0, "asc"]
            ],
            "searching": false,
            "ajax": {
            "type": "POST",
            "url": "tabla_cancelaciones.php",
            "dataSrc": "",
            "data": {
                fecha_inicial: fecha_inicio_OPE013,
                fecha_final: fecha_fin_OPE013,
                sucursal: sucursal_OPE013,
                cajero: cajero_OPE013
            }
            },
            "columns": [{
                "data": "ticn"
            },
            {
                "data": "ticn_folio"
            },
            {
                "data": "ticn_fecha"
            },
            {
                "data": "ticn_venta"
            },
            {
                "data": "cajero"
            },
            {
                "data": "ticn_motivo"
            },
            {
                "data": "autoriza"
            }
            ]
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