<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');

  $folio        = $_GET['folio'];
  $cadena       = mysqli_query($conexion,"SELECT * FROM efectivos WHERE folio = '$folio'");
  $row_efectivo = mysqli_fetch_array($cadena);

  $cadena = "SELECT abonos.folio,abonos.abono,CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno)AS nomb,prestamos_morralla.semana
              FROM abonos
              INNER JOIN usuarios ON usuarios.id = abonos.id_usuario
              INNER JOIN personas ON personas.id = usuarios.id_persona
              INNER JOIN prestamos_morralla ON prestamos_morralla.folio = abonos.folio
              WHERE abonos.id_sucursal = '$row_efectivo[26]'
              AND abonos.fecha = '$row_efectivo[24]'
              GROUP BY abonos.folio";
  $consulta = mysqli_query($conexion,$cadena);
  $existen = mysqli_num_rows($consulta);
 ?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../head.php'; ?>
  <link rel="stylesheet" href="../mJuntas/estilos.css">
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
            <h3 class="box-title">Editar Captura de Efectivos</h3>
          </div>
          <div class="box-body">
            <form id="form_efectivos">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="fecha_inicio">*Fecha:</label>
                    <div class="input-group date form_date" data-date="<?php echo $row_efectivo[24] ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $row_efectivo[24] ?>" readonly id="fecha" name="fecha">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
              </div>
            <div class="tabbable">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#1" data-toggle="tab">Efectivos</a></li>
                    <li><a href="#2" data-toggle="tab">Tarjetas Credito</a></li>
                    <li><a href="#3" data-toggle="tab">Bonos</a></li>
                    <li><a href="#5" data-toggle="tab" id="bonos">Abono a Prestamos</a></li>
                    <li><a href="#4" data-toggle="tab">Otros</a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="1">
                      <br>
                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label>*Efectivo</label>
                              <div class="input-group">
                                <div class="input-group-addon">$</div>
                                <input value="<?php echo $row_efectivo[2]?>" type="text" name="efectivo" class="form-control" id="e1" onkeyup="if(event.keyCode == 13)siguiente('e',this.value,1)">
                                <input type="text" name="folio" class="hidden" value="<?php echo $folio?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <label>*Efectivo 2</label>
                              <div class="input-group">
                                <div class="input-group-addon">$</div>
                                <input value="<?php echo $row_efectivo[30]?>" type="text" name="efectivo1" class="form-control" id="e2" onkeyup="if(event.keyCode == 13 || event.keyCode == 9)siguiente('e',this.value,2)">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <label>*Efectivo 3</label>
                              <div class="input-group">
                                <div class="input-group-addon">$</div>
                                <input value="<?php echo $row_efectivo[31]?>" type="text" name="efectivo2" class="form-control" id="e3" onkeyup="if(event.keyCode == 13 || event.keyCode == 9)siguiente('e',this.value,3)">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <label>*Complemento</label>
                              <div class="input-group">
                                <div class="input-group-addon">$</div>
                                <input value="<?php echo $row_efectivo[3]?>" type="text" name="complemento" class="form-control" id="e4" onkeyup="if(event.keyCode == 13)siguiente('e',this.value,4)">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <label>*Cheques Serfin</label>
                              <div class="input-group">
                                <div class="input-group-addon">$</div>
                                <input value="<?php echo $row_efectivo[4]?>" type="text" name="cheques_serfin" class="form-control" id="e5" onkeyup="if(event.keyCode == 13)siguiente('e',this.value,5)">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <label>*Cheques Locales</label>
                              <div class="input-group">
                                <div class="input-group-addon">$</div>
                                <input value="<?php echo $row_efectivo[5]?>" type="text" name="cheques_locales" class="form-control" id="e6" onkeyup="if(event.keyCode == 13)siguiente('e',this.value,6)">
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
                                <input value="<?php echo $row_efectivo[7]?>" type="text" name="tarjetas_credito" class="form-control" id="e7" onkeyup="if(event.keyCode == 13)siguiente('e',this.value,7)">
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
                              <input type="text" value="<?php echo $row_efectivo[6]?>" name="total_efectivos" id="total_efectivos" class="form-control" readonly>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="2">
                      <br>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>*De Debito</label>
                            <div class="input-group">
                              <div class="input-group-addon">$</div>
                              <input value="<?php echo $row_efectivo[8]?>" type="text" name="tarjetas_debito" class="form-control" id="t1" onkeyup="if(event.keyCode == 13)siguiente('t',this.value,1)">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>*De Prepago</label>
                            <div class="input-group">
                              <div class="input-group-addon">$</div>
                              <input value="<?php echo $row_efectivo[9]?>" type="text" name="tarjetas_prepago" class="form-control" id="t2" onkeyup="if(event.keyCode == 13)siguiente('t',this.value,2)">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>*De Accor</label>
                            <div class="input-group">
                              <div class="input-group-addon">$</div>
                              <input value="<?php echo $row_efectivo[10]?>" type="text" name="tarjetas_accor" class="form-control" id="t3" onkeyup="if(event.keyCode == 13)siguiente('t',this.value,3)">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>*De Ecovale</label>
                            <div class="input-group">
                              <div class="input-group-addon">$</div>
                              <input value="<?php echo $row_efectivo[11]?>" type="text" name="tarjetas_ecovale" class="form-control" id="t4" onkeyup="if(event.keyCode == 13)siguiente('t',this.value,4)">
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
                              <input value="<?php echo $row_efectivo[12]?>" type="text" name="tarjetas_efectivale" class="form-control" id="t5" onkeyup="if(event.keyCode == 13)siguiente('t',this.value,5)">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>*De Sivale</label>
                            <div class="input-group">
                              <div class="input-group-addon">$</div>
                              <input value="<?php echo $row_efectivo[13]?>" type="text" name="tarjetas_sivale" class="form-control" id="t6" onkeyup="if(event.keyCode == 13)siguiente('t',this.value,6)">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>*De Tienda PASS</label>
                            <div class="input-group">
                              <div class="input-group-addon">$</div>
                              <input value="<?php echo $row_efectivo[14]?>" type="text" name="tarjeta_pass" class="form-control" id="t7" onkeyup="if(event.keyCode == 13)siguiente('t',this.value,7)">
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
                            <input value="<?php echo $row_efectivo[15]?>" type="text" name="total_tarjetas" id="total_tarjetas" class="form-control" readonly>
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
                              <input value="<?php echo $row_efectivo[16]?>" type="text" name="bonos_prestaciones_mex" class="form-control" id="b1" onkeyup="if(event.keyCode == 13)siguiente('b',this.value,1)">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label>*Prestaciones Univer.</label>
                            <div class="input-group">
                              <div class="input-group-addon">$</div>
                              <input value="<?php echo $row_efectivo[17]?>" type="text" name="bonos_universales" class="form-control" id="b2" onkeyup="if(event.keyCode == 13)siguiente('b',this.value,2)">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label>*ACCOR</label>
                            <div class="input-group">
                              <div class="input-group-addon">$</div>
                              <input value="<?php echo $row_efectivo[18]?>" type="text" name="bonos_accor" class="form-control" id="b3" onkeyup="if(event.keyCode == 13)siguiente('b',this.value,3)">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label>*Efectivale</label>
                            <div class="input-group">
                              <div class="input-group-addon">$</div>
                              <input value="<?php echo $row_efectivo[19]?>" type="text" name="bonos_efectivale" class="form-control" id="b4" onkeyup="if(event.keyCode == 13)siguiente('b',this.value,4)">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label>*La Mision Especial</label>
                            <div class="input-group">
                              <div class="input-group-addon">$</div>
                              <input value="<?php echo $row_efectivo[20]?>" type="text" name="bonos_mision_especial" class="form-control" id="b5" onkeyup="if(event.keyCode == 13)siguiente('b',this.value,5)">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label>*Creditos</label>
                            <div class="input-group">
                              <div class="input-group-addon">$</div>
                              <input value="<?php echo $row_efectivo[21]?>" type="text" name="bonos_creditos" class="form-control" id="b6" onkeyup="if(event.keyCode == 13)siguiente('b',this.value,6)">
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
                              <input value="<?php echo $row_efectivo[32]?>" type="text" name="tengo_despensa" class="form-control" id="b7" onkeyup="if(event.keyCode == 13)siguiente('b',this.value,7)">
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
                            <input value="<?php echo $row_efectivo[22]?>" type="text" name="total_bonos" class="form-control" id="total_bonos" readonly>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="4">
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
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>*Añadir otro</label>
                            <a class="btn btn-danger" onclick="añadir_boton();" id="crear">+</a>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div id="nuevo_concepto"></div>
                        </div>
                        <div class="col-md-4">
                          <div id="nuevo_cantidad"></div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="5">
                      <h4 class="box-title">Abono a Prestamos:</h4>
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table id="lista_abonos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th>Folio</th>
                                <th>Semana</th>
                                <th>Usuario</th>
                                <th>Abono</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                if($existen == 0){
                              ?>
                              <tr>
                                <th align="center" colspan="3">No hay Datos.</th>
                              </tr>
                              <?php
                                }
                                else{
                                  while($row_abonos = mysqli_fetch_array($consulta)){
                              ?>
                              <tr>
                                <th><?php echo $row_abonos[0];?></th>
                                <th><?php echo $row_abonos[3];?></th>
                                <th><?php echo $row_abonos[2];?></th>
                                <th>$<?php echo $row_abonos[1];?></th>
                              </tr>
                              <?php
                                  }
                                }
                              ?>
                            </tbody>  
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                </form>
              <div class="box-footer text-right">
                <button class="btn btn-warning" name="guardar" id="guardar" onclick="guardar();">Actualizar</button>
              </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Faltantes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_efectivos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th>Folio</th>
                        <th>Usuario</th>
                        <th>Sucursal</th>
                        <th>Total General</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                        <th>Ver</th>
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
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<!-- Page script -->
<script>
  function verificar_llenado(){
    var campo,valor,numero;
    for (var i = 1; i <= 7; i++) {
      campo = "e";
      valor = $('#e'+i).val();
      siguiente(campo,valor,i);
    }
    for (var o = 1; o <= 7; o++) {
      campo = "t";
      valor = $('#t'+o).val();
      siguiente(campo,valor,o);
    }
    for (var u = 1; u <= 6; u++) {
      campo = "b";
      valor = $('#t'+u).val();
      siguiente(campo,valor,u);
    }
  }
