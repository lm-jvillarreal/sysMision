<?php
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/consulta_sqlsrvr.php';
	date_default_timezone_set('America/Monterrey');

  $fecha_uno       = $_POST['fecha_uno'];
  $fecha_dos       = $_POST['fecha_dos'];
  $sucursal        = $_POST['sucursal'];
  $nombre_empleado ="";
  $sucursales      ="";
  $departamentos   ="";

  if($sucursal == '1'){
    $sucursal = 'DIAZ ORDAZ';
  }else if($sucursal == '2'){
    $sucursal = 'ARBOLEDAS';
  }else if($sucursal == '3'){
    $sucursal = 'VILLEGAS';
  }else{
    $sucursal = 'ALLENDE';
  }

	$cadena_consulta= "SELECT
  id,
  nombre,
  departamento,
	sucursal,
	(SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.		 id_persona WHERE usuarios.id = tiempo_extra.usuario),
	tiempo,
	comentario,
	date_format(fecha_inicio,'%d/%m/%Y') as Fecha,
	tiempo_aut,
	folio,
	motivo
	FROM
	tiempo_extra 
	WHERE
	activo = '1' 
	AND sucursal = '$sucursal'
	AND fecha_inicio >='$fecha_uno ' and fecha_final <= '$fecha_dos'";	
  // echo $cadena_consulta;  
  

$consulta = mysqli_query($conexion, $cadena_consulta);
	$cuerpo =""; 
  $tiempo_autorizado = "";
	while ($row_incidencias = mysqli_fetch_array($consulta)) 
  {
    $tiempo_autorizado = substr($row_incidencias[8], 0,8);
    if ($row_incidencias[9] == "0"){
      $texto = "Pendiente";
    }else if($row_incidencias[9] == "1"){
      $texto = "Autorizada";
    }else{
      $texto = "Rechazada";
    }

    $autorizar = "<center><span class='label label-warning'>$texto</span></center>";
    $editar = "<center><a href='#' onclick='editar($row_incidencias[0])'>$row_incidencias[0]</a></center>";
    $sucursales=ucwords(strtolower($row_incidencias[3]));
    $departamentos=ucwords(strtolower($row_incidencias[2]));
    $tiempo = $row_incidencias[5];
    $tiempo = substr($tiempo,0,5);
    
    $cadena_persona = "SELECT nombre, ap_paterno, ap_materno FROM empleados WHERE codigo = '$row_incidencias[1]'";
    $consulta_persona = sqlsrv_query($conn, $cadena_persona);
    $row_persona = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);
    $nombre_empleado = $row_persona['nombre'].' '.$row_persona['ap_paterno'].' '.$row_persona['ap_materno'];
    $nombre_empleado=ucwords(strtolower($nombre_empleado));
    $empleado = $row_incidencias[1].' - '.$nombre_empleado; 
    
    $renglon = "
      {
      \"id\": \"$editar\",
      \"nombre\": \"$empleado\",
      \"departamento\": \"$departamentos\",
      \"sucursal\": \"$sucursales\",
      \"motivo\": \"$row_incidencias[10]\",
      \"autoriza\": \"$row_incidencias[4]\",
      \"tiempo\": \"$tiempo\",
      \"comentario\": \"$row_incidencias[6]\",
	    \"fecha\": \"$row_incidencias[7]\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $texto = "";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
echo $tabla;
 ?>