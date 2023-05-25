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
            <h3 class="box-title">Proveedores | Registro</h3>
          </div>
          <form action="" method="POST" id="form-proveedores">
            <div class="box-body">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="hidden" name="ide_prov" id="ide_prov">
                    <label for="clave_proveedor">*Cve. Prov.</label>
                    <input type="text" name="clave_proveedor" id="clave_proveedor" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nombre_proveedor">*Proveedor</label>
                    <input type="text" name="nombre_proveedor" id="nombre_proveedor" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <label for="tipo_proveedor">*Tipo proveedor:</label>
                  <select name="tipo_proveedor" id="tipo_proveedor" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="correo_prov">*Correo Electrónico</label>
                    <input type="text" name="correo_prov" id="correo_prov" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="id_comprador">*Comprador</label>
                    <select name="id_comprador" id="id_comprador" class="form-control">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="dificultad">*Dificultad</label>
                    <select name="dificultad" id="dificultad" class="form-control">
                      <option value=""></option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-guardar">Guardar Registro</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Proveedores | Lista</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_proveedores" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <th width="5%">#</th>
                      <th width="10%">Clave</th>
                      <th>Proveedor</th>
                      <th width="15%">Correo</th>
                      <th width='15%'>Tipo</th>
                      <th width='15%'>Comprador</th>
                      <th width='5%'>CEDIS</th>
                      <th width='5%'>ESCARG</th>
                      <th width='5%'></th>
                    </thead>
                    <tbody></tbody>
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
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <!-- Page script -->
  <script>
    $('#tipo_proveedor').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "consulta_tipo_proveedor.php",
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
    $('#id_comprador').select2({
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
    $("#dificultad").select2({
      placeholder: "Seleccione una opción",
      lenguage: "es",
      minimumResultForSearch: Infinity
    });
    $("#clave_proveedor").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = "consulta_proveedor.php"; // El script a dónde se realizará la petición.
        var clave_proveedor = $("#clave_proveedor").val();
        $.ajax({
          type: "POST",
          url: url,
          data: {
            clave_proveedor: clave_proveedor
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            $('#nombre_proveedor').val("");
            if (respuesta == "no") {
              alertify.error("El proveedor no existe");
              $('#clave_proveedor').val("");
            }
            var array = eval(respuesta);
            $('#nombre_proveedor').val(array[1]);
          }
        });
        return false;
      }
    });

    function cargar_tabla() {
      $('#lista_proveedores thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      $('#lista_proveedores').dataTable().fnDestroy();
      var table = $('#lista_proveedores').DataTable({
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
            title: 'ListaActividades',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'ListaActividades',
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
          "url": "tabla_proveedores.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "#"
          },
          {
            "data": "clave"
          },
          {
            "data": "proveedor"
          },
          {
            "data": "correo"
          },
          {
            "data": "tipo"
          },
          {
            "data": "comprador"
          },
          {
            "data": "cedis"
          },
          {
            "data": "escarg"
          },
          {
            "data": "eliminar"
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
    };

    function datos_editar(id) {
      var url = "consulta_datos_editar.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id: id
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#ide_prov').val(array[0]);
          $('#clave_proveedor').val(array[1]);
          $('#nombre_proveedor').val(array[2]);
          $('#correo_prov').val(array[3]);
          $("#id_comprador").select2("trigger", "select", {
            data: {
              id: array[4],
              text: array[5]
            }
          });
          $("#tipo_proveedor").select2("trigger", "select", {
            data: {
              id: array[6],
              text: array[7]
            }
          });
          $("#dificultad").select2("trigger", "select", {
            data: {
              id: array[8],
              text: array[8]
            }
          });
        }
      });
    };
    $("#btn-guardar").click(function() {
      var url = "insertar_proveedor.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: $("#form-proveedores").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("El registro ha sido manipulado correctamente");
          }else if(respuesta=="repetido"){
            alertify.error("El registro ya existe");
          }
          $(":text").val(''); //Limpiar los campos tipo Text
        }
      });
      // Evitar ejecutar el submit del formulario.
      //cargar_tabla();
      return false;
    });
    $(document).ready(function() {
      $("#clave_proveedor").focus();
      cargar_tabla();
    });

    function cambiar(id_registro) {
      var url = "cedis_proveedor.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id_registro: id_registro
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("El registro ha sido modificado correctamente");
          }
        }
      });
      return false;
    }

    function escarg(id_registro) {
      var url = "escarg_proveedor.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id_registro: id_registro
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("El registro ha sido modificado correctamente");
          }
        }
      });
      return false;
    }
    function eliminar(id_registro){
      var url = "eliminar_proveedor.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id_registro: id_registro
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("El registro ha sido eliminado correctamente");
          }
        }
      });
      return false;
    }
  </script>
</body>

</html>