</script>
  <script>
    function añadir_boton(){
      var input = document.createElement("INPUT");
      input.classList.add('form-control');
      input.name = "concepto[]";
      input.id = 'o10';
      document.getElementById("nuevo_concepto").appendChild(input);
      // input.appendChild(text);

      var br = document.createElement("BR");
      document.getElementById("nuevo_concepto").appendChild(br);
      br.id = 'br10';

      var div = document.createElement("DIV");
      div.classList.add('input-group');
      div.id = "d10";
      document.getElementById("nuevo_cantidad").appendChild(div);

      var input1 = document.createElement("INPUT");
      input1.classList.add('form-control');
      input1.name = "cantidad[]";
      input1.id = 'c10';
      document.getElementById("nuevo_cantidad").appendChild(input1);

      var input2 = document.createElement("INPUT");
      input2.classList.add('form-control');
      input2.classList.add('hidden');
      input2.name = "id[]";
      input2.id = 'c10';
      input2.value = '0';
      document.getElementById("nuevo_cantidad").appendChild(input2);

      $('#crear').hide();
    }
  </script>
  <script>
    var folio = <?php echo $folio;?>;
    var inicio,final;
    var concepto,cantidad,id;
    $(document).ready(function(){
        $.ajax({
        data: {
            'folio': folio,
        }, //datos que se envian a traves de ajax
        url: 'cantidad.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) 
          {
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
              success: function(respuesta)
              {
                var array_datos = eval(respuesta);

                concepto    = array_datos[0];
                cantidad    = array_datos[1];
                id          = array_datos[2];
                cant_inputs = array_datos[3];

                if(cant_inputs != 0){
                  var input = document.createElement("INPUT");
                  input.classList.add('form-control');
                  input.name = "concepto[]";
                  input.id = 'o'+i;
                  input.value = concepto;
                  document.getElementById("concepto").appendChild(input);
                  // input.appendChild(text);

                  var br = document.createElement("BR");
                  document.getElementById("concepto").appendChild(br);
                  br.id = 'br'+i;

                  var div = document.createElement("DIV");
                  div.classList.add('input-group');
                  div.id = "d" + i;
                  document.getElementById("cantidad").appendChild(div);

                  var input1 = document.createElement("INPUT");
                  input1.classList.add('form-control');
                  input1.name = "cantidad[]";
                  input1.id = 'c'+i;
                  input1.value = cantidad;
                  document.getElementById("cantidad").appendChild(input1);

                  var input2 = document.createElement("INPUT");
                  input2.classList.add('form-control');
                  input2.classList.add('hidden');
                  input2.name = "id[]";
                  input2.id = 'c'+i;
                  input2.value = id;
                  document.getElementById("cantidad").appendChild(input2);

                  var br1 = document.createElement("BR");
                  document.getElementById("cantidad").appendChild(br1);
                  br1.id = 'br1'+i;
                }
              }
            });
            
          }
        }
      });
    });
  </script>
  <script type="text/javascript">
      $('.form_datetime').datetimepicker({
          //language:  'fr',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 2,
          forceParse: 0,
          showMeridian: 1
      });
      $('.form_date').datetimepicker({
          language:  'es',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 2,
          minView: 2,
          forceParse: 0
      });
      $('.form_time').datetimepicker({
          language:  'fr',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 1,
          minView: 0,
          maxView: 1,
          forceParse: 0
      });
  </script>
