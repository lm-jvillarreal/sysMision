<?php
include '../global_seguridad/verificar_sesion.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
</head>
<style>
  #modal_detalle {
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
      <?php include 'menuV2.php'; ?>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Control de Pedidos | Historial de pedidos</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_codigos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='10%'>Folio</th>
                        <th>Pedido</th>
                        <th width='10%'>Fecha</th>
                        <th width='10%'>Artículos</th>
                        <th width='15%'>Solicita</th>
                        <th width='10%'>Sucursal</th>
                        <th width='10%'>Estatus</th>
                        <th width='5%'></th>
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
    <?php include 'modal_detalle.php'; ?>
    <?php //include 'modal_comentario.php'; 
    ?>
    <?php //include 'modal_negar.php'; 
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
    $('#modal-detalle').on('show.bs.modal', function(e) {
      var folio = $(e.relatedTarget).data().folio;
      $("#folio").val(folio);
      tabla_articulos();
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
          "url": "tabla_bitacora.php",
          "dataSrc": "",
          "data": ""
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "pedido"
          },
          {
            "data": "fecha"
          },
          {
            "data": "articulos"
          },
          {
            "data": "solicita"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "estatus"
          },
          {
            "data": "opciones"
          }
        ]
      });
    }

    function tabla_articulos() {
      var folio = $("#folio").val();
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
          "url": "tabla_detalle.php",
          "dataSrc": "",
          "data": {
            folio: folio
          },
        },
        "columns": [{
            "data": "codigo",
            "width": "10%"
          },
          {
            "data": "descripcion",
            "width": "55%"
          },
          {
            "data": "existencia",
            "width": "10%"
          },
          {
            "data": "pedido",
            "width": "10%"
          },
          {
            "data": "surtido",
            "width": "10%"
          },
          {
            "data": "opciones",
            "width": "5%"
          }
        ]
      });
    };

    function asignar_cant(id_registro) {
      var url = 'asignar_cantidad.php';

      swal("Cantidad surtida", {
          content: "input",
        })
        .then((value) => {
          var cantidad = value;
          $.ajax({
            type: "POST",
            url: url,
            data: {
              id_registro: id_registro,
              cantidad: cantidad
            },
            success: function(respuesta) {
              if (respuesta == "ok") {
                alertify.success("Cantidad ingresada correctamente");
              } else {
                swal("Error", "La cantidad surtida no puede ser mayor a la solicitada por el cliente", "error");
              }
              tabla_articulos();
            }
          });
        });
      return false;
    }
    $("#btn_finalizar").click(function() {
      var folio = $("#folio").val();
      var url = 'finaliza_pedido.php';
      $.ajax({
        type: "POST",
        url: url,
        data: {
          folio: folio
        },
        success: function(respuesta) {
          $("#modal-detalle").modal("hide");
          swal("Listo", "Surtido finalizado correctamente", "success");
          cargar_tabla();
        }
      });
      return false;
    });

    function traspaso(pedido, traspaso) {
      var url = "modificar_traspaso.php";
      swal({
          title: "Confirmar operación",
          text: "Esta acción modificará un traspaso existente en InfoFin",
          icon: "warning",
          buttons: {
            cancel: "Cancelar",
            ok: "Aceptar"
          },
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            //alert(traspaso);
            $.ajax({
              type: "POST",
              url: url,
              data: {
                pedido: pedido,
                traspaso: traspaso
              }, // Adjuntar los campos del formulario enviado.
              success: function(respuesta) {
                swal("Listo!", "Traspaso modificado satisfactoriamente", "success")
                cargar_tabla();
              }
            });
          } else {
            swal("La operación ha sido cancelada");
          }
        });
    }

    function valida_folio(pedido) {
      var url = "valida_folio.php";
      swal("Ingresa el Consecutivo del traspaso a modificar", {
          content: "input",
        })
        .then((value) => {
          var traspaso = `${value}`;
          if (traspaso == null) {
            swal("Falta de datos", "Tienes que ingresar un consecutivo de traspaso", "error")
          } else {
            //alert(traspaso);
            $.ajax({
              type: "POST",
              url: url,
              data: {
                pedido: pedido,
                traspaso: traspaso
              }, // Adjuntar los campos del formulario enviado.
              success: function(respuesta) {
                if (respuesta == 'validado') {
                  swal("¡Listo!", "Folio de traspaso validado correctamente", "success");
                  cargar_tabla();
                } else {
                  swal("Ha ocurrido un error", "Error al validar el traspaso, verifica el folio ingresado", "error");
                }
              }
            });
          }
        });
    }
  </script>
</body>

</html>