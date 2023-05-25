<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$fecha_inicial=$_POST['fecha_inicial'];
$fecha_final=$_POST['fecha_final'];
$filtro_sucursal=(!empty($solo_sucursal) == '1')?" AND SUCURSAL='$id_sede'":"";
$datos=array();
$cadenaRemision="SELECT
                  ID,
                  CONCAT( SUCURSAL, PREFIJO_REMISION, CONSECUTIVO_REMISION ) as Nota,
                  (SELECT nombre FROM sucursales WHERE id=inv_remisiones.SUCURSAL) as Sucursal,
                  DATE_FORMAT( FECHAHORA, '%d/%m/%Y' ) as Fecha,
                  ESTATUS_REMISION,
                  PROC_PROVEEDOR,
                  TIPO_MOVIMIENTO,
                  FOLIO_MOVIMIENTO
                  FROM
                  inv_remisiones WHERE (DATE_FORMAT(FECHAHORA, '%Y-%m-%d')>='$fecha_inicial' AND DATE_FORMAT(FECHAHORA, '%Y-%m-%d')<='$fecha_final')";
//ECHO $cadenaRemision;    
$consultaRemision=mysqli_query($conexion,$cadenaRemision);
while($rowRemision=mysqli_fetch_array($consultaRemision)){
  $cveProv=trim($rowRemision[5]);
  if($cveProv==""){
    $nombre_prov="SIN PROVEEDOR";
  }else{
    $cadenaProv="SELECT CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) FROM CXP_PROVEEDORES pr WHERE pr.PROC_CVEPROVEEDOR='$cveProv'";
    $consultaProv=oci_parse($conexion_central,$cadenaProv);
    oci_execute($consultaProv);
    $rowProv=oci_fetch_array($consultaProv);
    $nombre_prov=$rowProv[0];
  }
  if($rowRemision[4]=='1'){
    $estatus="<center><span class='label label-primary'>Capturado</span></center>";
    $ver ="<a href='#' onclick='ver($rowRemision[0],$rowRemision[1])'class='btn btn-success btn-sm'><i class='fa fa-plus fa-lg' aria-hidden='true'></i><a/>";
    $baja="<a href='#' onclick='baja($rowRemision[0],$rowRemision[1])' class='btn btn-danger btn-sm'><i class='fa fa-arrow-down fa-lg' aria-hidden='true'></i></a>";
    $reimprimir="<a href='#' onclick=\"abrir($rowRemision[0],$rowRemision[1],'$nombre_prov')\" class='btn btn-primary btn-sm'><i class='fa fa-print fa-lg' aria-hidden='true'></i></a>";
    $asociar="<a href='#' onclick='asociar($rowRemision[0],$rowRemision[1])' class='btn btn-default btn-sm'><i class='fa fa-check fa-lg' aria-hidden='true'></i></a>";
  }elseif($rowRemision[4]=='2'){
    $estatus="<center><span class='label label-success'>Asociado</span></center>";
    $ver ="";
    $baja="<a href='#' onclick='baja($rowRemision[0],$rowRemision[1])' class='btn btn-danger btn-sm'><i class='fa fa-arrow-down fa-lg' aria-hidden='true'></i></a>";
    $reimprimir="<a href='#' onclick='abrir($rowRemision[0],$rowRemision[1],\"$nombre_prov\")' class='btn btn-primary btn-sm'><i class='fa fa-print fa-lg' aria-hidden='true'></i></a>";
    $asociar="";
  }elseif($rowRemision[4]=='3'){
    $estatus="<center><span class='label label-danger'>Cancelado</span></center>";
    $ver ="";
    $baja="";
    $reimprimir="";
    $asociar="";
  }elseif($rowRemision[4]=='4'){
    $estatus="<center><span class='label label-default'>Liberado</span></center>";
    $ver ="";
    $baja="<a href='#' onclick='baja($rowRemision[0],$rowRemision[1])' class='btn btn-danger btn-sm'><i class='fa fa-arrow-down fa-lg' aria-hidden='true'></i></a>";
    $reimprimir="<a href='#' onclick='abrir($rowRemision[0],$rowRemision[1],\"$nombre_prov\")' class='btn btn-primary btn-sm'><i class='fa fa-print fa-lg' aria-hidden='true'></i></a>";
    $asociar="";
  }
  $opciones="<center>".$ver."&nbsp;".$reimprimir."&nbsp;".$baja."&nbsp".$asociar."</center>";
  $movimiento=$rowRemision[6].' - '.$rowRemision[7];
  array_push($datos,array(
    'id'=>$rowRemision[0],
    'remision'=>$rowRemision[1],
    'proveedor'=>$nombre_prov,
    'sucursal'=>$rowRemision[2],
    'movimiento'=>$movimiento,
    'fecha'=>$rowRemision[3],
    'estatus'=>$estatus,
    'opciones'=>$opciones
  ));
}
echo utf8_encode(json_encode($datos));
?>