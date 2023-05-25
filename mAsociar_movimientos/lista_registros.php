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
                <h3 class="box-title">Bitácora de Errores en Movimientos</h3>
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
              </div>
              <div class="box-footer text-right">
						    <button class="btn btn-danger" id="btn-generar">Generar</button>
              </div>
            </div>
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Control de Incidencias | Conteo Mensual</h3>
              </div>
              <div class="box-body">
                <?php
                  $cadena_cantidad = "SELECT DISTINCT(ctb_usuario), COUNT(id), nombre_usuario FROM me_control_errores where  month(fecha)=$mes AND year(fecha)=$ano GROUP BY nombre_usuario";
                  $consulta_cantidad = mysqli_query($conexion, $cadena_cantidad);
                  while ($row_cantidad = mysqli_fetch_array($consulta_cantidad)) {
                ?>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-thumbs-o-down"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text"><?php echo $row_cantidad[2] ?></span>
                      <span class="info-box-number"><?php echo $row_cantidad[1] ?></span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 0%" id="barra_progreso"></div>
                      </div>
                      <span class="progress-description">
                        Total de Incidencias capturadas
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Desglose</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table id="lista_registros" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                          <tr>
                            <th width="5%">ID</th>
                            <th width="">Movimiento</th>
                            <th width="">Sucursal</th>
                            <th width="">Fecha</th>
                            <th width="">Procesa</th>
                            <th width="">Error</th>
                            <th width="">Comentario</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th width="5%">ID</th>
                            <th width="">Movimiento</th>
                            <th width="">Sucursal</th>
                            <th width="">Fecha</th>
                            <th width="">Procesa</th>
                            <th width="">Error</th>
                            <th width="">Comentario</th>
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
        $( document ).ready( function () {
          cargar_tabla();
          mostrar_datos();
        });
        $("#btn-generar").click(function() {
          cargar_tabla(1);
          mostrar_datos();
        });
        function mostrar_datos(){
          var fecha1 = $('#fecha_inicio').val();
		      var fecha2 = $('#fecha_final').val();
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
        function cargar_tabla(parametro){
          var fecha_inicial = $("#fecha_inicial").val();
			    var fecha_final = $("#fecha_final").val();
          $('#lista_registros').dataTable().fnDestroy();
          $('#lista_registros').DataTable( {
            'language': {"url": "../plugins/DataTables/Spanish.json"},
            "paging":   false,
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
              "url": "tabla_registros.php",
              "dataSrc": "",
              "data": {
          		  fecha_final: fecha_final,
          		  fecha_inicial: fecha_inicial,
            	  parametro: parametro
        		  }
            },
            "columns": [
              { "data": "id" },
              { "data": "movimiento" },
              { "data": "sucursal" },
              { "data": "fecha" },
              { "data": "procesa" },
              { "data": "error"},
              { "data": "comentario"}
            ]
          });
        }
      </script>
    </body>
  </html>
