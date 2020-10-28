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
      <?php include '../header.php';
      ?>
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
            <h3 class="box-title">Captura Inventarios | Registro</h3>
          </div>
          <div class="box-body">
            <form id="frmDatosMapeo">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Area</label>
                    <select id="cmbArea" name="cmbArea" class="form-control"></select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Zona</label>
                    <input type="text" id="txtZona" name="txtZona" class="form-control">
                    <input type="hidden" id="id_mapeo" name="">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Mueble</label>
                    <input type="text" class="form-control" name="txtMueble" id="txtMueble">
                  </div>

                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Fecha</label>
                    <input type="date" class="form-control" name="fecha" id="fecha_conteo_i1">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer">

            <a href="#" id="btnGuardar" onclick="javascript:guardar_ca($('#id_mapeo').val())" class="btn btn-danger">Guardar Captura</a>
            <a href="#" onclick="javascript:mostrar_lista()" class="btn btn-danger">Lista</a>
            <a href="#" onclick="javascript:agregar($('#id_mapeo').val())" class="btn btn-danger">Agregar codigo</a>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Captura Inventarios | Lista</h3>
          </div>
          <div class="box-body">
            <div id="contenedor_tabla_detalle" style="display: none">

            </div>
            <div id="contenedor_tabla">
              <?php include 'tabla_lista_mapeos.php'; ?>
              <!--               <table class="table">
                <thead>
                  <tr>
                    <th>Sucursal</th>
                    <th>Area</th>
                    <th>Zona</th>
                    <th>Mueble</th>
                    <th>Cara</th>
                    <th>Fecha</th>
                    <th>Capturar</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table> -->
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
      <?php include 'modal_agregar.php'; ?>
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
  <script type="text/javascript">
    function agregar(id_mapeo) {
      $('#id_mapeoModal').val(id_mapeo);
      $('#agregar_p').modal('show');
    }
  </script>
  <script>
    $(document).ready(function() {
      tabla_inicio();
    });

    function tabla_inicio() {
      $('#lista_mapeos thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      $('#lista_mapeos').dataTable().fnDestroy();
      var table = $('#lista_mapeos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        select: {
          style: 'multi'
        },
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
            title: 'FaltantesComprador',
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


    function recargar_tabla(id_mapeo) {
      $.ajax({
        url: "tabla_captura.php",
        type: "POST",
        dateType: "html",
        data: {
          'id_mapeo': id_mapeo
        },
        success: function(respuesta) {
          $('#contenedor_tabla_detalle').html(respuesta);
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
    function consulta_codigo(codigo) {

      let datos = {
        codigo: codigo
      };
      $.ajax({
        url: "consulta_descripcion.php",
        type: "POST",
        dateType: "html",
        data: datos,
        success: function(respuesta) {
          console.log(respuesta);
          var e = eval(respuesta);
          $('#descripcionM').val(e[0]);
          $('#cantidadM').focus();
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }

    function insert_extra(id_mapeo) {
      $.ajax({
        url: "insertar_detalle.php",
        type: "POST",
        dateType: "html",
        data: $('#frmArticulo_extra').serialize(),
        success: function(respuesta) {
          recargar_tabla(id_mapeo);
          $('#txtCodProd').val('');
          $('#descripcionM').val('');
          $('#cantidadM').val('');
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }
  </script>
</body>

</html>