<?php 
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion_oracle.php';

  $filtro=(!empty($registros_propios) == '1')?"AND id_usuario = '$id_usuario'":"";
  
  $cadena  = "SELECT id,CONCAT( nombre, ' ', ap_paterno,' - ',compañia),(SELECT CONCAT(personas.nombre,' ',personas.ap_paterno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = promotores.id_comprador),telefono,
              CASE
                frecuencia 
                WHEN 1 THEN
                  'Diaria' 
                WHEN 2 THEN
                  'Semanal' 
                WHEN 3 THEN
                  'Quincenal' 
                WHEN 4 THEN
                  'Mensual' 
              END AS Frecuencia,
              clave_proveedor,
              celular,
              activo
              FROM promotores 
              WHERE (activo != '0' AND activo != '4')".$filtro;
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo         = "";
  $numero         = 1;
  $activo         = "";
  $nombre         = "";
  $button         = "";
  $opciones       = "";
  $icono          = "";
  $dias_restantes = 0;

  while ($row = mysqli_fetch_array($consulta)) 
  {
    //Cantidad de dias restantes
    $cadena_dias    = mysqli_query($conexion,"SELECT COUNT(*) FROM agenda_promotores WHERE activo = '1' AND dia > '$fecha' AND id_promotor = '$row[0]'");
    $row_dias       = mysqli_fetch_array($cadena_dias);
    $dias_restantes = ($row_dias[0] < 10)?"<span class='badge bg-red'>$row_dias[0]</span>":"";


    if($row[7] == '1'){
      $opciones = "<li><a href='#' data-id = '$row[0]' data-toggle = 'modal' data-target = '#modal-vacaciones' target='blank'><i class='fa fa-sun-o fa-lg' aria-hidden='true'></i>Vacaciones</a></li><li><a href='#' onclick='eliminar($row[0],3)'><i class='fa fa-wheelchair fa-lg' aria-hidden='true'></i>Incapacidad</a></li>";
      $icono = "";
    }else if($row[7] == '2'){ //Vacaciones
      $opciones = "<li><a href='#' onclick='eliminar($row[0],1)'><i class='fa fa-check-circle fa-lg' aria-hidden='true'></i>Activar</a></li><li><a href='#' onclick='eliminar($row[0],3)'><i class='fa fa-wheelchair fa-lg' aria-hidden='true'></i>Incapacidad</a></li>";
      $icono = "<button class= 'btn btn-xs btn-warning'><i class='fa fa-sun-o fa-lg'></i></button>";
    }else if($row[7] == '3'){ //Incapacidad
      $opciones = "<li><a href='#' onclick='eliminar($row[0],1)'><i class='fa fa-check-circle fa-lg' aria-hidden='true'></i>Activar</a></li><li><a href='#' onclick='eliminar($row[0],1)'><i class='fa fa-sun-o fa-lg' aria-hidden='true'></i>Vacaciones</a></li>";
      $icono = "<i class='fa fa-wheelchair fa-lg'></i>";
    }
    $opciones .= "<li><a href='#' data-id = '$row[0]' data-toggle = 'modal' data-target = '#modal-editar' target='blank'><i class='fa fa-calendar fa-lg' aria-hidden='true'></i>Modificar</a></li>";

    $button = "<div class='input-group input-group-md'><div class='input-group-btn'><button type='button' class='btn btn-danger dropdown-toggle' data-toggle='dropdown'><i class='fa fa-gear fa-lg' aria-hidden='true'></i> Acciones <span class='fa fa-caret-down'></span></button><ul class='dropdown-menu'><li><a href='#' onclick='editar_registro($row[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'></i>Editar</a></li>".$opciones."<li><a href='#' onclick='eliminar($row[0],4)'><i class='fa fa-trash fa-lg' aria-hidden='true'></i>Dar de Baja</a></li></div>";

    $cadena_proveedores = "SELECT PR.PROC_CVEPROVEEDOR, CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) FROM CXP_PROVEEDORES pr WHERE PR.PROC_CVEPROVEEDOR = '$row[5]'";
    
    $consulta_proveedores = oci_parse($conexion_central, $cadena_proveedores);
    oci_execute($consulta_proveedores);
    $row_proveedores=oci_fetch_row($consulta_proveedores);

    $nombre = "<a href='#' onclick='abrirModalSubir($row[0])'>$row[1]</a>";

    $boton_eliminar    = "<a onclick='eliminar($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'><i></a>";
    $boton_editar      = "<a class='btn btn-warning' onclick='editar_registro($row[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'><i></a>";
    $celular = ($row[6] == "1")?"<i class='fa fa-check-circle fa-lg' aria-hidden='true'></i>":"<i class='fa fa-ban fa-lg' aria-hidden='true'></i>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Nombre\": \"$nombre $icono\",
      \"Encargado\": \"$row[2]  $dias_restantes\",
      \"Proveedor\": \"$row_proveedores[1]\",
      \"Telefono\": \"$row[3]\",
      \"Frecuencia\": \"$row[4]\",
      \"Celular\": \"$celular\",
      \"Acciones\": \"$button\"
      },";
    $cuerpo   = $cuerpo.$renglon;
    $nombre   = "";
    $icono    = "";
    $opciones = "";
    $numero ++;
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>