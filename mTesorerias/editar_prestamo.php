<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');

$folio = $_GET['folio'];
$prestamo_total = 0;
// $cadena_fecha = mysqli_query($conexion,"SELECT fecha FROM faltantes WHERE folio = '$folio'");
// $row_fecha = mysqli_fetch_array($cadena_fecha);

$cadena = mysqli_query($conexion, "SELECT folio,cantidad,resultado,semana FROM prestamos_morralla WHERE folio = '$folio' order by cast(morralla AS DECIMAL(10,2)) desc");
$cadena2 = mysqli_query($conexion, "SELECT SUM(resultado) FROM prestamos_morralla WHERE folio = '$folio'");

$row_resultado = mysqli_fetch_array($cadena2);
$prestamo_total = $row_resultado[0];
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
            <h3 class="box-title">Editar Prestamos de Morralla</h3>
          </div>
          <div class="box-body" onload="cargar_tabla();">
            <div class="row container-fluid">
              <div class="col-md-4 col-md-offset-3">
                <div class="input-group">
                  <div class="input-group-addon">
                    Prestamo Total:
                  </div>
                  <input type="text" id="cant_prestamo" class="form-control" placeholder="<?php echo $prestamo_total; ?>" onchange="prestamo_total(this.value)">
                  <div class="input-group-addon">
                    .00
                  </div>
                </div>
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col-md-12" id="tabla">
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
                        $i = 1;
                        while ($row_prestamo = mysqli_fetch_array($cadena)) {
                        ?>
                          <tr>
                            <td>
                              <?php echo $i; ?>
                              <input type="text" name="folio" value="<?php echo $folio; ?>" class="hidden">
                            </td>
                            <td>$ <?php echo $morralla[$i]; ?>
                              <input type="text" value="<?php echo $morralla[$i]; ?>" class="hidden" name="morralla[]">
                            </td>
                            <td>
                              <div class="input-group">
                                <div class="input-group-addon">
                                  $
                                </div>
                                <input value="<?php echo $row_prestamo[2] ?>" type="text" id="resultado<?php echo $i; ?>" onkeyup="if(event.keyCode == 13)llenar(this.value,'<?php echo $morralla[$i]; ?>','<?php echo $i; ?>')" class="form-control" name="resultado[]">
                              </div>
                            </td>
                            <td>
                              <input value="<?php echo $row_prestamo[1] ?>" type="text" name="cantidad[]" id="cantidad<?php echo $i; ?>" class="form-control" readonly>
                            </td>
                          </tr>
                        <?php
                          $i++;
                        }
                        ?>
                      </tbody>
                    </table>
                  </form>
                </div>
              </div>
            </div>

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
          <div class="box-footer text-right">
            <div class="col-md-12">
              <button onclick="verificar_campos();" class="btn btn-warning" id="guardar">Actualizar Préstamo</button>
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
                        <th>Folio</th>
                        <th>Usuario</th>
                        <th>Sucursal</th>
                        <th>Semana</th>
                        <th>Total</th>
                        <th>Editar</th>
                        <th>Abonar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
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
    $('#resultado' + 1).focus();

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
    prestamo_total('<?php echo $prestamo_total; ?>');

    function guardar() {
      $.ajax({
        url: 'actualizar_prestamo.php',
        type: 'POST',
        dateType: 'html',
        data: $('#prestamo').serialize(),
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Se ha Actualizado Correctamente", 2);
            cargar_tabla(<?php echo $folio ?>);
          } else if (respuesta == "vacio") {
            alertify.error("Verifica Campos", 2);
          } else {
            alertify.error("Ha Ocurrido un Error", 2);
          }
        }
      });
    }
    $(function() {
      $('.select2').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es'
      })
    })

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
        //alert(parseFloat(morralla));
        verificar_moneda(resultado);
      }

      $('#cantidad' + id).val(resultado);

      total = parseInt(id) + 1;

      if (total <= 8) {
        $('#resultado' + total).focus();
      }
      prestamo_total($('#cant_prestamo').val());
    }

    function cargar_tabla() {
      $('#lista_prestamo_morralla').dataTable().fnDestroy();
      $('#lista_prestamo_morralla').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
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
            "data": "Editar"
          },
          {
            "data": "Abonar"
          },
        ]
      });
    }
    cargar_tabla(<?php echo $folio ?>);
  </script>
</body>

</html>