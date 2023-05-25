<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => '200.1.1.145:9090/api/GetTotalesSucursal?f_inicial=2021-01-01&f_final=2021-01-01',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
$array=json_decode($response, true);
print_r($array["response"]["data"][4]);