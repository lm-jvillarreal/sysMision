
<?php
date_default_timezone_set('America/Monterrey');
$fecha      = date('Y-m-d');
$nuevafecha = strtotime('+1 day', strtotime($fecha));
$nuevafecha = date('Y-m-d', $nuevafecha);
$hora       = date('h:i:s');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="http://weareoutman.github.io/clockpicker/dist/bootstrap-clockpicker.min.css">
  <link rel="stylesheet" href="../d_plantilla/bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/alertifyjs/css/alertify.min.css">
  <link rel="stylesheet" href="../plugins/alertifyjs/css/themes/default.min.css">
  <link rel="stylesheet" href="../plugins/alertifyjs/css/themes/semantic.min.css">
  <link rel="stylesheet" href="../plugins/alertifyjs/css/themes/bootstrap.min.css">
  <link rel="shortcut icon" href="../d_plantilla/dist/img/logo.png" type='image/png'>
  <link rel="stylesheet" href="estilos.css">
  <script src="http://code.jquery.com/jquery-2.2.0.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="http://weareoutman.github.io/clockpicker/dist/bootstrap-clockpicker.min.js"></script>
  <title>La Misión | Tiempo Extra</title>
</head>
<body>
<header>
  <nav class="navbar navbar-light">
        <div>
          <p class="navbar-text mb-0 h1"> <img src="../d_plantilla/dist/img/logo.png" width="150" height="80" alt=""></p>
          <center>
            <div class=col-md-9>Solicitud de Tiempo Extra</div>
          </center>
        </div>
      </nav>
</header>
    <div class="container-fluid">
      <div class="box box-danger">
        <div class="box-body">
          <form method="POST" id="form_datos">
            <div class="container container-fluid">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="id_persona">*Nombre:</label>
                    <input type="hidden" name="id_registro" id="id_registro">
                    <select name="id_persona" id="id_persona" class="select2" style="width: 240px" onchange="llenar()">
                     <option value=""></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                <div class="form-group">
                  <label for="departamento">*Departamento:</label>
                  <input type="text" name="departamento" id="departamento" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="sucursal">*Sucursal:</label>
                  <input type="text" name="sucursal" id="sucursal" class="form-control" readonly>
                </div>
              </div> 
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="reloj">Hora inicio:</label>
                      <div class="input-group clock">
                          <input type="text" class="form-control" value="" id="fecha_inicio" name="fecha_inicio" placeholder="Ahora" readonly onchange="diferencia()">
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-time"></span>
                          </span>
                      </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="reloj">Hora final:</label>
                      <div class="input-group clock">
                        <input type="text" class="form-control" value="" id="fecha_fin" name="fecha_fin"  placeholder="Ahora" readonly onchange="diferencia()">
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-time"></span>
                        </span>
                      </div>
                  </div>
                </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="comentario">*Motivo:</label>
                  <select name="motivo" id="motivo" class="form-control" onchange="if(this.value=='Otro') {document.getElementById('otro').disabled = false} else {document.getElementById('otro').disabled = true}">
                    <option value=""></option>
                    <option value="Inventario">Inventario</option>
                    <option value="Novillo Gordo">Novillo Gordo</option>
                    <option value="Dia de Muertos">Día de Muertos</option>
                    <option value="Dia de las Madres">Día de las Madres</option>
                    <option value="San Valentin">San Valentín</option>
                    <option value="Dia del Niño">Día del Niño</option>
                    <option value="Rosca de Reyes">Rosca de Reyes</option>
                    <option value="Navideño">Navideño</option>
                    <option value="Falta de Persona">Falta de Personal</option>
                    <option value="Cubrir Descanso">Cubrir Descanso</option>
                    <option value="Velada">Velada</option>
                    <option value="Produccion Extra">Producción Extra</option>
                    <option value="Otro">Otro</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="otro">*Motivo(Otro):</label>
                  <input type="text" name="otro" id="otro" class="form-control" placeholder="Especifique motivo" disabled>
                </div>
              </div>
              <div class="col-md-3">
              <div class="form-group">
                <label for="comentario">*Comentario:</label>
                <input type="text" name="comentario" id="comentario" class="form-control" placeholder="">
              </div>
            </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="tiempo"></label>
                  <input type="hidden" name="tiempo" id="tiempo" class="form-control" readonly>
                </div>
              </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 2.0.0
      </div>
      <strong>Copyright &copy; 2018 <a href="#" target="blank">La Misión Supermercados S.A. de C.V.</a></strong> Todos los derechos reservados.
    </footer>
    </div>
    <script src="script.js"></script>
    <script>
    function diferencia() {
      var fecha_inicio = $('#fecha_inicio').val();
      var fecha_fin = $('#fecha_fin').val();
      if (fecha_inicio != "" && fecha_fin != "") {
        if(fecha_fin < fecha_inicio){
          alert("Hora inicio es mayor");
        }
        else{ 
          var url = 'diferencia.php';
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: {
            'fecha_inicio': fecha_inicio,
            'fecha_fin': fecha_fin
          },
          success: function(respuesta) {
            $('#tiempo').val(respuesta);
          },
          error: function(xhr, status) {
            alert("error");
            alert(xhr);
          },
        });
        }
      }
    }
    </script>
</body>
</html>