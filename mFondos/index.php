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
            <h3 class="box-title">Fondo | Registro de Aportaciones</h3>
          </div>
          <div class="box-body">
            <div class="col-md-3">
              <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">ALEJANDRO RAMÍREZ</span>
                  <span class="info-box-number">
                    <div id="totalARAMIREZ"></div>
                  </span>

                  <div class="progress">
                    <div class="progress-bar" id="prgrsARAMIREZ"></div>
                  </div>
                  <span class="progress-description">
                    <div id="porcientoARAMIREZ"></div>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>
            <div class="col-md-3">
              <div class="info-box bg-green">
                <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">JUVENTINO REYNA</span>
                  <span class="info-box-number">
                    <div id="totalJREYNA"></div>
                  </span>

                  <div class="progress">
                    <div class="progress-bar" id="prgrsJREYNA"></div>
                  </div>
                  <span class="progress-description">
                    <div id="porcientoJREYNA"></div>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>
            <div class="col-md-3">
              <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">CARLOS WEINMANN</span>
                  <span class="info-box-number">
                    <div id="totalCWEINMANN"></div>
                  </span>

                  <div class="progress">
                    <div class="progress-bar" id="prgrsCWEINMANN"></div>
                  </div>
                  <span class="progress-description">
                    <div id="porcientoCWEINMANN"></div>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>
            <div class="col-md-3">
              <div class="info-box bg-red">
                <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">FRANCISCO RODRÍGUEZ</span>
                  <span class="info-box-number">
                    <div id="totalFRODRIGUEZ"></div>
                  </span>

                  <div class="progress">
                    <div class="progress-bar" id="prgrsFRODRIGUEZ"></div>
                  </div>
                  <span class="progress-description">
                    <div id="porcientoFRODRIGUEZ"></div>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>
            <div class="col-md-3">
              <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">GLORIA CHARUR</span>
                  <span class="info-box-number">
                    <div id="totalGCHARUR"></div>
                  </span>

                  <div class="progress">
                    <div class="progress-bar" id="prgrsGCHARUR"></div>
                  </div>
                  <span class="progress-description">
                    <div id="porcientoGCHARUR"></div>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>
            <div class="col-md-3">
              <div class="info-box bg-green">
                <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">JESUS HERNANDEZ BOTELLO</span>
                  <span class="info-box-number">
                    <div id="totalJHERNANDEZ"></div>
                  </span>

                  <div class="progress">
                    <div class="progress-bar" id="prgrsJHERNANDEZ"></div>
                  </div>
                  <span class="progress-description">
                    <div id="porcientoJHERNANDEZ"></div>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button id="btn-calcular" class="btn btn-danger">Calcular Fondo</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Fondo | Detalle por Proveedor</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="comprador">*Comprador</label>
                  <select name="comprador" id="comprador" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <button id="btn-mostrar" class="btn btn-warning">Mostrar detalle</button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_fondos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='10%'>Cve. Prov.</th>
                        <th>Proveedor</th>
                        <th width='10%'>Fondo</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer">
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
      cargar_tabla();
    });
    $('#comprador').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "consulta_compradores.php",
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

    function totales(id_comprador, div) {
      var url = "consulta_totales.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_comprador: id_comprador
        },
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#total" + div).html(array[0]);
          $("#porciento" + div).html(array[1] + " del total general");
          $("#prgrs" + div).attr("style", "width: " + array[1]);
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }
    $("#btn-calcular").click(function() {
      totales(7, 'GCHARUR');
      totales(8, 'ARAMIREZ');
      totales(9, 'JREYNA');
      totales(10, 'JHERNANDEZ');
      totales(11, 'CWEINMANN');
      totales(34, 'FRODRIGUEZ');
    });

    function cargar_tabla() {
      var comprador = $("#comprador").val();
      $('#lista_fondos').dataTable().fnDestroy();
      $('#lista_fondos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
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
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_fondos.php",
          "dataSrc": "",
          "data":{
            comprador: comprador
          }
        },
        "columns": [{
            "data": "clave_proveedor"
          },
          {
            "data": "nombre_proveedor"
          },
          {
            "data": "total"
          }
        ]
      });
    }
    $("#btn-mostrar").click(function(){
      cargar_tabla();
    })
  </script>
</body>

</html>