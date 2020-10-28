<?php
include '../global_seguridad/verificar_sesion.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
</head>
<style>
  #modal_codigos {
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
      <?php include 'menuV4.php'; ?>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Monitoreo de Teóricos | Registro de Folio</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form-catalogo">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="proveedor">*Proveedor:</label>
                    <select name="proveedor" id="proveedor" class="form-control select2">
                      <option></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="descripcion">*Descripción</label>
                    <input type="text" name="folio_descripcion" id="folio_descripcion" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="sucursal">*Sucursal</label>
                    <select name="sucursal" id="sucursal" class="form-control">
                      <option value=""></option>
                      <option value="1">Diaz Ordaz</option>
                      <option value="2">Arboledas</option>
                      <option value="3">Villegas</option>
                      <option value="4">Allende</option>
                      <option value="5">Petaca</option>
                      <option value="99">CEDIS</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="usuarios">*Usuarios</label>
                    <select name="usuarios" id="usuarios" class="form-control">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-guardar">Crear folio</button>
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
                        <th width="5%">Folio</th>
                        <th>Descripción</th>
                        <th width="15%">Cantidad</th>
                        <th width="10%">Fecha</th>
                        <th width='10%'>Sucursal</th>
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
                        <th width='10%'>Sucursal</th>
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
    <?php include 'modal_codigos.php'; ?>
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
    $('#proveedor').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "consulta_proveedores.php",
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
    $('#usuarios_modal').select2({
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
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
    });
    $('#usuarios').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
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

    $("#btn-guardar").click(function() {
      if ($("#proveedor").val() == "" || $("#descripcion").val() == "" || $("#sucursal").val() == "") {
        alertify.error("Favor de rellenar todos los datos");
      } else {
        var url = "insertar_folio.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: $('#form-catalogo').serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
           alertify.success("Folio creado correctamente")
          }
        });
        cargar_tabla();
      }
      return false;
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
            "data": "descripcion"
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
            text: 'Actualizar tabla',
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

    function eliminar_folio(folio) {
      var url = "eliminar_folio.php"; // El script a dónde se realizará la petición.
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
      $('#modal-codigos').on('show.bs.modal', function(e) {
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
      var url = "actualizar_codigos.php"; // El script a dónde se realizará la petición.
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
    $("#btn-compartir").click(function() {
      if ($("#folio").val() == "" || $("#usuarios_modal").val() == "") {
        $('#modal-compartir').modal('toggle');
      } else {
        var folio = $("#folio").val();
        var usuario = $("#usuarios_modal").val();
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