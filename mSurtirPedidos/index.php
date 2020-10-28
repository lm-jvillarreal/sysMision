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
                          <th width='10%'>Tipo</th>
                          <th width='10%'>Asignado a</th>
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
    <?php include 'modal_detalle.php'; ?>
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
            "data": "estatus"
          },
          {
            "data": "opciones"
          }
        ]
      });
    };

    function tabla_articulos() {
      var folio = $("#folio").val();
      $('#lista_articulos').dataTable().fnDestroy();
      $('#lista_articulos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
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
            "width": "5%"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "um",
            "width": "5%"
          },
          {
            "data": "cantidad",
            "width": "5%"
          },
          {
            "data": "opciones",
            "width": "5%"
          }
        ]
      });
    };
    $('#modal-detalle').on('show.bs.modal', function(e) {
      var folio = $(e.relatedTarget).data().folio;
      $("#folio").val(folio);
      tabla_articulos();
    });
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
    });

    function asignar_cant(id_registro) {
      var cantidad = $("#id_" + id_registro).val();
      var url = 'asignar_cantidad.php';
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
        }
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
          tabla_pedidos();
        }
      });
      return false;
    });
  </script>
</body>

</html>