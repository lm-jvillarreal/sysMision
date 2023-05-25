<?php
//$serverName = "200.1.1.160,50346"; //serverName\instanceName, portNumber (por defecto es 1433)
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$serverName = "200.1.1.145,1433";
$connectionInfo = ["Database"=>"CuboPlanen", "UID"=>"sa", "PWD"=>"ABC1238f47"];
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false ) {
     die( print_r( sqlsrv_errors(), true));
}


$cadenaVentas="SELECT
                    ISNULL(ROUND(SUM(Cantidad),2), 0) AS UNIDADES,
	                  ISNULL(SUM(PrecioFinal*Cantidad), 0) as Venta
                  FROM
                    DimVentasArticulo 
                  WHERE
                    Articulo = 'R7501055351237'
                  AND
                    (
                    Fecha >= '2021-01-01' 
                    AND Fecha <= '2021-01-31')
                    AND IdSucursal='1'";
  
  $consultaVentas=sqlsrv_query($conn, $cadenaVentas);
  $rowVentas = sqlsrv_fetch_array($consultaVentas, SQLSRV_FETCH_ASSOC);
  echo $rowVentas[0].' - '.$rowVentas[1];
?>