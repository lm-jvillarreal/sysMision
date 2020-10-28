<?php
include '../global_seguridad/verificar_sesion.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
</head>

<body class="hold-transition skin-red sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
      <?php include '../header.php'; ?>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <?php include 'menuV.php'; ?>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Mis Datos Personales | Actualizar Datos Personales</h3>
          </div>
          <div class="box-body">
            <form action="" method="POST" id="form-datos">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Titulo</label>
                    <select name="titulo" id="titulo" class="form-control">
                      <option value=""></option>
                      <option value="Sr">Señor (Sr.)</option>
                      <option value="Sra">Señora (Sra.)</option>
                      <option value="Lic">Licenciado (Lic.)</option>
                      <option value="Dr">Doctor (Dr.)</option>
                      <option value="Ing">Ingeniero (Ing.)</option>
                      <option value="C">Ciudadano (C.)</option>
                      <option value="Mtr">Master (Mtr.)</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="nombre">*Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingresa tu nombre">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="ap_paterno">*Ap. Paterno</label>
                    <input type="text" name="ap_paterno" id="ap_paterno" class="form-control" placeholder="Ingresa tu Apellido paterno">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="ap_materno">Ap. Materno</label>
                    <input type="text" name="ap_materno" id="ap_materno" class="form-control" placeholder="Ingresa tu apellido materno">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="num_emp">No. Empleado</label>
                    <input type="text" name="num_emp" id="num_emp" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha_nacimiento">*Fecha de Nacimiento:</label>
                    <div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="fecha_nacimiento" data-link-format="yyyy-mm-dd" value="">
                      <input class="form-control" size="16" type="text" id="fecha_nacimiento" name="fecha_nacimiento">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="sexo">*Sexo</label>
                    <select name="sexo" id="sexo" class="form-control">
                      <option value=""></option>
                      <option value="Masculino">Masculino</option>
                      <option value="Femenino">Femenino</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="estado_civil">*Estado Civil</label>
                    <select name="estado_civil" id="estado_civil" class="form-control">
                      <option value=""></option>
                      <option value="Soltero(a)">Soltero(a)</option>
                      <option value="Casado(a)">Casado(a)</option>
                      <option value="Viudo(a)">Viudo(a)</option>
                      <option value="Divorciado(a)">Divorciado(a)</option>
                      <option value="Union libre">Unión Libre</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Departamento</label>
                    <input type="text" name="depto" id="depto" class='form-control' placeholder="Nombre de Depto.">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="celular">*Celular</label>
                    <input type="text" name="celular" id="celular" class="form-control" placeholder="Celular">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="rfc">*RFC.</label>
                    <input type="text" name="rfc" id="rfc" class="form-control" placeholder="Reg. Federal del Contribuyente">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="curp">*CURP.</label>
                    <input type="text" name="curp" id="curp" class="form-control" placeholder="Ingresa tu CURP">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="email">*Email Empresarial</label>
                    <input type="text" name="email" id="email" class="form-control" placeholder="Correo Electrónico">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="telefono">*Teléfono Empresarial</label>
                    <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Telefono Empresarial">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="telefono">*Ext.</label>
                    <input type="text" name="ext" id="ext" class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="colonia">*Colonia</label>
                    <input type="text" name="colonia" id="colonia" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="calle">*Calle</label>
                    <input type="text" name="calle" id="calle" class="form-control">
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label for="numero">No.</label>
                    <input type="text" name="numero" id="numero" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="municipio">*Municipio</label>
                    <select name="municipio" id="municipio" class="form-control">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
              </div>
            </form>
            <div class="row">
              <div class="col-md-8">
                <img src="createImage.php" alt="" width="600px" heigth="200px" class="img-thumbnail">
              </div>
              <div class="col-md-4">
                <div id="qrcodeCanvas"></div>
              </div>
            </div>
          </div>
          <div class="box-footer">
            <div class="text-right">
              <button class="btn btn-primary" id="btnQR">Generar vCard QR</button>
              <a href='createImage.php' class="btn btn-danger" download="FirmaCorreo.jpg"><i class="fa fa-cloud-download"></i> Descagar Imagen</a>
              <button class="btn btn-warning" id="btn-guardar">Actualizar Información</button>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include '../footer2.php'; ?>

    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <?php include '../footer.php'; ?>
  <script src="http://jeromeetienne.github.com/jquery-qrcode/src/qrcode.js"></script>
  <script src="http://jeromeetienne.github.com/jquery-qrcode/src/jquery.qrcode.js"></script>
  <!-- Page script -->
  <script type="text/javascript">
    $('.form_date').datetimepicker({
      language: 'es',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0
    });
    $('#sexo').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
    });
    $('#estado_civil').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
    });
    $('#titulo').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
    });
    $('#municipio').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "consulta_municipios.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            searchTerm: params.term // search term
          };
        },
        processResults: function(response) {
          return {
            results: response
          };
        },
        cache: true
      }
    });

    function datos_editar() {
      var url = "consulta_datos.php";
      $.ajax({
        type: "POST",
        url: url,
        data: "", // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#nombre').val(array[1]);
          $('#ap_paterno').val(array[2]);
          $('#ap_materno').val(array[3]);
          $('#fecha_nacimiento').val(array[4]);
          $('#sexo').val(array[5]).trigger('change.select2');
          $('#rfc').val(array[6]);
          $('#curp').val(array[7]);
          $('#email').val(array[8]);
          $('#celular').val(array[9]);
          $('#colonia').val(array[10]);
          $('#calle').val(array[11]);
          $('#numero').val(array[12]);
          $('#estado_civil').val(array[13]).trigger('change.select2');
          $('#telefono').val(array[16]);
          id_municipio = array[14];
          municipio = array[17];
          $("#depto").val(array[18]);
          $("#ext").val(array[19]);
          $('#titulo').val(array[20]).trigger('change.select2');
          $("#municipio").select2("trigger", "select", {
            data: {
              id: id_municipio,
              text: municipio
            }
          });
          $("#num_emp").val(array[21]);
        }
      });
    };
    $(document).ready(function(e) {
      datos_editar();
    });

    function getCleanedString(cadena) {
      // Definimos los caracteres que queremos eliminar
      var specialChars = "!@#$^&%*()+=-[]\/{}|:<>?,.";

      // Los eliminamos todos
      for (var i = 0; i < specialChars.length; i++) {
        cadena = cadena.replace(new RegExp("\\" + specialChars[i], 'gi'), '');
      }

      // Lo queremos devolver limpio en minusculas
      //cadena = cadena.toLowerCase();

      // Quitamos espacios y los sustituimos por _ porque nos gusta mas asi
      //cadena = cadena.replace(/ /g, "_");

      // Quitamos acentos y "ñ". Fijate en que va sin comillas el primer parametro
      cadena = cadena.replace(/á/gi, "a");
      cadena = cadena.replace(/é/gi, "e");
      cadena = cadena.replace(/í/gi, "i");
      cadena = cadena.replace(/ó/gi, "o");
      cadena = cadena.replace(/ú/gi, "u");
      cadena = cadena.replace(/ñ/gi, "n");
      return cadena;
    }
    $("#btnQR").click(function() {
      var ap_paterno = $("#ap_paterno").val();
      var nombre = getCleanedString($("#nombre").val());
      var telefono = $("#celular").val();
      var email = $("#email").val();
      var myString = ['BEGIN:VCARD',
        'N:' + ap_paterno + ';' + nombre,
        'TEL;Celular;VOICE:' + telefono,
        'EMAIL:' + email,
        'END:VCARD'
      ].join('\n');
      jQuery('#qrcodeCanvas').qrcode({
        width: 180,
        height: 180,
        render: "canvas",
        text: myString
      });
    });

    $("#btn-guardar").click(function() {
      var url = "actualizar_datos.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: $('#form-datos').serialize(),
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Datos actualizados correctamente");
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      })
      return false;
    });
  </script>

</html>