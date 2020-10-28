<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$folio_oferta = $_POST['folio_oferta'];
$proveedor = $_POST['proveedor'];

$cadenaOferta = "SELECT aroc_articulo as Codigo,
                (SELECT ARTC_DESCRIPCION FROM PV_ARTICULOS WHERE ARTC_ARTICULO = pv_articulos_oferta.aroc_articulo) AS Descripcion
                FROM PV_ARTICULOS_OFERTA 
                WHERE aroc_sucursal = '$id_sede' 
                AND aron_baja_sn = '0' 
                AND coon_id_oferta = '$folio_oferta'";
$consultaOferta = oci_parse($conexion_central, $cadenaOferta);
oci_execute($consultaOferta);

$cadenaProveedores="SELECT numero_proveedor, proveedor FROM proveedores";
$consultaProveedores = mysqli_query($conexion,$cadenaProveedores);
$option="";
while($rowProveedores=mysqli_fetch_array($consultaProveedores)){
  $escapeProv = mysqli_real_escape_string($conexion,$rowProveedores[1]);
  if($rowProveedores[0]==$proveedor){
    $option= $option."<option value='$rowProveedores[0]' selected>$escapeProv</option>";
  }else{
    $option= $option."<option value='$rowProveedores[0]'>$escapeProv</option>";
  }
}

$cuerpo = "";
$conteo = 1;
while ($rowOferta=oci_fetch_row($consultaOferta)) {
  
  $fecha_inicio = "<input type='date' class='form-control' id='inicio_$conteo' value='$fecha' style='width: 100%'>";
  $fecha_fin = "<input type='date' class='form-control' id='fin_$conteo' value='$fecha' style='width: 100%'>";
  $codigo = "<input type='hidden' id='codigo_$conteo' value='$rowOferta[0]'>";
  $descripcion = "<input type='hidden' id='descripcion_$conteo' value='$rowOferta[1]'>";
  $proveedor = "<select name='proveedor_$conteo' id='proveedor_$conteo' class='form-control select2' style='width: 100%'><option value=''></option>$option</select>";
  $cantidad = "<input type='number' name='cantidad_$conteo' id='cantidad_$conteo' class='form-control' style='width: 100%'>";
  $guardar = "<button onclick='insertar($conteo)' class='btn btn-danger' type='button'><i class='fa fa-save fa-lg' aria-hidden='true'></i></button>";
  $renglon = "
  {
    \"articulo\": \"$rowOferta[0]$codigo\",
    \"descripcion\": \"$rowOferta[1]$descripcion\",
    \"inicio\": \"$fecha_inicio\",
    \"fin\": \"$fecha_fin\",
    \"proveedor\": \"$proveedor\",
    \"cantidad\": \"$cantidad\",
    \"opciones\": \"$guardar\"
  },";
  $cuerpo = $cuerpo.$renglon;
  $conteo = $conteo+1;
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>