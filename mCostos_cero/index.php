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
        <form method="POST" id="form-costos">
          <div class="box box-danger" <?php echo $solo_lectura ?>>
            <div class="box-header">
              <h3 class="box-title">Registro de artículos | Costo Cero</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="codigo">*Código</label>
                    <input type="text" name="codigo" id="codigo" class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descripcion">*Descripción</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <label for="sucursal">*Sucursal</label>
                  <select name="sucursal" id="sucursal" class="form-control">
                    <option value=""></option>
                    <option value="1">Díaz Ordaz</option>
                    <option value="2">Arboledas</option>
                    <option value="3">Villegas</option>
                    <option value="4">Allende</option>
                    <option value="5">Petaca</option>
                    <option value="99">CEDIS</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <label for="comentario">*Comentario</label>
                  <select name="comentario" id="comentario" class="form-control">
                    <option value=""></option>
                    <option value="COSTO CERO EN OTRAS TIENDAS">Costo Cero en otras tiendas</option>
                    <option value="CON INVENTARIO TEORICO EN TIENDAS">Con Inventario Teórico en tiendas</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="box-footer text-right">
              <button class="btn btn-warning" id="btn-guardar">Guardar Registro</button>
            </div>
          </div>
        </form>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Control de Articulos | Costo Cero</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div id="totales"></div><br><br>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_costosCero" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='5%'>#</th>
                        <th width='10%'>Código</th>
                        <th width='10%'>Código</th>
                        <th>Descripción</th>
                        <th width='5%'>Costo</th>
                        <th width='10%'>Sucursal</th>
                        <th width='10%'>P. Venta</th>
                        <th width='20%'>Comentarios</th>
                        <th width='5%'>Baja</th>
                        <th width='5%'>Estatus</th>
                        <th width='5%'>Liberar</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Costo</th>
                        <th>Sucursal</th>
                        <th>P. Venta</th>
                        <th>Comentarios</th>
                        <th>Baja</th>
                        <th>Estatus</th>
                        <th>Liberar</th>
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
    <?php include 'modal_costos.php'; ?>
    <?php include 'modal_ventas.php'; ?>
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
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
    });
    $('#comentario').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
    });

    function consulta_descripcion() {
      var url = "consulta_descripcion.php";
      var codigo = $("#codigo").val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          codigo: codigo
        },
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#descripcion").val(array[0]);
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      return false;
    }
    $("#codigo").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        consulta_descripcion();
        return false;
      }
    });
    $("#btn-guardar").click(function() {
      var url = "insertar_registro.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: $('#form-costos').serialize(),
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Código registrado correctamente");
            cargar_tabla();
          } else if (respuesta == 'repetido') {
            alertify.error('El código ya existe');
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      //cargar_tabla();
      $(":text").val('');
      return false;
    });

    function cargar_tabla() {
      $('#lista_costosCero').dataTable().fnDestroy();
      $('#lista_costosCero').DataTable({
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
            extend: 'pdf',
            text: 'Exportar a PDF',
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
          "url": "lista_codigos.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "id"
          },
          {
            "data": "codigo"
          },
          {
            "data": "codigo2"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "costo"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "pv"
          },
          {
            "data": "comentario"
          },
          {
            "data": "baja"
          },
          {
            "data": "estatus"
          },
          {
            "data": "liberar"
          }
        ]
      });
    }
    $(document).ready(function() {
      cargar_tabla();
    });
    $('#modal-costos').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data().id;
      $("#ide").val(id);
    });
    $("#btn-costos").click(function() {
      var url = "actualiza_costos.php";
      var id = $("#ide").val();
      var costo = $("#costo").val();
      var comentario = $("#comentario-verifica").val();
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id: id,
          comentario: comentario,
          costo: costo
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          $('#modal-costos').modal('hide');
          $("#ide").val("");
          $("#comentario-verifica").val("");
          $("#costo").val("");
          cargar_tabla();
        }
      });
    });

    function baja(codigo_artc) {
      var id_registro = codigo_artc;
      var url = 'baja_articulo.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          codigo_artc: codigo_artc
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Artículo deshabilitado correctamente");
            //cargar_tabla();
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      cargar_tabla();
    }

    function liberar(id_registro) {
      var id_registro = id_registro;
      var url = 'liberar_articulo.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_registro: id_registro
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Registro liberado correctamente");
            //cargar_tabla();
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      cargar_tabla();
    }
    $('#modal-ventas').on('show.bs.modal', function(e) {
      var articulo = $(e.relatedTarget).data().id;
      var suc = $(e.relatedTarget).data().suc;
      $('#res').html('<center><h4>Un momento, por favor...</h4><center>');
      var url = "contenido_modal_ventas.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          articulo: articulo,
          suc: suc
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          //$('#res').html(respuesta);
          $('#res').fadeIn(5000).html(respuesta);
        }
      });
    });
  </script>
</body>

</html>