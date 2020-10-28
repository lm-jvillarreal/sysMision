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
            <h3 class="box-title">Mis Datos Personales | Actualizar Sucursal</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="sucursal">*Sucursal</label>
                  <select name="sucursal" id="sucursal" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-guardar">Actualizar Sucursal</button>
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
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity,
      ajax: {
        url: "consulta_sucursal.php",
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
    });
    $("#btn-guardar").click(function() {
      var url = "actualizar_sucursal.php";
      var sucursal = $("#sucursal").val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          sucursal: sucursal
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            swal("Estamos realizando los cambios necesarios, espere...", {
              buttons: false,
              timer: 3000,
              closeOnEsc: false,
              closeOnClickOutside: false,
            });
            window.setTimeout(function() {
              var url = "../global_seguridad/cerrarsesion.php";
              $(location).attr('href', url);
            }, 3000);
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      })
      return false;
    });
  </script>
</body>

</html>