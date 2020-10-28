<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set("America/Monterrey");
$prefijo = date("Y") . date("m") . date("d");
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
            <h3 class="box-title">Registro de Boletos | Registro</h3>
          </div>
          <div class="box-body">
            <form action="" method="POST" id="form_registro">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="prefijo">*Prefijo</label>
                    <input type="text" name="prefijo" id="prefijo" class="form-control" value="<?php echo $prefijo; ?>">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="consecutivo">*Consecutivo</label>
                    <input type="number" name="consecutivo" id="consecutivo" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="sucursal">*Sucursal</label>
                    <input type="text" name="sucursal" id="sucursal" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="subtotal">*Subtotal</label>
                    <input type="number" id="subtotal" name="subtotal" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="impuestos">*Impuestos</label>
                    <input type="number" id="impuestos" name="impuestos" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="ajuste">*Ajuste</label>
                    <input type="number" id="ajuste" name="ajuste" class="form-control" readonly="true">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="subtotal">*Total</label>
                    <input type="number" id="total" name="total" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="cantidad_boletos">*Boletos</label>
                    <input type="number" id="cantidad_boletos" name="cantidad_boletos" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="restantes">*Restantes</label>
                    <input type="text" id="restantes" name="restantes" class="form-control" readonly="true">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="guardar">Guardar Registro</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Registro de Boletos | Listado de registros diarios</h3>
          </div>
          <div class="box-body">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="lista_boletos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width='5%'>#</th>
                      <th>Boleto</th>
                      <th>Ticket</th>
                      <th width='15%'>Sucursal</th>
                      <th width='10%'>Subtotal</th>
                      <th width='10%'>Impuestos</th>
                      <th width='10%'>Ajuste</th>
                      <th width='10%'>Total</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th width='5%'>#</th>
                      <th>Boleto</th>
                      <th>Ticket</th>
                      <th>Sucursal</th>
                      <th width='10%'>Subtotal</th>
                      <th width='10%'>Impuestos</th>
                      <th width='10%'>Ajuste</th>
                      <th width='10%'>Total</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
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
      $("#consecutivo").focus();
      resto();
    });

    function cargar_tabla() {
      $('#lista_boletos').dataTable().fnDestroy();
      $('#lista_boletos').DataTable({
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
          },
          {
            text: 'Liberar pendientes',
            action: function() {
              libera();
            },
            counter: 1
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "id"
          },
          {
            "data": "folio_boleto"
          },
          {
            "data": "folio_ticket"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "subtotal"
          },
          {
            "data": "impuestos"
          },
          {
            "data": "ajuste"
          },
          {
            "data": "total"
          }
        ]
      });
    }
    $("#consecutivo").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = "consulta_datos.php"; // El script a dónde se realizará la petición.
        var prefijo = $("#prefijo").val();
        var consecutivo = $("#consecutivo").val();
        var folio = prefijo + consecutivo;
        //alert(folio);
        $.ajax({
          type: "POST",
          url: url,
          data: {
            folio: folio
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "no_existe") {
              swal("Verifica!", "El folio de ticket que intentas ingresar no fue encontrado en el sistema.", "error");
              $("#form_registro")[0].reset();
              $("#consecutivo").focus();
            } else if (respuesta == "fuera_rango") {
              swal("Lo Sentimos!! =(", "El folio de ticket que intentas ingresar no es participante.", "error");
              $("#form_registro")[0].reset();
              $("#consecutivo").focus();
            } else if (respuesta == "no_boletos") {
              swal("Lo sentimos!! =(", "El total del ticket no amerita la cantidad mínima de boletos", "error");
              $("#form_registro")[0].reset();
              $("#consecutivo").focus();
            } else {
              var array = eval(respuesta);
              $('#sucursal').val("");
              $('#impuestos').val(array[0]);
              $('#subtotal').val(array[1]);
              $('#ajuste').val(array[2]);
              $('#total').val(array[3]);
              $('#sucursal').val(array[4]);
              $('#cantidad_boletos').val(array[5]);
            }
          }
        });
        return false;
      }
    });
    $("#guardar").click(function() {
      var url = "insertar_boletos.php";
      $.ajax({
        type: "POST",
        url: url,
        data: $("#form_registro").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "pendientes") {
            swal("Atención", "Libere los folios pendientes", "error");
            $("#form_registro")[0].reset();
            $("#consecutivo").focus();
          } else if (respuesta == "excedido") {
            swal("Lo sentimos!! =(", "El número de boletos disponibles es menor a los requeridos para este ticket.", "error");
            $("#form_registro")[0].reset();
            $("#consecutivo").focus();
          } else if (respuesta == "existe") {
            swal("Atención", "El ticket que intentas ingresar ya fue registrado en el sistema", "info");
            $("#form_registro")[0].reset();
            $("#consecutivo").focus();
          } else if (respuesta = "ok") {
            alertify.success("El ticket ha sido registrado correctamente");
            $("#form_registro")[0].reset();
            $("#consecutivo").focus();
          }
        }
      });
      cargar_tabla();
      resto();
      return false;
    });

    function asocia(id_boleto) {
      var url = "libera_folio.php";
      var folio = $("#folio_" + id_boleto).val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          folio: folio,
          id_boleto: id_boleto
        },
        success: function(respuesta) {
          alertify.success("El boleto ha sido corregido correctamente");
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      cargar_tabla();
      return false;
    }

    function libera() {
      var url = "libera_ticket.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {},
        success: function(respuesta) {
          alertify.success("El ticket ha sido liberado correctamente");
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      cargar_tabla();
      return false;
    };
    function resto(){
      var url = "boletos_restantes.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {},
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#restantes").val(array[0]);
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