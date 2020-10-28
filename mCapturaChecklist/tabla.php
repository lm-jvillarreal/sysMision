<?php 
  include '../global_seguridad/verificar_sesion.php';
  $filtro=(!empty($registros_propios) == '1')?" AND id_perfil = '$perfil_usuario'":"";
  $filtro_sucursal =($solo_sucursal=='1') ? " AND id_sucursal='$id_sede'":"";

  $cadena  = "SELECT id, nombre,
  (SELECT nombre FROM sucursales WHERE sucursales.id = checklist.id_sucursal),
  (SELECT nombre FROM departamentos_checklist WHERE departamentos_checklist.id = checklist.id_departamento),
  CASE id_categoria WHEN '1' THEN 'Diario' WHEN '2' THEN 'Semanal' WHEN '3' THEN 'Quincenal' ELSE 'Mensual' END AS id_categoria,
  CASE tipo WHEN '1' THEN 'Calificacion' WHEN '2' THEN 'Check' END AS tipo ,
  id_perfil
  FROM checklist 
  WHERE activo = '1'".$filtro.$filtro_sucursal;
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo   = "";
  $numero   = 1;

  while ($row = mysqli_fetch_array($consulta)) 
  {    
    $comenzar = "<a onclick='cargar($row[0],$numero)' class='btn btn-danger'><i class='fa fa-play fa-lg' aria-hidden='true'></i></a>";
    $combo    = ($row[6] == "3")?"<select id='sucursal".$numero."' class='form-control select2' style='width:100%' value='$id_sede'><option value='1'>Diaz Ordaz</option><option value='2'>Arboledas</option><option value='3'>Villegas</option><option value='4'>Allende</option><option value='5'>Petaca</option></select>":$row[2];

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Nombre\": \"$row[1]\",
      \"Departamento\": \"$row[3]\",
      \"Categoria\": \"$row[4]\",
      \"Calificar\": \"$row[5]\",
      \"SucursalC\": \"$combo\",
      \"Comenzar\": \"$comenzar\"
      },";
    $cuerpo = $cuerpo.$renglon;
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