<script>
  $(document).ready(function() {
    //Siempre que salgamos de un campo de texto, se chequeará esta función
    $("#form_efectivos input").keyup(function() {
        var form = $(this).parents("#form_efectivos");
        var check = checkCampos(form);
        if(check) {
            $("#guardar").prop("disabled", false);
        }
        else {
            $("#guardar").prop("disabled", true);
        }
    });
});
//Función para comprobar los campos de texto
function checkCampos(obj) {
    var camposRellenados = true;
    obj.find("input").each(function() {
    var $this = $(this);
            if( $this.val().length <= 0 ) {
                camposRellenados = false;
                return false;
            }
    });
    if(camposRellenados == false) {
        return false;
    }
    else {
        return true;
    }
}
</script>
<script>
  $('#e'+1).focus();
</script>
<script>
  function total_efectivos(){
    var resultado = 0;
    var numero;

    for (var i = 1; i <= 6; i++) {
        numero = $('#e'+i).val();
        if (numero == ""){
          numero = 0;
        }
        resultado += parseFloat(numero);
      }
    $('#total_efectivos').val(resultado.toFixed(2));
  }
  function Totalt(){
    var resultado = 0;
    var numero;

    for (var i = 1; i <= 7; i++) {
        numero = $('#t'+i).val();
        if (numero == ""){
          numero = 0;
        }
        resultado += parseFloat(numero);
      }
    $('#total_tarjetas').val(resultado.toFixed(2));
  }
  function Totalb(){
    var resultado = 0;
    var numero;

    for (var i = 1; i <= 7; i++) {
        numero = $('#b'+i).val();
        if (numero == ""){
          numero = 0;
        }
        resultado += parseFloat(numero);
      }
    $('#total_bonos').val(resultado.toFixed(2));
  }
