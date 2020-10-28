<?php 
  include '../global_seguridad/verificar_sesion.php';
  include "../global_settings/conexion_oracle.php";

  $fecha1 = $_POST['fecha1'];
  $fecha2 = $_POST['fecha2'];

  $fecha3 = strtotime ('-1 month',strtotime($fecha1)) ;
  $fecha3 = date('Y-m-d',$fecha3);

  $ano = substr($fecha3,0,4);
  $mes = substr($fecha3,5,2);

  function ultimo_dia($ano,$mes) {
    return date("Y-m-d",(mktime(0,0,0,$mes+1,1,$ano)-1));
  }

  $fecha4 = ultimo_dia($ano,$mes);

  $cadena   = "SELECT id, nombre FROM sucursales WHERE activo = '1'";
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo   = "";
  $numero   = 1;

  while ($row = mysqli_fetch_array($consulta)) 
  {
    ///////////////////////////////////// Auditoria Entradas /////////////////////
    $cadena_afectados = "SELECT COUNT(*) FROM INV_MOVIMIENTOS
                WHERE (modc_tipomov = 'ENTSOC' OR modc_tipomov = 'ENTCOC')
                AND movd_fechaafectacion >= trunc(TO_DATE ('$fecha1', 'YYYY/MM/DD'))
                AND movd_fechaafectacion < trunc(TO_DATE ('$fecha2', 'YYYY/MM/DD'))+1
                AND ALMN_ALMACEN = '$row[0]'
                ORDER BY modn_folio ASC";

    $consulta_afectados = oci_parse($conexion_central, $cadena_afectados);
                oci_execute($consulta_afectados);
    $row_afectados = oci_fetch_row($consulta_afectados);
    $afectados_do = $row_afectados[0];

    $cadena_afectados = "SELECT COUNT(*) FROM INV_MOVIMIENTOS
                WHERE (modc_tipomov = 'ENTSOC' OR modc_tipomov = 'ENTCOC')
                AND movd_fechaafectacion >= trunc(TO_DATE ('$fecha3', 'YYYY/MM/DD'))
                AND movd_fechaafectacion < trunc(TO_DATE ('$fecha4', 'YYYY/MM/DD'))+1
                AND ALMN_ALMACEN = '$row[0]'
                ORDER BY modn_folio ASC";

    $consulta_afectados = oci_parse($conexion_central, $cadena_afectados);
                oci_execute($consulta_afectados);
    $row_afectados = oci_fetch_row($consulta_afectados);
    $afectados_do2 = $row_afectados[0];

    if($afectados_do == $afectados_do2){
        $texto_afectado = "igual";
        $porcentaje_afectados = '0 %';
        $porcentaje_afectados2 = '0 %';
    }else{
      if($afectados_do2 != 0){
        $diferencia_afectados = ($afectados_do * 100) /$afectados_do2;
        $diferencia_afectados = round($diferencia_afectados,2); //Porentaje de diferencia
        if($diferencia_afectados < 100){
            $porcentaje_afectados = '- '.(100 - $diferencia_afectados).' %';
            $porcentaje_afectados2 = (100 - $diferencia_afectados).'%';
        }else{
            $porcentaje_afectados = '+ '.($diferencia_afectados - 100).' %';
            $porcentaje_afectados2 = 100 + $porcentaje_afectados.'%';
        }
      }else{
        $diferencia_afectados = 0;
        $porcentaje_afectados = (100 - $diferencia_afectados).' %';
      }
    }
?>
  <div class="progress-group">
      <span class="progress-text"><?php echo $row[1];?></span>
      <span class="progress-number"><b><?php echo $porcentaje_afectados;?></b></span>

      <!-- <div class="progress sm">
        <div class="progress-bar progress-bar-blue" style="width: <?php echo $porcentaje_afectados2?>"></div>
      </div> -->
      <div class="progress progress-sm active">
        <div class="progress-bar progress-bar-blue progress-bar-striped" role="progressbar" aria-valuenow=" <?php echo $porcentaje_afectados2;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $porcentaje_afectados2;?>">
        </div>
      </div>
    </div>
<?php 
  }
 ?>