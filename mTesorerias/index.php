<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha_actual = date('Y-m-d');
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
            <h3 class="box-title">Captura de Efectivos</h3> <a class="btn btn-danger btn-xs hidden" id="boton_regresar" onclick="regresar()">Regresar</a>
          </div>
          <div class="box-body">
            <form id="form_efectivos">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group hidden" id="editar_fecha">
                    <label for="fecha_inicio">*Fecha:</label>
                    <div class="input-group date form_date" data-date="<?php echo $fecha_actual; ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $fecha_actual ?>" readonly id="fecha" name="fecha">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tabbable">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#1" data-toggle="tab" id="efectivos">Efectivos</a></li>
                  <li><a href="#2" data-toggle="tab" id="tarjetas">Tarjetas Debito</a></li>
                  <li><a href="#3" data-toggle="tab" id="bonos">Bonos</a></li>
                  <li><a href="#5" data-toggle="tab" id="bonos">Abono a Prestamos</a></li>
                  <li><a href="#4" data-toggle="tab" id="otros">Otros</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="1">
                    <br>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>*Efectivo</label>
                          <input type="text" name="folio" id="folio" class="hidden" value="0">
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="efectivo" class="form-control" id="e1" onkeyup="if(event.keyCode == 13 || event.keyCode == 9)siguiente('e',this.value,1)">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>*Efectivo 2</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="efectivo1" class="form-control" id="e2" onkeyup="if(event.keyCode == 13 || event.keyCode == 9)siguiente('e',this.value,2)">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>*Efectivo 3</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="efectivo2" class="form-control" id="e3" onkeyup="if(event.keyCode == 13 || event.keyCode == 9)siguiente('e',this.value,3)">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>*Complemento</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="complemento" class="form-control" id="e4" onkeyup="if(event.keyCode == 13 || event.keyCode == 9)siguiente('e',this.value,4)">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>*Cheques Serfin</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="cheques_serfin" class="form-control" id="e5" onkeyup="if(event.keyCode == 13)siguiente('e',this.value,5)">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>*Cheques Locales</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="cheques_locales" class="form-control" id="e6" onkeyup="if(event.keyCode == 13)siguiente('e',this.value,6)">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>*Tarjetas de Credito</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="tarjetas_credito" class="form-control" id="e7" onkeyup="if(event.keyCode == 13)siguiente('e',this.value,7)">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-offset-7 col-md-3">
                        <h4>Total Efectivos:</h4>
                      </div>
                      <div class="col-md-2">
                        <div class="input-group">
                          <div class="input-group-addon">$</div>
                          <input type="text" name="total_efectivos" id="total_efectivos" class="form-control" readonly>
                        </div>
                      </div>
                    </div>
                    <label>
                      <h5>*No usar comas en las cantidades.</h5>
                    </label>
                    <br>
                    <label>
                      <h5>*Despues de ingresar una cantidad oprimir la de tecla enter.</h5>
                    </label>
                  </div>
                  <div class="tab-pane" id="2">
                    <script>
                      // $('#t1').focus();
                    </script>
                    <br>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>*De Debito</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="tarjetas_debito" class="form-control" id="t1" onkeyup="if(event.keyCode == 13)siguiente('t',this.value,1)">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>*De Prepago</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="tarjetas_prepago" class="form-control" id="t2" onkeyup="if(event.keyCode == 13)siguiente('t',this.value,2)">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>*De Accor</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="tarjetas_accor" class="form-control" id="t3" onkeyup="if(event.keyCode == 13)siguiente('t',this.value,3)">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>*De Ecovale</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="tarjetas_ecovale" class="form-control" id="t4" onkeyup="if(event.keyCode == 13)siguiente('t',this.value,4)">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>*De Efectivale</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="tarjetas_efectivale" class="form-control" id="t5" onkeyup="if(event.keyCode == 13)siguiente('t',this.value,5)">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>*De Sivale</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="tarjetas_sivale" class="form-control" id="t6" onkeyup="if(event.keyCode == 13)siguiente('t',this.value,6)">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>*De Tienda PASS</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="tarjeta_pass" class="form-control" id="t7" onkeyup="if(event.keyCode == 13)siguiente('t',this.value,7)">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>*De Toka</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="tarjeta_toka" class="form-control" id="t8" onkeyup="if(event.keyCode == 13)siguiente('t',this.value,8)">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-offset-7 col-md-3">
                        <h4>Total Tarjetas Varias:</h4>
                      </div>
                      <div class="col-md-2">
                        <div class="input-group">
                          <div class="input-group-addon">$</div>
                          <input type="text" name="total_tarjetas" id="total_tarjetas" class="form-control" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="3">
                    <br>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>*Prestaciones Mex.</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="bonos_prestaciones_mex" class="form-control" id="b1" onkeyup="if(event.keyCode == 13)siguiente('b',this.value,1)">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>*Prestaciones Univer.</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="bonos_universales" class="form-control" id="b2" onkeyup="if(event.keyCode == 13)siguiente('b',this.value,2)">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>*ACCOR</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="bonos_accor" class="form-control" id="b3" onkeyup="if(event.keyCode == 13)siguiente('b',this.value,3)">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>*Efectivale</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="bonos_efectivale" class="form-control" id="b4" onkeyup="if(event.keyCode == 13)siguiente('b',this.value,4)">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>*La Mision Especial</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="bonos_mision_especial" class="form-control" id="b5" onkeyup="if(event.keyCode == 13)siguiente('b',this.value,5)">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>*Creditos</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="bonos_creditos" class="form-control" id="b6" onkeyup="if(event.keyCode == 13)siguiente('b',this.value,6)">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>*Tengo Despensa</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="tengo_despensa" class="form-control" id="b7" onkeyup="if(event.keyCode == 13)siguiente('b',this.value,7)">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>*Toka</label>
                          <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" name="bonos_toka" class="form-control" id="b8" onkeyup="if(event.keyCode == 13)siguiente('b',this.value,8)">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-offset-8 col-md-2">
                        <h4>Total Bonos:</h4>
                      </div>
                      <div class="col-md-2">
                        <div class="input-group">
                          <div class="input-group-addon">$</div>
                          <input type="text" name="total_bonos" class="form-control" id="total_bonos" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="4">
                    <br>
                    <div id="otros_insertar">
                      <label>
                        <h5>*En caso de que exista algun concepto de tipo otro, poner la cantidad y luego darle clic al botón de crear.</h5>
                      </label>
                      <div class="row">
                        <div class="col-md-4">
                          <input type="text" name="cant_input" id="cant_input" class="form-control" value="0">
                        </div>
                        <div class="col-md-2">
                          <input type="button" onclick="crear_otros($('#cant_input').val())" class="btn btn-danger" id="crear" value="Crear">
                        </div>
                        <div class="col-md-2">
                          <input type="button" onclick="quitar($('#cant_input').val());" class="btn btn-danger" id="reset" value="Limpiar">
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>*Concepto</label>
                          <div id="concepto"></div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>*Cantidad</label>
                          <div id="cantidad"></div>
                        </div>
                      </div>
                      <div id="editar_otro" class="hidden">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>*Añadir otro</label>
                            <a class="btn btn-danger" onclick="añadir_boton();" id="crear_editar">+</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="5">
                    <!-- <h4 class="box-title">Abono a Prestamos:</h4> -->
                    <br>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="col-md-3">
                          <center><label>Folio</label></center>
                        </div>
                        <div class="col-md-2">
                          <center><label>Semana</label></center>
                        </div>
                        <div class="col-md-3">
                          <center><label>Usuario</label></center>
                        </div>
                        <div class="col-md-2">
                          <center><label>Abono</label></center>
                        </div>
                        <div class="col-md-2"></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="col-md-3">
                          <center><label id="folio_bd"></label></center>
                        </div>
                        <div class="col-md-2">
                          <center><label id="semana_bd"></label></center>
                        </div>
                        <div class="col-md-3">
                          <center><label id="usuario_bd"></label></center>
                        </div>
                        <div class="col-md-2">
                          <center><label id="abono_bd"></label></center>
                        </div>
                        <div class="col-md-2"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            <div class="box-footer text-right">
              <button class="btn btn-warning" name="guardar" id="guardar" onclick="guardar();" disabled>Guardar</button>
              <a class="btn btn-warning hidden" id="generar_excel">Generar Reporte Excel</a>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Efectivos</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_efectivos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th width="5%">Folio</th>
                        <th>Usuario</th>
                        <th width="15%">Sucursal</th>
                        <th width="15%">Total General</th>
                        <th width="5%">Fecha</th>
                        <th width="5%">Hora</th>
                        <th width="5%">Editar</th>
                        <th width="5%">Eliminar</th>
                        <th width="5%">Ver</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- </div> -->
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
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <!-- Page script -->
  <script>
    $('#cant_input').val("0");

    function checkCampos(obj) {
      var camposRellenados = true;
      obj.find("input").each(function() {
        var $this = $(this);
        if ($this.val().length <= 0) {
          camposRellenados = false;
          return false;
        }
      });
      if (camposRellenados == false) {
        return false;
      } else {
        return true;
      }
    }

    function crear_otros(cantidad) {
      for (var i = 1; i <= cantidad; i++) {

        var input = document.createElement("INPUT");
        input.classList.add('form-control');
        input.name = "concepto[]";
        input.id = 'o' + i;

        document.getElementById("concepto").appendChild(input);

        var br = document.createElement("BR");
        document.getElementById("concepto").appendChild(br);
        br.id = 'br' + i;

        var div = document.createElement("DIV");
        div.classList.add('input-group');
        div.id = "d" + i;
        document.getElementById("cantidad").appendChild(div);

        var div2 = document.createElement("DIV");
        div2.classList.add('input-group-addon');
        document.getElementById("d" + i).appendChild(div2);
        texto = document.createTextNode("$");
        div2.appendChild(texto);

        var input1 = document.createElement("INPUT");
        input1.classList.add('form-control');
        input1.name = "cantidad[]";
        input1.id = 'c' + i;
        document.getElementById("d" + i).appendChild(input1);

        var br1 = document.createElement("BR");
        document.getElementById("cantidad").appendChild(br1);
        br1.id = 'br1' + i;
      }
      $("#cant_input").prop("disabled", true);
      $("#crear").prop("disabled", true);
    }

    function quitar(cantidad) {
      for (var u = 1; u <= cantidad; u++) {
        $('#d' + u).remove();
        $('#o' + u).remove();
        $('#c' + u).remove();
        $('#br' + u).remove();
        $('#br1' + u).remove();
      }

      $("#cant_input").prop("disabled", false);
      $("#crear").prop("disabled", false);
    }
  </script>
  <script>
    $(document).ready(function() {
      //Siempre que salgamos de un campo de texto, se chequeará esta función
      $("#form_efectivos input").keyup(function() {
        var form = $(this).parents("#form_efectivos");
        var check = checkCampos(form);
        if (check) {
          $("#guardar").prop("disabled", false);
        } else {
          $("#guardar").prop("disabled", true);
        }
      });
    });
  </script>
  <script>
    $('#e' + 1).focus();
  </script>
  <script>
    function total_efectivos() {
      var resultado = 0;
      var numero;
      for (var i = 1; i <= 6; i++) {
        numero = $('#e' + i).val();
        if (numero == "") {
          numero = 0;
        }
        resultado += parseFloat(numero);
      }
      $('#total_efectivos').val(resultado.toFixed(2));
    }

    function Totalt() {
      var resultado = 0;
      var numero;

      for (var i = 1; i <= 8; i++) {
        numero = $('#t' + i).val();
        if (numero == "") {
          numero = 0;
        }
        resultado += parseFloat(numero);
      }
      $('#total_tarjetas').val(resultado.toFixed(2));
    }

    function Totalb() {
      var resultado = 0;
      var numero;

      for (var i = 1; i <= 8; i++) {
        numero = $('#b' + i).val();
        if (numero == "") {
          numero = 0;
        }
        resultado += parseFloat(numero);
      }
      $('#total_bonos').val(resultado.toFixed(2));
    }
  </script>
  <script>
    function siguiente(campo, valor, numero) {
      if (campo == "e") {
        total_efectivos();
        if (numero == 1) {
          if (valor == "") {
            $('#e' + numero).val("0");
          }

          next = parseInt(numero) + 1;
          $('#e' + next).focus();
        } else if (numero == 2) {
          if (valor == "") {
            $('#e' + numero).val("0");
          }

          next = parseInt(numero) + 1;
          $('#e' + next).focus();
        } else if (numero == 3) {
          if (valor == "") {
            $('#e' + numero).val("0");
          }

          next = parseInt(numero) + 1;
          $('#e' + next).focus();
        } else if (numero == 4) {
          if (valor == "") {
            $('#e' + numero).val("0");
          }

          next = parseInt(numero) + 1;
          $('#e' + next).focus();
        } else if (numero == 5) {
          if (valor == "") {
            $('#e' + numero).val("0");
          }

          next = parseInt(numero) + 1;
          $('#e' + next).focus();
        } else if (numero == 6) {
          if (valor == "") {
            $('#e' + numero).val("0");
          }

          next = parseInt(numero) + 1;
          $('#e' + next).focus();
        } else if (numero == 7) {
          if (valor == "") {
            $('#e' + numero).val("0");
          }

          $('#t1').focus();
        }
      } else if (campo == "t") {
        Totalt();
        if (numero == 1) {
          if (valor == "") {
            $('#t' + numero).val("0");
          }
          next = parseInt(numero) + 1;
          $('#t' + next).focus();
        } else if (numero == 2) {
          if (valor == "") {
            $('#t' + numero).val("0");
          }

          next = parseInt(numero) + 1;
          $('#t' + next).focus();
        } else if (numero == 3) {
          if (valor == "") {
            $('#t' + numero).val("0");
          }

          next = parseInt(numero) + 1;
          $('#t' + next).focus();
        } else if (numero == 4) {
          if (valor == "") {
            $('#t' + numero).val("0");
          }

          next = parseInt(numero) + 1;
          $('#t' + next).focus();
        } else if (numero == 5) {
          if (valor == "") {
            $('#t' + numero).val("0");
          }

          next = parseInt(numero) + 1;
          $('#t' + next).focus();
        } else if (numero == 6) {
          if (valor == "") {
            $('#t' + numero).val("0");
          }

          next = parseInt(numero) + 1;
          $('#t' + next).focus();
        } else if (numero == 7) {
          if (valor == "") {
            $('#t' + numero).val("0");
          }
          next = parseInt(numero) + 1;
          $('#t' + next).focus();
        } else if (numero == 8) {
          if (valor == "") {
            $('#t' + numero).val("0");
          }
        }
      } else if (campo == "b") {
        Totalb();
        if (numero == 1) {
          if (valor == "") {
            $('#b' + numero).val("0");
          }
          next = parseInt(numero) + 1;
          $('#b' + next).focus();
        } else if (numero == 2) {
          if (valor == "") {
            $('#b' + numero).val("0");
          }

          next = parseInt(numero) + 1;
          $('#b' + next).focus();
        } else if (numero == 3) {
          if (valor == "") {
            $('#b' + numero).val("0");
          }

          next = parseInt(numero) + 1;
          $('#b' + next).focus();
        } else if (numero == 4) {
          if (valor == "") {
            $('#b' + numero).val("0");
          }

          next = parseInt(numero) + 1;
          $('#b' + next).focus();
        } else if (numero == 5) {
          if (valor == "") {
            $('#b' + numero).val("0");
          }

          next = parseInt(numero) + 1;
          $('#b' + next).focus();
        } else if (numero == 6) {
          if (valor == "") {
            $('#b' + numero).val("0");
          }

          next = parseInt(numero) + 1;
          $('#b' + next).focus();
        } else if (numero == 7) {
          if (valor == "") {
            $('#b' + numero).val("0");
          }
          next = parseInt(numero) + 1;
          $('#b' + next).focus();
        } else if (numero == 8) {
          if (valor == "") {
            $('#b' + numero).val("0");
          }
          $('#o1').focus();
        }
      } else if (campo == "o") {
        if (numero == 1) {
          if (valor == "") {
            $('#o' + numero).val("0");
          }
          next = parseInt(numero) + 1;
          $('#o' + next).focus();
        } else if (numero == 2) {
          if (valor == "") {
            $('#o' + numero).val("0");
          }

          next = parseInt(numero) + 1;
          $('#o' + next).focus();
        }
      }
    }

    function verificar_llenado() {
      var campo, valor, numero;
      for (var i = 1; i <= 6; i++) {
        campo = "e";
        valor = $('#e' + i).val();
        siguiente(campo, valor, i);
      }
      for (var o = 1; o <= 7; o++) {
        campo = "t";
        valor = $('#t' + o).val();
        siguiente(campo, valor, o);
      }
      for (var u = 1; u <= 8; u++) {
        campo = "b";
        valor = $('#b' + u).val();
        siguiente(campo, valor, u);
      }
    }

    function mensaje_eliminar(folio) {
      swal({
          title: "¿Está seguro de eliminar registro?",
          icon: "warning",
          buttons: ["No", "Si"],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            eliminar(folio);
            swal("El registro se ha eliminado.", {
              icon: "success",
            });
          } else {
            swal("No se ha eliminado el registro.", {
              icon: "error",
            });
          }
        });
    }

    function eliminar(folio) {
      var url = "eliminar_efectivo.php";
      $.ajax({
        data: {
          'folio': folio
        }, //datos que se envian a traves de ajax
        url: url, //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(respuesta) {
          if (respuesta == "ok") {
            // alertify.success("Registro eliminado correctamente");
            cargar_tabla_efectivos();
          } else {
            alertify.error("Ha ocurrido un error");
          }
        }
      });
    }

    function guardar() {
      verificar_llenado();
      $.ajax({
        url: 'insertar_efectivo.php',
        type: 'POST',
        dateType: 'html',
        data: $('#form_efectivos').serialize(),
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Se ha Guardado el registro");
            cargar_tabla_efectivos();
            quitar($('#cant_input').val());
            $(":text").val(''); //Limpiar los campos tipo Text
            regresar();
          } else if (respuesta == "vacio") {
            alertify.error("Verifica Campos");
          } else {
            alert(respuesta);
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
    }

    function cargar_tabla_efectivos() {
      $('#lista_efectivos').dataTable().fnDestroy();
      $('#lista_efectivos').DataTable({
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
            title: 'Efectivos',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Efectivos',
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
          "url": "tabla_efectivos.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "#"
          },
          {
            "data": "Folio"
          },
          {
            "data": "Usuario"
          },
          {
            "data": "Sucursal"
          },
          {
            "data": "Total_general"
          },
          {
            "data": "Fecha"
          },
          {
            "data": "Hora"
          },
          {
            "data": "Editar"
          },
          {
            "data": "Eliminar"
          },
          {
            "data": "Ver"
          },
        ]
      });
    }

    function cargar_otros(folio) {
      var inicio, final;
      var concepto, cantidad, id;
      $.ajax({
        data: {
          'folio': folio,
        }, //datos que se envian a traves de ajax
        url: 'cantidad.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) {
          var array = eval(response);
          inicio = array[1];
          final = array[2];

          for (var i = inicio; i <= final; i++) {
            $.ajax({
              data: {
                'i': i,
              }, //datos que se envian a traves de ajax
              url: 'datos.php', //archivo que recibe la peticion
              type: 'POST', //método de envio
              dateType: 'html',
              success: function(respuesta) {
                var array_datos = eval(respuesta);

                concepto = array_datos[0];
                cantidad = array_datos[1];
                id = array_datos[2];
                cant_inputs = array_datos[3];

                if (cant_inputs != 0) {
                  var input = document.createElement("INPUT");
                  input.classList.add('form-control');
                  input.name = "concepto[]";
                  input.id = 'dinamico_o' + i;
                  input.value = concepto;
                  document.getElementById("concepto").appendChild(input);
                  // input.appendChild(text);

                  var br = document.createElement("BR");
                  document.getElementById("concepto").appendChild(br);
                  br.id = 'dinamico_br' + i;

                  var div = document.createElement("DIV");
                  div.classList.add('input-group');
                  div.id = "dinamico_d" + i;
                  document.getElementById("cantidad").appendChild(div);

                  var input1 = document.createElement("INPUT");
                  input1.classList.add('form-control');
                  input1.name = "cantidad[]";
                  input1.id = 'dinamico_c' + i;
                  input1.value = cantidad;
                  document.getElementById("cantidad").appendChild(input1);

                  var input2 = document.createElement("INPUT");
                  input2.classList.add('form-control');
                  input2.classList.add('hidden');
                  input2.name = "id[]";
                  input2.id = 'dinamico_c' + i;
                  input2.value = id;
                  document.getElementById("cantidad").appendChild(input2);

                  var br1 = document.createElement("BR");
                  document.getElementById("cantidad").appendChild(br1);
                  br1.id = 'dinamico_br1' + i;
                }
              }
            });
          }
        }
      });
    }

    function cargar_abonos(fecha, sucursal) {
      var fecha = (fecha === undefined) ? "" : fecha;
      var sucursal = (sucursal === undefined) ? "" : sucursal;
      $.ajax({
        data: {
          'fecha': fecha,
          'sucursal': sucursal
        }, //datos que se envian a traves de ajax
        url: 'datos_abonos.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(respuesta) {
          var array1 = eval(respuesta);

          $('#folio_bd').html(array1[0]);
          $('#semana_bd').html(array1[1]);
          $('#usuario_bd').html(array1[2]);
          $('#abono_bd').html(array1[3]);
        }
      });
    }
    cargar_abonos();

    function editar_efectivos(folio) {
      $("#guardar").prop("disabled", false);
      $.ajax({
        data: {
          'folio': folio
        }, //datos que se envian a traves de ajax
        url: 'datos2.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(respuesta) {
          cargar_otros(folio);

          var array = eval(respuesta);

          $('#folio').val(folio);

          $('#e1').val(array[0]);
          $('#e2').val(array[1]);
          $('#e3').val(array[2]);
          $('#e4').val(array[3]);
          $('#e5').val(array[4]);
          $('#e6').val(array[5]);
          $('#e7').val(array[6]);
          $('#total_efectivos').val(array[7]);

          $('#t1').val(array[8]);
          $('#t2').val(array[9]);
          $('#t3').val(array[10]);
          $('#t4').val(array[11]);
          $('#t5').val(array[12]);
          $('#t6').val(array[13]);
          $('#t7').val(array[14]);
          $('#t8').val(array[15]);
          $('#total_tarjetas').val(array[16]);

          $('#b1').val(array[17]);
          $('#b2').val(array[18]);
          $('#b3').val(array[19]);
          $('#b4').val(array[20]);
          $('#b5').val(array[21]);
          $('#b6').val(array[22]);
          $('#b7').val(array[23]);
          $('#b8').val(array[24]);
          $('#total_bonos').val(array[25]);

          $('#fecha').val(array[26]);
          $('#editar_fecha').removeClass("hidden");
          cargar_abonos(array[27]);

          $("#otros_insertar").addClass('hidden');
          $("#editar_otro").removeClass('hidden');

          $("#boton_regresar").removeClass('hidden');

          $('#fecha_div').prop('data-date', array[26]);
        }
      });
    }

    function añadir_boton() {
      var input = document.createElement("INPUT");
      input.classList.add('form-control');
      input.name = "concepto[]";
      input.id = 'o10';
      document.getElementById("concepto").appendChild(input);

      var br = document.createElement("BR");
      document.getElementById("concepto").appendChild(br);
      br.id = 'br10';

      var div = document.createElement("DIV");
      div.classList.add('input-group');
      div.id = "d10";
      document.getElementById("cantidad").appendChild(div);

      var input1 = document.createElement("INPUT");
      input1.classList.add('form-control');
      input1.name = "cantidad[]";
      input1.id = 'c10';
      document.getElementById("cantidad").appendChild(input1);

      var input2 = document.createElement("INPUT");
      input2.classList.add('form-control');
      input2.classList.add('hidden');
      input2.name = "id[]";
      input2.id = 'c10';
      input2.value = '0';
      document.getElementById("cantidad").appendChild(input2);

      $('#crear_editar').hide();
    }

    function regresar() {
      $("#guardar").prop("disabled", true);
      cargar_abonos();

      $(':input').val("");
      $('#folio').val("0");

      $('#fecha').val("0");
      $('#cant_input').val("0");

      $('#editar_fecha').addClass('hidden');

      if ($('#generar_excel').hasClass("hidden")) {} else {
        $('#generar_excel').addClass('hidden');
      }

      if ($('#guardar').hasClass("hidden")) {
        $('#guardar').removeClass('hidden');
      } else {}
      if ($('#boton_regresar').hasClass("hidden")) {} else {
        $('#boton_regresar').addClass('hidden');
      }

      $(':input').removeAttr('readonly');
      $("[id*=dinamico]").remove();

      if ($('#otros_insertar').hasClass("hidden")) {
        $('#otros_insertar').removeClass('hidden');
      } else {}
      if ($('#editar_otro').hasClass("hidden")) {} else {
        $('#editar_otro').addClass('hidden');
      }

      $('#crear').val("Crear");
      $('#reset').val("Limpiar");
    }

    function ver_efectivos(folio) {
      $("[id*=dinamico]").remove();
      $.ajax({
        data: {
          'folio': folio
        }, //datos que se envian a traves de ajax
        url: 'datos2.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(respuesta) {
          cargar_otros(folio);

          var array = eval(respuesta);

          $('#folio').val(folio);

          $('#e1').val(array[0]);
          $('#e2').val(array[1]);
          $('#e3').val(array[2]);
          $('#e4').val(array[3]);
          $('#e5').val(array[4]);
          $('#e6').val(array[5]);
          $('#e7').val(array[6]);
          $('#total_efectivos').val(array[7]);

          $('#t1').val(array[8]);
          $('#t2').val(array[9]);
          $('#t3').val(array[10]);
          $('#t4').val(array[11]);
          $('#t5').val(array[12]);
          $('#t6').val(array[13]);
          $('#t7').val(array[14]);
          $('#t8').val(array[15]);
          $('#total_tarjetas').val(array[16]);

          $('#b1').val(array[17]);
          $('#b2').val(array[18]);
          $('#b3').val(array[19]);
          $('#b4').val(array[20]);
          $('#b5').val(array[21]);
          $('#b6').val(array[22]);
          $('#b7').val(array[23]);
          $('#b8').val(array[24]);
          $('#total_bonos').val(array[25]);

          cargar_abonos(array[26], array[27]);

          $(':input').attr('readonly', 'true');

          $("#otros_insertar").addClass('hidden');

          $("#guardar").addClass('hidden');

          $("#generar_excel").removeClass('hidden');

          $("#generar_excel").attr('href', 'reporte_excel_efectivos.php?folio=' + folio);

          $("#boton_regresar").removeClass('hidden');
        }
      });
    }
    cargar_tabla_efectivos();
  </script>
  <script>
    $('.form_date').datetimepicker({
      language: 'es',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0
    });
  </script>
</body>

</html>