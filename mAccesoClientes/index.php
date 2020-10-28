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
            <h3 class="box-title">Configuración de accesos</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <label for="limite_permitido">*Límite permitido</label>
                <input type="number" id="limite_permitido" name="limite_permitido" class="form-control">
              </div>
              <div class="col-md-3">
                <label for="limite_real">*Límite real</label>
                <input type="number" id="limite_real" name="limite_real" class="form-control">
              </div>
              <div class="col-md-3">
                <label for="conteo_clientes">*Conteo Clientes</label>
                <input type="number" id="conteo_clientes" name="conteo_clientes" class="form-control" readonly="true">
              </div>
            </div>
          </div>
          <div class="box-footer">
            <div class="row">
              <div class="col-md-6">
                <button class="btn btn-warning" id="btnTabla">Recargar tabla</button>
              </div>
              <div class="col-md-6 text-right">
                <button class="btn btn-warning" id="btnActualizar">Actualizar configuración</button>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de configuraciones existentes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="detalle_conteo" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Sucursal</th>
                        <th>L. Permitido</th>
                        <th>L. Real</th>
                        <th>Clientes</th>
                        <th width='5%'></th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
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
      datos();
    });

    $("#btnActualizar").click(function() {
      var url = "actualizar_configuracion.php";
      var limite_permitido = $("#limite_permitido").val();
      var limite_real = $("#limite_real").val();
      var conteo_clientes = $("#conteo_clientes").val();
      $.ajax({
        type: "POST",
        url: url,
        data: {
          limite_real: limite_real,
          limite_permitido: limite_permitido,
          conteo_clientes: conteo_clientes
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "mayor") {
            swal("Error", "El límite real no puede ser menor a los clientes actuales en tienda", "error");
          } else if (respuesta == "ok") {
            swal("Listo", "La configuración ha sido actualizada", "success");
          }
        }
      });
      return false;
    });

    function datos() {
      var url = "configuracion_conteo.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {

        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#limite_permitido').val(array[0]);
          $('#limite_real').val(array[1]);
          $('#conteo_clientes').val(array[2]);
          cargar_tabla();
        }
      });
      return false;
    }

    function cargar_tabla() {
      $('#detalle_conteo').dataTable().fnDestroy();
      $('#detalle_conteo').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        "ajax": {
          "type": "POST",
          "url": "tabla_conteo.php",
          "dataSrc": "",
          "data": {},
        },
        "columns": [{
            "data": "sucursal"
          },
          {
            "data": "l_permitido"
          },
          {
            "data": "l_real"
          },
          {
            "data": "clientes"
          },
          {
            "data": "ceros"
          }
        ]
      });
    };
    $("#btnTabla").click(function() {
      cargar_tabla();
    });

    function ceros(sucursal) {
      var url = "ceros.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {
          sucursal: sucursal
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          alertify("Conteo reiniciado");
          cargar_tabla();
        }
      });
      return false;
    }
  </script>
</body>

</html>