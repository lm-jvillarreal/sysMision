<?php
$apiURL='200.1.1.145:9090/api/';

//Extraemos la información periodo actual
$curlAct = curl_init();
curl_setopt_array($curlAct, array(
  CURLOPT_URL => $apiURL."GetVentasFamiliaSucursal?sucursal=1&f_inicial=2022-03-01&f_final=2022-03-31",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));
$responseAct = curl_exec($curlAct);
curl_close($curlAct);
$arrayAct=json_decode($responseAct, true);
$datosAct=$arrayAct['response']['data'];
$conteoAct=count($datosAct);

$curlAnt = curl_init();
curl_setopt_array($curlAnt, array(
  CURLOPT_URL => $apiURL."GetVentasFamiliaSucursal?sucursal=1&f_inicial=2021-03-01&f_final=2021-03-31",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));
$responseAnt = curl_exec($curlAnt);
curl_close($curlAnt);
$arrayAnt=json_decode($responseAnt, true);
$datosAnt=$arrayAnt['response']['data'];
$conteoAnt=count($datosAnt);

//ECHO "<pre>";
//print_r($datosAnt);

if($conteoAct<$conteoAnt){
  $bucle=$conteoAnt;
  $arrayMaster=$datosAnt;
  $arraySlave=$datosAct;
}else{
  $bucle=$conteoAct;
  $arrayMaster=$datosAct;
  $arraySlave=$datosAnt;
}
for($i=0;$i<$bucle; $i++){
  $fila=$i+9;
  $NombreSucursal=$rowSuc[0];
  $NombreCategoria=$datosAct[$i]['Nombre'];
  $NombreDepto=$datosAct[$i]['Departamento'];
  $familiaMaster=$arrayMaster[$i]['Familia'];

  //recorrer año actual
  for($p=0;$p<$conteoAct;$p++){
    $famAct=$datosAct[$p]['Familia'];
    if($familiaMaster==$famAct){
      $totalUnidadesAct=$datosAct[$p]['Cantidad'];
      $totalUnidadesAct=$totalUnidadesAct-$datosAct[$p]['CantidadDev'];
      $totalDineroAct=$datosAct[$p]['Venta'];
      $totalDineroAct=$totalDineroAct-$datosAct[$p]['VentaDev'];
      $totalCostoAct=$datosAct[$p]['Costo'];
      $totalCostoAct=$totalCostoAct-$datosAct[$p]['CostoDev'];
      $margenAct=$totalDineroAct-$totalCostoAct;
    }
  }

  //Recorrer año anterior
  for($q=0;$q<$conteoAnt; $q++){
    $famAnt=$datosAnt[$q]['Familia'];
    if($familiaMaster==$famAnt){
      $totalUnidadesAnt=$datosAnt[$q]['Cantidad'];
      $totalUnidadesAnt=$totalUnidadesAnt-$datosAnt[$q]['CantidadDev'];
      $totalDineroAnt=$datosAnt[$q]['Venta'];
      $totalDineroAnt=$totalDineroAnt-$datosAnt[$q]['VentaDev'];
      $totalCostoAnt=$datosAnt[$q]['Costo'];
      $totalCostoAnt=$totalCostoAnt-$datosAnt[$q]['CostoDev'];
      $margenAnt=$totalDineroAnt-$totalCostoAnt;
    }
  }
  echo $i." ".$familiaMaster." | ".$totalUnidadesAct.' - '.$totalDineroAct." | ".$totalUnidadesAnt." - ".$totalDineroAnt."<br>";
  //$result="";
  $totalUnidadesAct=0;
  $totalUnidadesAnt=0;
  $totalDineroAct=0;
  $totalDineroAnt=0;
  $totalCostoAct=0;
  $totalCostoAnt=0;
  $margenAct=0;
  $margenAnt=0;
}
?>