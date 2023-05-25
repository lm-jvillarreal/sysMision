<?php
include '../global_seguridad/verificar_sesion.php';

/*-----preguntar como funciona el día------ */

$datos=array();
$cadenaConsulta="SELECT ID, ARTC_ARTICULO, ARTC_DESCRIPCION 
FROM panaderia_recetasventa WHERE ACTIVO=1";
$consultaCostos=mysqli_query($conexion,$cadenaConsulta);
while($rowCostos=mysqli_fetch_array($consultaCostos)){

  $cadenaDetalle="SELECT
                  ID,
                  ID_PRODUCTO,
                  CLAVE_ARTICULO,
                  CANTIDAD_RECETA,
                  SUBRECETA,
                  MERMA 
                  FROM
                  panaderia_recetasventarenglones 
                  WHERE
                  ACTIVO = 1 
                  AND ID_PRODUCTO = '$rowCostos[0]' GROUP BY CLAVE_ARTICULO";
$consultaDetalle=mysqli_query($conexion,$cadenaDetalle);
  while($rowDetalle=mysqli_fetch_array($consultaDetalle)){
    if($rowDetalle[4]=='1'){
      $cadenaSR="SELECT CLAVE_RECETA, NOMBRE_RECETA, UNIDAD_MEDIDA, RENDIMIENTO AS FACTOR_EMPAQUE, ID FROM panaderia_subrecetas WHERE CLAVE_RECETA='$rowDetalle[2]'";
      $consultaSR=mysqli_query($conexion,$cadenaSR);
      $rowSR=mysqli_fetch_array($consultaSR);
      
      $cadenaDesglose="SELECT ID, ID_ARTICULO, CANTIDAD_RECETA, SUBRECETA FROM panaderia_subrecetasrenglones WHERE ID_SUBRECETA='$rowSR[4]' AND ACTIVO='1' GROUP BY ID_ARTICULO";
      $consultaDesglose=mysqli_query($conexion,$cadenaDesglose);
      while($rowDesglose=mysqli_fetch_array($consultaDesglose)){
       if($rowDesglose[3]=='0'){
          $cadenaTotales="SELECT
                            round(
                              SUM( ( ( a.RMON_ULTIMOPRECIO / a.FACTOR_EMPAQUE ) * r.CANTIDAD_RECETA ) / ( 1- ( a.PORCENTAJE_MERMA / 100 ) ) ) + SUM( ( ( a.RMON_ULTIMOPRECIO / a.FACTOR_EMPAQUE ) * r.CANTIDAD_RECETA ) / ( 1- ( a.PORCENTAJE_MERMA / 100 ) ) ) * 0.03,
                              2 
                            ) AS COSTO_NETO ,
                            sum(r.CANTIDAD_RECETA * (SELECT LUNES FROM panaderia_calendarioprod WHERE ID_TABLA = '$rowDetalle[1]')),
                            sum(r.CANTIDAD_RECETA * (SELECT MARTES FROM panaderia_calendarioprod WHERE ID_TABLA = '$rowDetalle[1]')),
                            sum(r.CANTIDAD_RECETA * (SELECT MIERCOLES FROM panaderia_calendarioprod WHERE ID_TABLA = '$rowDetalle[1]')),
                            sum(r.CANTIDAD_RECETA * (SELECT JUEVES FROM panaderia_calendarioprod WHERE ID_TABLA = '$rowDetalle[1]')),
                            sum(r.CANTIDAD_RECETA * (SELECT VIERNES FROM panaderia_calendarioprod WHERE ID_TABLA = '$rowDetalle[1]')),
                            sum(r.CANTIDAD_RECETA * (SELECT SABADO FROM panaderia_calendarioprod WHERE ID_TABLA = '$rowDetalle[1]')),
                            sum(r.CANTIDAD_RECETA * (SELECT DOMINGO FROM panaderia_calendarioprod WHERE ID_TABLA = '$rowDetalle[1]')),
                            a.ARTC_ARTICULO,
                            a.ARTC_DESCRIPCION
                          FROM
                            panaderia_subrecetasrenglones  AS r
                            INNER JOIN panaderia_articulos AS a ON r.ID_ARTICULO = a.ARTC_ARTICULO 
                          WHERE
                            r.ID_SUBRECETA = '$rowSR[4]' GROUP BY a.ARTC_ARTICULO";
          $consultaTotales=mysqli_query($conexion,$cadenaTotales);
          $rowTotales=mysqli_fetch_array($consultaTotales);
        }
      }
      $artc_articulo = $rowTotales[8];
      $artc_descripcion = $rowTotales[9];
      $lunes = $rowTotales[1] == "" ? 0 : $rowTotales[1];
      $martes = $rowTotales[2] == "" ? 0 : $rowTotales[2];
      $miercoles = $rowTotales[3] == "" ? 0 : $rowTotales[3];
      $jueves = $rowTotales[4] == "" ? 0 : $rowTotales[4];
      $viernes = $rowTotales[5] == "" ? 0 : $rowTotales[5];
      $sabado = $rowTotales[6] == "" ? 0 : $rowTotales[6];
      $domingo = $rowTotales[7] == "" ? 0 : $rowTotales[7];
    }else{
      //Entra aqui si es articulo
      $cadenaArtc="SELECT
                    r.CLAVE_ARTICULO,
                    a.ARTC_DESCRIPCION,
                    a.PROVEEDOR,
                    a.RMON_ULTIMOPRECIO,
                    a.UNIMEDIDA_COMPRA,
                    a.FACTOR_EMPAQUE,
                    round((a.RMON_ULTIMOPRECIO/a.FACTOR_EMPAQUE),2) as COSTO_UNITARIO,
                    r.CANTIDAD_RECETA,
                    a.PORCENTAJE_MERMA,
                    round(((a.RMON_ULTIMOPRECIO/a.FACTOR_EMPAQUE)*r.CANTIDAD_RECETA)/(1-(a.PORCENTAJE_MERMA/100)),2) PRECIO_UNITARIO,
                    sum(r.CANTIDAD_RECETA * (SELECT LUNES FROM panaderia_calendarioprod WHERE ID_TABLA = r.ID_PRODUCTO)),
                    sum(r.CANTIDAD_RECETA * (SELECT MARTES FROM panaderia_calendarioprod WHERE ID_TABLA = r.ID_PRODUCTO)),
                    sum(r.CANTIDAD_RECETA * (SELECT MIERCOLES FROM panaderia_calendarioprod WHERE ID_TABLA = r.ID_PRODUCTO)),
                    sum(r.CANTIDAD_RECETA * (SELECT JUEVES FROM panaderia_calendarioprod WHERE ID_TABLA = r.ID_PRODUCTO)),
                    sum(r.CANTIDAD_RECETA * (SELECT VIERNES FROM panaderia_calendarioprod WHERE ID_TABLA = r.ID_PRODUCTO)),
                    sum(r.CANTIDAD_RECETA * (SELECT SABADO FROM panaderia_calendarioprod WHERE ID_TABLA = r.ID_PRODUCTO)),
                    sum(r.CANTIDAD_RECETA * (SELECT DOMINGO FROM panaderia_calendarioprod WHERE ID_TABLA = r.ID_PRODUCTO))
                    FROM
                    panaderia_recetasventarenglones AS r
                    INNER JOIN panaderia_articulos AS a ON r.CLAVE_ARTICULO = a.ARTC_ARTICULO
                    WHERE r.CLAVE_ARTICULO='$rowDetalle[2]' AND r.ID_PRODUCTO='$rowDetalle[1]' GROUP BY r.CLAVE_ARTICULO";
      $consultaArtc=mysqli_query($conexion,$cadenaArtc);
      $rowArtc=mysqli_fetch_array($consultaArtc);
      $artc_articulo = $rowArtc[0];
      $artc_descripcion = $rowArtc[1];
      $lunes = $rowArtc[10] == "" ? 0 : $rowArtc[10];
      $martes = $rowArtc[11] == "" ? 0 : $rowArtc[11];
      $miercoles = $rowArtc[12] == "" ? 0 : $rowArtc[12];
      $jueves = $rowArtc[13] == "" ? 0 : $rowArtc[13];
      $viernes = $rowArtc[14] == "" ? 0 : $rowArtc[14];
      $sabado = $rowArtc[15] == "" ? 0 : $rowArtc[15];
      $domingo = $rowArtc[16] == "" ? 0 : $rowArtc[16];
    }
    if (count($datos) <= 0) {
      array_push($datos,array(
        'artc_articulo' => $artc_articulo,
        'artc_descripcion' => $artc_descripcion,
        'lunes'=> $lunes,//round(($cantidad_receta * $lunes),2),
        'martes'=> $martes,//round(($cantidad_receta * $martes),2),
        'miercoles'=>$miercoles,//round(($cantidad_receta * $miercoles),2),
        'jueves'=>$jueves,//round(($cantidad_receta * $jueves),2),
        'viernes'=>$viernes,//round(($cantidad_receta * $viernes),2),
        'sabado'=>$sabado,//round(($cantidad_receta * $sabado),2)
        'domingo'=>$domingo
      ));
    }else{
      $existe = "no";
      $posicion = 0;
      for($i = 0; $i < count($datos); $i++){
        if ($datos[$i]['artc_articulo'] == $artc_articulo) {
          $existe = "si";
          $posicion = $i;
        }        
      }
      if ($existe == "si") {
        $datos[$posicion]['lunes'] = $datos[$posicion]['lunes'] + $lunes;
        $datos[$posicion]['martes'] = $datos[$posicion]['martes'] + $martes;
        $datos[$posicion]['miercoles'] = $datos[$posicion]['miercoles'] + $miercoles;
        $datos[$posicion]['jueves'] = $datos[$posicion]['jueves'] + $jueves;
        $datos[$posicion]['viernes'] = $datos[$posicion]['viernes'] + $viernes;
        $datos[$posicion]['sabado'] = $datos[$posicion]['sabado'] + $sabado;
        $datos[$posicion]['domingo'] = $datos[$posicion]['domingo'] + $domingo;
      }else{
            array_push($datos,array(
            'artc_articulo' => $artc_articulo,
            'artc_descripcion' => $artc_descripcion,
            'lunes'=> $lunes,//round(($cantidad_receta * $lunes),2),
            'martes'=> $martes,//round(($cantidad_receta * $martes),2),
            'miercoles'=>$miercoles,//round(($cantidad_receta * $miercoles),2),
            'jueves'=>$jueves,//round(($cantidad_receta * $jueves),2),
            'viernes'=>$viernes,//round(($cantidad_receta * $viernes),2),
            'sabado'=>$sabado,//round(($cantidad_receta * $sabado),2)
            'domingo'=>$domingo
          ));
        }
    }
       
  }  
}
echo utf8_encode(json_encode($datos));
?>
