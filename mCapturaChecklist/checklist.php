<?php
  include '../global_seguridad/verificar_sesion.php';
  $checklist = $_GET['checklist'];
  $sucursal  = $_GET['sucursal'];
  $sucursal = ($sucursal == 0)?$id_sede:$sucursal;
  $cadena_c = mysqli_query($conexion,"SELECT nombre FROM checklist WHERE id = '$checklist'");
  $row_c    = mysqli_fetch_array($cadena_c);

  $estado = "collapse-box";
  $cadena = "SELECT sub_departamentos.id, sub_departamentos.nombre,checklist.tipo
      FROM detalle_checklist 
      INNER JOIN sub_departamentos ON sub_departamentos.id = detalle_checklist.id_subdepartamento
      INNER JOIN checklist ON checklist.id = detalle_checklist.id_checklist
      WHERE detalle_checklist.activo = '1' 
      AND detalle_checklist.programada = '1'  AND id_checklist = '$checklist' GROUP BY sub_departamentos.id";
  $consulta = mysqli_query($conexion, $cadena);
  $numero = 1;
  $numeroc = 1;

  function sumar_hora($id, $tiempo){
    include '../global_settings/conexion.php';
    $hora_mas = "";
    if($tiempo == 1){
      $hora_mas = "00:15:00";
    }else if($tiempo == 2){
      $hora_mas = "00:30:00";
    }else if($tiempo = 3){
      $hora_mas = "00:45:00";
    }else if($tiempo = 4){
      $hora_mas = "01:00:00";
    }
    $cadena_f   = mysqli_query($conexion,"SELECT ADDTIME(hora_inicio, '$hora_mas') FROM detalle_checklist WHERE id = '$id'");
    $row_f      = mysqli_fetch_array($cadena_f);
    $nueva_hora = substr($row_f[0], 0,8);
    return $nueva_hora;
  }
  function verificar_dia($id, $dia){
    include '../global_settings/conexion.php';
    if($dia == 1){
      $dia_bd = "l";
    }else if($dia == 2){
      $dia_bd = "m";
    }else if($dia = 3){
      $dia_bd = "x";
    }else if($dia = 4){
      $dia_bd = "j";
    }else if($dia = 5){
      $dia_bd = "v";
    }else if($dia = 6){
      $dia_bd = "s";
    }else if($dia = 7){
      $dia_bd = "d";
    }
    $cadena_d = mysqli_query($conexion,"SELECT $dia_bd FROM detalle_checklist WHERE id = '$id'");
    $row_d    = mysqli_fetch_array($cadena_d);
    return $row_d[0];
  }

  function verificar_mes($dia,$fecha){
    $existe_m = 0;
    $nuevafecha = strtotime ( '+1 month' , strtotime($fecha));
    $nuevafecha = date ( 'Y-m-d ' , $nuevafecha );
    $dia_nuevo = substr($nuevafecha, 8,2);

    if($dia_nuevo == $dia || $dia_nuevo == '28' || $dia_nuevo == '29' || $dia_nuevo == '30' || $dia_nuevo == '31'){
      $existe_m = 1;
    }else{
      $existe_m = 0;
    }
    return $existe_m;
  }

  function verificar_year($dia_mes,$fecha){
    $existe_a = 0;
    $nuevafecha = strtotime ( '+1 year' , strtotime($fecha));
    $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
    $dia_mes_nuevo = substr($nuevafecha, 0,4);
    if($dia_mes_nuevo == $dia_mes){
      $existe_a = 1;
    }
    return $existe_a;
  }

  function _data_first_month_day() {
    $month = date('m');
    $year = date('Y');
    return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
  }
  function verificar_quincena(){
    $fecha=date("Y-m-d"); 
    $primer_dia = _data_first_month_day($fecha);
    //generamos el ciclo
    $existe_q = 0;
    $tiempo=1; // numero de quincenas que queremos generar
    $i=0; //contador
    while($i <= $tiempo) {
      $dayx=date('d', strtotime($primer_dia)) ; // sacamos el dia de $last_day
      $hoy3=date('Y-m', strtotime($primer_dia)) ;// sacamos el año y mes de $last_day
      //si el dia del primer pago es menor a quince el primer pago lo programo al dia ultimo de ese mes si no se va hasta la otra quincena del siguiente
      if($dayx <= 15){
        $aux = date('Y-m-d', strtotime("{$hoy3} + 1 month" )) ;
        $primer_dia = date('Y-m-d', strtotime("{$aux} -1 day" )) ;
        $primer_dia;//imprimo la fecha de pago
      }else{
        $aux = date('Y-m-d', strtotime("{$hoy3} + 1 month" ) ) ;
        $primer_dia = date('Y-m-d', strtotime("{$aux} +14 day" )) ;
        $primer_dia;//imprimo la fecha de pago
      }
      if($fecha == $primer_dia){
        $existe_q = 1;
      }
      $i++;
    } 
    return $existe_q;
  }
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
      <form id="form_datos">
        <input type="hidden" name="checklist" value="<?php echo $checklist;?>">
        <input type="hidden" name="sucursal" value="<?php echo $sucursal;?>">
      <center><h2><?php echo $row_c[0]?></h2></center>
      <br>
      <?php
        while ($row = mysqli_fetch_row($consulta)) {
          //Verificar que en la categoria existan actividades
          $cadena_verificar = mysqli_query($conexion,"SELECT COUNT(*) FROM detalle_checklist WHERE id_subdepartamento = '$row[0]' AND id_checklist = '$checklist'");
          $row_v = mysqli_fetch_array($cadena_verificar);
          if($row_v[0] != 0){
      ?>
      <div class="row">
        <div class="col-md-12">
          <div class="box box-danger <?php echo $estado; ?> box-solid">
            <div class="box-header with-border" data-widget="collapse">
              <h3 class="box-title"><?php echo $row[1] ?></h3>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table  class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th style="width: 2%">#</th>
                      <th>Actividad</th>
                      <th style="width: 5%">Resultado</th>
                    </tr>
                  </thead>
                  <?php
                  $fecha_inicio = "";
                  $estado = "";
                  $cadena2 = "SELECT id,
                                nombre,
                                fecha_inicio,
                                hora_inicio,
                                fecha_fin,
                                hora_fin,
                                se_repite,
                                frecuencia,
                                l,
                                m,
                                x,
                                j,
                                v,
                                s,
                                duracion,
                                finaliza,
                                dia_finaliza
                              FROM detalle_checklist 
                              WHERE id_checklist = '$checklist' 
                              AND activo = '1' 
                              AND programada = '1' 
                              AND id_subdepartamento = '$row[0]'";
                    $consulta2      = mysqli_query($conexion, $cadena2);

                    while ($row2 = mysqli_fetch_row($consulta2)) {
                      $cadena_vr = mysqli_query($conexion,"SELECT detalle_resultados_checklist.id 
                      FROM detalle_resultados_checklist 
                      INNER JOIN resultados_checklist ON resultados_checklist.id = detalle_resultados_checklist.id_resultado
                      WHERE detalle_resultados_checklist.activo = '1' 
                      AND detalle_resultados_checklist.fecha = '$fecha' 
                      AND detalle_resultados_checklist.id_actividad = '$row2[0]' 
                      AND detalle_resultados_checklist.id_usuario = '$id_usuario'
                      AND resultados_checklist.id_checklist = '$checklist'");
                      $existe_vr = mysqli_num_rows($cadena_vr);
                      if($existe_vr == 0){
                        $hora_inicio_bd = substr($row2[3], 0,8);
                        $hora_fin_bd    = substr($row2[5], 0,8);

                        if($row2[6] == 1){ //Verifico si la actividad se repite
                          if($row2[15] == 1){ //Verifico si la actividad finaliza
                            if($fecha <= $row2[16]){ //verifico que la activida este vigente
                              if($row2[7] == 1){ //Todos los dias
                                if($row2[14] == 5){ //Duracion todo el dia
                                  $estado = "ok";
                                }else{
                                  $limite = sumar_hora($row2[0],$row2[14]);
                                  if($hora >= $hora_inicio_bd && $hora <= $limite){ //Se verifica la hora
                                    $estado = "ok";
                                  }else{
                                    continue; 
                                  }
                                }
                              }else if($row2[7] == 2){ //Semanal
                                $dia = date('N');
                                $verificar_dia = verificar_dia($row2[0], $dia);
                                if($verificar_dia == 1){
                                  if($row2[14] == 5){ //Duracion todo el dia
                                    $estado = "ok";
                                  }else{
                                    $limite = sumar_hora($row2[0],$row2[14]);
                                    if($hora >= $hora_inicio_bd && $hora <= $limite){ //Se verifica la hora
                                      $estado = "ok";
                                    }else{
                                      continue; 
                                    }
                                  }
                                }else{
                                  continue;
                                }
                              }else if($row2[7] == 3){ //quincena
                                $existe_q = verificar_quincena();
                                if($existe_q == 1){
                                  if($row2[14] == 5){ //Duracion todo el dia
                                    $estado = "ok";
                                  }else{
                                    $limite = sumar_hora($row2[0],$row2[14]);
                                    if($hora >= $hora_inicio_bd && $hora <= $limite){ //Se verifica la hora
                                      $estado = "ok";
                                    }else{
                                      continue; 
                                    }
                                  }
                                }else{
                                  continue;
                                }
                              }else if($row2[7] == 4){ //mes
                                $dia = substr($row2[2], 8,2);
                                $existe_m = verificar_mes($dia,$fecha);
                                if($existe_m == 1){
                                  if($row2[14] == 5){ //Duracion todo el dia
                                    $estado = "ok";
                                  }else{
                                    $limite = sumar_hora($row2[0],$row2[14]);
                                    if($hora >= $hora_inicio_bd && $hora <= $limite){ //Se verifica la hora
                                      $estado = "ok";
                                    }else{
                                      continue; 
                                    }
                                  }
                                }else{
                                  continue;
                                }
                              }else if($row2[7] == 5){ //año
                                $dia_mes = substr($fecha, 0,4);
                                $existe_a = verificar_year($dia_mes,$fecha);
                                if($existe_a == 1){
                                  $limite = sumar_hora($row2[0],$row2[14]);
                                  if($hora >= $hora_inicio_bd && $hora <= $limite){ //Verifico la hora de inicio y fin
                                    $estado = "ok";
                                  }else{
                                    continue;  
                                  }
                                }else{
                                  continue;
                                }
                              }
                            }else{
                              continue;
                            }
                          }else{ //La Actividad nunca finaliza
                            if($row2[7] == 1){ //Todos los dias
                              if($row2[14] == 5){ //Duracion todo el dia
                                $estado = "ok";
                              }else{
                                $limite = sumar_hora($row2[0],$row2[14]);
                                if($hora >= $hora_inicio_bd && $hora <= $limite){ //Se verifica la hora
                                  $estado = "ok";
                                }else{
                                  continue; 
                                }
                              }
                            }else if($row2[7] == 2){ //Semanal
                              $dia = date('N');
                              $verificar_dia = verificar_dia($row2[0], $dia);
                              if($verificar_dia == 1){
                                if($row2[14] == 5){ //Duracion todo el dia
                                  $estado = "ok";
                                }else{
                                  $limite = sumar_hora($row2[0],$row2[14]);
                                  if($hora >= $hora_inicio_bd && $hora <= $limite){ //Se verifica la hora
                                    $estado = "ok";
                                  }else{
                                    continue; 
                                  }
                                }
                              }else{
                                continue;
                              }
                            }else if($row2[7] == 3){ //quincena
                              $existe_q = verificar_quincena();
                              if($existe_q == 1){
                                if($row2[14] == 5){ //Duracion todo el dia
                                  $estado = "ok";
                                }else{
                                  $limite = sumar_hora($row2[0],$row2[14]);
                                  if($hora >= $hora_inicio_bd && $hora <= $limite){ //Se verifica la hora
                                    $estado = "ok";
                                  }else{
                                    continue; 
                                  }
                                }
                              }else{
                                continue;
                              }
                            }else if($row2[7] == 4){ //mes
                              $dia = substr($row2[2], 8,2);
                              $existe_m = verificar_mes($dia,$row2[2]);
                              if($existe_m == 1){
                                if($row2[14] == 5){ //Duracion todo el dia
                                  $estado = "ok";
                                }else{
                                  $limite = sumar_hora($row2[0],$row2[14]);
                                  if($hora >= $hora_inicio_bd && $hora <= $limite){ //Se verifica la hora
                                    $estado = "ok";
                                  }else{
                                    continue; 
                                  }
                                }
                              }else{
                                continue;
                              }
                            }else if($row2[7] == 5){ //año
                              $dia_mes = substr($fecha, 0,4);
                              $existe_a = verificar_year($dia_mes,$fecha);
                              if($existe_a == 1){
                                if($row2[14] == 5){ //Duracion todo el dia
                                  $estado = "ok";
                                }else{
                                  $limite = sumar_hora($row2[0],$row2[14]);
                                  if($hora >= $hora_inicio_bd && $hora <= $limite){ //Se verifica la hora
                                    $estado = "ok";
                                  }else{
                                    continue; 
                                  }
                                }
                              }else{
                                continue;
                              }
                            }
                          }
                        }else{
                          if($row2[2] == $fecha || $row2[4] == $fecha){ //Verifico la fecha de fin y la de inicio
                            //$hora_inicio_bd >= $hora && $hora_fin_bd <= $hora
                            if($hora >= $hora_inicio_bd && $hora <= $hora_fin_bd){ //Verifico la hora de inicio y fin
                              $estado = "ok";
                            }else{
                              continue;  
                            }
                          }else{
                            continue;
                          }
                        }

                        if($estado == "ok"){
                          $boton_numero = '<button type="button" class="btn btn-info contador" value="'.$numero.'">'.$numero.'</button> <input name= "id[]" value="'.$row2[0].'" class="ids_inp" type="hidden"> <input type="hidden" id="activo_'.$numero.'" name="activo[]" value="0" class="activo_inp">';
                          if($row[2] == 1){
                            $campo = '<center><button type="button" class="btn btn-danger calificacion bloqueado boton_general" value="0" id="boton_'.$numero.'" disabled>0</button></center>'; 
                          }else{
                            $campo = '<center><button type="button" class="btn btn-danger sino bloqueado boton_general" value="0" id="boton_'.$numero.'" disabled>No</button></center>';
                          }
                  ?>
                  <tr>
                    <td><?php echo $boton_numero;?></td>
                    <td><?php echo $row2[1];?></td>
                    <td><?php echo $campo;?></td>
                  </tr>
                  <?php
                          $numero ++;
                        }else{
                          continue;
                        }
                      }else{
                        continue;
                      }
                      echo "<input type='hidden' value='$numero' id='$numeroc' class='veri'>";
                    }
                  ?>
                </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        <!-- /.box -->
        </div>
      </div>
      <?php
          $estado = "collapsed-box";
          }else{
            continue;
          }
        }
      ?>
      <!-- /.row -->
      <input type="hidden" id="activos" name="activo">
      <input type="hidden" id="resultados" name="resultado">
      <input type="hidden" id="ids" name="id">
      </form>
      <div class="box-footer">
        <center>
          <button type="button" class="btn btn-warning btn-block" disabled id="guardar">Guardar</button>
        </center>
      </div>
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

<?php include '../footer.php';?>
<!-- Page script -->
<script>
  $(".calificacion").click(function(){
    if($(this).hasClass('btn-danger')){
      $(this).removeClass('btn-danger');
      $(this).addClass('btn-warning');
      $(this).html('5');
      $(this).val('5');
    }else if($(this).hasClass('btn-warning')){
      $(this).removeClass('btn-warning');
      $(this).addClass('btn-success');
      $(this).html('10');
      $(this).val('10');
    }else if($(this).hasClass('btn-success')){
      $(this).removeClass('btn-success');
      $(this).addClass('btn-danger');
      $(this).html('0');
      $(this).val('0');
    }
  })
  $(".sino").click(function(){
    if($(this).hasClass('btn-danger')){
      $(this).removeClass('btn-danger');
      $(this).addClass('btn-success');
      $(this).html('Si');
      $(this).val('10');
    }else if($(this).hasClass('btn-success')){
      $(this).removeClass('btn-success');
      $(this).addClass('btn-danger');
      $(this).html('No');
      $(this).val('0');
    }

  })
  $('.contador').click(function(){
    var valor = $(this).val();
    if($('#boton_'+valor).hasClass('bloqueado')){
      $('#guardar').removeAttr('disabled');
      $(this).removeClass('btn-info');
      $(this).addClass('btn-primary');
      $('#boton_'+valor).removeClass('bloqueado');
      $('#boton_'+valor).addClass('desbloqueado');
      $('#boton_'+valor).removeAttr('disabled');
      $('#activo_'+valor).val('1');
    }else{
      $(this).removeClass('btn-primary');
      $(this).addClass('btn-info');
      $('#boton_'+valor).removeClass('desbloqueado');
      $('#boton_'+valor).addClass('bloqueado');
      $('#boton_'+valor).attr('disabled',true);
      $('#activo_'+valor).val('0');
    }
    // Verificar si algun input esta habilitado y asi evitar que el input guardar se deshabilite
    var bool = $('.boton_general').toArray().some(function(el) {
      return $(el).hasClass('desbloqueado') == true;
    });

    if (bool) {
      console.log("al menos uno de los elementos esta vacio");
    }else{
      $('#guardar').attr('disabled',true);
    }
    })
      // $(".input_conta").each(function() {
  //   console.log($(this).val());
  // });
  $('#guardar').click(function(){
    ////////////////////////////
    $('#resultados').val('');
    var texto_total = "";
    var texto = "";
    $(".boton_general").each(function() {
      texto = $(this).val();
      texto_total = texto +','+texto_total;
    });
    $('#resultados').val(texto_total);
    ////////////////////////////
    $('#activos').val('');
    var act_total = "";
    var act = "";
    $(".activo_inp").each(function() {
      act = $(this).val();
      act_total = act +','+act_total;
    });
    $('#activos').val(act_total);
    ////////////////////////////
    $('#ids').val('');
    var ids_total = "";
    var ids = "";
    $(".ids_inp").each(function() {
      ids = $(this).val();
      ids_total = ids +','+ids_total;
    });
    $('#ids').val(ids_total);

    $.ajax({
      type: "POST",
      url: 'guardar_resultado.php',
      data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        if(respuesta == "ok"){
          alertify.success("Datos Guardados Correctamente",3);
          redireccionar();
        }else{
          alertify.error("Ha Ocurrido un Error");
        }
      }
    });
    // Evitar ejecutar el submit del formulario.
    return false;
  });
  function redireccionar() {
    setTimeout("location.reload()", 3000);
  }
  $(".table").each(function() {
    if ($("tr",this).length == 1){
      $(this).hide();
    }else{
      // alert ( "SI" );
    }
  });
  // $(".row").each(function() {
  //   if ($(".veri",this).length == 1){
  //   }else{
  //     $(this).hide();
  //   }
  // });
</script>
</body>
</html>
