<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  
  if (!empty($_POST['fecha'])){
    $fecha = $_POST['fecha'];
  }
  else{
    $fecha = date("Y-m-d");
    $fecha = date("Y-m-d");
    $fecha    = strtotime('-1 day', strtotime($fecha));
    $fecha = date('Y-m-d', $fecha);
  }
  $sucursal_alta = $_POST['sucursal'];
  $sucursal = ($sucursal_alta == "")?$id_sede:$sucursal_alta;

  $cadena = "SELECT
                a.folio,
                CONCAT(p.nombre,' ',p.ap_paterno,' ',p.ap_materno)AS Nomb,
                a.abono
              FROM
                abonos a
              INNER JOIN usuarios u ON u.id =  a.id_usuario
              INNER JOIN personas p ON p.id = u.id_persona
              WHERE
                a.id_sucursal = '$sucursal'
              AND a.fecha = '$fecha'";
  $consulta = mysqli_query($conexion,$cadena);
  $row = mysqli_fetch_array($consulta);

  $cadena2 = "SELECT
                DISTINCT(semana)
              FROM
                prestamos_morralla
              WHERE folio = '$row[0]'";
  $consulta2 = mysqli_query($conexion,$cadena2);
  $row2 = mysqli_fetch_array($consulta2);

  $folio   = ($row[0] == "")?"-":$row[0];
  $semana  = ($row2[0] == "")?"-":$row2[0];
  $usuario = ($row[1] == "")?"-":$row[1];
  $abono   = ($row[2] == "")?"-":'$ '.$row[2];

  $array1 = array($folio,$semana,$usuario,$abono);

  $array = json_encode($array1);
  echo $array;

?>