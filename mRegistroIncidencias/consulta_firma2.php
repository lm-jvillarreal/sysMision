
<?php
include '../global_settings/conexion.php';
include '../global_settings/consulta_sqlsrvr.php';

$id_registro = $_POST['id_registro'];

//$ide_registro = $_GET['ide_registro'];
//$nombre = $_GET['id_persona'];

$cadena_nom = "SELECT nombre FROM incidencias WHERE id = '$id_registro'";
$consulta_nom = mysqli_query($conexion, $cadena_nom);
$row_nom = mysqli_fetch_array($consulta_nom);

$nombre = $row_nom[0];

$clave="";
$match="";

	$d= mt_rand(1,4);
		//echo $d;
	

	if($d == '1')
	{
		//10 digitos de seguro social mas numero de empledo
		$cadena_persona1 = "SELECT codigo,(afiliacion + cast(codigo as varchar) ) AS 'firma1' FROM empleados WHERE activo = 'S' AND codigo = '$nombre'"; 
	 	$consulta_persona1 = sqlsrv_query($conn, $cadena_persona1);
	  	$row_persona1 = sqlsrv_fetch_array( $consulta_persona1, SQLSRV_FETCH_ASSOC);
	  	$clave= $row_persona1['firma1'];
		$match = "Ingrese los primeros 10 digitos de NSS + su NO. EMP.";
	  	//echo $clave;
	}elseif($d== '2')
	{
		//digito del 5 al 10 del rfc + numero de empleado
		$cadena_firma2 = "SELECT codigo,(rfcnum  + cast(codigo as varchar) )  AS 'firma2' FROM empleados WHERE activo = 'S' AND codigo = '$nombre'"; 
  		$consulta_persona2 = sqlsrv_query($conn, $cadena_firma2);
   		$row_persona1 = sqlsrv_fetch_array( $consulta_persona2, SQLSRV_FETCH_ASSOC);
   		$clave= $row_persona1['firma2'];
		$match = "Ingrese del 5° al 10° dígito de su RFC + su NO. EMP.";
	}else if($d =='3'){
		//primeros 4 digitos del rfc + numero de empleado
   		$cadena_firma3 = "SELECT codigo,(rfcalfa  + cast(codigo as varchar) )  AS 'firma3' FROM empleados WHERE activo = 'S' AND codigo = '$nombre'"; 
   		$consulta_persona3 = sqlsrv_query($conn, $cadena_firma3);
   		$row_persona3 = sqlsrv_fetch_array( $consulta_persona3, SQLSRV_FETCH_ASSOC);
   		$clave= $row_persona3['firma3'];
		$match = "Ingrese los primeros 4 dígitos de su RFC + su NO. EMP.";
	}else if($d == '4'){
		//ultimos 3 digitos del rfc mas numero de empleado
		$cadena_firma4 = "SELECT codigo,(rfchomo  + cast(codigo as varchar) )  AS 'firma4' FROM empleados WHERE activo = 'S' AND codigo = '$nombre'"; 
		$consulta_persona4 = sqlsrv_query($conn, $cadena_firma4);
		$row_persona4 = sqlsrv_fetch_array( $consulta_persona4, SQLSRV_FETCH_ASSOC);
		$clave= $row_persona4['firma4'];
		$match = "Ingrese los últimos 3 dígitos de su RFC + su NO. EMP.";
	}

$cadena_nombre = "SELECT codigo, (cast(codigo as varchar) + ' - ' + nombre + ' ' + ap_paterno + ' ' + ap_materno) AS 'nombre' FROM empleados WHERE activo = 'S'and codigo = '$nombre'";
$consulta_nombre = sqlsrv_query($conn, $cadena_nombre);
$row_nombre = sqlsrv_fetch_array( $consulta_nombre, SQLSRV_FETCH_ASSOC);


 $array = array(
 		$row_nombre['nombre'],//row 0, nombre de la persona
		$match,
 		$clave,//aqui va clave
		$d,
		$id_registro);//row 1, la concatenacion que debe coincidir para insertar.
 echo $array_datos= json_encode($array);
 //echo $cadena_nom;
?>
