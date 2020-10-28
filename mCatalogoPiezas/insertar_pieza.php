<?php
include '../global_seguridad/verificar_sesion.php';

$Pcodigo_inter = $_POST["interno"];
$Pdescripcion = $_POST["desc"];
$Pfamilia = $_POST["familia"];
$Pdescripcion_det = $_POST["desc_det"];
$Punidad_med = $_POST["uni_m"];
$Pmax = $_POST["max"];
$Pmin = $_POST["min"];
$Preorden = $_POST["reorden"];
$Prack = $_POST["rack"];
$Pfila = $_POST["fila"];
$Pcolumna = $_POST["columna"];
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('h:i:s');


if (strlen($Pcodigo_inter) == 1){
    $VarInterno = $Pfamilia."-"."000".$Pcodigo_inter;
}else if (strlen($Pcodigo_inter) == 2){
    $VarInterno = $Pfamilia."-"."00".$Pcodigo_inter;
}else if (strlen($Pcodigo_inter) == 3){
    $VarInterno = $Pfamilia."-"."0".$Pcodigo_inter;
}else if (strlen($Pcodigo_inter) == 4){
    $VarInterno = $Pfamilia."-".$Pcodigo_inter;
}

$f_nombre = $_FILES["archivos"]['name'];
$f_tamano = $_FILES["archivos"]['size']; 
$f_tipo = $_FILES["archivos"]['type'];

$extension = explode(".", $_FILES['archivos']['name']);
$extension = end($extension);

if ($f_nombre != ""){
  $destino =  "archivos/". $Pcodigo_inter.".".$extension;
  if (copy($_FILES['archivos']['tmp_name'],$destino)){ 
    $status = "Archivo subido"; 
  }else{ 
    $status = "Error al subir el archivo"; 
  } 
}else{
  $status = "Vacio";
}
$consulta="INSERT INTO catalogo_piezas (
            codigo_interno, 
            clave_familia, 
            descripcion, 
            descripcion_det, 
            foto, 
            unidad_med, 
            max, 
            min, 
            reorden, 
            rack, 
            fila, 
            columna, 
            hora, 
            fecha, 
            usuario, 
            activo) 
          VALUES(
                           
            '$VarInterno',
            '$Pfamilia',
            '$Pdescripcion',
            '$Pdescripcion_det',
            '$destino',
            '$Punidad_med',
            '$Pmax',
            '$Pmin',
            '$Preorden',
            '$Prack',
            '$Pfila',
            '$Pcolumna',
            '$hora',
            '$fecha',
            '$id_usuario',
            '1')";     

$result = mysqli_query($conexion, $consulta);
echo $consulta;
$consulta1="INSERT INTO historial_existencias (
              codigo_interno,
              cantidad,
              ult_costo,
              id_almacen,
              fecha,
              activo
            )
            VALUES(
              '$VarInterno',
              '0',
              '$PcostoPza',
              '1',
              '$fecha',
              '1')";        

$result1 = mysqli_query($conexion, $consulta1);

$consulta2="INSERT INTO historial_existencias (
              codigo_interno,
              cantidad,
              ult_costo,
              id_almacen,
              fecha,
              activo
            )
          VALUES(
            '$VarInterno',
            '0',
            '$PcostoPza',
            '2',
            '$fecha',
            '1')";        

$result2 = mysqli_query($conexion, $consulta2);
$consulta3="INSERT INTO historial_existencias (
              codigo_interno,
              cantidad,
              ult_costo,
              id_almacen,
              fecha,
              activo
            )
          VALUES(
            '$VarInterno',
            '0',
            '$PcostoPza',
            '3',
            '$fecha',
            '1')";        

$result3 = mysqli_query($conexion, $consulta3);
$consulta4="INSERT INTO historial_existencias (
              codigo_interno,
              cantidad,
              ult_costo,
              id_almacen,
              fecha,
              activo
            )
          VALUES(
            '$VarInterno',
            '0',
            '$PcostoPza',
            '4',
            '$fecha',
            '1')";        

$result4 = mysqli_query($conexion, $consulta4);
echo "ok";
?>
