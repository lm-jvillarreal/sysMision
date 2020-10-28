<?php
include '../global_seguridad/verificar_sesion.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
</head>
<style>
  #modal_teoricos {
    width: 80% !important;
  }
</style>

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
            <h3 class="box-title">Control de Producción | Lista de recetas</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="lista_recetas">*Lista de recetas</label>
                  <select name="lista_recetas" id="lista_recetas" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button id="btn-detalle" class="btn btn-danger">Mostrar Receta</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Control de Producción | Registro de recetas</h3>
          </div>
          <div class="box-body">
            <form action="" method='POST' id='form-receta'>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="">*Código</label>
                    <input type="hidden" name="id_receta" id="id_receta">
                    <input type="text" name="codigo" id="codigo" class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="nombre_receta">*Nombre receta</label>
                    <input type="text" name="nombre_receta" id="nombre_receta" class="form-control">
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label for="nombre_receta">*IEPS (%)</label>
                    <input type="text" name="ieps" id="ieps" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="rendimiento">*Kg. Porción</label>
                    <input type="number" name="rendimiento" id="rendimiento" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="rendimiento">*Margen operativo (%)</label>
                    <input type="number" name="margen_operativo" id="margen_operativo" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="rendimiento">*Margen sugerido (%)</label>
                    <input type="number" name="margen_sugerido" id="margen_sugerido" class="form-control">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-guardar">Actualizar receta</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Control de Producción | Detalle de ingrendientes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="articulo">*Artículo</label>
                  <input type="text" name="articulo" id="articulo" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="descripcion">*Descripción</label>
                  <input type="text" name="descripcion" id="descripcion" class="form-control" readonly>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer">
            <div class="row">
              <div class="col-md-6 text-left">
                <button class="btn btn-warning" id="btn-agregar" disabled="true">Agregar artículo</button>
              </div>
              <div class="col-md-6 text-right">
                <button class="btn btn-danger" id="btn-finalizar" disabled="true">Finalizar receta</button>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Control de Producción | Detalle de ingrendientes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_detalle" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <th width="5%">#</th>
                      <th width="10%">Código</th>
                      <th>Descripción</th>
                      <th width='10%'>Cantidad</th>
                      <th width="10%">C.U.</th>
                      <th width="10%">Total</th>
                    </thead>
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
    <?php //include 'modal_teoricos.php'; 
    ?>
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
    $('#lista_recetas').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "select_recetas.php",
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
    $(document).ready(function(e) {
      cargar_tabla();
    })
    $('#btn-guardar').click(function() {
      if ($("#codigo").val() == "" || $("#nombre_receta").val() == "" || $("#rendimiento").val() == "" || $("#margen_operativo").val() == "" || $("#margen_sugerido").val() == "") {
        alertify.error("Favor de rellenar todos los datos");
      } else {
        var url = "actualizar_receta.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: $('#form-receta').serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            alertify.success("Receta actualizada correctamente");
            $("#form-receta")[0].reset();
            cargar_tabla();
          }
        });
      }
      return false;
    });
    $('#btn-finalizar').click(function() {
      var id_receta = $("#id_receta").val();
      var url = "finalizar_receta.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id_receta: id_receta
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          alertify.success("Receta finalizada correctamente");
          $("#form-receta")[0].reset();
          $("#codigo").removeAttr("readonly");
          $("#nombre_receta").removeAttr("readonly");
          $("#rendimiento").removeAttr("readonly");
          $("#margen_operativo").removeAttr("readonly");
          $("#margen_sugerido").removeAttr("readonly");
          $("#articulo").attr("readonly", true);
          $("#descripcion").val();
          $("#btn-guardar").removeAttr("disabled");
          $("#btn-finalizar").attr("disabled", true);
          $("#codigo").focus();
          cargar_tabla();
        }
      });
      return false;
    });
    $("#articulo").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = "consulta_descripcion.php"; // El script a dónde se realizará la petición.
        var articulo = $("#articulo").val();
        $.ajax({
          type: "POST",
          url: url,
          data: {
            articulo: articulo
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "no_existe") {
              alertify.error("El artículo no existe");
            } else {
              $("#descripcion").val(respuesta);
              $("#btn-agregar").removeAttr("disabled");
            }
          }
        });
        return false;
      }
    });
    $("#codigo").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = "consulta_articulo.php"; // El script a dónde se realizará la petición.
        var codigo = $("#codigo").val();
        $.ajax({
          type: "POST",
          url: url,
          data: {
            codigo: codigo
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            var array = eval(respuesta);
            $("#nombre_receta").val(array[0]);
            $("#ieps").val(array[1]);
          }
        });
        return false;
      }
    });
    $("#btn-agregar").click(function() {
      var url = "insertar_detalle.php"; // El script a dónde se realizará la petición.
      var id_receta = $("#id_receta").val();
      var codigo = $("#codigo").val();
      var articulo = $("#articulo").val();
      var descripcion = $("#descripcion").val();
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id_receta: id_receta,
          codigo: codigo,
          articulo: articulo,
          descripcion: descripcion
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "no_existe") {
            alertify.error("El artículo no existe");
          } else {
            $("#descripcion").val("");
            $("#articulo").val("");
            $("#articulo").focus();
            cargar_tabla();
            $("#btn-finalizar").removeAttr("disabled");
            $("#btn-agregar").attr("disabled", true);
          }
        }
      });
      return false;
    })

    function cargar_tabla() {
      var id_receta = $("#id_receta").val();
      $('#lista_detalle').dataTable().fnDestroy();
      $('#lista_detalle').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "order": [
          [0, "desc"]
        ],
        "dom": 'Bfrtip',
        buttons: [{
            extend: 'excel',
            text: 'Exportar a Excel',
            className: 'btn btn-default',
            title: 'AuditoriaPV',
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
          "url": "tabla_detalle.php",
          "dataSrc": "",
          "data": {
            id_receta: id_receta
          }
        },
        "columns": [{
            "data": "num"
          },
          {
            "data": "codigo"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "costo_unitario"
          },
          {
            "data": "total"
          }
        ]
      });
    };

    function cambiar_cantidad(id_registro) {
      var url = "actualizar_cantidad.php";
      var folio = $("#id_" + id_registro).val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          folio: folio,
          id_registro: id_registro
        },
        success: function(respuesta) {
          alertify.success("La cantidad ha sido actualizada");
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      cargar_tabla();
      return false;
    }
    $("#btn-detalle").click(function() {
      if ($("#lista_recetas").val() == "") {
        alertify.error("Selecciona una receta");
      } else {
        var url = "mostrar_receta.php";
        var id_receta = $("#lista_recetas").val();
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: {
            id_receta: id_receta
          },
          success: function(respuesta) {
            var array = eval(respuesta);
            $("#id_receta").val($("#lista_recetas").val());
            $("#codigo").val(array[0]);
            $("#nombre_receta").val(array[1]);
            $("#ieps").val(array[2]);
            $("#rendimiento").val(array[3]);
            $("#margen_operativo").val(array[4]);
            $("#margen_sugerido").val(array[5]);
            $("#articulo").removeAttr("readonly");
            $("#btn-agregar").removeAttr("disabled");
            $("#btn-finalizar").removeAttr("disabled");
            $("#articulo").focus();
            cargar_tabla();
          },
          error: function(xhr, status) {
            alert("error");
            //alert(xhr);
          },
        });
      }
    });
  </script>
</body>

</html>