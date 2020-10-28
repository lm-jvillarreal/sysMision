<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')));
$hora = date("h:i:s");
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <script type="text/javascript" src="funciones.js?v=<?php echo (rand()) ?>"></script>
</head>

<body class="hold-transition skin-red sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <?php include '../header.php';
      ?>
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
            <h3 class="box-title">Analisis de codigos | Filtros</h3>
          </div>
          <div class="box-body">
            <form id="frmDatosAnalisis">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Codigo</label>
                    <input type="text" class="form-control" id="txtCodigo" name="">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Fecha Inicial</label>
                    <input type="date" class="form-control" name="fecha_inicial" id="fecha_inicial">                  
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Fecha Final</label>
                    <input type="date" class="form-control" name="fecha_final" id="fecha_final" >                  
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label></label>
                    <br>
                    <a href="#" onclick="javascript:consulta_codigo()" class="btn btn-danger">Buscar</a>                  
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer">

            
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Analisis de codigos | Lista</h3>
          </div>
          <div class="box-body">
            <div id="contenedor_tabla">
              
            </div>
          </div>
          <div class="box-footer text-right">
          </div>
        </div>
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
  <!-- Page script -->
  <script type="text/javascript">
    function agregar(id_mapeo) {
      $('#id_mapeoModal').val(id_mapeo);
      $('#agregar_p').modal('show');
    }
  </script>
  <script>
    $(document).ready(function() {
      tabla_inicio();
    });

    function tabla_inicio() {
      $('#lista_mapeos thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      $('#lista_mapeos').dataTable().fnDestroy();
      var table = $('#lista_mapeos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        select: {
          style: 'multi'
        },
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
            title: 'FaltantesComprador',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'CostosCero',
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
        ]
      });
      table.columns().every(function() {
        var that = this;
        $('input', this.header()).on('keyup change', function() {
          if (that.search() !== this.value) {
            that
              .search(this.value)
              .draw();
          }
        });
      });
    }
  </script>
  <script>
    $(function() {
      $('#cmbArea').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: {
          url: "consulta_areas.php",
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
    })
  </script>
<script type="text/javascript">
    function consulta_codigo() {

      var fecha_inicial = $('#fecha_inicial').val();
      var fecha_final = $('#fecha_final').val();
      var codigo = $('#txtCodigo').val();

      let datos = {
        codigo: codigo,
        fecha_inicial: fecha_inicial,
        fecha_final: fecha_final
      };

      $.ajax({
        url: "tabla_captura.php",
        type: "POST",
        dateType: "html",
        data: datos,
        success: function(respuesta) {
          $('#contenedor_tabla').html(respuesta);
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }

  </script>
</body>

</html>