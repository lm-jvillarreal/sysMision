<?php
$apiURL='200.1.1.145:9090/api/';

//Extraemos la información periodo actual
$curlAct = curl_init();
curl_setopt_array($curlAct, array(
  CURLOPT_URL => $apiURL."GetVentasDeptoSucursal?sucursal=1&f_inicial=2022-06-01&f_final=2022-06-30",
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
  CURLOPT_URL => $apiURL."GetVentasDeptoSucursal?sucursal=1&f_inicial=2021-06-01&f_final=2021-06-30",
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


if($conteoAct<$conteoAnt){
  echo "aqui";
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
  $NombreDepto=$datosAct[$i]['Nombre'];
  $DeptoMaster=$arrayMaster[$i]['ClaveDepartamento'];
  //recorrer año actual
  for($p=0;$p<$conteoAct;$p++){
    $deptoAct=$datosAct[$p]['ClaveDepartamento'];
    if($DeptoMaster==$deptoAct){
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
    $deptoAnt=$datosAnt[$q]['ClaveDepartamento'];
    if($DeptoMaster==$deptoAnt){
      $totalUnidadesAnt=$datosAnt[$q]['Cantidad'];
      $totalUnidadesAnt=$totalUnidadesAnt-$datosAnt[$q]['CantidadDev'];
      $totalDineroAnt=$datosAnt[$q]['Venta'];
      $totalDineroAnt=$totalDineroAnt-$datosAnt[$q]['VentaDev'];
      $totalCostoAnt=$datosAnt[$q]['Costo'];
      $totalCostoAnt=$totalCostoAnt-$datosAnt[$q]['CostoDev'];
      $margenAnt=$totalDineroAnt-$totalCostoAnt;
    }
  }
  echo $DeptoMaster." - ".$NombreDepto." | ".$totalUnidadesAct." - ".$totalDineroAct." | ".$totalUnidadesAnt." - ".$totalDineroAnt."<br>";
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