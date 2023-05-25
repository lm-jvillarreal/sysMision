<?php
include '../global_seguridad/verificar_sesion.php';
$folio = $_POST['idreg'];
//id del registro
$id = $_POST['idprod'];
//id del producto

    $CadenaProducto = "SELECT
                  ID,
                  ARTC_ARTICULO, 
                  ARTC_DESCRIPCION
                FROM panaderia_recetasventa 
                WHERE ARTC_ARTICULO = '$id' AND ID = '$folio'";

     $consultaProducto=mysqli_query($conexion,$CadenaProducto);
    $rowProducto=mysqli_fetch_array($consultaProducto);

    echo utf8_encode(json_encode(array(
     $folio,
     ($rowProducto[1]),
     ($rowProducto[2])
    )));

?>