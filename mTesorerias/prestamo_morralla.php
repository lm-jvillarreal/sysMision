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
      <?php include 'menuV3.php'; ?>
      <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Captura de Prestamo de Morralla</h3>
          </div>
          <div class="box-body">
            <div class="row container-fluid">
              <div class="col-md-4 col-md-offset-3">
                <div class="input-group">
                  <div class="input-group-addon">
                    Prestamo Total:
                  </div>
                  <input type="text" id="cant_prestamo" class="form-control">
                  <div class="input-group-addon">
                    .00
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <button class="btn btn-danger" id="generar" onclick="generar_tabla($('#cant_prestamo').val())">Generar</button>
                <button class="btn btn-danger" id="cancelar" onclick="ocultar()" style="display:none;">Cancelar</button>
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col-md-12" id="tabla" style="display:none;">
                <div class="table-responsive text-center">
                  <form id="prestamo">
                    <table id="lista_morralla" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th width="5%">#</th>
                          <th>Moneda</th>
                          <th>Monto</th>
                          <th>Cantidad de Monedas</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $morralla = array(
                          1 => '20.00', 2 => '10.00', 3 => '5.00', 4 => '2.00', 5 => '1.00',
                          6 => '0.50', 7 => '0.20', 8 => '0.10'
                        );
                        for ($i = 1; $i <= 8; $i++) {
                          ?>
                          <tr>
                            <td>
                              <?php echo $i; ?>
                            </td>
                            <td>$ <?php echo $morralla[$i]; ?>
                              <input type="text" value="<?php echo $morralla[$i]; ?>" class="hidden" name="morralla[]">
                            </td>
                            <td>
                              <div class="input-group">
                                <div class="input-group-addon">
                                  $
                                </div>
                                <input type="text" id="resultado<?php echo $i; ?>" class="form-control" name="resultado[]" onkeyup="if(event.keyCode == 13)llenar(this.value,'<?php echo $morralla[$i]; ?>','<?php echo $i; ?>')">
                              </div>
                            </td>
                            <td>
                              <input type="text" name="cantidad[]" id="cantidad<?php echo $i; ?>" readonly class="form-control">
                            </td>
                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>
                  </form>
                </div>
                <div class="box-footer text-right">
                  <div class="col-md-12">
                    <div class="col-md-2 col-md-offset-7">
                      <label>Total:</label>
                    </div>
                    <div class="col-md-3">
                      <input type="text" name="total" id="total" class="form-control" readonly>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-footer text-right">
              <div class="col-md-12">
                <button onclick="verificar_campos();" class="btn btn-warning" id="guardar">Guardar</button>
              </div>
            </div>
          </div>
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Lista de Prestamos de Morralla</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12" id="tabla">
                  <div class="table-responsive">
                    <table id="lista_prestamo_morralla" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th width='5%'>#</th>
                          <th>Usuario</th>
                          <th width='10%'>Sucursal</th>
                          <th width='10%'>Semana</th>
                          <th width='10%'>Total</th>
                          <th width='10%'>Restante</th>
                          <th width='5%'></th>
                          <th width='5%'></th>
                          <th width='5%'></th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
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
    <!-- /.content-wrapper -->
    <?php include 'modal_abonar.php'; ?>
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
    function ocultar() {
      $('#tabla').hide();
      $('#guardar').hide();
      $('#cancelar').hide();
      $('#generar').show();
      $('#cant_prestamo').val("");
      $('#cant_prestamo').focus();
      $("#cant_prestamo").prop('disabled', false);
    }
    ocultar();

    function generar_tabla(cantidad) {
      if (cantidad != "" && cantidad != "0") {
        $('#cancelar').show();
        $('#tabla').show();
        $('#guardar').show();
        $("#guardar").prop('disabled', true);
        $('#generar').hide();
        $("#cant_prestamo").prop('disabled', true);
      } else {
        alertify.error("Verificar Campo", 3);
        $('#cant_prestamo').focus();
      }
    }

    function prestamo_total(prestamo) {
      var total = 0;
      for (var i = 1; i <= 8; i++) {
        var cantidad = $('#resultado' + i).val();
        if (cantidad == "") {
          cantidad = 0;
        }
        total += parseFloat(cantidad);
      }
      if (total > prestamo) {
        alertify.error("Verifica total");
        $("#guardar").prop('disabled', true);
      } else if (total < prestamo) {
        $("#guardar").prop('disabled', true);
      } else if (total == prestamo) {
        $("#guardar").prop('disabled', false);
      }

      $('#total').val(total.toFixed(2));
    }
  </script>
  <script>
    function guardar() {
      $.ajax({
        url: 'insertar_prestamo.php',
        type: 'POST',
        dateType: 'html',
        data: $('#prestamo').serialize(),
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Se ha Guardado el registro");
            limpiar();
            ocultar();
            cargar_tabla();
          } else {
            alertify.error("Ha ocurrido un error", 2);
          }
        }
      });
    }

    function cargar_tabla_abonos(folio) {
      $('#lista_abonos').dataTable().fnDestroy();
      $('#lista_abonos').DataTable({
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
            title: 'Abonos',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Abonos',
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
          "url": "tabla_abonos.php",
          "dataSrc": "",
          "data": {
            "folio": folio
          },
        },
        "columns": [{
            "data": "#"
          },
          {
            "data": "Usuario"
          },
          {
            "data": "Cantidad"
          },
          {
            "data": "Fecha"
          },
        ]
      });
    }
    $('#modal-default').on('show.bs.modal', function(e) {
      var folio = $(e.relatedTarget).data().id;
      var url = "consulta_datos_modal.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          folio: folio
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          cargar_tabla_abonos(folio);
          var array = eval(respuesta);

          $('#semana').html(array[0]);
          $('#prestamo_total').html(array[1]);
          $('#prestamo_restante').html(array[2]);
          $('#folio').val(folio);

          if (array[2] == "$ 0.00") {
            $('#abono').attr('disabled', true);
            $('#btn-abonar').attr('disabled', true);
          } else {
            $('#abono').attr('disabled', false);
            $('#btn-abonar').attr('disabled', false);
          }
        }
      });
    });
    $("#btn-abonar").click(function() {
      var url = "insertar_abono.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: $('#form_datos_abonar').serialize(),
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Abono Guardado Correctamente");
            $('#abono').val("");
            $('#modal-default').modal('hide');
            cargar_tabla();
          } else if (respuesta == "1") {
            alertify.error("Verifica Campos");
          } else {
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
    });
  </script>
  <script>
    function limpiar() {
      var i = 1;
      while (i <= 8) {
        $('#cantidad' + i).val("");
        $('#resultado' + i).val("");
        i++;
      }
      $
    }
  </script>
  <script>
    function verificar_moneda(numero) {
      if (numero % 1 == 0) {} else {
        alertify.error("Verificar Campo");
        $("#guardar").prop('disabled', true);
      }
    }

    function llenar(monto, morralla, id) {
      if (monto == "") {
        monto = 0;
        $('#resultado' + id).val(monto);
      }
      if (monto == 0 && morralla == 0) {
        resultado = 0;
      } else {
        resultado = parseFloat(monto) / parseFloat(morralla);
        verificar_moneda(resultado);
      }

      $('#cantidad' + id).val(resultado);

      total = parseInt(id) + 1;

      if (total <= 8) {
        $('#resultado' + total).focus();
      }
      prestamo_total($('#cant_prestamo').val());
    }

    function verificar_campos() {
      var errores = 0;
      for (var i = 1; i <= 8; i++) {
        var campo = $('#resultado' + i).val();
        var numero = $('#cantidad' + i).val();
        var morralla = 0;
        if (campo == "" || campo == "0") {
          llenar(campo, morralla, i);
        }
        if (numero % 1 == 0) {} else {
          errores += 1;
        }
      }
      if (errores != 0) {
        alertify.error("Verificar " + errores + " Campo(s)");
        $("#guardar").prop('disabled', true);
      } else {
        guardar();
      }
    }

    function cargar_tabla() {
      $('#lista_prestamo_morralla').dataTable().fnDestroy();
      $('#lista_prestamo_morralla').DataTable({
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
            title: 'Prestamo',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Prestamo',
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
          "url": "tabla_prestamo_morralla.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "#"
          },
          {
            "data": "Usuario"
          },
          {
            "data": "Sucursal"
          },
          {
            "data": "Semana"
          },
          {
            "data": "Total"
          },
          {
            "data": "Restante"
          },
          {
            "data": "Editar"
          },
          {
            "data": "Abonar"
          },
          {
            "data": "PDF"
          }
        ]
      });
    }

    function mostrar(numero) {
      if ($('#inputabono_' + numero).hasClass('hidden')) {
        $('#inputabono_' + numero).removeClass('hidden');
      } else {
        $('#inputabono_' + numero).addClass('hidden');
      }
    }

    function editar_abono(numero, id) {
      var abono = $('#inputabono_' + numero).val();
      var folio = $('#folio').val();
      $.ajax({
        url: 'actualizar_registro.php',
        data: {
          'abono': abono,
          'id': id
        },
        type: "POST",
        success: function(respuesta) {
          if (respuesta = "ok") {
            alertify.success("Registro Actualizado Correctamente");
            cargar_tabla_abonos(folio);
            cargar_tabla();
          } else {
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
    }
  </script>
  <script>
    cargar_tabla();
  </script>
</body>

</html>