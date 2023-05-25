<?php
  include '../global_seguridad/verificar_sesion.php';

  $cadena_reporte = "SELECT COUNT(id) from reportes_cajas where id_sucursal = '$id_sede'";
  $consulta_reporte = mysqli_query($conexion, $cadena_reporte);
  $row_reporte = mysqli_fetch_array($consulta_reporte);

  $cadena = "SELECT * from reportes_cajas where id_sucursal = '$id_sede'";
  $consulta = mysqli_query($conexion, $cadena);
  $row = mysqli_fetch_array($cadena);
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
          <h3 class="box-title">Lista de Reportes de Cajas</h3>
          <br>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="contenedor">
              <div class="form-group">
                <input type="hidden" name="id_registro" id="id_registro" class="">
                <a class="btn btn-app" id="DO" name="1DO" style="background-color:rgb(144, 210, 93);" onclick="mostrarDO();">
                  <i class="fa fa-building-o" style="color: black"></i><b>Díaz Ordaz</b> 
                </a>
                <a class="btn btn-app" id="ARB" name="1ARB" style="background-color:rgb(144, 210, 93);" onclick="mostrarARB();">
                  <i class="fa fa-building-o" style="color: black"></i><b>Arboledas</b> 
                </a>
                <a class="btn btn-app" id="VILL" name="1VILL" style="background-color:rgb(144, 210, 93);" onclick="mostrarVILL();">
                  <i class="fa fa-building-o" style="color: black"></i><b>Villegas</b> 
                </a>
                <a class="btn btn-app" id="ALL" name="1ALL" style="background-color:rgb(144, 210, 93);"onclick="mostrarALL();">
                  <i class="fa fa-building-o" style="color: black"></i><b>Allende</b> 
                </a>
                <a class="btn btn-app" id="PET" name="1PET" style="background-color:rgb(144, 210, 93);"onclick="mostrarPET();">
                  <i class="fa fa-building-o" style="color: black"></i><b>Petaca</b> 
                </a>
              </div> 
            </div>
          </div>
        </div>
      </div>
      <div id="DIAZORDAZ" style="display:none">
        <form action="" id="tablaDO">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Lista de Reportes de Cajas</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table id="lista_reportes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Sucursal</th>
                          <th>Caja</th>
                          <th>Equipo</th>
                          <th>Falla</th>
                          <th>Marcar V.</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>#</th>
                          <th>Sucursal</th>
                          <th>Caja</th>
                          <th>Equipo</th>
                          <th>Falla</th>
                          <th>Marcar V.</th>
                          <th>Status</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form> 
      </div>
      <div id="ARBOLEDAS" style="display:none">
        <form action="" id="tablaARB">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Lista de Reportes de Cajas</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table id="lista_reportesA" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Sucursal</th>
                          <th>Caja</th>
                          <th>Equipo</th>
                          <th>Falla</th>
                          <th>Marcar V.</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>#</th>
                          <th>Sucursal</th>
                          <th>Caja</th>
                          <th>Equipo</th>
                          <th>Falla</th>
                          <th>Marcar V.</th>
                          <th>Status</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form> 
      </div>
      <div id="VILLEGAS" style="display:none">
        <form action="" id="tablaVILL">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Lista de Reportes de Cajas</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table id="lista_reportesV" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Sucursal</th>
                          <th>Caja</th>
                          <th>Equipo</th>
                          <th>Falla</th>
                          <th>Marcar V.</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>#</th>
                          <th>Sucursal</th>
                          <th>Caja</th>
                          <th>Equipo</th>
                          <th>Falla</th>
                          <th>Marcar V.</th>
                          <th>Status</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form> 
      </div>
      <div id="ALLENDE" style="display:none">
        <form action="" id="tablaALL">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Lista de Reportes de Cajas</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table id="lista_reportesALL" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Sucursal</th>
                          <th>Caja</th>
                          <th>Equipo</th>
                          <th>Falla</th>
                          <th>Marcar V.</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>#</th>
                          <th>Sucursal</th>
                          <th>Caja</th>
                          <th>Equipo</th>
                          <th>Falla</th>
                          <th>Marcar V.</th>
                          <th>Status</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form> 
      </div>
      <div id="PETACA" style="display:none">
        <form action="" id="tablaPET">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Lista de Reportes de Cajas</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table id="lista_reportesPET" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Sucursal</th>
                          <th>Caja</th>
                          <th>Equipo</th>
                          <th>Falla</th>
                          <th>Marcar V.</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>#</th>
                          <th>Sucursal</th>
                          <th>Caja</th>
                          <th>Equipo</th>
                          <th>Falla</th>
                          <th>Marcar V.</th>
                          <th>Status</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form> 
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

