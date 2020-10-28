<?php
//Conexion a Servidor DO
$conexion_do = oci_connect('INFOFIN', 'INFOFIN', '200.1.1.165/DIAZORDAZ',"AL32UTF8");
$conexion_arb = oci_connect('INFOFIN', 'INFOFIN', '200.1.3.55/ARBOLEDAS',"AL32UTF8");
$conexion_vill = oci_connect('INFOFIN', 'INFOFIN', '200.1.2.230/VILLEGAS',"AL32UTF8");
$conexion_all = oci_connect('INFOFIN', 'INFOFIN', '200.1.4.100/ALLENDE',"AL32UTF8");
$conexion_lp = oci_connect('INFOFIN', 'INFOFIN', '200.1.5.100/PETACA',"AL32UTF8");
?>