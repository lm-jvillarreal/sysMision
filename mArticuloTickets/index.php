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
            <h3 class="box-title">Reporte | Articulo en tickets</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_inicio">*Fecha de inicio:</label>
                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_inicial" name="fecha_inicial">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_fin">*Fecha final:</label>
                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_final" name="fecha_final">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="artc_articulo">*Artículo</label>
                  <input type="text" name="artc_articulo" id="artc_articulo" class="form-control">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="artc_articulo">*Descripción</label>
                  <input type="text" name="artc_descripcion" id="artc_descripcion" class="form-control" readonly="true">
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer">
            <div class="row">
              <div class="col-md-12 text-right">
                <button class="btn btn-warning" id="btn-cargar">Generar Tabla</button>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Conteo de articulo en tickets | Listado</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="tabla_conteo" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='5%'></th>
                        <th>Sucursal</th>
                        <th width='10%'>Total</th>
                        <th width='10%'>Muestra</th>
                        <th width='10%'>Muestra (%)</th>
                      </tr>
                    </thead>
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
    <?php include 'modal_tickets.php'; ?>
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
  <script type="text/javascript">
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

    function cargar_tabla(estatus) {
      var fecha_incial = $("#fecha_inicial").val();
      var fecha_final = $("#fecha_final").val();
      var artc_articulo = $("#artc_articulo").val();
      $('#tabla_conteo').dataTable().fnDestroy();
      $('#tabla_conteo').DataTable({
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
            title: 'Pasivos por documentar',
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
          "url": "tabla_conteo.php",
          "dataSrc": "",
          "data": {
            fecha_inicial: fecha_incial,
            fecha_final: fecha_final,
            artc_articulo: artc_articulo,
            estatus: estatus
          }
        },
        "columns": [{
            "data": "conteo"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "total"
          },
          {
            "data": "muestra"
          },
          {
            "data": "porcentaje"
          }
        ]
      });
    }
    $(document).ready(function() {
      cargar_tabla(0);
    });
    $("#btn-cargar").click(function() {
      cargar_tabla(1);
    });

    $("#artc_articulo").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = "consulta_desc.php"; // El script a dónde se realizará la petición.
        var artc_articulo = $("#artc_articulo").val();
        $.ajax({
          type: "POST",
          url: url,
          data: {
            artc_articulo: artc_articulo
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "no") {
              alertify.error("El articulo no existe");
              $('#artc_articulo').val("");
            }
            var array = eval(respuesta);
            $('#artc_descripcion').val(array[0]);
          }
        });
        return false;
      }
    });
    $('#modal-tickets').on('show.bs.modal', function(e) {
      $('#tabla').html("<h2>Cargando datos, por favor espere...</h2>");
      var articulo = $(e.relatedTarget).data().articulo;
      var inicio = $(e.relatedTarget).data().inicio;
      var fin = $(e.relatedTarget).data().fin;
      var sucursal = $(e.relatedTarget).data().sucursal;
      //alert(id);
      var url = "tabla_modal.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          articulo: articulo,
          inicio: inicio,
          fin: fin,
          sucursal: sucursal
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          $('#tabla').html(respuesta);
          //cargar_tabla2();
        }
      });
    });
  </script>
</body>

</html>