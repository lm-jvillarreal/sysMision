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
                  <form action="" method="POST" id="frm-libera">
                    <table id="lista_codigos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th width="2%">#</th>
                          <th width='10%'>Depto.</th>
                          <th width='10%'>Fam.</th>
                          <th width="8%">Código</th>
                          <th>Descripción</th>
                          <th width="9%">Suc.</th>
                          <th width="5%">DO</th>
                          <th width="5%">ARB</th>
                          <th width="5%">VILL</th>
                          <th width="5%">ALL</th>
                          <th width="5%">PET</th>
                          <th width="5%">CEDIS</th>
                          <th width="5%">Lib.</th>
                          <th width="5%">AI</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>#</th>
                          <th>Depto.</th>
                          <th>Fam.</th>
                          <th>Código</th>
                          <th>Descripción</th>
                          <th>Sucursal</th>
                          <th>DO</th>
                          <th>ARB</th>
                          <th>VILL</th>
                          <th>ALL</th>
                          <th>PET</th>
                          <th>CEDIS</th>
                          <th>Liberar</th>
                          <th>AjuInv</th>
                        </tr>
                      </tfoot>
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
    $('#id_comprador').select2({
      dropdownParent: $('#modal-comp'),
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
    })
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
            text: 'Liberar Seleccionados',
            className: 'red',
            action: function() {
              libera_multiple();
            },
            counter: 1
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_faltantes.php",
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
          },
          {
            "data": "liberar"
          },
          {
            "data": "ajuste"
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

    function liberar(registro) {
      var id_registro = registro;
      var url = 'liberar.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_registro: id_registro
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Artículo liberado correctamente");
            cargar_tabla();
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }

    function revision(registro) {
      var id_registro = registro;
      var url = 'revision.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_registro: id_registro
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Artículo liberado correctamente");
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
      var ini = $(e.relatedTarget).data().ini;
      $('#res').html('<center><h4>Un momento, por favor...</h4><center>');
      var url = "contenido_modal_ue.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id: id,
          suc: suc,
          ini: ini
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
    $('#modal-comp').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data().id;
      var id_compra = $(e.relatedTarget).data().id_compra;
      var comprador = $(e.relatedTarget).data().comprador;
      $("#ide_rg").val(id);
      $("#id_comprador").select2("trigger", "select", {
        data: {
          id: id_compra,
          text: comprador
        }
      });
    });
    $("#btn-cambiaComprador").click(function() {
      var url = "cambia_comprador.php";
      var id = $("#ide_rg").val();
      var id_comprador = $("#id_comprador").val();
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id: id,
          id_comprador: id_comprador
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          $('#modal-comp').modal('hide');
          $("#ide_rg").val("");
          cargar_tabla();
        }
      });
    })
    $("#btn-coment").click(function() {
      var url = "comenta_faltante.php";
      var id = $("#ide").val();
      var comentario = $("#comentario-verifica").val();
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id: id,
          comentario: comentario
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          $('#modal-coment').modal('hide');
          $("#ide").val("");
          $("#comentario-verifica").val("");
          cargar_tabla();
        }
      });
    });

    function ajuinv(registro) {
      var url = 'ajuinv.php';
      id_registro = registro;
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_registro: id_registro
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Artículo etiquetado para ajuste de inventario");
            cargar_tabla();
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }

    function libera_multiple() {
      var url = "libera_multiple.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: $("#frm-libera").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          alertify.success("Articulos liberados correctamente");
          cargar_tabla();
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    }
  </script>
</body>

</html>