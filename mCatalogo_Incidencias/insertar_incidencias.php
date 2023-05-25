<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');

$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

  $id_registro = $_POST['id_registro2'];
  $incidencia = $_POST['incidencia'];
  $categoria=$_POST['categoriaa'];
  $tipo=$_POST['tipoIn'];
  $gravedad=$_POST['gravedad'];
  $accion=$_POST['accion'];
  
  if (empty($id_registro)) {
    //Insertar nuevo registro
    $verificar=mysqli_query($conexion,"SELECT id FROM catalogo_incidencias WHERE incidencia= '$incidencia'");
    $existe = mysqli_num_rows($verificar);

    if($existe == 0){
      $cadena_consulta = "INSERT INTO catalogo_incidencias (incidencia,categoria,tipo,accion_sugerida,gravedad,fecha,hora,usuario, activo)
      VALUES('$incidencia','$categoria','$tipo','$accion','$gravedad','$fecha','$hora','$id_usuario','1' )";
      $insertar = mysqli_query($conexion,$cadena_consulta);
      echo "ok_nuevo";
     }else{
   
      echo "duplicado";
    }
  }elseif (!empty($id_registro)) {
    $cadena_actualizar = "UPDATE catalogo_incidencias SET incidencia = '$incidencia', categoria = '$categoria',tipo = '$tipo', gravedad = '$gravedad',accion_sugerida ='$accion', fecha='$fecha',hora='$hora',usuario='$id_usuario',activo = '1'  WHERE id = '$id_registro'";
    $consulta_actualizar = mysqli_query($conexion, $cadena_actualizar);
    echo "ok_actualizado";
  
}
?>
