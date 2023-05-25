<?php
//$serverName = "200.1.1.160,50346"; //serverName\instanceName, portNumber (por defecto es 1433)
$serverName = "200.1.1.160,50668";
$connectionInfo = array( "Database"=>"LaMision", "UID"=>"sa", "PWD"=>"Apsi_2020", "CharacterSet"=>"UTF-8");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
?>