</script>
<script>
  function siguiente(campo,valor,numero){
    if (campo == "e")
    {
      total_efectivos();
      if(numero == 1)
      {
        if (valor == "")
        {
          $('#e'+numero).val("0");
        }

        next = parseInt(numero) + 1;
        $('#e'+next).focus();  
      }
      else if(numero == 2)
      {
        if (valor == "")
        {
          $('#e'+numero).val("0");
        }

        next = parseInt(numero) + 1;
        $('#e'+next).focus();    
      }
      else if(numero == 3)
      {
        if (valor == "")
        {
          $('#e'+numero).val("0");
        }

        next = parseInt(numero) + 1;
        $('#e'+next).focus();  
      }
      else if(numero == 4)
      {
        if (valor == "")
        {
          $('#e'+numero).val("0");
        }

        next = parseInt(numero) + 1;
        $('#e'+next).focus();  
      }
      else if(numero == 5)
      {
        if (valor == "")
        {
          $('#e'+numero).val("0");
        }

        next = parseInt(numero) + 1;
        $('#e'+next).focus();  
      }
      else if(numero == 6)
      {
        if (valor == "")
        {
          $('#e'+numero).val("0");
        }

        next = parseInt(numero) + 1;
        $('#e'+next).focus();  
      }
      else if(numero == 7)
      {
        if (valor == "")
        {
          $('#e'+numero).val("0");
        }
        
        $('#t1').focus();  
      }
    }
    else if (campo == "t")
    { 
      Totalt();
      if(numero == 1)
      {
        if (valor == "")
        {
          $('#t'+numero).val("0");
        }
        next = parseInt(numero) + 1;
        $('#t'+next).focus();  
      }
      else if(numero == 2)
      {
        if (valor == "")
        {
          $('#t'+numero).val("0");
        }

        next = parseInt(numero) + 1;
        $('#t'+next).focus();    
      }
      else if(numero == 3)
      {
        if (valor == "")
        {
          $('#t'+numero).val("0");
        }

        next = parseInt(numero) + 1;
        $('#t'+next).focus();  
      }
      else if(numero == 4)
      {
        if (valor == "")
        {
          $('#t'+numero).val("0");
        }

        next = parseInt(numero) + 1;
        $('#t'+next).focus();  
      }
      else if(numero == 5)
      {
        if (valor == "")
        {
          $('#t'+numero).val("0");
        }

        next = parseInt(numero) + 1;
        $('#t'+next).focus();  
      }
      else if(numero == 6)
      {
        if (valor == "")
        {
          $('#t'+numero).val("0");
        }

        next = parseInt(numero) + 1;
        $('#t'+next).focus();  
      }
      else if(numero == 7)
      {
        if (valor == "")
        {
          $('#t'+numero).val("0");
        }

        $('#b1').focus();  
      }
    }
    else if(campo == "b")
    {
      Totalb();
      if(numero == 1)
      {
        if (valor == "")
        {
          $('#b'+numero).val("0");
        }
        next = parseInt(numero) + 1;
        $('#b'+next).focus();  
      }
      else if(numero == 2)
      {
        if (valor == "")
        {
          $('#b'+numero).val("0");
        }

        next = parseInt(numero) + 1;
        $('#b'+next).focus();    
      }
      else if(numero == 3)
      {
        if (valor == "")
        {
          $('#b'+numero).val("0");
        }

        next = parseInt(numero) + 1;
        $('#b'+next).focus();  
      }
      else if(numero == 4)
      {
        if (valor == "")
        {
          $('#b'+numero).val("0");
        }

        next = parseInt(numero) + 1;
        $('#b'+next).focus();  
      }
        else if(numero == 5)
        {
          if (valor == "")
          {
            $('#b'+numero).val("0");
          }

          next = parseInt(numero) + 1;
          $('#b'+next).focus();  
        }
        else if(numero == 6)
        {
          if (valor == "")
          {
            $('#b'+numero).val("0");
          }

          next = parseInt(numero) + 1;
          $('#b'+next).focus();  
        }
        else if(numero == 7)
        {
          if (valor == "")
          {
            $('#b'+numero).val("0");
          }
          $('#o1').focus();
        }
    }
    else if(campo == "o")
    {
      if(numero == 1)
      {
        if (valor == "")
        {
          $('#o'+numero).val("0");
        }
        next = parseInt(numero) + 1;
        $('#o'+next).focus();  
      }
      else if(numero == 2)
      {
        if (valor == "")
        {
          $('#o'+numero).val("0");
        }

        next = parseInt(numero) + 1;
        $('#o'+next).focus();    
      }
    }
  }
