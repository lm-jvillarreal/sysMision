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
      <?php include 'menuV2.php'; ?>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <form method="POST" id="form-catalogo">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Monitoreo de Teóricos | Registro de Folio</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descripcion">*Descripción</label>
                    <input type="hidden" name="folio_registro" id="folio_registro">
                    <input type="text" name="descripcion" id="descripcion" class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="articulo">*Artículo</label>
                    <input type="text" name="articulo" id="articulo" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="descripcionArticulo">*Artc. Descripción</label>
                    <input type="text" name="descripcionArticulo" id="descripcionArticulo" class="form-control" readonly="true">
                  </div>
                </div>
              </div>
            </div>
            <div class="box-footer text-right">
              <button class="btn btn-warning" id="btn-finalizar">Finalizar Captura</button>
            </div>
          </div>
        </form>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Módulos Existentes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_modulos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">Folio</th>
                        <th>Descripción</th>
                        <th width="15%">Cantidad</th>
                        <th width="10%">Fecha</th>
                        <th width="10%">Usuario</th>
                        <th width="5%"></th>
                        <th width="5%"></th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th width="5%">Folio</th>
                        <th>Descripción</th>
                        <th width="15%">Cantidad</th>
                        <th width="10%">Fecha</th>
                        <th width="10%">Usuario</th>
                        <th width="5%"></th>
                        <th width="5%"></th>
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
    <?php include 'modal_teoricos.php'; ?>
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

    function cargar_tabla() {
      $('#lista_modulos').dataTable().fnDestroy();
      $('#lista_modulos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "order": [
          [0, "desc"]
        ],
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
						extend: 'pdf',
						text: 'Exportar a PDF',
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
            text: 'Lista de Modulos',
            action: function() {
              alert('hola');
            },
            counter: 1
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_folios.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "fecha"
          },
          {
            "data": "usuario"
          },
          {
            "data": "ver"
          },
          {
            "data": "eliminar"
          }
        ]
      });
    }

    function cargar_tabla2() {
      $('#lista_teoricos thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      $('#lista_teoricos').dataTable().fnDestroy();
      var table = $('#lista_teoricos').DataTable({
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
            text: 'Actualizar descripciones',
            className: 'red',
            action: function() {
              actualizaDescripcion();
            },
            counter: 1
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

    function eliminar(folio) {
      var url = "eliminar_folio.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          folio: folio
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          alertify.success("Folio eliminado correctamente");
          cargar_tabla();
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    }

    function eliminar_codigo(folio) {
      var url = "eliminar_codigo.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          folio: folio
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          alertify.success("Registro eliminado correctamente");
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    }

    function cargar_folio() {
      var url = "nuevo_folio.php";
      $.ajax({
        type: "POST",
        url: url,
        data: "", // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#folio_registro").val(array[0]);
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    }
    $(document).ready(function(e) {
      $('#modal-teoricos').on('show.bs.modal', function(e) {
        $('#tabla').html("<h2>Cargando datos, por favor espere...</h2>");
        var folio = $(e.relatedTarget).data().folio;
        //alert(id);
        var url = "tabla_modal.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: {
            folio: folio
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            $('#tabla').html(respuesta);
            cargar_tabla2();
          }
        });
      });
      cargar_folio();
      $("#descripcion").focus();
    });
    $("#articulo").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = "insertar_manual.php";
        var folio_registro = $("#folio_registro").val();
        var folio_descripcion = $("#descripcion").val();
        var articulo = $("#articulo").val();
        $.ajax({
          type: "POST",
          url: url,
          data: {
            folio_registro: folio_registro,
            folio_descripcion: folio_descripcion,
            articulo: articulo
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            var array = eval(respuesta);
            $("#descripcionArticulo").val(array[0]);
            $("#articulo").val("");
            $("#articulo").focus();
          }
        });
        return false;
      }

    });
    $("#btn-finalizar").click(function() {
      cargar_tabla();
      $("#form-catalogo")[0].reset();
      cargar_folio();
      $("#descripcion").focus();
      return false;
    });
    $("#descripcion").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        $("#articulo").focus();
        return false;
      }
    });

    function actualizaDescripcion() {
      $('#lista_teoricos').dataTable().fnClearTable();
      swal("Los registros se están actualizando, espere...", {
        icon: "info",
        closeOnClickOutside: false,
        buttons: false
      });
      var url = "actualizar_descripcion.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: $("#form-tabla").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "ok") {
            swal("La tabla ha sido actualizada correctamente", {
              icon: "success",
            });
            var folio = $("#folio").val();
            //alert(id);
            var url = "tabla_modal.php"; // El script a dónde se realizará la petición.
            $.ajax({
              type: "POST",
              url: url,
              data: {
                folio: folio
              }, // Adjuntar los campos del formulario enviado.
              success: function(respuesta) {
                $('#tabla').html(respuesta);
                cargar_tabla2();
              }
            });
          }
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    }

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
  </script>
</body>

</html>