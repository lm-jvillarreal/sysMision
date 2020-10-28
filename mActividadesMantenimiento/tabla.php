<?php 
  include '../global_seguridad/verificar_sesion.php';
  $filtro=(!empty($registros_propios) == '1')?" AND actividades_mantenimiento.id_usuario = '$id_usuario'":"";
  // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";

  $fecha = $_POST['fecha'];
  $validar = $_POST['validar'];
  $filtroFecha=($validar == '1')?" AND fecha = '$fecha'":"";

  function icono($conexion, $codigo1, $codigo2, $codigo3, $codigo4, $codigo5, $codigo6, $codigo7, $id){
    $pieza = "";
    $codigo = array($codigo1,$codigo2,$codigo3,$codigo4,$codigo5,$codigo6,$codigo7);
    for($i = 0; $i <= 6; $i++){

      $cadena_pieza = mysqli_query($conexion,"SELECT descripcion FROM catalogo_piezas WHERE codigo_interno = '$codigo[$i]'");
      $row2 = mysqli_fetch_array($cadena_pieza);
      if($row2[0] != "N/A" && $row2[0] != "" ){
        $pieza .= "<i class='fa fa-wrench' aria-hidden='true' title='$row2[0]'></i>";
      }
    }

    $cadena3 = mysqli_query($conexion,"SELECT descripcion FROM detalle_act_mant_piezas
    INNER JOIN catalogo_piezas ON catalogo_piezas.id_cat = detalle_act_mant_piezas.id_pieza
    WHERE detalle_act_mant_piezas.activo = '1' AND id_act_mant = '$id'");
    while($row3 = mysqli_fetch_array($cadena3)){
      $pieza .= "<i class='fa fa-wrench' aria-hidden='true' title='$row3[0]'></i>";
    }
    return $pieza;
  }
  function personal($conexion, $codigo1, $codigo2, $codigo3, $codigo4, $id){
    $compañero = "";
    $codigo = array($codigo1,$codigo2,$codigo3,$codigo4);
    for($i = 0; $i <= 3; $i++){
      if($codigo[$i] != null && $codigo[$i] != ""){
        $compañero .= "<i class='fa fa-user-plus' aria-hidden='true' title='$codigo[$i]'></i>";
      }
    }

    $cadena3 = mysqli_query($conexion,"SELECT
    (SELECT CONCAT(personas.nombre,' ',personas.ap_paterno, ' ', personas.ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = detalle_act_mant_compañeros.id_compañero)
    FROM detalle_act_mant_compañeros 
    WHERE activo = '1'AND id_act_mant = '$id'");
    while($row3 = mysqli_fetch_array($cadena3)){
      $compañero .= "<i class='fa fa-user-plus' aria-hidden='true' title='$row3[0]'></i>";
    }
    return $compañero;
  }
  
    $cadena  = "SELECT id, TRIM(actividad), 
      (SELECT nombre FROM areas_mantenimiento WHERE areas_mantenimiento.id = actividades_mantenimiento.id_area),
      (SELECT nombre FROM tipo_actividad_mantenimiento WHERE tipo_actividad_mantenimiento.id = actividades_mantenimiento.id_t_actividad),
      (SELECT nombre FROM sucursales WHERE sucursales.id = actividades_mantenimiento.id_sucursal),
      tiempo,codigo_interno,codigo_interno2,codigo_interno3,codigo_interno4,codigo_interno5,codigo_interno6,codigo_interno7,compañero1,compañero2,compañero3,compañero4, fecha
      FROM actividades_mantenimiento WHERE activo = '1'".$filtroFecha.$filtro." ORDER BY id DESC LIMIT 100";
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
    $compañero = "";
    $pieza = "";
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $pieza = icono($conexion, $row[6],$row[7],$row[8],$row[9],$row[10],$row[11],$row[12],$row[0]);
    $compañero = personal($conexion,$row[13],$row[14],$row[15],$row[16],$row[0]);

    $actividad = mysqli_real_escape_string($conexion, $row[1]);
    // $actividad = str_replace('/',' ',$row[1]);
    // $actividad = str_replace('"',' ',$row[1]);
    $boton_eliminar="<center><button type='button' onclick='eliminar($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button></center>";
    $boton_editar="<center><button type='button' onclick='editar($row[0])' class='btn btn-warning'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button></center>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Actividad\": \"$actividad\",
      \"fecha\": \"$row[17]\",
      \"TipoAct\": \"$row[5]\",
      \"Tiempo\": \"$row[3]\",
      \"Area\": \"$row[2]\",
      \"Sucursal\": \"$row[4]\",
      \"Piezas\": \"$pieza\",
      \"Compañeros\": \"$compañero\",
      \"Editar\": \"$boton_editar\",
      \"Eliminar\": \"$boton_eliminar\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $pieza = "";
    $compañero ="";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>