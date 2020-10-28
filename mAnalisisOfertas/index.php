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
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Análisis de Ofertas | Registro de Folio</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="descripcion_oferta">*Descripción</label>
                  <input type="text" name="descripcion_oferta" id="descripcion_oferta" class="form-control">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="comentario">*Comentario</label>
                  <input type="text" name="comentario_oferta" id="comentario_oferta" class="form-control">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_inicio">*Fecha de inicio:</label>
                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha; ?>" readonly id="fecha_inicial" name="fecha_inicial">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_fin">*Fecha final:</label>
                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha; ?>" readonly id="fecha_final" name="fecha_final">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="articulo">*Artículo</label>
                  <input type="text" id="articulo" name="articulo" class="form-control">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="descripcion">*Descripción</label>
                  <input type="text" name="descripcion" id="descripcion" class="form-control" readonly='true'>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="detalle_articulo" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='5%'>#</th>
                        <th width='10%'>Sucursal</th>
                        <th width='5%'>T.Mov.</th>
                        <th width='5%'>Folio</th>
                        <th width='5%'>Fecha</th>
                        <th width='5%'>Cantidad</th>
                        <th>Proveedor</th>
                        <th width='5%'>Teórico</th>
                        <th width='10%'>Ventas (x̄)</th>
                        <th width='10%'>Días Inv.</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-crear">Crear Folio</button>
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <!-- Page script -->
  <script>
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
    $("#articulo").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        consutaArticulo();
        cargar_tabla();
      }
    });

    function consutaArticulo() {
      var url = "consulta_codigo.php"; // El script a dónde se realizará la petición.
      var codigo = $("#articulo").val();
      $("#articulo").attr("readonly", true);
      $.ajax({
        type: "POST",
        url: url,
        data: {
          codigo: codigo
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "no existe") {
            alert("No existe ese codigo");
            $("#articulo").removeAttr("readonly");
          } else {
            var array = eval(respuesta);
            $("#descripcion").val(array[0]);
            $("#articulo").removeAttr("readonly");
          }
        }
      });
      return false;
    }

    function cargar_tabla() {
      var codigo = $("#articulo").val();
      var fecha_inicio = $("#fecha_inicial").val();
      var fecha_fin = $("#fecha_final").val();
      $('#detalle_articulo').dataTable().fnDestroy();
      $('#detalle_articulo').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        buttons: [{
            extend: 'excel',
            text: 'Exportar a Excel',
            className: 'btn btn-default',
            title: 'AuditoriaPV',
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
            text: 'Foliar Seleccionados',
            className: 'red',
            action: function() {
              libera_multiple();
            },
            counter: 1
          },
          {
            text: 'Limpiar tabla',
            className: 'red',
            action: function() {
              limpiar_tabla();
            },
            counter: 1
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_detalle.php",
          "dataSrc": "",
          "data": {
            codigo: codigo,
            fecha_inicio: fecha_inicio,
            fecha_fin: fecha_fin
          },
        },
        "columns": [{
            "data": "num"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "tipo_mov"
          },
          {
            "data": "folio"
          },
          {
            "data": "fecha"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "proveedor"
          },
          {
            "data": "existencia"
          },
          {
            "data": "prom_ventas"
          },
          {
            "data": "dias_inv"
          }
        ]
      });
    };
  </script>
</body>

</html>