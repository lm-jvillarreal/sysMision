<?php 
	include '../global_settings/conexion.php';
	include "../global_settings/conexion_oracle.php";

	$cve_proveedor = TRIM($_POST['clave_proveedor']);
	$cadena_od = "SELECT TRIM(PR.PROC_CVEPROVEEDOR), PR.PROC_NOMBRE FROM CXP_PROVEEDORES pr WHERE PR.PROC_CVEPROVEEDOR = '$cve_proveedor'";
    //echo $cadena_od;
	$sr_prov = oci_parse($conexion_central, $cadena_od);
	oci_execute($sr_prov);
	$row_proveedor = oci_fetch_row($sr_prov);
    $conteo = oci_num_rows($sr_prov);
    if($conteo==0){
        echo "no";
    }elseif($conteo>0){
        $array_datos  = array(		
                            $row_proveedor[0], //cve prov
                            $row_proveedor[1] //Nombre Prov
                        );
        $array_completo = json_encode($array_datos);
        echo "$array_completo";
    }
 ?>