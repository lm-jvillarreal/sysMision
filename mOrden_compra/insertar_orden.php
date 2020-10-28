<?php 
include '../global_seguridad/verificar_sesion.php';
include 'funciones.php';

date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');

$no_orden = $_POST['no_orden'];
$proveedor = $_POST['proveedor'];
$sucursal = $_POST['sucursal'];
$fecha_llegada = $_POST['fecha_llegada'];
$comentarios = $_POST['comentarios'];
$id_sucursal = $_POST['id_sucursal'];
$cve_proveedor = $_POST['cve_prov'];
$estatus=$_POST['estatus'];

$cadena_validar = "SELECT * FROM orden_compra WHERE orden_compra = '$no_orden' AND tipo = '1'";
$consulta_validar = mysqli_query($conexion, $cadena_validar);
$row_validar = mysqli_fetch_array($consulta_validar);
$conteo_validar = count($row_validar);
if($conteo_validar>0 && $estatus=='3'){
    echo "existe";
}elseif($conteo_validar>0 && $estatus=='5'){
    echo "completo";
}else{
//Validar correo del proveedor
$cadenaValida_correoProveedor = "SELECT id, correo_vendedor FROM proveedores WHERE numero_proveedor = '$cve_proveedor'";
$consulta_correoProveedor = mysqli_query($conexion, $cadenaValida_correoProveedor);
$row_correoProveedor = mysqli_fetch_array($consulta_correoProveedor);
$conteo_proveedor = count($row_correoProveedor[0]);
$id_proveedor = $row_correoProveedor[0];
$correo_proveedor = $row_correoProveedor[1];

if($conteo_proveedor==0){
    echo "no_existe";
}else{
//echo $conteo_proveedor;
    if ($correo_proveedor==NULL) {
        echo "no_correo";
    }elseif ($correo_proveedor!=NULL) {

        $inicio = _formatear($fecha_llegada . "08:00");
        $final  = _formatear($fecha_llegada . "08:00");

        if ($sucursal == 1 ) {
            $clase = "event-important";
            $suc = '1';//DO
        }elseif ($sucursal == 2) {
            $clase = "event-success";
            $suc = '2';//Arboledas
        }elseif($sucursal == 3){
            $clase = "event-info";
            $suc = '3'; //Villegas
        }elseif($sucursal == 4){
            $clase = "event-special";
            $suc = '4'; //Allende
        }elseif($sucursal==5){
            $clase = "event-important";
            $suc = '5'; //Petaca
        }elseif($sucursal==99){
            $clase = "event-success";
            $suc = '99'; //CEDIS
        }

        if($estatus=='3'){
            $print= "ok";
            $msg="";
        }elseif($estatus=='4'){
            $print= "BO";
            $msg="BO -";
        }
        $num_orden=$msg.$no_orden;

        $cadena_insertar = "INSERT INTO orden_compra (id_proveedor, id_sucursal, orden_compra, fecha_llegada, fecha, hora, activo, usuario , comentarios, tipo, status, recibido, completo)
        VALUES ('$cve_proveedor', '$id_sucursal','$num_orden', '$fecha_llegada', '$fecha', '$hora', '1', '$id_usuario', '$comentarios', '1', '2','0','0')";
        $insertar_orden = mysqli_query($conexion, $cadena_insertar);

        $cadena_evento  = "INSERT INTO eventos VALUES(null,'$proveedor','$no_orden','','$clase','$inicio','$final','$fecha_llegada','$fecha_llegada', '$suc')";
        $insertar_evento = mysqli_query($conexion, $cadena_evento);

        echo $print;
        
        include 'orden_compra_pdf.php';
    }
}
}
 ?>