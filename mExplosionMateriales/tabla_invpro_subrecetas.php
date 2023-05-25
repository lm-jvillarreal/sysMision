<?php 
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$cantidad = 0;
$cadenaConsulta="SELECT ID, CLAVE_RECETA, NOMBRE_RECETA, RENDIMIENTO, UNIDAD_MEDIDA FROM panaderia_subrecetas WHERE ACTIVO=1";

$consulta=mysqli_query($conexion,$cadenaConsulta);
while($row=mysqli_fetch_array($consulta)){
    $cadenaConsultaRecetasVentas = "SELECT ID_PRODUCTO, CLAVE_ARTICULO, sum(CANTIDAD_RECETA), MERMA, count(CLAVE_ARTICULO) FROM panaderia_recetasventarenglones WHERE CLAVE_ARTICULO='$row[1]' AND SUBRECETA='1' GROUP BY CLAVE_ARTICULO";
    $consultaRV = mysqli_query($conexion, $cadenaConsultaRecetasVentas);
    while ($row2=mysqli_fetch_array($consultaRV)) { 

        $cadenaMinimoInv = "SELECT CANTIDAD FROM  panaderia_invpro_cantidad WHERE ID_ARTICULO = '$row[1]' AND TIPO = '2' GROUP BY ID_ARTICULO";
        $consultaMinimoInv = mysqli_query($conexion, $cadenaMinimoInv);
        $rowMinimo = mysqli_fetch_array($consultaMinimoInv);
        $valorMin = ($rowMinimo[0] == null ) ? 0 : $rowMinimo[0];

        $cadenaCantidad = "SELECT CANTIDAD FROM panaderia_inventariospos WHERE ID_ARTICULO = '$row2[1]' GROUP BY ID_ARTICULO";
        $consultaCantidad = mysqli_query($conexion, $cadenaCantidad);
        $rowCantidad = mysqli_fetch_array($consultaCantidad);
        $valorCant = ($rowCantidad[0] == "" ? 0 : $rowCantidad[0]);
        
        $InsertCant = "<center><a href='#' data-idreg = '$row[0]' data-idProd = '$row[1]' data-toggle = 'modal' data-target = '#modal-subrecetas' class='btn btn-default'  target='blank'><i class='fa fa-pencil fa-lg' aria-hidden='true'></i></a></center>";
        $produccion = (($row2[2] + $valorMin) - $valorCant <= 0) ? 0 : ($row2[2] + $valorMin) - $valorCant;
        $input = "<div class='input-group' style='width:100%''><input type='number'  class='form-control' value='$valorMin'></input></div>";
        array_push($datos,array(
            "id"=>$row[0],
            "clave_receta"=>$row[1],
            "nombre_receta"=>$row[2],
            "minimo_jc" => $input,
            /*"agregar" => $InsertCant,*/
            "existencias" => $row2[4],
            "produccion"=>$produccion
        ));
    }
}
echo utf8_encode(json_encode($datos));
?>