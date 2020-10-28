<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$nuevafecha  = strtotime ( '+1 day' , strtotime ($fecha) ) ;
$nuevafecha  = date ( 'Y-m-d' , $nuevafecha );

$fecha_completa_inicio = $fecha .' 12:00:00';
$fecha_completa_final  = $nuevafecha .' 12:00:00';
$title = "";
$color = "#FF0000";

$folio     = $_POST["folio"];
$codigo    = $_POST["codigo"];
$bodega    = $_POST["bodega"];
$pedido    = $_POST["pedido"];
$envio     = $_POST["envio"];
$longitud  = count($envio);
$resultado = 0;
$folio_e   = 0;

for ($i=0; $i < $longitud; $i++) 
    {
        if($envio[$i] == null)
            {
                echo"1";
            }
        else
            {
                $qry = "UPDATE materiales
                                SET id_usuario_libero = '$id_usuario',
                                 activo = '2'
                                WHERE
                                    folio = '$folio'";
                        $result = mysqli_query($conexion, $qry); 
                for ($i=0; $i < $longitud; $i++) 
                    { 
                    
                        $qry1 = "UPDATE historial_pedido_materiales
                                SET envio = '$envio[$i]',
                                 activo = '2'
                                WHERE
                                    folio = '$folio'
                                AND codigo = '$codigo[$i]'";
                        $result1 = mysqli_query($conexion, $qry1);    
                    }
                for ($o=0; $o <$longitud ; $o++) { 
                    $cadena_seleccionar = mysqli_query($conexion,"SELECT existencia FROM historial_existencia_materiales WHERE codigo = '$codigo[$o]'");
                    $row = mysqli_fetch_array($cadena_seleccionar);

                    $resultado = $row[0] - $envio[$o];

                    $cadena = mysqli_query($conexion,"UPDATE historial_existencia_materiales SET existencia = '$resultado'  WHERE codigo = '$codigo[$o]'");
                    $resultado = 0;
                }
                for ($m=13; $m < 25 ; $m++) { 
                    $cadena = mysqli_query($conexion,"SELECT existencia,(SELECT nombre FROM catalago_materiales WHERE historial_existencia_materiales.codigo = catalago_materiales.codigo) FROM historial_existencia_materiales WHERE codigo = '$m'");

                    $row_cadena = mysqli_fetch_array($cadena);

                    if($row_cadena[0] == "0"){
                        $title = "Falta - $row_cadena[1]";
                        
                        $verificar     = mysqli_query($conexion,"SELECT folio FROM agenda WHERE title = '$title'");
                        $row_verificar = mysqli_fetch_array($verificar);
                        $cantidad      = mysqli_num_rows($verificar);

                        if($cantidad != 0){
                            $folio_e = $row_verificar[0];
                            $cadena_actualizar = mysqli_query($conexion,"UPDATE agenda SET start='$fecha_completa_inicio', end = '$fecha_completa_final', fecha = '$fecha', hora = '$hora' WHERE folio = '$folio_e'");
                        }
                        else{
                            $cadena_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM agenda");
                            
                            $row_folio    = mysqli_fetch_array($cadena_folio);
                            
                            $folio_e        = $row_folio[0] + 1;

                         $cadena_agenda = mysqli_query($conexion,"INSERT INTO agenda (folio,title,start,end,id_usuario,fecha,hora,backgroundColor,borderColor)
                                VALUES('$folio_e','$title','$fecha_completa_inicio','$fecha_completa_final','2','$fecha','$hora','$color','$color')");
                        }
                    }
                    $folio_e = 0;
                }            
                echo"2";
            }
    }   

?>