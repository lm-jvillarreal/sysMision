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
                <h3 class="box-title">Incidencias | Lista</h3>
              </div>
              <div class ="box-body">
                <form method="POST" id = "form_datos">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="fecha_inicio">*Fecha Inicio: </label>
                        <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                          <input class="form-control" size="16" type="text" value="<?php echo $prim_dia?>" id="fecha_inicio" name="fecha_inicio">
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
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="sucursal">*Sucursal:</label>
                        <select name="sucursal" id="sucursal" class="form-control select2">
                          <option value=""></option>
                        </select>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="box-footer text-right">
							  <button class="btn btn-danger" id="btn-generar">Generar</button>
              </div>
            </div>
            <div class="box box-danger">
              <div id="datos_usuarios">
                <div class="box-header">
                  <h3 class="box-title">Gráficos</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" onclick="limpiar()"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- en este div se muestran los widgets -->
                <div class="box-body">
                  <div id="datos">
                  </div>
                  <div class="row">
								    <div class="col-md-12">
									    <div id="grafica" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
								    </div>
							    </div>
                </div>
              </div>
            </div>
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Tabla de Registros</h3>
              </div>
              <div id="sSede">
              <input type="hidden" name="sede" id="sede" class="form-control"readonly>
              </div>
              <div class = "box-body" id="datos_tabla">
                <div class = "tabbable">
                  <ul class="nav nav-tabs">
                    <li class ="active"><a href="#1" data-toggle="tab" id="empleados" onclick="ocultar()">Incidencias de Empleados</a></li>
                    <li><a href="#2" data-toggle="tab" id="promotores" onclick="ocultar1()">Incidencias a Promotores</a></li>
                  </ul>
                  <div class ="tab-content"> 
                    <div class="tab-pane active"id="1">
                      <form method="POST" id="form-datos">
                        <br>
                        <div class="row">
                          <div class="col-md-12" id="tabla">
                            <div class="table-responsive">
                              <table id="lista_datos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Empleado</th>
                                    <th>Suc.</th>
                                    <th>Dpto.</th>
                                    <th>Tipo</th>
                                    <th>Comentario</th>
                                    <th>Fecha</th>
                                    <th>Autorizó</th>
                                    <th>Perfil</th>
                                    <th>Estado</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="tab-pane" id ="2">
                      <form method="POST" id="form_promotores">
                        <br>
                        <div class="row">
                          <div class="col-md-12" id="tablaPromotores">
                            <div class="table-responsive">
                              <table id="lista_datosPromotores" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Empleado</th>
                                    <th>Suc.</th>
                                    <th>Dpto.</th>
                                    <th>Tipo</th>
                                    <th>Comentario</th>
                                    <th>Fecha</th>
                                    <th>Autorizó</th>
                                    <th>Perfil</th>
                                    <th>Estado</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div> 
          </section>
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
<script src="../Chart.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script>
  function ocultar(){
          $('#lista_datosPromotores').hide();
          $('#lista_datos').show();
          var lugar = $("#sede").val();
          //alert(lugar);
          cargar_tabla_datos();
        }
        function ocultar1(){
          $('#lista_datos').hide();
          $('#lista_datosPromotores').show();
          var lugar = $("#sede").val();
          cargar_tabla_Promotores(lugar);
        }
  $("#btn-generar").click(function() {
		  generar();
      mostrar_datos();
     
  })
  
  function generar() {
	  var fecha1 = $('#fecha_inicio').val();
    var fecha2 = $('#fecha_final').val();
    var sucursal = $('#sucursal').val();
    //alert(sucursal);
    var url = "datos_graficaB.php"; // El script a dónde se realizará la petición.
    var dato = 1;
    $.ajax({
      type: "POST",
      dataType: "json",
      url: url,
      data: {
        'fecha1': fecha1,
        'fecha2': fecha2,
        'sucursal': sucursal
      }, // Adjuntar los campos del formulario enviado.
      // async: false,
      success: function(respuesta) {
        mostrar_datos();
        var options = {
          chart: {
            renderTo: 'grafica',
            type: 'column'
          },
          title: {
            text: 'Incidencias'
          },
          subtitle: {
            text: fecha1 + " - " + fecha2
          },
          xAxis: {
            type: 'category'
          },
          yAxis: {
            title: {
              text: 'Incidencias Registradas en el mes'
            }
          },
          legend: {
            enabled: false
          },
          plotOptions: {
            series: {
              borderWidth: 0,
              dataLabels: {
                enabled: true,
                format: '{y}'
              }
            }
          },
          tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:,.2f}</b><br/>'
          },
          series: [{}]
        };
        options.series[0].data = respuesta;
        var chart = new Highcharts.Chart(options);
      }
    });
  }

  $( document ).ready( function () {
    //mostrar_datos();
    generar();
  });
  function mostrar_datos(){
    var fecha1 = $('#fecha_inicio').val();
		var fecha2 = $('#fecha_final').val();
		var sucursal = $('#sucursal').val();
    var url = "datos_widgets.php";
    $.ajax({
      type: "POST",
			dataType: "html",
      url: url,
      data: {
					'fecha1': fecha1,
					'fecha2': fecha2,
					'sucursal': sucursal
				},
      success : function(respuesta){
        $('#datos_tabla').show();
        $('#datos').html(respuesta);
      }
    });
  }
  function abrir(dato) {
      $.ajax({
        data: {
          'dato': dato
        }, //datos que se envian a traves de ajax
        url: 'datos.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) {
          var array = eval(response);

          $('#datos_usuarios').show();
          $('#nombre').html(array[0]);
          $('#boton_p').html(array[1]);
        }
      });
      cargar_tabla_datos(dato);
    }
    function datos(dato) {
      $('#sede').val(dato);

      // $.ajax({
      //   data: {
      //     'dato': dato
      //   }, //datos que se envian a traves de ajax
      //   url: 'datos.php', //archivo que recibe la peticion
      //   type: 'POST', //método de envio
      //   dateType: 'html',
      //   success: function(response) {
      //     var array = eval(response);

      //     $('#datos_usuarios').show();
      //     $('#nombre').html(array[0]);
      //     $('#boton_p').html(array[1]);
      //   }
      // });
      cargar_tabla_datos(dato);
    }

  function cargar_tabla_datos(){
    var lugar = $('#sede').val()
    // alert(lugar);
    var dateI =  $('#fecha_inicio').val();
    var dateF =  $('#fecha_final').val();
   // alert(dateF);
    $('#lista_datos').dataTable().fnDestroy();
    $('#lista_datos').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
      "paging":   false,
      "dom": 'Bfrtip',
      "order": ["0","ASC"],
	        buttons: [{
	            extend: 'pageLength',
	            text: 'Registros',
	            className: 'btn btn-default'
	          },
	          {
	            extend: 'excel',
	            text: 'Exportar a Excel',
	            className: 'btn btn-default',
	            title: 'Control Equipos',
	            exportOptions: {
	              columns: ':visible'
	            }
	          },
	          {
	            extend: 'pdf',
	            text: 'Exportar a PDF',
	            className: 'btn btn-default',
	            title: 'Control Equipos',
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
        "url":"tabla_widget.php?lugar="+lugar+"",
        "dataSrc": "",
        //http://200.1.1.197/SMPruebas/mRegistro_incidencias/
        "data":{lugar:lugar,
                dateI:dateI,
                dateF:dateF},

      },
      "columns": [
        { "data": "id" },
        { "data": "nombre" },
        { "data": "sucursal" },
        { "data": "departamento" },
        { "data": "incidencia" },
        { "data": "comentario" },
        { "data": "fecha" },
        { "data": "autoriza"},
        { "data": "perfil"},
        { "data": "activo"},
      ]
    });
  }
  function cargar_tabla_Promotores(){
    var tienda = $('#sede').val()
    //$('#sede').html(lugar);
    //var lugar=  lugar;
    //alert(tienda);
    
    var dateI =  $('#fecha_inicio').val();
    var dateF =  $('#fecha_final').val();
   // alert(dateF);
    $('#lista_datosPromotores').dataTable().fnDestroy();
    $('#lista_datosPromotores').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
      "paging":   false,
      "dom": 'Bfrtip',
      "order": ["0","ASC"],
	        buttons: [{
	            extend: 'pageLength',
	            text: 'Registros',
	            className: 'btn btn-default'
	          },
	          {
	            extend: 'excel',
	            text: 'Exportar a Excel',
	            className: 'btn btn-default',
	            title: 'Control Equipos',
	            exportOptions: {
	              columns: ':visible'
	            }
	          },
	          {
	            extend: 'pdf',
	            text: 'Exportar a PDF',
	            className: 'btn btn-default',
	            title: 'Control Equipos',
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
        "url":"tabla_widgetPromotores.php?lugar="+tienda+"",
        "dataSrc": "",
        //http://200.1.1.197/SMPruebas/mRegistro_incidencias/
        "data":{tienda:tienda,
                dateI:dateI,
                dateF:dateF},

      },
      "columns": [
        { "data": "id" },
        { "data": "nombre" },
        { "data": "sucursal" },
        { "data": "departamento" },
        { "data": "incidencia" },
        { "data": "comentario" },
        { "data": "fecha" },
        { "data": "autoriza"},
        { "data": "perfil"},
        { "data": "activo"},
      ]
    });
  }
  $(function () {
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
     url: "combo_sucursal.php",
     type: "post",
     dataType: 'json',
     delay: 250,
     data: function (params) {
      return {
        searchTerm: params.term // search term
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
