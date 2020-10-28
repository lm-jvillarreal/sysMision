<?php 
  include '../global_seguridad/verificar_sesion.php';

  	$fecha1         = $_POST['fecha1'];
	$fecha2         = $_POST['fecha2'];


	if(!empty($_POST['fecha1']) && !empty($_POST['fecha2'])){
		$filtro = "AND agenda_promotores.dia BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)";
	}else{
		$filtro = "";
	}
  
  $cadena  = "SELECT id, CONCAT(nombre,' ',ap_paterno,' - ',compañia) FROM promotores WHERE activo = '1'";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo   = "";
  $numero   = 1;
  $cantDO = 0;
  $cantAR = 0;
  $cantVILL = 0;
  $cantALL = 0;

  while ($row = mysqli_fetch_array($consulta)) 
  {
  	$cadenaDO = mysqli_query($conexion,"SELECT COUNT(*)
                FROM agenda_promotores 
                INNER JOIN promotores ON promotores.id = agenda_promotores.id_promotor
                WHERE promotores.activo = '1' AND agenda_promotores.id_sucursal = '1'
                AND agenda_promotores.id_promotor = '$row[0]'".$filtro);
  	$rowDO = mysqli_fetch_array($cadenaDO);
  	$cantDO = ($rowDO[0] == "")?0:$rowDO[0];

    

  	$cadenaAR = mysqli_query($conexion,"SELECT COUNT(*)
                FROM agenda_promotores 
                INNER JOIN promotores ON promotores.id = agenda_promotores.id_promotor
                WHERE promotores.activo = '1' AND agenda_promotores.id_sucursal = '2'
                AND agenda_promotores.id_promotor = '$row[0]'".$filtro);
  	$rowAR = mysqli_fetch_array($cadenaAR);
  	$cantAR = ($cantAR[0] == "")?0:$cantAR[0];

  	$cadenaVILL = mysqli_query($conexion,"SELECT COUNT(*)
                FROM agenda_promotores 
                INNER JOIN promotores ON promotores.id = agenda_promotores.id_promotor
                WHERE promotores.activo = '1' AND agenda_promotores.id_sucursal = '3'
                AND agenda_promotores.id_promotor = '$row[0]'".$filtro);
  	$rowVILL = mysqli_fetch_array($cadenaVILL);
  	$cantVILL = ($cantVILL[0] == "")?0:$cantVILL[0];

  	$cadenaALL = mysqli_query($conexion,"SELECT COUNT(*)
                FROM agenda_promotores 
                INNER JOIN promotores ON promotores.id = agenda_promotores.id_promotor
                WHERE promotores.activo = '1' AND agenda_promotores.id_sucursal = '4'
                AND agenda_promotores.id_promotor = '$row[0]'".$filtro);
  	$rowALL = mysqli_fetch_array($cadenaALL);
  	$cantALL = ($cantALL[0] == "")?0:$cantALL[0];
    

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Promotor\": \"$row[1]\",
      \"DO\": \"$cantDO\",
      \"AR\": \"$cantAR\",
      \"VILL\": \"$cantVILL\",
      \"ALL\": \"$cantALL\"
      },";
    $cuerpo   = $cuerpo.$renglon;
    $nombre   = "";
    $icono    = "";
    $opciones = "";
    $numero ++;
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>