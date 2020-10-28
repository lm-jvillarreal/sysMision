<?php
include '../global_settings/conexion.php';
$folio =  $_POST['folio'];
$cadena_surtido = "SELECT receta.id,
                           receta.nombre_generico,
                           receta.nombre_farmacia,
                           receta.surtido
                         FROM
                        receta WHERE folio = '$folio' and receta.surtido='0'";
$consulta_surtido = mysqli_query($conexion, $cadena_surtido);

$cuerpo = "";
while ($row_surtido = mysqli_fetch_array($consulta_surtido)) {
    $surtido = ($row_surtido[3]=="0") ? "" : "checked";
   

    $chk_surtido = "<center><input type='checkbox' name='surtido' id='surtido' $surtido onchange='surtido($row_surtido[0])'></center>";

    $renglon = "
    {
        \"nombre_generico\": \"$row_surtido[1]\",
        \"nombre_farmacia\": \"$row_surtido[2]\",
        \"surtido\": \"$chk_surtido\"
       
      },";
    $cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');
$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>