</script>
<script>
  function mensaje(folio){
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
        swal("No se ha eliminado el registro.",{
          icon: "error",
        });
      }
    });
  }
  function eliminar(folio){
    var url = "eliminar_efectivo.php";
    $.ajax({
      data: {
              'folio':folio
            }, //datos que se envian a traves de ajax
      url: url, //archivo que recibe la peticion
      type: 'POST', //método de envio
      dateType: 'html',
      success: function(respuesta){
        if (respuesta=="ok") {
          alertify.success("Registro eliminado correctamente");
          cargar_tabla();
        }else {
          alertify.error("Ha ocurrido un error");
        }
      }
     });
  }
</script>
<script>
  function guardar(){
    verificar_llenado();
    $.ajax({
      url: 'actualizar_efectivo.php',
      type: 'POST',
      dateType: 'html',
      data: $('#form_efectivos').serialize(),
      success:function(respuesta){
          if(respuesta == "ok")
          {
            alertify.success("Se ha Actualizado el registro");
            limpiar();
            cargar_tabla_efectivos();
          }
          else
          {
            alert(respuesta);
            // alertify.error("Ha ocurrido un Error");
          }
      }
    });
  }
</script>
<script>
  function limpiar() {
    var i = 1;
    while(i <= 8){
      $('#faltante'+i).val("");
      i ++;
    }
  }
</script>
<script>
  $(function () {
    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  })
</script>
<script>
  function total_tarjetas(cantidad,morralla,id){
    if(cantidad == "")
    {
      cantidad = 0;
      $('#faltante'+id).val(cantidad);
    }
      resultado = cantidad * morralla;

      $('#resultado'+id).val(resultado.toFixed(2));

      total = parseInt(id) + 1;

      if (total <= 8)
      {
        $('#faltante'+total).focus();
      }
  }
  function cargar_tabla_efectivos(folio){
    $('#lista_efectivos').dataTable().fnDestroy();
    $('#lista_efectivos').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "dom": 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
      "ajax": {
          "type": "POST",
          "url": "tabla_efectivos.php",
          "dataSrc": "",
          "data": {'folio':folio}
      },
      "columns": [
          { "data": "#" },
          { "data": "Folio" },
          { "data": "Usuario" },
          { "data": "Sucursal" },
          { "data": "Total_general" },
          { "data": "Fecha" },
          { "data": "Hora" },
          { "data": "Editar" },
          { "data": "Eliminar" },
          { "data": "Ver" },
      ]
   });
  }
</script>
<script>
  cargar_tabla_efectivos(<?php echo $folio?>);
</script>
</body>
</html>