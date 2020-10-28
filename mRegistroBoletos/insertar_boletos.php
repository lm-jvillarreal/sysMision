<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set("America/Monterrey");
$fecha = date("Y-m-d");
$hora = date("H:i:s");
$prefijo = $_POST['prefijo'];
$consecutivo = $_POST['consecutivo'];
$folio_ticket = $prefijo.$consecutivo;
$subtotal = $_POST['subtotal'];
$impuestos = $_POST['impuestos'];
$ajuste = $_POST['ajuste'];
$total = $_POST['total'];
$boletos = $_POST['cantidad_boletos'];

$cadena_captura = "SELECT COUNT(id) FROM registro_boletos WHERE estatus = '1' AND sucursal = '$id_sede' AND usuario = '$id_usuario'";
$consulta_captura = mysqli_query($conexion, $cadena_captura);
$row_captura = mysqli_fetch_array($consulta_captura);
if($row_captura[0]!="0"){
  echo "pendientes";
}else{
  $cadena_valida = "SELECT id FROM registro_boletos WHERE folio_ticket = '$folio_ticket' AND sucursal = '$id_sede'";
  $consulta_valida = mysqli_query($conexion,$cadena_valida);
  $row_valida = mysqli_fetch_array($consulta_valida);
  $conteo = count($row_valida[0]);
  if($conteo > 0){
    echo "existe";
  }else{

    $cadena_rango = "SELECT id_sorteo, folio_inicial, folio_final FROM dispersion_boletos WHERE activo = '1' AND sucursal = '$id_sede'";
    $consulta_rango = mysqli_query($conexion, $cadena_rango);
    $row_rango = mysqli_fetch_array($consulta_rango);
    $id_sorteo = $row_rango[0];
    $folio_inicial = $row_rango[1];
    $folio_final = $row_rango[2];

    $cadena_ultimo = "SELECT MAX(folio_boleto) FROM registro_boletos WHERE sucursal = '$id_sede' AND id_sorteo='$id_sorteo'";
    $consulta_ultimo = mysqli_query($conexion, $cadena_ultimo);
    $row_ultimo = mysqli_fetch_array($consulta_ultimo);
    $ultimo = $row_ultimo[0];
    $resto = $folio_final - $ultimo;
    if($boletos > $resto){
      echo "excedido";
    }else{
      for($i=1;$i<=$boletos; $i++){
        $cadena_boletos = "SELECT IFNULL(MAX(folio_boleto),0) FROM registro_boletos WHERE sucursal = '$id_sede' AND id_sorteo = '$id_sorteo' and folio_boleto >= '$folio_inicial'";
        $consulta_boletos = mysqli_query($conexion, $cadena_boletos);
        $row_boletos = mysqli_fetch_array($consulta_boletos);
        if($row_boletos[0]=="0"){
          $folio_calculado = $folio_inicial;
        }else{
          $folio_calculado = $row_boletos[0] + 1;
        }
        if($folio_calculado >= $folio_inicial && $folio_calculado <= $folio_final){
          //Insertar registro
          $cadena_insertar = "INSERT INTO registro_boletos (id_sorteo, folio_boleto, folio_ticket, subtotal, impuestos, ajuste, total, sucursal, estatus, fecha, hora, activo, usuario)VALUES('$id_sorteo', '$folio_calculado', '$folio_ticket', '$subtotal', '$impuestos', '$ajuste', '$total', '$id_sede', '1', '$fecha', '$hora', '1', '$id_usuario')";
          $insertar_registro = mysqli_query($conexion, $cadena_insertar);
        }
      }
      echo "ok";
    }
  }
}
?>