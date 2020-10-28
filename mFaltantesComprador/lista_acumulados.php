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
            <h3 class="box-title">Lista de faltantes registrados</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <form action="" method="POST" id="frm-libera">
                    <table id="lista_codigos" class="table table-striped table-bordered" cellspacing="0" width="120%">
                      <thead>
                        <tr>
                          <th width="2%">#</th>
                          <th width='10%'>Depto.</th>
                          <th width='10%'>Fam.</th>
                          <th width="8%">Código</th>
                          <th>Descripción</th>
                          <th width="5%">Suc.</th>
                          <th width="5%">Conteo</th>
                          <th width="5%">DO</th>
                          <th width="5%">ARB</th>
                          <th width="5%">VILL</th>
                          <th width="5%">ALL</th>
                          <th width='5%'>PET</th>
                          <th width='5%'>CEDIS</th>
                        </tr>
                      </thead>
                    </table>
                  </form>
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
    <?php include 'modal_comp.php'; ?>
    <?php include 'modal_conteo.php'; ?>
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
      $('#lista_codigos thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      $('#lista_codigos').dataTable().fnDestroy();
      var table = $('#lista_codigos').DataTable({
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
          {
            text: 'Actualizar Descripciones',
            className: 'red',
            action: function() {
              actualizar_descripciones();
            },
            counter: 1
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_acumulados.php",
          "dataSrc": "",
          "data": ""
        },
        "columns": [{
            "data": "no"
          },
          {
            "data": "depto"
          },
          {
            "data": "fam"
          },
          {
            "data": "codigo"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "conteo"
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
            "data": "pet"
          },
          {
            "data": "cedis"
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
    }

    function cargar_tabla_conteo(articulo) {
      $('#lista_conteo').dataTable().fnDestroy();
      $('#lista_conteo').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        "ajax": {
          "type": "POST",
          "url": "tabla_conteo.php",
          "dataSrc": "",
          "data": {
            articulo: articulo
          }
        },
        "columns": [{
            "data": "articulo"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "fecha"
          },
          {
            "data": "usuario"
          }
        ]
      });
    }
    $('#modal-ue').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data().id;
      var suc = $(e.relatedTarget).data().suc;
      $('#res').html('<center><h4>Un momento, por favor...</h4><center>');
      var url = "contenido_modal_ue.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id: id,
          suc: suc
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          //$('#res').html(respuesta);
          $('#res').fadeIn(5000).html(respuesta);
        }
      });
    });
    $('#modal-conteo').on('show.bs.modal', function(e) {
      var articulo = $(e.relatedTarget).data().articulo;
      cargar_tabla_conteo(articulo);
    });

    function actualizar_descripciones() {
      $('#lista_codigos').dataTable().fnClearTable();
      swal("Los registros se están actualizando, espere...", {
        icon: "info",
        closeOnClickOutside: false,
        buttons: false
      });
      var url = 'actualiza_descripciones.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {},
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
  </script>
</body>

</html>