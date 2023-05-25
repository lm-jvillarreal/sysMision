<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha_ant = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')));
$fecha = date('Y-m-d');
$hora = date("h:i:s");
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <link href="https://cdn.datatables.net/fixedcolumns/3.2.4/css/fixedColumns.bootstrap4.min.css" rel="stylesheet" />
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
            <h3 class="box-title">Conciliación de Libro de Entrada | Filtros</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form-datos">
              <div class="row">
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
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="proveedor">*Proveedor:</label>
                    <select name="proveedor" id="proveedor" class="form-control">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer">
            <div class="row">
              <div class="col-md-6 text-left">
                <a class="btn btn-danger" href="rpt_corte.php" target="blank">Descargar corte</a>
              </div>
              <div class="col-md-6 text-right">
                <button class="btn btn-warning" id="btn-guardar">Visualizar Información</button>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Conciliación de Libro de Entrada | Resumen</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id='libro_diario' class='display table table-striped table-bordered nowrap' style="width:100%" cellspacing='0' width='100%'>
                    <thead>
                      <tr>
                        <th>F.E.</th>
                        <th>Cve.</th>
                        <th>Proveedor</th>
                        <th>Dificultad</th>
                        <th>Tipo</th>
                        <th>Remisión</th>
                        <th>Remisión($)</th>
                        <th>Entrada($)</th>
                        <th>Devolución($)</th>
                        <th>C.F.($)</th>
                        <th>(-)D.C.($)</th>
                        <th>(+)D.C.($)</th>
                        <th>G.Total</th>
                        <th>Dif</th>
                        <th>Escaneado</th>
                        <th>Concilia</th>
                        <th></th>
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
    <?php include 'modal_entradas.php'; ?>
    <?php include 'modal_faltante.php'; ?>
    <?php include 'modal_difmas.php'; ?>
    <?php include 'modal_difmenos.php'; ?>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/fixedcolumns/3.2.4/js/dataTables.fixedColumns.min.js"></script>
  <!-- Page script -->
  <script>
    $(document).ready(function(e) {
      libro_diario();
    });
    $("#btn-guardar").click(function() {
      libro_diario();
    });
    $('#proveedor').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
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
    })

    function libro_diario() {
      fecha_inicio = $("#fecha_inicial").val();
      fecha_fin = $("#fecha_final").val();
      proveedor = $("#proveedor").val();
      $('#libro_diario').dataTable().fnDestroy();
      $('#libro_diario').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        fixedColumns: {
          leftColumns: 1,
          rightColumns: 1
        },
        'order': [
          [0, "desc"]
        ],
        "scrollX": true,
        "scrollY": "300px",
        "scrollCollapse": true,
        "dom": 'Bfrtip',
        buttons: [{
            extend: 'excel',
            text: 'Exportar a Excel',
            className: 'btn btn-default',
            title: 'Conciliación de Libro de Entrada',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            download: 'open',
            orientation: 'landscape',
            pageSize: 'LEGAL'
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
            extend: 'print',
            title: 'Resumen conciliación Libro de Entrada',
            text: 'Imprimir registros',
            orientation: 'landscape',
            exportOptions: {
              columns: ':visible'
            }
          }
        ],
        "ajax": {
          "type": "POST",
          "url": "consulta_resumen.php",
          "dataSrc": "",
          "data": {
            fecha_inicio: fecha_inicio,
            fecha_fin: fecha_fin,
            proveedor: proveedor
          }
        },
        "columns": [{
            "data": "ficha_entrada"
          },
          {
            "data": "cve_prov"
          },
          {
            "data": "nombre_proveedor"
          },
          {
            "data": "dificultad"
          },
          {
            "data": "tipo_proveedor"
          },
          {
            "data": "remision"
          },
          {
            "data": "total_remision"
          },
          {
            "data": "total_entrada"
          },
          {
            "data": "total_devoluciones"
          },
          {
            "data": "total_cf"
          },
          {
            "data": "total_dc"
          },
          {
            "data": "total_dc2"
          },
          {
            "data": "gran_total"
          },
          {
            "data": "diferencia"
          },
          {
            "data": "escaneada"
          },
          {
            "data": "usuario_concilia"
          },
          {
            "data": "consumo_interno"
          }
        ]
      });
    }
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

    $('#modal-entradas').on('show.bs.modal', function(e) {
      $('#tabla').html("<h2>Cargando datos, por favor espere...</h2>");
      var folio = $(e.relatedTarget).data().id;
      //alert(id);
      var url = "tabla_modal.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          folio: folio
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          $('#tabla').html(respuesta);
          cargar_tabla2();
        }
      });
    });

    $('#modal-difmas').on('show.bs.modal', function(e) {
      $('#tabladifmas').html("<h2>Cargando datos, por favor espere...</h2>");
      var folioDM = $(e.relatedTarget).data().id;
      //alert(id);
      var url = "tabla_difmas.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          folioDM: folioDM
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          $('#tabladifmas').html(respuesta);
          cargar_tabla2();
        }
      });
    });

    $('#modal-difmenos').on('show.bs.modal', function(e) {
      $('#tabladifmenos').html("<h2>Cargando datos, por favor espere...</h2>");
      var folioDif = $(e.relatedTarget).data().id;
      //alert(id);
      var url = "tabla_difmenos.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          folioDif: folioDif
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          $('#tabladifmenos').html(respuesta);
          cargar_tabla2();
        }
      });
    });

    $('#modal-faltante').on('show.bs.modal', function(e) {
      $('#tablaF').html("<h2>Cargando datos, por favor espere...</h2>");
      var folioF = $(e.relatedTarget).data().id;
      //alert(id);
      var url = "tabla_faltante.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          folioF: folioF
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          $('#tablaF').html(respuesta);
          cargar_tabla2();
        }
      });
    });

    function imp_ficha(oc) {
      window.open("../mLiberar_orden/imprimir_folio.php?foc=" + oc, "folio", "width=320,height=900,menubar=no,titlebar=no");
    }
  </script>
</body>

</html>