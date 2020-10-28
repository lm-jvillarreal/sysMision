<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
</head>
<style>
  #modal_kardex {
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
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Compras | Historial de Movimientos</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form-catalogo" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="documento">*Documento</label>
                    <input name="action" type="hidden" value="upload" id="action" />
                    <input type="file" name="file">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha_inicio">*Fecha inicial:</label>
                    <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicial" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="" readonly id="fecha_inicial" name="fecha_inicial">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha_fin">*Fecha final:</label>
                    <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_final" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="" readonly id="fecha_final" name="fecha_final">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3">
                  <label for="">Sucursal</label>
                  <select name="sucursal" class="form-control" id="sucursal">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btnCargarFolio">Importar códigos</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Folios Existentes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_folios" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="10%">Folio</th>
                        <th>Rango de fechas</th>
                        <th width="10%">Cantidad</th>
                        <th width="15%">Fecha</th>
                        <th width="15%">Sucursal</th>
                        <th width="15%">Usuario</th>
                        <th width="10%"></th>
                      </tr>
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
    <?php include 'modal_kardex.php'; ?>
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
    })
    $('.form_date').datetimepicker({
      language: 'es',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0
    });
    $(":file").filestyle('buttonText', 'Seleccionar');
    $(":file").filestyle('size', 'sm');
    $(":file").filestyle('input', true);
    $(":file").filestyle('disabled', false);
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity,
      ajax: {
        url: "consulta_sucursales.php",
        type: "POST",
        dataType: 'JSON',
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
    $('#form-catalogo').submit(function(e) {
      if ($("#action").val() == "" || $("#fecha_inicial").val() == "" || $("#fecha_final").val() == "" || $("#sucursal").val() == "") {
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
              swal("Completado", "El folio se importó correctamente", "success");
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
    $("#btnCargarFolio").click(function() {
      $("#form-catalogo").submit();
    });
    $('#modal-kardex').on('show.bs.modal', function(e) {
      var folio = $(e.relatedTarget).data().folio;
      $("#folio_modal").val(folio);
      tabla_modal(folio);
    });

    function cargar_tabla() {
      $('#lista_folios').dataTable().fnDestroy();
      $('#lista_folios').DataTable({
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
            "data": "rango"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "fecha"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "usuario"
          },
          {
            "data": "opciones"
          }
        ]
      });
    }

    function tabla_modal(folio) {
      $('#lista_detalle').dataTable().fnDestroy();
      $('#lista_detalle').DataTable({
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
            text: 'Actualizar datos',
            action: function() {
              actualizaDetalle();
            },
            counter: 1
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_detalle.php",
          "dataSrc": "",
          data: {
            folio: folio
          }
        },
        "columns": [{
            "data": "artc_articulo"
          },
          {
            "data": "artc_descripcion"
          },
          {
            "data": "costo"
          },
          {
            "data": "ppublico"
          },
          {
            "data": "poferta"
          },
          {
            "data": "inicial"
          },
          {
            "data": "compra"
          },
          {
            "data": "etrans"
          },
          {
            "data": "exdev"
          },
          {
            "data": "entradas"
          },
          {
            "data": "totent"
          },
          {
            "data": "salxve"
          },
          {
            "data": "strans"
          },
          {
            "data": "devol"
          },
          {
            "data": "salidas"
          },
          {
            "data": "totsal"
          },
          {
            "data": "teorico"
          }
        ]
      });
    }

    function actualizaDetalle() {
      var folio_modal = $("#folio_modal").val();
      $('#lista_detalle').dataTable().fnClearTable();
      swal("Los registros se están actualizando, espere...", {
        icon: "info",
        closeOnClickOutside: false,
        buttons: false
      });
      var url = "actualizar_detalle.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          folio_modal: folio_modal
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "ok") {
            swal("La tabla ha sido actualizada correctamente", {
              icon: "success",
            });
            tabla_modal(folio_modal);
          }
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    }

    function eliminar_folio(folio) {
      var url = "eliminar_folio.php";
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
    }
  </script>
</body>

</html>