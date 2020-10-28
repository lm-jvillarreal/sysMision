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
            <h3 class="box-title">Reportes de Inventario | Filtros</h3>
          </div>
          <div class="box-body">
            <form id="frmDatosMapeo">
              <div class="row">
                <div class="col-md-3">
                  <label>Sucursal</label>
                  <select class="form-control">
                    <option>Seleccione...</option>
                    <?php
                    $sql = "SELECT id, nombre FROM sucursales";
                    $exSql = mysqli_query($conexion, $sql);

                    while ($row = mysqli_fetch_row($exSql)) {
                      echo "<option value='$row[0]'>$row[1]</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer">
            <a href="#" class="btn btn-danger">Filtrar</a>
            <!-- <a href="#" id="btnGuardar" onclick="javascript:insert()" class="btn btn-danger">Guardar</a>
            
            <a href="#" onclick="javascript:finalizar()" class="btn btn-danger" id="btnFinalizar" disabled>Finalizar</a> -->
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Reportes de Inventario | Lista</h3>
          </div>
          <div class="box-body">
            <div id="contenedor_tabla">
              <?php include 'mapeos_dia.php'; ?>
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
  <script>
    $(document).ready(function() {
      $('#example').dataTable({
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
            title: 'NuevoMapeo',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'NuevoMapeo',
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
          }
        ],
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
    function insert_name(fecha, nombre, sucursal) {
      $.ajax({
        url: "insertar_nombre.php",
        type: "POST",
        dateType: "html",
        data: {
          'fecha': fecha,
          'nombre': nombre,
          'sucursal': sucursal
        },
        success: function(respuesta) {
          alertify.success("Guardado");
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
</body>

</html>