<?php
include '../global_seguridad/verificar_sesion.php';
$folio = $_POST['idreg'];
//id del registro
$tipo = $_POST['tipo'];
//receta-subrectea-producto
$id = $_POST['idprod'];
//id del producto

if($tipo == "PRODUCTO")
{
    $CadenaProducto = "SELECT
                  ID,
                  ARTC_ARTICULO, 
                  ARTC_DESCRIPCION,
                  RMON_ULTIMOPRECIO,
                  FACTOR_EMPAQUE
                FROM panaderia_articulos_historial 
                WHERE ARTC_ARTICULO = '$id' AND ID = '$folio'";

     $consultaProducto=mysqli_query($conexion,$CadenaProducto);
    $rowProducto=mysqli_fetch_array($consultaProducto);

    echo utf8_encode(json_encode(array(
     $folio,
     ($rowProducto[1]),
     $tipo
    )));
}elseif($tipo == "RECETA")
{
    $CadenaReceta = "SELECT 
                        ID, 
                        ARTC_ARTICULO, 
                        ARTC_DESCRIPCION 
                        FROM 
                        panaderia_recetasventa 
                        WHERE ARTC_ARTICULO = '$id' AND ID = '$folio'";
    $consultaReceta = mysqli_query($conexion, $CadenaReceta);
    $rowReceta = mysqli_fetch_array($consultaReceta);

   echo  utf8_encode(json_encode(array(
        $folio,
        $rowReceta[1],
        $tipo
    )));
}elseif($tipo == "SUBRECETA"){
    $cadenaSubeceta = "SELECT 
                    ID, 
                    ID_ARTICULO, 
                    CANTIDAD_RECETA, 
                    SUBRECETA 
                    FROM 
                    panaderia_subrecetasrenglones 
                    WHERE ID_ARTICULO = '$id' AND ID = '$folio'";
    $consultaSubreceta = mysqli_query($conexion, $cadenaSubeceta);
    $rowSubreceta = mysqli_fetch_array($consultaSubreceta);

    echo utf8_encode(json_encode(array(
        $folio,
        $rowSubreceta[1],
        $tipo
    )));
    
}

?>