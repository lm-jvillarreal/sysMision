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
            <h3 class="box-title">Lista de faltantes registrados</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_codigos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th width="15%">Código</th>
                        <th>Descripción</th>
                        <th width='10%'>Sucursal</th>
                        <th width="5%">DO</th>
                        <th width="5%">ARB</th>
                        <th width="5%">VILL</th>
                        <th width="5%">ALL</th>
                        <th width="5%">Estatus</th>
                        <th width="5%"></th>
                        <th width="5%"></th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Sucursal</th>
                        <th>DO</th>
                        <th>ARB</th>
                        <th>VILL</th>
                        <th>ALL</th>
                        <th>Estatus</th>
                        <th></th>
                        <th></th>
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
    <?php include 'modal_ue.php'; ?>
    <?php include 'modal_comentario.php'; ?>
    <?php include 'modal_negar.php'; ?>
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
    $(document).ready(function(e) {
      cargar_tabla();
    });

    function cargar_tabla() {
      $('#lista_codigos').dataTable().fnDestroy();
      $('#lista_codigos').DataTable({
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
            title: 'FaltantesLista',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'FaltantesLista',
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
        "ajax": {
          "type": "POST",
          "url": "tabla_faltantes_espera.php",
          "dataSrc": "",
          "data": ""
        },
        "columns": [{
            "data": "no"
          },
          {
            "data": "codigo"
          },
          {
            "data": "desc"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "do"
          },
          {
            "data": "arb"
          },
          {
            "data": "vill"
          },
          {
            "data": "all"
          },
          {
            "data": "liberar"
          },
          {
            "data": "existe_pv"
          },
          {
            "data": "negar_pv"
          }
        ]
      });
    }

    function libera_def(registro) {
      $('#lista_codigos').dataTable().fnClearTable();
      swal("Los registros se están actualizando, espere...", {
        icon: "info",
        closeOnClickOutside: false,
        buttons: false
      });
      var id_registro = registro;
      var url = 'libera_definitivo.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_registro: id_registro
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            swal("La tabla ha sido actualizada correctamente", {
              icon: "success",
            });
            cargar_tabla();
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }
    $('#modal-ue').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data().id;
      var suc = $(e.relatedTarget).data().suc;
      var inicio = $(e.relatedTarget).data().inicio;
      $('#res').html('<center><h4>Un momento, por favor...</h4><center>');
      var url = "contenido_modal_ue.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id: id,
          suc: suc,
          inicio: inicio
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          //$('#res').html(respuesta);
          $('#res').fadeIn(5000).html(respuesta);
        }
      });
    });
    $('#modal-coment').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data().id;
      $("#ide").val(id);
    });
    $('#modal-negar').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data().id;
      $("#ide_negar").val(id);
    });

    $("#btn-coment").click(function() {
      var url = "libera_pv.php";
      var id_registro = $("#ide").val();
      var comentario = $("#comentario-verifica").val();
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id_registro: id_registro,
          comentario: comentario
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          $('#modal-coment').modal('hide');
          $("#ide").val("");
          $("#comentario-verifica").val("");
          cargar_tabla();
        }
      });
    })
    $("#btn-niega").click(function() {
      var url = "negar_pv.php";
      var id_registro = $("#ide_negar").val();
      var comentario = $("#comentario-niega").val();
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id_registro: id_registro,
          comentario: comentario
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          $('#modal-negar').modal('hide');
          $("#ide_negar").val("");
          $("#comentario-niega").val("");
          cargar_tabla();
        }
      });
    })
  </script>
</body>

</html>