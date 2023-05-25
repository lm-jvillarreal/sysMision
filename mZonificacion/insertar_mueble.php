<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set("America/Monterrey");

$fechahora=date("Y-m-d H:i:s");
$area=$_POST['area'];
$zona=$_POST['zona'];
$mueble=$_POST['mueble'];
$tipo_mueble=$_POST['tipo_mueble'];
$comentarios=$_POST['comentarios'];
$fijar=$_POST['fijar'];

$cadenaValidar="SELECT
                * 
                FROM
                inv_muebles 
                WHERE
                ID_SUCURSAL = '$id_sede' 
                AND ID_AREA = '$area' 
                AND ZONA = '$zona' 
                AND MUEBLE = '$mueble'";
$consultaValidar=mysqli_query($conexion,$cadenaValidar);
$rowValidar=mysqli_fetch_array($consultaValidar);
$conteoValidar=count($rowValidar[0]);
if($conteoValidar>0 && $rowValidar[7]=='1'){
  echo "no_permitido";
}else{
  $cadenaInsertar="INSERT INTO inv_muebles(ID_SUCURSAL,ID_AREA,ZONA,MUEBLE,TIPO_MUEBLE,COMENTARIOS,FIJO,FECHAHORA,ACTIVO,USUARIO)VALUES('$id_sede','$area','$zona','$mueble','$tipo_mueble','$comentarios','$fijar','$fechahora','1','$id_usuario')";
  $insertarMueble=mysqli_query($conexion,$cadenaInsertar);

  $cadenaID="SELECT MAX(ID) FROM inv_muebles WHERE USUARIO='$id_usuario'";
  $consultaID=mysqli_query($conexion,$cadenaID);
  $rowID=mysqli_fetch_array($consultaID);

  if($tipo_mueble=="GONDOLA"){
    for($i=1; $i<=4; $i=$i+1){
      switch ($i){
        case 1:
          $cara="A";
          break;
        case 2:
          $cara="B";
          break;
        case 3:
          $cara="C";
          break;
        case 4:
          $cara="D";
          break;
      }
      $cadenaCaras="INSERT INTO inv_caramuebles (ID_MUEBLE, TIPO_MUEBLE, CARA_MUEBLE, FECHAHORA, ACTIVO, USUARIO)VALUES('$rowID[0]','$tipo_mueble','$cara','$fechahora','1','$id_usuario')";
      $consultaCaras=mysqli_query($conexion,$cadenaCaras);
    }
  }else{
    $cadenaCaras="INSERT INTO inv_caramuebles (ID_MUEBLE, TIPO_MUEBLE, CARA_MUEBLE, FECHAHORA, ACTIVO, USUARIO)VALUES('$rowID[0]','$tipo_mueble','X','$fechahora','1','$id_usuario')";
    $consultaCaras=mysqli_query($conexion,$cadenaCaras);
  }
  echo "ok";
}
?>