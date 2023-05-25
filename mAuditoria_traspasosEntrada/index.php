<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha = date("Y-m-d");
$fecha_final = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')));
$hora = date("h:i:s");

$month = date('m');
$year = date('Y');
$nuevafecha = date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
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
        <form method="POST" id="form_datoss">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Auditoría de Traspasos de entradas | Filtros</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="fecha_inicio">*Fecha de inicio:</label>
                    <div class="input-group date form_date" data-date="<?php echo $fecha_final ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $fecha_final ?>" readonly id="fecha_inicial" name="fecha_inicial">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="fecha_fin">*Fecha final:</label>
                    <div class="input-group date form_date" data-date="<?php echo $fecha_final ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $fecha_final ?>" readonly id="fecha_final" name="fecha_final">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="sucursal">*Sucursal:</label>
                    <select name="sucursal" id="sucursal" class="form-control select">
                      <option value=""></option>
                      <option value="1">Díaz Ordaz</option>
                      <option value="2">Arboledas</option>
                      <option value="3">Villegas</option>
                      <option value="4">Allende</option>
                      <option value="5">La Petaca</option>
                      <option value="6">Montemorelos</option>
                      <option value="99">CEDIS</option>
                      <option value="203">CEDIS ROPA</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
        </form>
        <div class="box-footer text-right">
          <button class="btn btn-danger" id="btn-mostrar">Filtrar Resultados</button>
        </div>
    </div>
    <div class="box box-danger">
      <div class="box-header">
        <h3 class="box-title">Auditoría de Traspasos de entradas | Porcentaje de efectividad</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-green">
              <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Traspasos Recibidos</span>
                <span class="info-box-number">
                  <div id="recibidos"></div>
                </span>

                <div class="progress">
                  <div class="progress-bar" style="width: 0%" id="barra_progreso"></div>
                </div>
                <span class="progress-description">
                  <div id="porcentaje"></div>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-red">
              <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Traspasos Pendientes</span>
                <span class="info-box-number">
                  <div id="pendientes"></div>
                </span>

                <div class="progress">
                  <div class="progress-bar" style="width: 100%" id="barra_negativa"></div>
                </div>
                <span class="progress-description">
                  <div id="porcentaje_negativo"></div>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-yellow">
              <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Promedio Calculado</span>
                <span class="info-box-number">
                  <div id="promedio"></div>
                </span>

                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                  <div id="porcentaje_negativo"></div>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <input type="hidden" id="txt_recibido" name="txt_recibido">
          <input type="hidden" id="p_calificacion" name="p_calificacion">
          <input type="hidden" id="txt_pendientes" name="txt_pendientes">
        </div>
      </div>
      <div class="box-footer text-right">
        <button class="btn btn-danger" id="btn-calificar">Guardar Calificación</button>
      </div>
    </div>

    <div class="box box-danger">
      <div class="box-header">
        <h3 class="box-title">Auditoría de Traspasos de entradas | Lista</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id='lista_traspasos' class='table table-striped table-bordered' cellspacing='0' width='100%'>
                <thead>
                  <tr>
                    <th width="10%">Id. Trans</th>
                    <th>Sucursal Envía</th>
                    <th width="15%">Folio Salida</th>
                    <th>Sucursal Recibe</th>
                    <th width="15%">Folio Entrada</th>
                    <th>Fecha Captura</th>
                    <th width="10%">Detalles</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Id.Trans</th>
                    <th>Folio Salida</th>
                    <th>Folio Entrada</th>
                    <th>Sucursal Recibe</th>
                    <th>Sucursal Envía</th>
                    <th>Fecha Captura</th>
                    <th>Detalles</th>
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
  <?php include 'modal.php'; ?>
  <?php include 'modal_detalle.php'; ?>
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
    $('.select').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
    })
    cargar_tabla();

    function cargar_tabla() {
      var fecha_inicio = $("input[name='fecha_inicial']").val();
      var fecha_fin = $("input[name='fecha_final']").val();
      var sucursal = $("select[name='sucursal']").val();
      $('#lista_traspasos').dataTable().fnDestroy();
      $('#lista_traspasos').DataTable({
        "bPaginate": false,
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
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
					},
          {
            text: 'Ver detalle',
            action: function() {
              ver_detalle();
            },
            counter: 1
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla.php",
          "dataSrc": "",
          "data": {
            fecha_inicial: fecha_inicio,
            fecha_final: fecha_fin,
            sucursal: sucursal
          }
        },
        "columns": [{
            "data": "id_trans"
          },
          {
            "data": "sucursal_envia"
          },
          {
            "data": "folio_salida"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "folio_entrada"
          },
          {
            "data": "fecha_captura"
          },
          {
            "data": "detalles"
          }
        ]
      });
    }

    function tabla_detalle() {
      var fecha_inicio = $("input[name='fecha_inicial']").val();
      var fecha_fin = $("input[name='fecha_final']").val();
      var sucursal = $("select[name='sucursal']").val();
      $('#detalle_categoria').dataTable().fnDestroy();
      $('#detalle_categoria').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        buttons: [{
            extend: 'excel',
            text: 'Exportar a Excel',
            className: 'btn btn-default',
            title: 'ListaCategorias',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'copy',
            text: 'Copiar registros',
            className: 'btn btn-default',
            copyTitle: 'Ajouté au presse-papiers',
            copyKeys: '',
            copySuccess: {
              _: '%d lignes copiées',
              1: '1 ligne copiée'
            }
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_detalle.php",
          "dataSrc": "",
          data: {
            fecha_inicial: fecha_inicio,
            fecha_final: fecha_fin,
            sucursal: sucursal
          }
        },
        "columns": [{
            "data": "codigo",
            "width": "15%"
          },
          {
            "data": "descripcion",
            "width": "45%"
          },
          {
            "data": "salida",
            "width": "20%"
          },
          {
            "data": "salida",
            "width": "20%"
          }

        ]
      });
    };

    function ver_detalle() {
      $("#modal-detalle").modal("show");
    }
    $('#modal-detalle').on('show.bs.modal', function(e) {
      tabla_detalle();
    });
    $("#btn-mostrar").click(function() {
      cargar_tabla();
      carga_calificaciones();
      return false;
    });
    $("#btn-calificar").click(function() {
      var url = "insertar_calificacion.php"; // El script a dónde se realizará la petición.
      var fecha_inicio = $("input[name='fecha_inicial']").val();
      var fecha_fin = $("input[name='fecha_final']").val();
      var sucursal = $("select[name='sucursal']").val();
      var txt_recibidos = $('#txt_recibido').val();
      var txt_pendientes = $('#txt_pendientes').val();
      var p_calificacion = $('#p_calificacion').val();
      $.ajax({
        type: "POST",
        url: url,
        data: {
          fecha_inicial: fecha_inicio,
          fecha_final: fecha_fin,
          sucursal: sucursal,
          txt_recibidos: txt_recibidos,
          txt_pendientes: txt_pendientes,
          p_calificacion: p_calificacion
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Calificación insertada correctamente");
          } else {
            alertify.error("Ya está calificado");
          }
        }
      });
      return false;
    });
    $('.form_date').datetimepicker({
      language: 'es',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0
    });
    $(document).ready(function(e) {
      $('#modal-default').on('show.bs.modal', function(e) {
        var id = $(e.relatedTarget).data().id;
        //alert(id);
        var url = "tabla_modal.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: {
            ide: id
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            $('#tabla').html(respuesta);
          }
        });
      });
      carga_calificaciones();
    });

    function carga_calificaciones() {
      var url = "consulta_calificacion.php"; // El script a dónde se realizará la petición.
      var fecha_inicio = $("input[name='fecha_inicial']").val();
      var fecha_fin = $("input[name='fecha_final']").val();
      var sucursal = $("select[name='sucursal']").val();
      $.ajax({
        type: "POST",
        url: url,
        data: {
          fecha_inicial: fecha_inicio,
          fecha_final: fecha_fin,
          sucursal: sucursal
        },
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#recibidos').html(array[0]);
          $('#txt_recibido').val(array[0]);
          $('#pendientes').html(array[1]);
          $('#txt_pendientes').val(array[1]);
          $('#porcentaje').html(array[2]);
          $('#p_calificacion').val(array[6]);
          $('#porcentaje_negativo').html(array[4]);
          $('#barra_progreso').css("width", array[3]);
          $('#barra_negativa').css("width", array[5]);
          $('#promedio').html(array[7]);
        }
      });
      return false;
    }

    function imprimir(folio){
      alert(folio);
    }
  </script>
</body>

</html>