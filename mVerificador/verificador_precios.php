<?php
include '../global_seguridad/verificar_sesion.php';
$sucursal = "";
if($id_sede=='1'){
  $sucursal = 'DO';
}elseif($id_sede=='2'){
  $sucursal = 'ARB';
}elseif($id_sede=='3'){
  $sucursal='VILL';
}elseif($id_sede=='4'){
  $sucursal = 'ALL';
}elseif($id_sede=='5'){
  $sucursal = 'PTCA';
}elseif($id_sede=='6'){
  $sucursal = 'MMORELOS';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <title>La Misión Supermercados</title>
  <style type="text/css">
    .encabezado{
      background-color: #B40404;
    }
    .texto-encabezado{
      font-size: 2em;
      color: #FFFFFF;
    }
    .etiqueta{
      font-size: 1em;
    }
    .tamaño-input{
      font-size: 2em;
    }
    .descripcion{
      font-size: 3em;
    }
    .precio{
      font-size: 5em;
    }
    .oferta{
      font-size: 5em;
      color: #B40404;
    }
    .texto-oferta{
      font-size: 3em;
      color: #B40404;
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row text-center encabezado">
      <h1 class="texto-encabezado">Verificador de Precios - <?php echo $sucursal; ?></h1>
      <br>
    </div>
  </div>
  <br>
  <div class="container">
    <form method="POST" id="form-datos">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="codigo_producto" class="etiqueta">Ingresa el código:</label>
            <input type="text" name="codigo_producto" class="form-control text-center tamaño-input" id="codigo_producto">
          </div>
        </div>
      </div>
    </form>
  </div>
  <br>
  <div id="resp"></div>
  <script src="assets/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script>   
    $(function(){
      $('#codigo_producto').focus(); //Se enfoca la caja de texto al cargar la página
      $("#codigo_producto").keypress(function(e){ //Función que se desencadena al presionar enter
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13){
        var url = "consulta_producto.php"; // El script a dónde se realizará la petición.
          $.ajax({
            type: "POST",
            url: url,
            data: $("#form-datos").serialize(), // Adjuntar los campos del formulario enviado.
            success: function(respuesta)
            {
              $('#resp').html(respuesta);
              $(":text").val(''); //Limpiar los campos tipo Text
              $('#codigo_producto').focus();
            }
          });
          return false;
        }
      });
    });
  </script>
</body>
</html>