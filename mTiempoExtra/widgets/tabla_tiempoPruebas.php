<?php

include '../global_settings/conexion.php';

   $cadena_sucursal =mysqli_query($conexion, "SELECT
   tabla.activo,
   tabla.Arboledas,
   tabla.Villegas,
   tabla.DiazOrdaz,
   tabla.Allende
   FROM
     (
       SELECT
       activo,(
         SELECT
       SEC_TO_TIME((
           SUM(
           TIME_TO_SEC( tiempo )))) 
     FROM
       tiempo_extra te 
     WHERE
       te.activo = tiempo_extra.activo 
       AND te.sucursal = 'ARBOLEDAS' 
       AND te.activo = '1' 
     ) AS Arboledas,
   (
     SELECT
       SEC_TO_TIME((
         SUM(
           TIME_TO_SEC( tiempo )))) 
     FROM
       tiempo_extra te 
     WHERE
       te.activo = tiempo_extra.activo 
     AND te.sucursal = 'VILLEGAS' 
     AND te.activo = '1' 
   ) AS Villegas,
   (
     SELECT
       SEC_TO_TIME((
         SUM(
       TIME_TO_SEC( tiempo )))) 
     FROM
       tiempo_extra te 
     WHERE
       te.activo = tiempo_extra.activo 
     AND te.sucursal = 'DIAZ ORDAZ' 
     AND te.activo = '1' 
   ) AS DiazOrdaz,
   (
     SELECT
       SEC_TO_TIME((
         SUM(
       TIME_TO_SEC( tiempo )))) 
     FROM
       tiempo_extra te 
     WHERE
       te.activo = tiempo_extra.activo 
     AND te.sucursal = 'ALLENDE' 
     AND te.activo = '1' 
   ) AS Allende
 FROM tiempo_extra
 GROUP BY tiempo_extra.activo
) AS tabla"); 

$row_sucursal  = mysqli_fetch_array($cadena_sucursal);
      
$array2 = array(
  $row_sucursal[1],
  $row_sucursal[2],
  $row_sucursal[3],
  $row_sucursal[4]
);
$array = json_encode($array2);
  echo "$array";


 ?> 
