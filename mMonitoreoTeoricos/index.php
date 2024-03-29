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
    width: 100% !important;
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
        <form method="POST" id="form-catalogo" enctype="multipart/form-data">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Monitoreo de Teóricos | Registro de Folio</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="documento">*Documento</label>
                    <input name="action" type="hidden" value="upload" id="action" />
                    <input type="file" name="file">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="descripcion">*Descripción</label>
                    <input type="text" name="folio_descripcion" id="folio_descripcion" class="form-control">
                  </div>
                </div>
              </div>
            </div>
            <div class="box-footer text-right">
              <button class="btn btn-warning" id="btn-guardar">Cargar Archivo</button>
            </div>
          </div>
        </form>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Folios Existentes</h3>
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
    <?php include 'modal_compartir.php'; ?>
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
    $(document).ready(function() {
      cargar_tabla();
    });
    $('#usuarios').select2({
      width: '100%',
      dropdownParent: $("#modal-compartir"),
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      ajax: {
        url: "consulta_usuarios.php",
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
          url: 'importar_folio.php', //URL destino
          data: data,
          processData: false, //Evitamos que JQuery procese los datos, daría error
          contentType: false, //No especificamos ningún tipo de dato
          type: 'POST',
          success: function(resultado) {
            if (resultado == "ok") {
              swal("Satisfactorio!!", "La actualización de artículos se realizó sin inconvenientes.", "success");
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
      $('#lista_modulos').dataTable().fnDestroy();
      $('#lista_modulos').DataTable({
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
          },
          {
            "data": "compartir"
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
      $('#modal-compartir').on('show.bs.modal', function(e) {
        var folio = $(e.relatedTarget).data().folio;
        $("#folio").val(folio);
      });
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
    $("#btn-compartir").click(function() {
      if ($("#folio").val() == "" || $("#usuarios").val() == "") {
        $('#modal-compartir').modal('toggle');
      } else {
        var folio = $("#folio").val();
        var usuario = $("#usuarios").val();
        var url = 'compartir_folio.php';
        $.ajax({
          type: "POST",
          url: url,
          data: {
            folio: folio,
            usuario: usuario
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            $('#modal-compartir').modal('toggle');
            alertify.success("El folio ha sido compartido");
            cargar_tabla();
          }
        });
      }
      return false;
    });
  </script>
</body>

</html>