<?php
	include '../global_seguridad/verificar_sesion.php';
	include '../global_settings/conexion_oracle.php';
	include 'funciones.php';

	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d");
    $hora=date ("H:i:s");
    //$fecha = '2019-05-02';

	$proveedor = $_POST['proveedor'];
	//$factura = $_POST['no_factura'];

	 if ($id_sede == 1 ) {
        $clase = "event-important";//DO
    }elseif ($id_sede == 2) {
        $clase = "event-success";//Arboledas
    }elseif($id_sede == 3){
        $clase = "event-info"; //Villegas
    }elseif($id_sede == 4){
        $clase = "event-special"; //Allende
    }
	$inicio = _formatear($fecha . "08:00");
    $final  = _formatear($fecha . "08:00");

    $select = "SELECT MAX(CAST(orden_compra AS UNSIGNED)) FROM orden_compra WHERE tipo = '3'";
    $exSelect = mysqli_query($conexion, $select);
    $row = mysqli_fetch_row($exSelect);
    $orden = $row[0] + 1;


    $s = "SELECT
            PR.PROC_CVEPROVEEDOR, 
            PR.PROC_NOMBRE
          FROM
              CXP_PROVEEDORES pr
          WHERE PR.PROC_CVEPROVEEDOR = '$proveedor'";

    $stm = oci_parse($conexion_central, $s);
    oci_execute($stm);
    $row_p = oci_fetch_row($stm);


    $consulta="INSERT INTO orden_compra (id_proveedor, id_sucursal, orden_compra, fecha_llegada, fecha, hora, activo, usuario , tipo, fecha_inicio, hora_inicio, status, usuario_inicio, recibido, completo) 
    	VALUES ('$proveedor', '$id_sede','$orden', '$fecha', '$fecha', '$hora', '1', '$id_usuario', '3', '$fecha', '$hora', '1', '$id_usuario', '0', '0')";

    $exConsulta = mysqli_query($conexion, $consulta);

    $max = "SELECT MAX(id) FROM orden_compra";
    $exMax = mysqli_query($conexion, $max);
    $row_max = mysqli_fetch_row($exMax);

    //$consulta_evento = "INSERT INTO eventos VALUES(null,'$row_p[1]','$orden','','$clase','$inicio','$final','$fecha','$fecha', '$id_sede')";
    //$exQry = mysqli_query($conexion, $consulta_evento);

    $insert_libro = "INSERT INTO libro_diario (id_proveedor, sucursal, orden_compra, fecha, hora, usuario, activo) VALUES('$proveedor', '$id_sede', '$row_max[0]', '$fecha', '$hora', '$id_usuario', '1')";
    //$exInsert = mysqli_query($conexion, $insert_libro);
    echo "ok";
?>
