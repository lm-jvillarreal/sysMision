<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date('Y-m-d', mktime(0, 0, 0, date('m'),date('d')-1,date('Y'))); 
$hora=date ("h:i:s");
 ?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../head.php'; ?>
  <script type="text/javascript" src="funciones.js?v=<?php echo(rand()) ?>"></script>
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
          <h3 class="box-title">Invenario| Importar captura</h3>
        </div>
        <div class="box-body">
          <form id="frmImportacion">
            <div class="row">
              <div class="col-lg-3">
                <label>Archivo</label>
                <input type="file" name="excel">
              </div>
            </div>
          </form>
        </div>
        <div class="box-footer">
            
            <a href="#" id="btnGuardar" onclick="javascript:subir_excel()" class="btn btn-danger">Guardar</a>
            
        </div>
      </div>

<!--          <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Cajas de articulos | Detalle</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <div id="contenedor_tabl2a"></div>
                </div>
              </div>
            </div>
          </div>
        </div> -->

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



<script type="text/javascript">
    function subir_excel() {
      var parametros = new FormData($("#frmImportacion")[0]);

      $.ajax({
        data: parametros, //datos que se envian a traves de ajax
        url: '../plugins/excelamysql/importar_captura.php', //archivo que recibe la peticion
        type: 'post', //método de envio
        contentType: false,
        processData: false,
        beforesend: function() {

        },
        success: function(response) {
          alert("Mapeo Guardado, buscar en rectificar captura")
          location.reload();
        }
      });
    }

</script>

</body>
</html>
