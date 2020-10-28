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
      <?php include 'menuV.php'; ?>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-6">
            <form method="POST" id="form-catalogo" enctype="multipart/form-data">
              <div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Control de Producción | Importación de catálogo</h3>
                </div>
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="documento">*Documento</label>
                        <input name="action" type="hidden" value="upload" id="action" />
                        <input type="file" name="file">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="descripcion">*Departamento</label>
                        <input type="text" name="departamento" id="departamento" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="box-footer text-right">
                  <button class="btn btn-warning" id="btn-guardar">Cargar Archivo</button>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Control de Producción | Registro manual</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="codigo">*Código</label>
                      <input type="text" name="codigo" id="codigo" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="unidad_medida">*U.M.</label>
                      <input type="number" name="unidad_medida" id="unidad_medida" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="departamento">*Departamento</label>
                      <input type="text" name="depto" id="depto" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <button class="btn btn-danger" id="btn-manual">Registrar artículo</button>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Artículos registrados</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table id="lista_articulos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th width="12%">Departamento</th>
                            <th width="8%">Código</th>
                            <th width="15%">Código</th>
                            <th>Descripción</th>
                            <th width="10%">Costo U.M.</th>
                            <th width="10%">U.M.</th>
                            <th width="5%">C.U.</th>
                            <th width="5%">Imp.</th>
                            <th width="5%">Total</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
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
    $(function() {
      cargar_tabla();
    })
    $(":file").filestyle('buttonText', 'Seleccionar');
    $(":file").filestyle('size', 'sm');
    $(":file").filestyle('input', true);
    $(":file").filestyle('disabled', false);
    $('#form-catalogo').submit(function(e) {
      if ($("#action").val() == "" || $("#folio_descripcion").val() == "") {
        alertify.error("Datos incompletos.");
      } else {
        var data = new FormData(this); //Creamos los datos a enviar con el formulario
        $.ajax({
          url: 'importar_articulos.php', //URL destino
          data: data,
          processData: false, //Evitamos que JQuery procese los datos, daría error
          contentType: false, //No especificamos ningún tipo de dato
          type: 'POST',
          success: function(resultado) {
            if (resultado == "ok") {
              swal("Satisfactorio!!", "El registro del catálogo ha sido realizado", "success");
            } else if (resultado == "invalido") {
              alertify.error("El archivo que intenta subir no es válido");
            }
            $(":text").val("");
            cargar_tabla();
          }
        });
      }
      e.preventDefault(); //Evitamos que se mande del formulario de forma convencional
    });

    function cargar_tabla() {
      $('#lista_articulos').dataTable().fnDestroy();
      $('#lista_articulos').DataTable({
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
            title: 'Modulos-Lista',
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
          {
            text: 'Actualizar costos',
            action: function() {
              actualizaCostos();
            },
            counter: 1
          },
          {
            text: 'Actualizar recetas',
            action: function() {
              actualizaRecetas();
            },
            counter: 1
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_articulos.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "departamento"
          },
          {
            "data": "cod"
          },
          {
            "data": "codigo"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "costo_um"
          },
          {
            "data": "um"
          },
          {
            "data": "costo_unitario"
          },
          {
            "data": "impuesto"
          },
          {
            "data": "total"
          }
        ]
      });
    }

    function actualizaCostos() {
      $('#lista_articulos').dataTable().fnClearTable();
      swal("Los registros se están actualizando, espere...", {
        icon: "info",
        closeOnClickOutside: false,
        buttons: false
      });
      var url = "actualizar_costos.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: "", // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "ok") {
            swal("La tabla ha sido actualizada correctamente", {
              icon: "success",
            });
            cargar_tabla();
          }
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    }

    function actualizaRecetas() {
      swal("Los registros se están actualizando, espere...", {
        icon: "info",
        closeOnClickOutside: false,
        buttons: false
      });
      var url = "actualizar_recetas.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: "", // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "ok") {
            swal("Las recetas han sido actualizadas correctamente", {
              icon: "success",
            });
          }
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    }

    function cambiar_codigo(id_registro) {
      var url = "actualizar_codigo.php";
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
          alertify.success("El código ha sido actualizado");
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      cargar_tabla();
      return false;
    }

    function cambiar_um(id_registro) {
      var url = "actualizar_um.php";
      var folio = $("#um_" + id_registro).val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          folio: folio,
          id_registro: id_registro
        },
        success: function(respuesta) {
          alertify.success("El código ha sido actualizado");
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      cargar_tabla();
      return false;
    }
    $("#btn-manual").click(function() {
      if ($("#codigo").val() == "" || $("#unidad_medida").val() == "" || $("#depto").val() == "") {
        alertify.error("Favor de llenar todos los campos");
      } else {
        var url = "inserta_manual.php";
        var codigo = $("#codigo").val();
        var unidad_medida = $("#unidad_medida").val();
        var depto = $("#depto").val();
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: {
            codigo: codigo,
            unidad_medida: unidad_medida,
            depto: depto
          },
          success: function(respuesta) {
            alertify.success("El código ha sido registrado");
          },
          error: function(xhr, status) {
            alert("error");
            //alert(xhr);
          },
        });
        cargar_tabla();
      }
      return false;
    })
  </script>
</body>

</html>