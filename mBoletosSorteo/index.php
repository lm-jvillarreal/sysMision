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
                <div class="col-md-6 col-xs-6">
                  <div class="form-group">
                    <label for="prefijo">*Prefijo</label>
                    <input type="text" name="prefijo" id="prefijo" class="form-control" value="<?php echo $prefijo; ?>">
                  </div>
                </div>
                <div class="col-md-6 col-xs-6">
                  <div class="form-group">
                    <label for="consecutivo">*Consecutivo</label>
                    <input type="number" name="consecutivo" id="consecutivo" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 col-xs-6">
                  <div class="form-group">
                    <label for="subtotal">*Total</label>
                    <input type="number" id="total" name="total" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-6 col-xs-6">
                  <div class="form-group">
                    <label for="cantidad_boletos">*Boletos</label>
                    <input type="number" id="cantidad_boletos" name="cantidad_boletos" class="form-control" readonly="true">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 col-xs-6">
                  <div class="form-group">
                    <label for="restantes">*Restantes</label>
                    <input type="text" id="restantes" name="restantes" class="form-control" readonly="true">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer">
            <div class="row">
              <div class="col-xs-6">
                <button class="btn btn-success" id="folios">Agregar Folios</button>
              </div>
              <div class="col-xs-6 text-right">
                <button class="btn btn-warning" id="guardar">Guardar Registro</button>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Registro de Boletos | Listado de registros diarios</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_boletos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='5%'>#</th>
                        <th>Boleto</th>
                        <th>Ticket</th>
                        <th width='10%'>Total</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-danger" id="btnFinalizar">Finalizar turno</button>
          </div>
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <?php include 'modal_folios.php'; ?>
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
  <script src="https://code.highcharts.com/highcharts.js"></script>
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
    $("#folios").click(function() {
      $("#modal-folios").modal("show");
    });
    $("#btn-folios").click(function() {
      var url = "validar_gerente.php";
      swal("Autorización de folios", {
          content: {
            element: "input",
            attributes: {
              placeholder: "Contraseña de autorización",
              type: "password",
            },
          },
        })
        .then((value) => {
          var password = value;
          $.ajax({
            type: "POST",
            url: url,
            data: {
              password: password
            },
            success: function(respuesta) {
              if (respuesta == "valido") {
                var folio_inicial = $("#folio_inicial").val();
                var folio_final = $("#folio_final").val();
                var url = "ingresar_folios.php";
                $.ajax({
                  url: url,
                  type: "POST",
                  dateType: "html",
                  data: {
                    folio_inicial: folio_inicial,
                    folio_final: folio_final
                  },
                  success: function(respuesta) {
                    $('#modal-folios').modal('toggle');
                    if (respuesta == "ya_existe") {
                      alertify.error("El folio que intenta registrar ya existe");
                    } else if (respuesta == "ok") {
                      alertify.success("Los folios han sido registrados correctamente");
                    }
                  },
                  error: function(xhr, status) {
                    alert("error");
                    //alert(xhr);
                  },
                });
                cargar_tabla();
                resto();
                return false;
              } else {
                alertify.error("La contraseña ingresada no es válida");
              }
            }
          });
        });
    });

    function cargar_tabla() {
      $('#lista_boletos').dataTable().fnDestroy();
      $('#lista_boletos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "order": [
          [0, "asc"]
        ],
        "searching": false,
        "dom": 'Bfrtip',
         buttons: [
          {
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
					}
				],
        "ajax": {
          "type": "POST",
          "url": "tabla_boletos.php",
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
            "data": "total"
          }
        ]
      });
    }
    $("#consecutivo").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = "consulta_ticket.php"; // El script a dónde se realizará la petición.
        var prefijo = $("#prefijo").val();
        var consecutivo = $("#consecutivo").val();
        var folio = prefijo + consecutivo;
        //alert(folio);
        $.ajax({
          type: "POST",
          url: url,
          data: {
            prefijo: prefijo,
            consecutivo: consecutivo,
            folio: folio,
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
              $("#total").val(array[0]);
              $("#cantidad_boletos").val(array[1]);
            }
            resto();
          }
        });
        return false;
      }
    });
    $("#guardar").click(function() {
      var url = "insertar_boletos.php";
      var cantidad_boletos = parseInt($("#cantidad_boletos").val(), 10);
      var boletos_restantes = parseInt($("#restantes").val(), 10);
      if (boletos_restantes < cantidad_boletos) {
        alertify.error("Los boletos disponibles son insuficientes para ese ticket");
      } else {
        $.ajax({
          type: "POST",
          url: url,
          data: $("#form_registro").serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "no_folios") {
              alertify.error("No hay folios registrados");
            } else if (respuesta == "ya_existe") {
              alertify.error("El ticket ya ha sido registrado");
            } else if (respuesta == "ok") {
              $("#form_registro")[0].reset();
              alertify.success("Ticket registrado con éxito");
              $("#consecutivo").focus();
            }
            cargar_tabla();
            resto();

          }
        });
        return false;
      }
    });

    function resto() {
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
    $("#btnFinalizar").click(function() {
      var url = "finalizar_turno.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {},
        success: function(respuesta) {
          swal("Muchas gracias", "El turno del usuario ha sido finalizado.", "success");
          cargar_tabla();
          resto();
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    })
  </script>
</body>

</html>