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
            <h3 class="box-title">Reimpresión de Comprobantes | Reimprimir</h3>
          </div>
          <div class="box-body">
            <form action="" method="POST" id="form-catalogo">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="no_ticket">*No. de Ticket</label>
                  <input type="text" name="no_ticket" id="no_ticket" class="form-control">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="sucursal">*Sucursal</label>
                  <select name="sucursal" id="sucursal" class="form-control">
                    <option></option>
                  </select>
                </div>
              </div>
            </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-crear" onclick="abrir();">Visualizar</button>
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
<script>
  function abrir(){
    var ticket = $("#no_ticket").val();
    var sucursal = $("#sucursal").val();
    window.open("voucher.php?tckt="+ticket+"&scrsl="+sucursal,"vouhcer","width=290,height=900,menubar=no,titlebar=no");
  }
  $('#sucursal').select2({
     placeholder: 'Seleccione una opcion',
     lenguage: 'es',
     minimumResultsForSearch: Infinity,
     ajax: { 
     url: "consulta_sucursal.php",
     type: "post",
     dataType: 'json',
     delay: 250,
     data: function (params) {
      return {
        searchTerm: params.term // search term
      };
     },
     processResults: function (response) {
       return {
          results: response
       };
     },
     cache: true
    }
  })
  $(document).ready(function (e) {
    $("#sucursal").select2("trigger", "select", {
        data: { id: "<?php echo $id_sede; ?>", text:"<?php echo $nombre_sede; ?>" }
    });
  });
</script>
</body>
</html>