<?php include '../footer.php';?>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<!-- Page script -->
<script>
  function mostrarDO(){
    $("#DIAZORDAZ").show();
    $("#ARBOLEDAS").hide();
    $("#VILLEGAS").hide();
    $("#ALLENDE").hide();
    $("#PETACA").hide();
    $("#lista_reportes").show();
    $("#lista_reportesA").hide();
    $("#lista_reportesV").hide();
    $("#lista_reportesALL").hide();
    $("#lista_reportesPET").hide();
     cargar_tabla();
  }
  function mostrarARB(){
    $("#DIAZORDAZ").hide();
    $("#ARBOLEDAS").show();
    $("#VILLEGAS").hide();
    $("#ALLENDE").hide();
    $("#PETACA").hide();
    $("#lista_reportes").hide();
    $("#lista_reportesA").show();
    $("#lista_reportesV").hide();
    $("#lista_reportesALL").hide();
    $("#lista_reportesPET").hide();
    cargar_tablaARB();
  }
  function mostrarVILL(){
    $("#DIAZORDAZ").hide();
    $("#ARBOLEDAS").hide();
    $("#VILLEGAS").show();
    $("#ALLENDE").hide();
    $("#PETACA").hide();
    $("#lista_reportesA").hide();
    $("#lista_reportesV").show();
    $("#lista_reportes").hide();
    $("#lista_reportesALL").hide();
    $("#lista_reportesPET").hide();
    cargar_tablaVILL();
  }
  function mostrarALL(){
    $("#DIAZORDAZ").hide();
    $("#ARBOLEDAS").hide();
    $("#VILLEGAS").hide();
    $("#ALLENDE").show();
    $("#PETACA").hide();
    $("#lista_reportesA").hide();
    $("#lista_reportesV").hide();
    $("#lista_reportes").hide();
    $("#lista_reportesALL").show();
    $("#lista_reportesPET").hide();
    cargar_tablaALL();
  }
  function mostrarPET(){
    $("#DIAZORDAZ").hide();
    $("#ARBOLEDAS").hide();
    $("#VILLEGAS").hide();
    $("#ALLENDE").hide();
    $("#PETACA").show();
    $("#lista_reportesA").hide();
    $("#lista_reportesV").hide();
    $("#lista_reportes").hide();
    $("#lista_reportesALL").hide();
    $("#lista_reportesPET").show();
    cargar_tablaPET();
  }
  function cargar_tabla() {
    $('#lista_reportes').dataTable().fnDestroy();
    $('#lista_reportes').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
      "paging":   false,
      "dom": 'Bfrtip',
      "order": ["0", "ASC"],
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
        "url": "tabla_reportes.php",
        "dataSrc": "",
      },
      "columns": [
        { "data": "#", "width":"3%" },
        { "data": "Sucursal", "width":"3%" },
        { "data": "Caja", "width":"5%" },
        { "data": "Equipo"},
        { "data": "Fallo"},
        { "data": "Visto", "width":"7%"},
        { "data": "Status","width":"20%"}
      ]
    });
  }
  function cargar_tablaARB() {
    $('#lista_reportesA').dataTable().fnDestroy();
    $('#lista_reportesA').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
      "paging":   false,
      "dom": 'Bfrtip',
      "order": ["0", "ASC"],
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
        "url": "tabla_reportesARB.php",
        "dataSrc": "",
      },
      "columns": [
        { "data": "#", "width":"3%" },
        { "data": "Sucursal", "width":"3%" },
        { "data": "Caja", "width":"5%" },
        { "data": "Equipo"},
        { "data": "Fallo"},
        { "data": "Visto", "width":"7%"},
        { "data": "Status","width":"20%"}
      ]
    });
  }
  function cargar_tablaVILL() {
    $('#lista_reportesV').dataTable().fnDestroy();
    $('#lista_reportesV').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
      "paging":   false,
      "dom": 'Bfrtip',
      "order": ["0", "ASC"],
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
        "url": "tabla_reportesVILL.php",
        "dataSrc": "",
      },
      "columns": [
        { "data": "#", "width":"3%" },
        { "data": "Sucursal", "width":"3%" },
        { "data": "Caja", "width":"5%" },
        { "data": "Equipo"},
        { "data": "Fallo"},
        { "data": "Visto", "width":"7%"},
        { "data": "Status","width":"20%"}
      ]
    });
  }
  function cargar_tablaALL() {
    $('#lista_reportesALL').dataTable().fnDestroy();
    $('#lista_reportesALL').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
      "paging":   false,
      "dom": 'Bfrtip',
      "order": ["0", "ASC"],
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
        "url": "tabla_reportesALL.php",
        "dataSrc": "",
      },
      "columns": [
        { "data": "#", "width":"3%" },
        { "data": "Sucursal", "width":"3%" },
        { "data": "Caja", "width":"5%" },
        { "data": "Equipo"},
        { "data": "Fallo"},
        { "data": "Visto", "width":"7%"},
        { "data": "Status","width":"20%"}
      ]
    });
  }
  function cargar_tablaPET() {
    $('#lista_reportesPET').dataTable().fnDestroy();
    $('#lista_reportesPET').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
      "paging":   false,
      "dom": 'Bfrtip',
      "order": ["0", "ASC"],
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
        "url": "tabla_reportesPET.php",
        "dataSrc": "",
      },
      "columns": [
        { "data": "#", "width":"3%" },
        { "data": "Sucursal", "width":"3%" },
        { "data": "Caja", "width":"5%" },
        { "data": "Equipo"},
        { "data": "Fallo"},
        { "data": "Visto", "width":"7%"},
        { "data": "Status","width":"20%"}
      ]
    });
  }
  function cambiar_estatus2(id){
    $.ajax({
      url: 'cambiar_estatus2.php',
      data: {'id':id} ,
      type: "POST",
      success: function(respuesta) {
        if(respuesta == "ok"){
          alertify.success('Reporte Marcado como Revisado');
          cargar_tabla();
          llenar_notificaciones();
        }
        else{
          alertify.error('Ha Ocurrido un Error');
        }
      }
    });
  }
  function cambiar_estatus(id, numero){
    var comentario = $('#comentario'+numero).val();
    if(comentario == ""){
      alertify.error('Verifica Campos');
      return false;
    }
    $.ajax({
      url: 'cambiar_estatus.php',
      data: {'id':id,'comentario':comentario} ,
      type: "POST",
      success: function(respuesta) {
        if(respuesta == "ok"){
          alertify.success('Reporte Solucionado');
          cargar_tabla();
          llenar_notificaciones();
        }
        else{
          alertify.error('Ha Ocurrido un Error');
        }
      }
    });
  }
</script>
</body>
</html>
