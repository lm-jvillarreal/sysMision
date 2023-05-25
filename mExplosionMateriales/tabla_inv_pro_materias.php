<?php 
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$cantidad = 0;
/****pedidos de las recetas o son pedidos especificos de materiales */
$cadenaConsulta="SELECT ID,
                ARTC_ARTICULO,
                ARTC_DESCRIPCION,
                PROVEEDOR,
                RMON_ULTIMOPRECIO,
                UNIMEDIDA_VENTA,
                FACTOR_EMPAQUE,
                PORCENTAJE_MERMA
                FROM panaderia_articulos 
                WHERE ACTIVO=1";
$consulta=mysqli_query($conexion,$cadenaConsulta);
while($row=mysqli_fetch_array($consulta)){
    $cadenaConsultaRecetasVentas = "SELECT ID_PRODUCTO, 
    CLAVE_ARTICULO, 
    sum(CANTIDAD_RECETA), 
    MERMA FROM panaderia_recetasventarenglones WHERE CLAVE_ARTICULO='$row[1]' AND SUBRECETA='0' GROUP BY CLAVE_ARTICULO";
    $consultaRV = mysqli_query($conexion, $cadenaConsultaRecetasVentas);
    while ($row2=mysqli_fetch_array($consultaRV)) { 
        $cadenaMinimoInv = "SELECT CANTIDAD FROM  panaderia_invpro_cantidad WHERE ID_ARTICULO = '$row[1]' AND TIPO = '3' GROUP BY ID_ARTICULO";
        $consultaMinimoInv = mysqli_query($conexion, $cadenaMinimoInv);
        $rowMinimo = mysqli_fetch_array($consultaMinimoInv);
        $valorMin = ($rowMinimo[0] == null ) ? 0 : $rowMinimo[0];

        $cadenaConsultaSrRenglones = "SELECT sum(CANTIDAD_RECETA)
        FROM panaderia_subrecetasrenglones WHERE ID_ARTICULO = '$row[1]' AND SUBRECETA='0' GROUP BY ID_ARTICULO";
        $consultaSrRenglones = mysqli_query($conexion, $cadenaConsultaSrRenglones);
        $rowCantidadReceta = mysqli_fetch_array($consultaSrRenglones);
        $valorCantReceta = $rowCantidadReceta[0] == null ? 0 : $rowCantidadReceta[0];

        $cadenaCantidad = "SELECT CANTIDAD FROM panaderia_inventariospos WHERE ID_ARTICULO = '$row2[1]' GROUP BY ID_ARTICULO";
        $consultaCantidad = mysqli_query($conexion, $cadenaCantidad);
        $rowCantidad = mysqli_fetch_array($consultaCantidad);
        $valorCant = ($rowCantidad[0] == "" ? 0 : $rowCantidad[0]);
        $InsertCant = "<center><a href='#' data-idreg = '$row[0]' data-idProd = '$row[1]' data-toggle = 'modal' data-target = '#modal-materias' class='btn btn-default'  target='blank'><i class='fa fa-pencil fa-lg' aria-hidden='true'></i></a></center>";
        $input = "<div class='input-group' style='width:100%''><input type='number'  class='form-control' value='$valorMin'></input></div>";
        array_push($datos,array(
            "id"=>$row[0],
            "artc_articulo"=>$row[1],
            "ingrediente"=>$row[2],
            "minimo_inventario"=>$input,
            /*"agregar_cantidad"=>$InsertCant,*/
            "existencias" => $valorCant,
            "pedido_do" => "0",
            "pedido_arb" => "0",
            "pedido_vill" => "0",
            "pedido_all" => "0",
            "pedido_pet" => "0",
            "requerimiento"=>$row2[2] + $valorCantReceta
        ));
    }
}
echo utf8_encode(json_encode($datos));
?>