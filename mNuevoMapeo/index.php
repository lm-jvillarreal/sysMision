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
            <h3 class="box-title">Nuevo Mapeo | Registro</h3>
          </div>
          <div class="box-body" id="div_datos">
            <form id="frmDatosMapeo">
              <div class="row">
                <?php if ($solo_sucursal == 1) {
                  $s = "style='display: none'";
                } else {
                  $s = "";
                } ?>
                <div class="col-md-3" <?php echo $s ?>>
                  <label>Sucursal</label>
                  <select class="form-control" id="sucursal" name="cmbSucursal">
                    <option value=""></option>
                  </select>
                </div>
                <div class="col-md-3">
                  <label>Area</label>
                  <select id="cmbArea" name="cmbArea" class="form-control"></select>
                </div>
                <div class="col-md-3">
                  <label>Zona</label>
                  <input type="text" id="txtZona" name="txtZona" class="form-control">
                  <input type="hidden" id="id_mapeo" value="1" name="">
                </div>
                <div class="col-md-3">
                  <label>Mueble</label>
                  <input type="text" class="form-control" name="txtMueble" id="txtMueble">
                </div>
                <div class="col-md-3">
                  <label>Cara</label>
                  <input type="text" class="form-control" name="txtCara" id="txtCara">
                </div>
              </div>
            </form>
            <form id="frmDatosCodigo">
              <div class="row">
                <div class="col-md-3">
                  <label>Codigo</label>
                  <input type="number" readonly id="txtCodigo" onchange="javascript:insert_detalle();" name="txtCodigo" class="form-control">
                </div>
                <div class="col-md-3">
                  <label>Descripcion</label>
                  <input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control" readonly>
                </div>
                <div class="col-md-3">
                  <label>Estante</label>
                  <input type="text" readonly id="txtEstante" name="txtEstante" class="form-control">
                </div>
                <div class="col-md-3">
                  <label>Consecutivo</label>
                  <input type="text" readonly id="txtConsecutivo" value="1" class="form-control">
                </div>
              </div>
            </form>
          </div>
          <div class="box-body" id="div_importar" style="display: none">
            <form id="importa">
              <div class="row">
                <div class="col-md-4">
                  <input type="file" name="excel">
                </div>
                <div class="col-md-3">
                  <a href="#" onclick="javascript:subir_excel()" class="btn btn-danger">Enviar</a>
                  <a href="docs/importador.xlsx" class="btn btn-danger">Descargar importador</a>
                </div>
              </div>
            </form>



          </div>
          <div class="box-footer">
            <a href="#" class="btn btn-danger" onclick="javascript:mostrar_importar()" class="text-right">Importar</a>
            <a href="#" id="btnGuardar" onclick="javascript:insert()" class="btn btn-danger">Guardar</a>
            <a href="#" class="text-left btn btn-warning" onclick="javascript:cambiar_estante()" id="btnCambiar" disabled>Cambiar estante</a>
            <a href="#" onclick="javascript:finalizar()" class="btn btn-danger" id="btnFinalizar" disabled>Finalizar</a>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Nuevo Mapeo | Detalle del mapeo</h3>
          </div>
          <div class="box-body">
            <div id="contenedor_tabla">
              <table class="table">
                <thead>
                  <tr>
                    <th>Consecutivo</th>
                    <th>Estante</th>
                    <th>Codigo</th>
                    <th>Descripcion</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
          <div class="box-footer text-right">
          </div>
        </div>
        <!--          <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Cajas de articulos | Detalle</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <div id="contenedor_tabl2a"></div>
                </div>
              </div>
            </div>
          </div>
        </div> -->

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
    function insert_detalle() {
      var id_mapeo = $('#id_mapeo').val();
      var codigo = $('#txtCodigo').val();
      var estante = $('#txtEstante').val();
      var consecutivo = $('#txtConsecutivo').val();
      var descripcion = $('#txtDescripcion').val();

      let datos = {
        id_mapeo: id_mapeo,
        codigo: codigo,
        estante: estante,
        consecutivo: consecutivo,
        descripcion: descripcion
      };
      $.ajax({
        url: "insertar_detalle.php",
        type: "POST",
        dateType: "html",
        data: datos,
        success: function(respuesta) {
          console.log(respuesta);
          if (respuesta == "false") {
            alert("Este articulo no existe en la Base de Datos");
            $('#txtCodigo').val('');

          } else {
            $('#txtDescripcion').val(respuesta);
            cargar_tabla(id_mapeo);
            var c = parseInt(consecutivo) + 1;
            $('#txtConsecutivo').val(c);
            $('#txtCodigo').val('');
          }
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