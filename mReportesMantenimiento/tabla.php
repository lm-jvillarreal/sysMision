<?php 
    include '../global_seguridad/verificar_sesion.php';
    // $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
    // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";

    $fechaD = $_POST['fecha'];
    $familia = $_POST['familia'];
    $articulo = $_POST['articulo'];

    $filtro_fecha = (!empty($_POST['fecha']))?" WHERE fecha >= '$fechaD'":"";
    $filtro_familia = (!empty($_POST['familia']))?" AND familia = '$familia'":"";
    $filtro_articulo = (!empty($_POST['articulo']))?" AND codigo_interno = '$articulo'":"";
  
    $cadena  = "SELECT fecha, codigo_interno,
	(SELECT descripcion FROM catalogo_piezas WHERE catalogo_piezas.codigo_interno = corte_existencia.codigo_interno),diaz,
	arboledas,
	villegas,
	allende,
	( diaz+arboledas+villegas+allende ) AS Total 
    FROM corte_existencia".$filtro_fecha.$filtro_familia.$filtro_articulo."LIMIT 10";
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $descrip = mysqli_real_escape_string($conexion, $row[2]);
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Fecha\": \"$row[0]\",
      \"Codigo\": \"$row[1]\",
      \"Descripcion\": \"$descrip\",
      \"DO\": \"$row[3]\",
      \"ARB\": \"$row[4]\",
      \"VILL\": \"$row[5]\",
      \"ALL\": \"$row[6]\",
      \"Total\": \"$row[7]\"
      },";
    $cuerpo = $cuerpo.$renglon;
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