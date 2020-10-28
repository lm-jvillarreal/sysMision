<?php
	 include '../global_seguridad/verificar_sesion.php';
	 date_default_timezone_set('America/Monterrey');

    $fecha1      = $_POST['fecha1'];
    $fecha2      = $_POST['fecha2'];

    $cadena_principal = mysqli_query($conexion,"SELECT id,nombre FROM sucursales WHERE (id != '11' AND id !='12' AND id!='99') ORDER BY id");

    while($row_sucursal = mysqli_fetch_array($cadena_principal)){
    	$consulta = mysqli_query($conexion,"SELECT
		count(*) AS numFilas,AVG(calificacion),
		(SELECT nombre FROM sucursales WHERE sucursales.id = solicitud_etiquetas.sucursal)
		FROM solicitud_etiquetas
    INNER JOIN usuarios ON usuarios.id = solicitud_etiquetas.usuario_solicita
    INNER JOIN personas ON personas.id = usuarios.id_persona
    INNER JOIN perfil ON perfil.id = usuarios.id_perfil 
		WHERE estatus = '2' AND perfil.id != '4'
		AND sucursal = '$row_sucursal[0]' AND (solicitud_etiquetas.fecha BETWEEN '$fecha1' AND '$fecha2')");
    $row = mysqli_fetch_array($consulta);
		$consulta2 = mysqli_query($conexion,"SELECT calificacion 
      FROM solicitud_etiquetas 
      INNER JOIN usuarios ON usuarios.id = solicitud_etiquetas.usuario_solicita
      INNER JOIN personas ON personas.id = usuarios.id_persona
      INNER JOIN perfil ON perfil.id = usuarios.id_perfil 
      WHERE calificacion = '100' AND sucursal = '$row_sucursal[0]' AND estatus = '2' 
      AND (solicitud_etiquetas.fecha BETWEEN '$fecha1' AND '$fecha2') AND perfil.id != '4'");
    $cantidad_perfectos = mysqli_num_rows($consulta2);
    $promedio = round($row[1],2);

    $cadenaProm="SELECT COUNT(d.id) FROM detalle_solicitud as d inner join solicitud_etiquetas as s ON d.id_solicitud=s.id 
                  WHERE s.sucursal='$row_sucursal[0]' 
                  AND s.estatus='2'
                  AND (s.fecha BETWEEN '$fecha1' AND '$fecha2')";
    $consultaProm=mysqli_query($conexion,$cadenaProm);
    $rowProm=mysqli_fetch_array($consultaProm);
    $promArtc=$rowProm[0]/$row[0];
    $promArtc=ceil($promArtc);

    if($row_sucursal[0] == 1){
      $color = "red";
    }else if($row_sucursal[0] == 2){
      $color = "green";
    }else if($row_sucursal[0] == 3){
      $color = "blue";
    }else{
      $color = "purple";
    }
?>
	<div class="col-md-3">
    <div class="box box-widget widget-user-2">
      <div class="widget-user-header bg-<?php echo $color?>">
        <center><h3><?php echo $row[2];?></h3></center>
      </div>
      <div class="box-footer no-padding">
        <ul class="nav nav-stacked">
          <li><a href="#">Auditorias: <span class="pull-right badge bg-blue"><?php echo $row[0];?></span></a></li>
          <li><a href="#">Prom. etiquetas: <span class="pull-right badge bg-blue"><?php echo $promArtc;?></span></a></li>
          <li><a href="#">Perfectas: <span class="pull-right badge bg-aqua"><?php echo $cantidad_perfectos;?> (CALIF. 100 POR FOLIO)</span></a></li>
          <li><a href="#">Calificacion Promedio: <span class="pull-right badge bg-green"><?php echo $promedio;?></span></a></li>
        </ul>
      </div>
    </div>
  </div>
<?php
    $promedio = 0;
    $cantidad_perfectos = 0;
	}
?>