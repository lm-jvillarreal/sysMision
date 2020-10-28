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
        <div class="row">
          <div class="col-md-12">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Control de Pedidos | Pedidos a surtir</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table id="lista_pedidos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <th width='5%'>Folio</th>
                          <th>Cliente</th>
                          <th width='10%'>Teléfono</th>
                          <th>Dirección</th>
                          <th width='5%'>Tipo</th>
                          <th width='10%'>Asignado a</th>
                          <th width='15%'>Repartidor</th>
                          <th width='5%'>Monto</th>
                          <th width='5%'>Estatus</th>
                          <th width='5%'></th>
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
    <?php include 'modal_surtidor.php'; ?>
    <?php include 'modal_repartidor.php'; ?>
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
  <script>
    $(document).ready(function() {
      tabla_pedidos();
      $('#modal-personal').on('show.bs.modal', function(e) {
        var folio = $(e.relatedTarget).data().folio;
        $("#folio").val(folio);
      });
      $('#modal-reparto').on('show.bs.modal', function(e) {
        var folio = $(e.relatedTarget).data().folio;
        $("#folio_pedido").val(folio);
      });
    });
    $('#usuarios').select2({
      width: '100%',
      dropdownParent: $("#modal-personal"),
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
    $('#repartidor').select2({
      width: '100%',
      dropdownParent: $("#modal-reparto"),
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      ajax: {
        url: "consulta_repartidores.php",
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

    function tabla_pedidos() {
      $('#lista_pedidos').dataTable().fnDestroy();
      $('#lista_pedidos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        "order": [
          [0, "asc"]
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_pedidos.php",
          "dataSrc": "",
          "data": {

          },
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "cliente"
          },
          {
            "data": "telefono"
          },
          {
            "data": "direccion"
          },
          {
            "data": "tipo_pedido"
          },
          {
            "data": "surtidor"
          },
          {
            "data": "repartidor"
          },
          {
            "data": "monto"
          },
          {
            "data": "estatus"
          },
          {
            "data": "opciones"
          }
        ]
      });
    };
    $("#btn_asignar").click(function() {
      var url = 'asignar_pedido.php';
      var folio = $("#folio").val();
      var usuarios = $("#usuarios").val();
      $.ajax({
        type: "POST",
        url: url,
        data: {
          folio: folio,
          usuarios: usuarios
        },
        success: function(respuesta) {
          $("#modal-personal").modal("hide");
          swal("Asignado", "El pedido #" + respuesta + " ha sido asignado para surtir", "success");
          tabla_pedidos();
        }
      });
      return false;
    })
    $("#btn_asignarReparto").click(function() {
      var url = 'asignar_repartidor.php';
      var folio = $("#folio_pedido").val();
      var repartidor = $("#repartidor").val();
      $.ajax({
        type: "POST",
        url: url,
        data: {
          folio: folio,
          repartidor: repartidor
        },
        success: function(respuesta) {
          $("#modal-reparto").modal("hide");
          swal("Asignado", "El pedido #" + respuesta + " ha sido asignado para entrega", "success");
          tabla_pedidos();
        }
      });
      return false;
    })

    function liberar_entrega(id_pedido) {
      var url = 'liberar_pedido.php';
      swal("Cantidad para liquidar", {
          content: "input",
        })
        .then((value) => {
          var cantidad = `${value}`;
          $.ajax({
            type: "POST",
            url: url,
            data: {
              cantidad: cantidad,
              id_pedido: id_pedido
            },
            success: function(respuesta) {
              if (respuesta == "menor") {
                swal("Hay un problema", "La cantidad para liquidar es menor al total del pedido", "error");
              } else {
                swal("Finalizado", "El pedido #" + respuesta + " ha sido liberado con éxito", "success");
                tabla_pedidos();
              }
            }
          });
        });
    }
  </script>
</body>

</html>