<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')));
$hora = date("h:i:s");
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <script type="text/javascript" src="funciones.js?v=<?php echo (rand()) ?>"></script>
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
            <h3 class="box-title">Inventarios | Auditoria</h3>
          </div>
          <div class="box-body">
            <form>
              <div class="row">
                <div class="col-lg-4">
                  <label>Folio</label>
                  <input type="text" class="form-control" id="txtId" name="">
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer">
            <a href="#" class="btn btn-danger" onclick="GetDetalleMapeo()">Buscar</a>
          </div>
        </div>
        <div class="box box-danger" style="display: none;" id="detalle_mapeo">
          <div class="box-header">
            <h3 class="box-title">Inventario | Auditoria</h3>
          </div>
          <div class="box-body">
            <div id="contenedor_tabla">
            </div>
          </div>
          <div class="box-footer text-right">
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
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <script type="text/javascript">
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity,
      ajax: {
        url: "consulta_sucursales.php",
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
  </script>

  <script>
    $(document).ready(function() {
      $('#example').dataTable({

        "lengthMenu": [
          [-1],
          ["All"]
        ],

        "language": {
          "url": "../assets/js/Spanish.json"
        }
      });
    });
  </script>
  <script>
    $(function() {
      $('#cmbArea').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: {
          url: "consulta_areas.php",
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
    })
  </script>
  <script type="text/javascript">
    function insert() {
      $.ajax({
        url: "insertar_mapeo.php",
        type: "POST",
        dateType: "html",
        data: $('#frmDatosMapeo').serialize(),
        success: function(respuesta) {
          if (respuesta == "false") {
            alert("Este mapeo ya existe, intenta con otros valores");
            $('#habilitar').modal('show');
          } else {
            $('#txtCara').attr('readonly', 'true');
            $('#txtMueble').attr('readonly', 'true');
            $('#txtZona').attr('readonly', 'true');
            $('#btnGuardar').attr('disabled', 'true');
            $('#txtEstante').val(1);
            $('#txtCodigo').removeAttr('readonly');
            $('#btnFinalizar').removeAttr('disabled');
            $('#btnCambiar').removeAttr('disabled');
            $('#cmbArea').attr('disabled');
            $('#id_mapeo').val(respuesta);
          }
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }
  </script>
  <script type="text/javascript">
    function GetDetalleMapeo() {
      var id_mapeo = $('#txtId').val();
      let datos = {
        id_mapeo: id_mapeo
      };
      $.ajax({
        url: "tabla_detalle_mapeo.php",
        type: "POST",
        dateType: "html",
        data: datos,
        success: function(respuesta) {
          $('#detalle_mapeo').show();
          $('#contenedor_tabla').html(respuesta);
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }

    
  </script>

  <script type="text/javascript">
    function InsertAuditoria(IdDetalleMapeo, IdCaptura, CantidadAnterior, CantidadNueva) {
      let datos = {
        IdDetalleMapeo: IdDetalleMapeo,
        IdCaptura: IdCaptura,
        CantidadAnterior: CantidadAnterior,
        CantidadNueva: CantidadNueva
      };
      $.ajax({
        url: "insertar_auditoria.php",
        type: "POST",
        dateType: "html",
        data: datos,
        success: function(respuesta) {
          alertify.success("Guardado")
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }
  </script>
  <script type="text/javascript">
    function cargar_tabla(id_mapeo) {
      $.ajax({
        url: "tabla_detalle_mapeo.php",
        type: "POST",
        dateType: "html",
        data: {
          'id_mapeo': id_mapeo
        },
        success: function(respuesta) {
          $('#contenedor_tabla').html(respuesta);
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }
  </script>
  <script type="text/javascript">
    function finalizar() {
      var id_mapeo = $('#id_mapeo').val();
      $.ajax({
        url: "guardar_mapeo.php",
        type: "POST",
        dateType: "html",
        data: {
          'id_mapeo': id_mapeo
        },
        success: function(respuesta) {
          alert("Mapeo registrado");
          location.reload();
          //$('#contenedor_tabla').html(respuesta);
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }
  </script>
  <script type="text/javascript">
    function cambiar_estante() {
      var estante = $('#txtEstante').val();
      var n_es = parseInt(estante) + 1;
      $('#txtEstante').val(n_es);
      $('#txtConsecutivo').val(1);
    }
  </script>
  <script type="text/javascript">
    function mostrar_importar() {
      $('#div_datos').hide();
      $('#div_importar').show();
    }
  </script>
  <script type="text/javascript">
    function subir_excel() {
      var id_mapeo = $('#id_mapeo').val();
      var parametros = new FormData($("#importa")[0]);

      $.ajax({
        data: parametros, //datos que se envian a traves de ajax
        url: '../plugins/excelamysql/importar.php', //archivo que recibe la peticion
        type: 'post', //método de envio
        contentType: false,
        processData: false,
        beforesend: function() {

        },
        success: function(response) {
          cargar_tabla(id_mapeo);

        }
      });
    }
  </script>
</body>

</html>