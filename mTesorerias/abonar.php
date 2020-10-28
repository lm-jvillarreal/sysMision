<?php
  include '../global_seguridad/verificar_sesion.php';

  $folio          = $_GET['folio'];
  $prestamo_total = 0;
  $abonos         = 0;
  $restante       = 0;

  $cadena = mysqli_query($conexion,"SELECT SUM(resultado) FROM prestamos_morralla WHERE folio = '$folio'");
  $row_resultado  = mysqli_fetch_array($cadena);
  $prestamo_total = $row_resultado[0];

  $cadena2 = mysqli_query($conexion,"SELECT SUM(abono) FROM abonos WHERE folio = '$folio'");
  $cantidad = mysqli_num_rows($cadena2);
  $row_restante  = mysqli_fetch_array($cadena2);
  if ($cantidad == 0){
    $abonos = 0;
  }
  else{
    $abonos = $row_restante[0];
  }

  $operacion = $prestamo_total - $abonos;

  $restante = sprintf('%0.2f', $operacion);
 ?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../head.php'; ?>
  <link rel="stylesheet" href="../mJuntas/estilos.css">
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <?php include '../header.php'; ?>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <?php include 'menuV3.php'; ?>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Abono A Prestamo de Morralla</h3>
        </div>
        <div class="box-body">
          <div class="row container-fluid">
            <div class="col-md-offset-2 col-md-3">
              <h4>Prestamo Total: $<?php echo $prestamo_total;?></h4>
              <br>
            </div>
            <div class="col-md-offset-1 col-md-3">
              <h4>Prestamo Restante: $<?php echo $restante;?></h4>
              <br>
            </div>
          </div>
          <div class="col-md-offset-3 col-md-4">
            <form id="abonos">
              <div class="form-group">
                <label for="abono">*Monto del Abono: </label>
                <div class="input-group">
                  <div class="input-group-addon">
                    $
                  </div>
                  <input type="text" id="abono" name="abono" class="form-control">
                  <input type="text" id="folio" name="folio" class="hidden" class="" value="<?php echo $folio?>">
                  <div class="input-group-addon">
                    .00
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-offset-4 col-md-4" id="liquidado" style="display: none">
            <h3>Abono Liquidado</h3>
          </div>
          <div class="col-md-4">
            <br>
            <button onclick="verificar_campo($('#abono').val(),'<?php echo $restante?>');" class="btn btn-warning" id="guardar">Abonar</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Abonos</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_abonos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Usuario</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
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
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<!-- Page script -->
<script>
  function guardar(){
    $.ajax({
      url: 'insertar_abono.php',
      type: 'POST',
      dateType: 'html',
      data: $('#abonos').serialize(),
      success:function(respuesta){
        if(respuesta == "ok")
        {
          alertify.success("Se ha Abonado al Prestamo");
          location.href='prestamo_morralla.php';
        }
        else
        {
          alert(respuesta);
          alertify.error("Ha ocurrido un error",2);
        }
      }
    });
  }
  function verificar_campo(abono,restante){
    if (abono == ""){
      alertify.error("Verifica campos",2);
    }
    else{
      if (parseFloat(abono) <= parseFloat(restante)){
        guardar();
      }
      else{
        alertify.error("El abono es mayor al restante");
      }
    }
  }
  function verificar_abono(restante){
    if (parseFloat(restante) == 0){
      $("#abonos").hide();
      $("#guardar").hide();
      $('#liquidado').show();
    }
  }
  verificar_abono('<?php echo $restante;?>')
</script>
<script>
  function cargar_tabla(folio){
    $('#lista_abonos').dataTable().fnDestroy();
    $('#lista_abonos').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "dom": 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
      "ajax": {
          "type": "POST",
          "url": "tabla_abonos.php",
          "dataSrc": "",
          "data":{'folio':folio}
      },
      "columns": [
          { "data": "#" },
          { "data": "Usuario" },
          { "data": "Cantidad" },
          { "data": "Fecha" },
      ]
   });
  }
</script>
<script>
  cargar_tabla('<?php echo $folio;?>');
</script>
</body>
</html>