<?php
$conn = oci_connect('INFOFIN', 'INFOFIN', '200.1.1.185/INFOFIN');

$stid = oci_parse($conn, "UPDATE COM_ARTICULOS SET ARTC_DESCRIPCION = '***NO USAR OMYGEN 20 MG C/60 TABS.' WHERE artc_articulo = '7501842953088'");
oci_execute($stid);
