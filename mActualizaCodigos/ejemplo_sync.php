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
            <h3 class="box-title">Consulta de artículos | Gtin</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="artc_articulo">Gtin</label>
                  <input type="text" name="artc_gtin" id="artc_gtin" class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="artc_articulo">Artículo</label>
                  <input type="text" name="artc_articulo" id="artc_articulo" class="form-control" readonly="true">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-6 col-md-3">
                <a href="#" class="thumbnail" id="contenedor1">
                </a>
              </div>
              <div class="col-xs-6 col-md-3">
                <a href="#" class="thumbnail" id="contenedor2">
                </a>
              </div>
              <div class="col-xs-6 col-md-3">
                <a href="#" class="thumbnail" id="contenedor3">
                </a>
              </div>
              <div class="col-xs-6 col-md-3">
                <a href="#" class="thumbnail" id="contenedor4">
                </a>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-success" id="btnVer" name="btnVer">Consultar información</button>
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
    $(document).ready(function() {

    });

    $("#btnVer").click(function() {
      var gtin = $("#artc_gtin").val();
      var url = "ver.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          gtin: gtin
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          const obj = JSON.parse(respuesta);
          //Descripción Larga
          var descripcion = obj.TradeItemList[0].TradeItemInformation[0].Extension.Any[9].TradeItemDescription[0].Value;
          var img1 = obj.TradeItemList[0].TradeItemInformation[0].Extension.Any[8].ReferencedFileHeader[0].UniformResourceIdentifier;
          var img2 = obj.TradeItemList[0].TradeItemInformation[0].Extension.Any[8].ReferencedFileHeader[1].UniformResourceIdentifier;
          var img3 = obj.TradeItemList[0].TradeItemInformation[0].Extension.Any[8].ReferencedFileHeader[2].UniformResourceIdentifier;
          var img4 = obj.TradeItemList[0].TradeItemInformation[0].Extension.Any[8].ReferencedFileHeader[3].UniformResourceIdentifier;
          $("#artc_articulo").val(descripcion);
          $("#contenedor1").html('<img src="' + img1 + '" alt="">');
          $("#contenedor2").html('<img src="' + img2 + '" alt="">');
          $("#contenedor3").html('<img src="' + img3 + '" alt="">');
          $("#contenedor4").html('<img src="' + img4 + '" alt="">');
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    })
  </script>
</body>

</html>