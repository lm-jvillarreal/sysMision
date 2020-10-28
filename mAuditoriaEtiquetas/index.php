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
        <div class="box box-danger" id="contenedor_solicitud">
          <div class="box-header">
            <h3 class="box-title">Etiquetas | Auditoría</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nombre">*Nombre</label>
                  <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Referencia Solicitud">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="formato">*Formato</label>
                  <select name="formato" id="formato" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-guardarSolicitud">Guardar Datos</button>
          </div>
        </div>
        <div class="box box-danger" id="contenedor_detalle" style="display: none">
          <div class="box-header">
            <h3 class="box-title">Etiquetas | Detalle de Auditoría</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <input type="hidden" id="id_solicitud">
                  <label for="codigo">*Código</label>
                  <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Ingresa el código de producto" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="descripcion">*Descripción</label>
                  <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripcion del producto">
                </div>
              </div>
              <div class="col-md-2 col-xs-6">
                <div class="form-group">
                  <label for="precio_venta">*P. Regular</label>
                  <input type="text" class="form-control" name="precio_venta" id="precio_venta">
                </div>
              </div>
              <div class="col-md-2 col-xs-6">
                <div class="form-group">
                  <label for="oferta">*P. Oferta</label>
                  <input type="text" class="form-control" name="oferta" id="oferta">
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-guardarDetalle">Guardar Detalle</button>
          </div>
        </div>
        <div class="box box-danger" id="contenedor_tabla" style="display: none">
          <div class="box-header">
            <h3 class="box-title">Etiquetas | Lista Detalle</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <form action="" method="POST" id="form_detalle">
                    <table id="lista_detalle" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th width='5%'>#</th>
                          <th width="10%">Código</th>
                          <th>Descripción</th>
                          <th width="15%">Cantidad</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>#</th>
                          <th>Código</th>
                          <th>Descripción</th>
                          <th>Cantidad</th>
                        </tr>
                      </tfoot>
                    </table>
                  </form>
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
    $('#formato').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "consulta_formatos.php",
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
    $("#btn-guardarSolicitud").click(function() {
      if ($("#nombre").val() == "" || $("#formato").val() == "") {
        swal("Falta información", "Favor de completar toda la información requerida", "error");
      } else {
        $("#contenedor_detalle").removeAttr("style");
        $("#contenedor_solicitud").css('display', ' none');
        $("#contenedor_tabla").removeAttr("style");

        var url = "insertar_solicitud.php";
        var nombre = $("#nombre").val();
        var formato = $("#formato").val();
        var id = "";
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: {
            nombre: nombre,
            formato: formato
          },
          success: function(respuesta) {
            id_solicitud = respuesta;
            cargar_tabla(id_solicitud);
            $("#id_solicitud").val(id_solicitud);
          },
          error: function(xhr, status) {
            alert("error");
            //alert(xhr);
          },
        })
      }
    });
    $("#btn-guardarDetalle").click(function() {
      var url = "solicitar_detalle.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: $("#form_detalle").serialize(),
        success: function(respuesta) {
          alertify.success("Etiquetas solicitadas correctamente");
          window.location.href = "index.php";
        },
        error: function(xhr, status) {
          alert("error");
        }
      });
    });
    $("#codigo").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = "consulta_productos.php"; // El script a dónde se realizará la petición.
        var codigo = $("#codigo").val();
        if (codigo == "") {

        } else {
          $.ajax({
            type: "POST",
            url: url,
            data: {
              codigo: codigo
            }, // Adjuntar los campos del formulario enviado.
            success: function(respuesta) {
              var array = eval(respuesta);
              $('#descripcion').val(array[0]);
              $("#precio_venta").val(array[1]);
              $("#oferta").val(array[2]);
              inserta_detalle();
              $("#codigo").val("");
            }
          });
        }
        return false;
      }
    });

    function cargar_tabla(id_solicitud) {
      $('#lista_detalle').dataTable().fnDestroy();
      $('#lista_detalle').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "order": [
          [0, "desc"]
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_detalle.php",
          "dataSrc": "",
          "data": {
            id_solicitud: id_solicitud
          }
        },
        "columns": [{
            "data": "no"
          },
          {
            "data": "codigo"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "cantidad"
          }
        ]
      });
    }

    function inserta_detalle() {
      var codigo = $("#codigo").val();
      var descripcion = $("#descripcion").val();
      var formato = $("#formato").val();
      var ide_solicitud = $("#id_solicitud").val();
      var url = "insertar_detalle.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {
          codigo: codigo,
          descripcion: descripcion,
          ide_solicitud: ide_solicitud,
          formato: formato
        },
        success: function(response) {
          cargar_tabla(ide_solicitud);
        }
      });
    };

    function act_cantidad(cantidad, id) {
      var ide_solicitud = $("#id_solicitud").val();
      var url = "actualizar_cantidad.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {
          cantidad: cantidad,
          id: id
        },
        success: function(response) {
          //cargar_tabla(ide_solicitud);
        }
      });
      return false;
    }
  </script>
</body>

</html>