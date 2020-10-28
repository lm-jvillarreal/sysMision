<?php include '../global_seguridad/verificar_sesion.php'; ?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
</head>
<style>
  #popup {
    visibility: hidden;
    opacity: 0;
    margin-top: -350px;
  }

  #popup:target {
    visibility: visible;
    opacity: 1;
    background-color: rgba(0, 0, 0, 0.8);
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: 0;
    z-index: 999;
    transition: all 1s;
  }

  .popup-contenedor {
    position: relative;
    margin: 7% auto;
    padding: 30px 50px;
    background-color: #fafafa;
    color: #333;
    border-radius: 3px;
    width: 50%;
  }

  a.popup-cerrar {
    position: absolute;
    top: 3px;
    right: 3px;
    background-color: #333;
    padding: 7px 10px;
    font-size: 20px;
    text-decoration: none;
    line-height: 1;
    color: #fff;
  }

  @import url(//fonts.googleapis.com/css?family=Montserrat:400,700);

  .col-md-4 {
    text-align: center;
    font-size: 25px;
  }

  .col-md-4:last-child {
    border-right: 0px solid black;
  }

  .counter {
    font-size: 80px;
    animation-duration: 1s;
    animation-delay: 0s;
  }

  @media (max-width: 991px) {
    .col-md-4 {
      width: 50%;
      margin: auto auto;
    }
  }
</style>

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
        <form method="POST">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Asignaci&oacute;n de Turnos</h3>
            </div>
            <div class="box-bdy">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group" style="margin-left:50px;">
                    <button type="submit" class="btn btn-warning" onclick="imprimir();" id="turno">Imprimir Turno</button>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <h1><span id="turno_actual" class="counter"></span></h1>
                    <h3>Turno Actual</h3>
                    <i class="fa fa-users"></i>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <h1><span id="turno_impreso" class="counter"></span></h1>
                    <h3>Turnos Impresos</h3>
                    <i class="fa fa-desktop"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
        <!-- /.content -->
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Turnos</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_turnos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th width='5%'>Turno</th>
                        <th>Paciente</th>
                        <th width='15%'>Fecha</th>
                        <th width='10%'>Imprimir</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
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
  <script>
    function cargar_tabla() {
      var paciente = $("#Paciente").val();
      $('#lista_turnos').dataTable().fnDestroy();
      $('#lista_turnos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": true,
        "order": [
          [0, "desc"]
        ],
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
            title: 'ListaActividades',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'ListaActividades',
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
          "url": "tabla_turnos.php",
          "dataSrc": "",
          "data": ""
        },
        "columns": [{
            "data": "id"
          },
          {
            "data": "consecutivo"
          },
          {
            "data": "paciente"
          },
          {
            "data": "fecha"
          },
          {
            "data": "imprimir"
          }
        ]
      });
    }
    cargar_tabla();
  </script>
  <script>
    function cargar() {
      $.ajax({
        url: 'cargar_registros.php',
        success: function(array) {
          var array = eval(array);
          turno = array[0];
          consecutivo = array[1];

          $('#turno_actual').html(turno);
          $('#turno_impreso').html(consecutivo);
        }
      })
    }
    cargar();
  </script>
  <script>
    function imprimir() {

      var url = "insertar_datos.php";

      window.open(url, "_blank", "width=650,height=400,top=100,left=490,scrollbars=NO,menubar=NO,titlebar= NO,status=NO,toolbar=NO");
      cargar_tabla();
      return false;
    }
    cargar();
  </script>
  <script>
    function reimpresion(turno, prefijo) {
      var url = "reimprimir_turno.php";

      var parametro = '?id_turno=' + turno + '&prefijo=' + prefijo;
      window.open(url + parametro, "_blank", "width=650,height=400,top=100,left=490,scrollbars=NO,menubar=NO,titlebar= NO,status=NO,toolbar=NO");
      return false;
    }
  </script>
</body>

</html>