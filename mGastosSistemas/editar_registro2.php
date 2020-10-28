<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$id = $_POST['id'];
	
	$cadena = mysqli_query($conexion,"SELECT
						                          proveedor,
                                      fecha_movimiento,
                                      gasto,
                                      id_rublo,
                                      (SELECT nombre FROM rublos WHERE rublos.id = gastos_sistemas.id_rublo),
                                      documento,
                                      comentario,
                                      evidencia,
                                      id_sucursal,
                                      folio_factura
                                    FROM
                                      gastos_sistemas
                                    WHERE 
                                        id = '$id'");

    $row = mysqli_fetch_array($cadena);

    function imagen($imagen){
      if (strlen(stristr($imagen,'pdf'))>0) {
        $imagen = "file-pdf-o";
      }else if(strlen(stristr($imagen,'xlsx'))>0){
        $imagen = "file-excel-o";
      }else if(strlen(stristr($imagen,'docx'))>0){
        $imagen = "file-word-o";
      }else if(strlen(stristr($imagen,'pptx'))>0){
        $imagen = "file-powerpoint-o";
      }else if(strlen(stristr($imagen,'jpg'))>0){
        $imagen = "file-image-o";
      }else if(strlen(stristr($imagen,'png'))>0){
        $imagen = "file-image-o";
      }else{
        $imagen = "file-o";
      }
      return $imagen;
    }

    $imagen  = imagen($row[5]);
    $imagen2 = imagen($row[7]);

    $array  = array($row[0], //Proveedor
                    $row[1], //Fecha_Mov
                    $row[2], //Gasto
                    $row[3], //id_rublo
                    $row[4], //nombre_rublo
                    $row[5], //Documento
                    $row[6], //Comentario
                    $imagen, //Formato
                    $row[7], //Evidencia
                    $imagen2, //Formato_evi
                    $row[8], //sucursal
                    $row[9] //folio_factura
                    );
	$array1 = json_encode($array);
	
	echo $array1;
	
?>