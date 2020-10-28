<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');


  $filtro=(!empty($registros_propios) == '1')?"AND id_usuario = '$id_usuario'":"";

  if(!empty($_POST['folio']))
  {
    $folio = $_POST['folio'];
  }
  else
  {
    $folio = 0;
  }

  $cadena  = "SELECT
                prestamos_morralla.id,
                prestamos_morralla.folio,
                CONCAT(
                  personas.nombre,
                  ' ',
                  personas.ap_paterno,
                  ' ',
                  personas.ap_materno
                ) AS Nom,
                sucursales.nombre,
                prestamos_morralla.semana,
                prestamos_morralla.resultado,
                prestamos_morralla.fecha
              FROM
                prestamos_morralla
              INNER JOIN usuarios ON usuarios.id = prestamos_morralla.id_usuario
              INNER JOIN personas ON usuarios.id_persona = personas.id
              INNER JOIN sucursales ON sucursales.id = prestamos_morralla.id_sucursal
              WHERE prestamos_morralla.activo = '1'".$filtro."
              GROUP BY prestamos_morralla.folio 
              ORDER BY prestamos_morralla.id DESC";
              // echo $cadena;
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo    = "";
  $operacion = 0;
  $total     = 0;
  $abono     = 0;
  $restante  = 0;
  $numero    = 1;
  $abonar    ="";
  $clase     ="";

  while ($row_prestamo = mysqli_fetch_array($consulta)) 
  {
    $cadena = mysqli_query($conexion,"SELECT SUM(resultado) FROM prestamos_morralla WHERE folio = '$row_prestamo[1]' AND activo = '1'");
    $row_resultado = mysqli_fetch_array($cadena);

    $cadena2 = mysqli_query($conexion, "SELECT SUM(abono) FROM abonos WHERE folio = '$row_prestamo[1]'");
    $row_abonos = mysqli_fetch_array($cadena2);
    
    if($row_abonos[0] == ""){
      $abono = 0;
    }
    else{
      $abono = $row_abonos[0];
    }
    $total = $row_resultado[0];

    $operacion = $total - $abono;

    $restante = sprintf('%0.2f', $operacion);
    
    if($fecha_actual == $row_prestamo[6] && $abono == 0){
      $clase = "disabled";
    }
    else{
      $clase = "";
    }

    if ($restante == 0){
      // $abonar = "<a href='abonar.php?folio=$row_prestamo[1]'><button class='btn btn-success'".$clase.">Liquidado</button></a>";
      $color = "success";
      $texto = "<i class='fa fa-check-circle fa-lg' aria-hidden='true'></i>";

    }
    else{
      // $abonar = "<a href='abonar.php?folio=$row_prestamo[1]'><button class='btn btn-warning'".$clase.">Abonar</button></a>";
      $color = "warning";
      $texto = "<i class='fa fa-money fa-lg' aria-hidden='true'></i>";
    }

    $abonar = "<button href='#' data-id = '$row_prestamo[1]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-".$color."' target='blank' ".$clase.">".$texto."</button>";
    
    $editar=($row_prestamo[6] != $fecha_actual)?"<button class='btn btn-danger' disabled><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button>":"<a href='editar_prestamo.php?folio=$row_prestamo[1]'><button class='btn btn-danger'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button></a>";

    $pdf = "<a href='pdf/pdfPrestamo.php?folio=$row_prestamo[1]' target='_blank'><button class='btn btn-danger'><i class='fa fa-file-pdf-o fa-lg' aria-hidden='true'></i></button></a>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Usuario\": \"$row_prestamo[2]\",
      \"Sucursal\": \"$row_prestamo[3]\",
      \"Semana\": \"$row_prestamo[4]\",
      \"Total\": \"$ $total\",
      \"Restante\": \"$ $restante\",
      \"Editar\": \"$editar\",
      \"Abonar\": \"$abonar\",
      \"PDF\": \"$pdf\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $total = 0;
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;
 ?>