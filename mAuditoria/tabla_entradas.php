<?php
include '../global_seguridad/verificar_sesion.php';

$ficha_entrada=$_POST['ficha_entrada'];
$parametro=$_POST['parametro'];
if($parametro=="inicio"){
  $clause=" limit 0";
}else{
  $clause="";
}

$cadenaLD="SELECT id_proveedor, sucursal, numero_nota, numero_factura, total, orden_compra, fecha, id 
          FROM libro_diario where numero_nota='$ficha_entrada'".$clause;
$consultaLD=mysqli_query($conexion,$cadenaLD);

$cuerpo ="";
$it=1;
while($row = mysqli_fetch_array($consultaLD)){
  if($it>1){
    $opciones = "<a href='#' class='btn btn-danger' onclick='eliminar($row[7])'><i class='fa fa-trash-o fa-lg' aria-hidden=true'></i></a>";
  }else{
    $opciones="";
  }
  $renglon = "
  {
    \"proveedor\": \"$row[0]\",
    \"sucursal\": \"$row[1]\",
    \"numero_nota\": \"$row[2]\",
    \"numero_factura\": \"$row[3]\",
    \"total\": \"$row[4]\",
    \"orden_compra\": \"$row[5]\",
    \"fecha\": \"$row[6]\",
    \"opciones\": \"$opciones\"
  },";
  $cuerpo = $cuerpo.$renglon;
  $it=$it+1;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>