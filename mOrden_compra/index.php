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
            <h3 class="box-title">Órdenes de Compra | ENTCOC</h3>
          </div>
          <form method="POST" id="form-datos">
            <div class="box-body">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="nombre_modulo">*No. Orden</label>
                    <input type="text" name="no_orden" id="no_orden" class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="proveedor">*Proveedor</label>
                    <input type="text" name="proveedor" id="proveedor" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="sucursal">*Sucursal</label>
                    <input type="text" name="sucursal" id="sucursal" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha_fin">*Fecha Llegada</label>
                    <div class="input-group date form_date" data-date="" data-date-format="dd/mm/yy" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="" readonly id="fecha_llegada" name="fecha_llegada">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="comentarios">*Comentarios</label>
                    <input type="text" name="comentarios" id="comentarios" class="form-control">
                    <input type="hidden" id="cve_prov" name="cve_prov">
                    <input type="hidden" id="id_sucursal" name="id_sucursal">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="estatus">*Estatus</label>
                    <input type="text" name="estatus" id="estatus" class="form-control" readonly="true">
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="box-footer text-right">
            <button type="submit" class="btn btn-warning" id="btn-guardar">Guardar</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Órdenes de Compra | ENTSOC</h3>
          </div>
          <form method="POST" id="form-datos2">
            <div class="box-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="nombre_modulo">*Proveedor</label>
                    <select name="cve_proveedor" id="cve_proveedor" class="form-control select2" lang="es">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="id_sucursal">*Sucursal</label>
                    <select name="suc[]" id="id_suc" class="form-control select2" multiple="multiple">
                      <option value=""></option>
                      <option value="1">Díaz Ordaz</option>
                      <option value="2">Arboledas</option>
                      <option value="3">Villegas</option>
                      <option value="4">Allende</option>
                      <option value="5">La Petaca</option>
                      <option value="99">CEDIS</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha_fin">*Fecha Llegada</label>
                    <div class="input-group date form_date" data-date="" data-date-format="dd/mm/yy" data-link-field="fecha_llegada_s" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="" readonly id="fecha_llegada_s" name="fecha_llegada_s">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="comentarios">*Comentarios</label>
                    <input type="text" name="coment" id="coment" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="documento">*Documento</label>
                    <input name="action" type="hidden" value="upload" id="action" />
                    <input type="file" name="archivos" id="archivos">
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="box-footer text-right">
            <button type="submit" class="btn btn-warning" id="btn-guardar2">Guardar</button>
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
  <!-- Page script -->
  <script>
    $(function() {
      $('#no_orden').focus(); //Se enfoca la caja de texto al cargar la página
      $("#no_orden").keypress(function(e) { //Función que se desencadena al presionar enter
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
          var url = "consulta_datos.php"; // El script a dónde se realizará la petición.
          var no_orden = $("#no_orden").val();
          $.ajax({
            type: "POST",
            url: url,
            data: {
              folio: no_orden
            }, // Adjuntar los campos del formulario enviado.
            success: function(respuesta) {
              var array = eval(respuesta);
              $('#sucursal').val(array[0]);
              $('#proveedor').val(array[1]);
              $('#cve_prov').val(array[3]);
              $('#id_sucursal').val(array[4]);
              $('#fecha_llegada').val(array[5]);
              $('#estatus').val(array[6]);
            }
          });
          return false;
        }
      });
    });
    $("#btn-guardar").click(function() {
      var fecha_llegada = $("#fecha_llegada").val();
      if (fecha_llegada == "") {
        swal("Datos Faltantes", "Favor de rellenar todos los campos", "error");
        $("#fecha_llegada").focus();
      } else {
        var url = "insertar_orden.php";
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: $('#form-datos').serialize(),
          success: function(respuesta) {
            if (respuesta == "okok") {
              swal("Registro exitoso", "La OC ha sido registrada correctamente.", "success");
              $(":text").val('');
              $("#id_suc option:selected").removeAttr("selected");
            } else if (respuesta == "BOok") {
              swal("Registro exitoso", "La OC ha sido registrada correctamente como BO", "success");
              $(":text").val('');
              $("#id_suc option:selected").removeAttr("selected");
            } else if (respuesta == "no_existe") {
              swal("El proveedor no está registrado en el sistema", {
                icon: "error",
              });
            } else if (respuesta == "existe") {
              swal("La OC ya existe en el sistema", {
                icon: "error",
              });
              $(":text").val('');
              $("#no_orden").focus();
            } else if (respuesta == "completo") {
              swal("La OC fue recibida SURTIDO COMPLETO", {
                icon: "error",
              });
              $(":text").val('');
              $("#no_orden").focus();
            } else if (respuesta == "no_correo") {
              swal({
                  title: "Error de envío",
                  text: "El proveedor no cuenta con un correo electrónico configurado, para continuar, debe signar uno.",
                  icon: "warning",
                  buttons: ["Cancelar", "Asignar"],
                  dangerMode: true,
                })
                .then((WillCorreo) => {
                  if (WillCorreo) {
                    //redireccionar a devoluciones
                    swal({
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        title: "Ingresa el correo electrónico",
                        content: {
                          element: "input",
                          type: "text",
                          required: "true",
                        }
                      })
                      .then((value) => {
                        actualizar_correo($("#cve_prov").val(), `${value}`);
                      })
                  } else {
                    swal("No puede continuar sin configurar una cuenta de correo electrónico", {
                      icon: "error",
                    });
                  }
                });
            }
          },
          error: function(xhr, status) {},
        });
        //$(":text").val('');
        return false;
      }
    })
    $("#btn-guardar2").click(function() {
      var parametros = new FormData($("#form-datos2")[0]);
      $.ajax({
        data: parametros, //datos que se envian a traves de ajax
        url: 'insertar_orden_s.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        contentType: false,
        processData: false,
        success: function(response) {
          swal("Registro exitoso", "La OC ha sido registrada correctamente.", "success");
          $(":text").val('');
          $("#id_suc option[value]").remove();
          $("#cve_proveedor option[value]").remove();
        }
      });
    })
    $('#id_suc').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
    $('#cve_proveedor').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "consulta_proveedores.php",
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
    })
    $(":file").filestyle('buttonText', 'Seleccionar');
    $(":file").filestyle('size', 'sm');
    $(":file").filestyle('input', true);
    $(":file").filestyle('disabled', false);
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

    function actualizar_correo(cv_prov, correo_e) {
      var url = "asignar_correo_proveedor.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          cv_prov: cv_prov,
          correo_e: correo_e
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "ok") {
            swal("Asignación exitosa", "El correo electrónico ha sido asignado correctamente", "success");
          }
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    }
  </script>
</body>

</html>