<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha = date("Y-m-d");
$hora = date("h:i:s");
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
            <h3 class="box-title">Cartas Faltantes | Filtros</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form-datos">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha_inicio">*Fecha de inicio:</label>
                    <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicial" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_inicial" name="fecha_inicial">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha_fin">*Fecha final:</label>
                    <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_final" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_final" name="fecha_final">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="sucursal">*Sucursal:</label>
                    <select name="sucursal" id="sucursal" class="form-control">
                      <option value=""></option>
                      <?php
                      $cadena_sucursales = "SELECT id, nombre FROM sucursales WHERE activo = '1' ORDER BY id";
                      $consulta_sucursales = mysqli_query($conexion, $cadena_sucursales);
                      while ($row_sucursales = mysqli_fetch_array($consulta_sucursales)) {
                        ?>
                        <option value="<?php echo $row_sucursales[0] ?>"><?php echo $row_sucursales[1] ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="proveedor">*Proveedor:</label>
                    <select name="proveedor" id="proveedor" class="form-control" lang="es">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-danger" id="btn-guardar">Filtrar Resultados</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Cartas Faltantes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id='lista_cartas' class='table table-striped table-bordered' cellspacing='0' width='100%'>
                    <thead>
                      <tr>
                        <td width="5%"><strong>Folio</strong></td>
                        <td width="10%"><strong>No. O.C.</strong></td>
                        <td width="12%"><strong>No. Proveedor</strong></td>
                        <td><strong>Proveedor</strong></td>
                        <td width="10%"><strong>No. Factura</strong></td>
                        <td width="8%"><strong>Sucursal</strong></td>
                        <td width="8%"><strong>Status</strong></td>
                        <td width="5%" align="center"><strong>PDF</strong></td>
                        <td width="5%" align="center"><strong>Afectar</strong></td>
                      </tr>
                      <tr>
                        <th width="5%">Folio</th>
                        <th width="10%">No. O.C.</th>
                        <th width="12%">No. Proveedor</th>
                        <th>Proveedor</th>
                        <th width="10%">No. Factura</th>
                        <th width="8%">Sucursal</th>
                        <th width="8%">Status</th>
                        <th width="5%" align="center">PDF</th>
                        <th width="5%" align="center">Afectar</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Folio</th>
                        <th>No. O.C.</th>
                        <th>No. Proveedor</th>
                        <th>Proveedor</th>
                        <th>No. Factura</th>
                        <th>Sucursal</th>
                        <th>Status</th>
                        <th>PDF</th>
                        <th>Afectar</th>
                      </tr>
                    </tfoot>
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
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
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
    $(document).ready(function() {
      cargar_tabla();
    });
    $("#btn-guardar").click(function() {
      cargar_tabla();
      //alert("Hola");
    });

    function cargar_tabla() {
      $('#lista_cartas thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      var fecha_inicio = $("input[name='fecha_inicial']").val();
      var fecha_fin = $("input[name='fecha_final']").val();
      var sucursal = $("select[name='sucursal']").val();
      var proveedor = $("select[name='proveedor']").val();
      $('#lista_cartas').dataTable().fnDestroy();
      var table = $('#lista_cartas').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        'paging': false,
        "ajax": {
          "type": "POST",
          "url": "tabla.php",
          "dataSrc": "",
          "data": {
            fecha_inicial: fecha_inicio,
            fecha_final: fecha_fin,
            sucursal: sucursal,
            proveedor: proveedor
          }
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "no_orden"
          },
          {
            "data": "clave_proveedor"
          },
          {
            "data": "proveedor"
          },
          {
            "data": "no_factura"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "status"
          },
          {
            "data": "ver"
          },
          {
            "data": "totales"
          }
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

    function cancelar(id) {
      var id_registro = id;
      var url = 'cambiar_estado.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_registro: id_registro
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Registro cancelado correctamente");
            cargar_tabla();
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
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
  </script>
</body>

</html>