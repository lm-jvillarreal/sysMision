<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');
  
  $cadena  = "SELECT
                id,
                (
                  SELECT
                    marca
                  FROM
                    marcas
                  WHERE
                    marcas.id = modelos.id_marca
                ),
                modelo
              FROM
                modelos
              WHERE activo = '1'
              AND tipo = '0'";
  $consulta = mysqli_query($conexion, $cadena);

  $cadena2 = mysqli_query($conexion,"SELECT id,marca FROM marcas WHERE activo = '1'");
  $opciones = "";

  $cuerpo = "";
  $numero = 1;
  $activo = "";
  while ($row_modelo = mysqli_fetch_array($consulta)) 
  { 
    $boton_editar = "<a class='btn btn-warning' onclick='editar_modelo($row_modelo[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></a>";
    $boton_eliminar="<a onclick='eliminar_modelo($row_modelo[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Marca\": \"$row_modelo[1]\",
      \"Modelo\": \"$row_modelo[2]\",
      \"Editar\": \"$boton_editar\",
      \"Eliminar\": \"$boton_eliminar\"
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