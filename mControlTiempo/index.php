<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha      = date('Y-m-d');
$nuevafecha = strtotime('+1 day', strtotime($fecha));
$nuevafecha = date('Y-m-d', $nuevafecha);
$hora       = date('h:i:s');
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
        <div class="box box-danger" <?php echo $solo_lectura ?>>
          <div class="box-header">
            <h3 class="box-title">Captura de Tiempos</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="nombre_usuario">*Usuario:</label>
                    <select name="nombre_usuario" id="nombre_usuario" class="select2" style="width: 100%">
                      <option></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Fecha/Hora Inicio</label>
                    <div class='input-group date' id='datetimepicker_inicio'>
                      <input type='text' class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo $fecha ?>" />
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Fecha/Hora Fin</label>
                    <div class='input-group date' id='datetimepicker_fin'>
                      <input type='text' class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo $fecha ?>" />
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tipo_registro">*Tipo Registro:</label><br>
                    <select name="tipo_registro" id="tipo_registro" class="combo" style="width: 100px">
                      <option value="1">Extra</option>
                      <option value="2">Permiso</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tipo_registro">*Comentarios:</label>
                    <textarea id="comentario" class="form-control" name="comentario"></textarea>
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
              </div>
            </form>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Registros Existentes</h3>
          </div>
          <div class="box-body">
            <div id="datos2"></div>
          </div>
        </div>
        <div id="datos_usuarios">
          <div class="box box-danger">
            <div class="box-header">
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-4"></div>
                  <div class="col-md-4">
                    <br>
                    <h3>
                      <div id="nombre">
                    </h3></b>
                  </div>
                  <div class="col-md-4">
                    <br><br>
                    <div id='boton_p'></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12" id="tabla">
                  <div class="table-responsive">
                    <table id="lista_datos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Fecha</th>
                          <th>Hora I.</th>
                          <th>Hora F.</th>
                          <th>Tipo</th>
                          <th>Diferencia</th>
                          <th>Comentario</th>
                          <th>Eliminar</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include 'modal_pagar.php'; ?>
    <?php include '../footer2.php'; ?>

    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <?php include '../footer.php'; ?>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <!-- Page script -->
  <script>
    $(function() {
      $('.combo').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es'
      })
    })
  </script>
  <script>
    function pagar2(id, numero) {
      var comentario = $('#comentario2_' + numero).val();
      var id_persona = $('#id_persona_' + numero).val();
      if (comentario == "") {
        $('#comentario2_' + numero).focus()
        alertify.error("Verifica campos");
        return false;
      }
      $.ajax({
        data: {
          'id': id,
          'comentario': comentario
        }, //datos que se envian a traves de ajax
        url: 'pagar.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) {
          if (response == "ok") {
            alertify.success("Pagado Correctamente");
            cargar_tabla_datos(id_persona);
            datos_horas();
          } else {
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
    }
    $('#datos_usuarios').hide();

    function pagar(id) {
      var comentario = $('#' + id).val();
      if (comentario == "") {
        alertify.error("Añadir Comentario");
      } else {
        $.ajax({
          data: {
            'id': id,
            'comentario': comentario
          }, //datos que se envian a traves de ajax
          url: 'pagar.php', //archivo que recibe la peticion
          type: 'POST', //método de envio
          dateType: 'html',
          success: function(response) {
            location.reload();
            cargar_tabla();
            $('#datos_usuarios').hide();
          }
        });
      }
    }

    function eliminar(id, id_persona) {
      swal({
          title: "¿Está seguro de eliminar registro?",
          icon: "warning",
          buttons: ["No", "Si"],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              data: {
                'id': id
              }, //datos que se envian a traves de ajax
              url: 'eliminar_registro.php', //archivo que recibe la peticion
              type: 'POST', //método de envio
              dateType: 'html',
              success: function(response) {
                alertify.success("Registro Eliminado Correctamente");
                $('#datos2').empty();
                datos_horas();
                cargar_tabla_datos(id_persona);
              }
            });
          }
        });
    }
  </script>
  <script>
    function cargar_tabla_datos(dato) {
      $('#lista_datos').dataTable().fnDestroy();
      $('#lista_datos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        buttons: [{
            extend: 'pageLength',
            text: 'Registros',
            className: 'btn btn-default'
          },
          {
            extend: 'excel',
            text: 'Exportar a Excel',
            className: 'btn btn-default',
            title: 'Control Tiempo',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Control Tiempo',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'copy',
            text: 'Copiar registros',
            className: 'btn btn-default',
            copyTitle: 'Ajouté au presse-papiers',
            copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
            copySuccess: {
              _: '%d lignes copiées',
              1: '1 ligne copiée'
            }
          }
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_datos.php",
          "dataSrc": "",
          "data": {
            'dato': dato
          }
        },
        "columns": [{
            "data": "#",
            "width": "5%"
          },
          {
            "data": "Fecha",
            "width": "10%"
          },
          {
            "data": "HoraI",
            "width": "10%"
          },
          {
            "data": "HoraF",
            "width": "10%"
          },
          {
            "data": "Tipo",
            "width": "10%"
          },
          {
            "data": "Diferencia",
            "width": "10%"
          },
          {
            "data": "Comentario"
          },
          {
            "data": "Eliminar",
            "width": "20%"
          },
        ]
      });
    }

    function llenar_combo_usuarios() {
      $.ajax({
        type: "POST",
        url: "combo_usuarios.php",
        success: function(response) {
          $('#nombre_usuario').html(response).fadeIn();
          $('#nombre_usuario_e').html(response).fadeIn();
        }
      });
    }
    $(function() {
      $('#nombre_usuario').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: {
          url: "combo_usuarios.php",
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
    })
    $(function() {
      $('#nombre_usuario_e').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: {
          url: "combo_usuarios.php",
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
    })

    function abrir(dato) {
      $.ajax({
        data: {
          'dato': dato
        }, //datos que se envian a traves de ajax
        url: 'datos.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) {
          var array = eval(response);

          $('#datos_usuarios').show();
          $('#nombre').html(array[0]);
          $('#boton_p').html(array[1]);
        }
      });
      cargar_tabla_datos(dato);
    }
    llenar_combo_usuarios();

    function activar_fecha(numero) {
      if ($('#input_fecha' + numero).hasClass('hidden')) {
        $('#input_fecha' + numero).removeClass('hidden');
      } else {
        $('#input_fecha' + numero).addClass('hidden');
      }
    }

    function actualizar_fecha(fecha, id) {
      $.ajax({
        url: 'actualizar_fecha.php',
        data: '&id=' + id + '&fecha=' + fecha,
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);
          mensaje = array[0];
          id_persona = array[1];

          if (mensaje == "ok") {
            alertify.success('Fecha Actualizada');
            cargar_tabla_datos(id_persona);
          } else if (mensaje == "igual") {} else {
            alert(mensaje);
            alertify.error('Ha Ocurrido un Error');
          }
        }
      });
    }

    function activar_horaini(numero) {
      if ($('#input_horaini' + numero).hasClass('hidden')) {
        $('#input_horaini' + numero).removeClass('hidden');
      } else {
        $('#input_horaini' + numero).addClass('hidden');
      }
    }

    function actualizar_horaini(horaini, id) {
      $.ajax({
        url: 'actualizar_horaini.php',
        data: '&id=' + id + '&horaini=' + horaini,
        type: "POST",
        success: function(respuesta) {
          alert(respuesta);
          var array = eval(respuesta);
          mensaje = array[0];
          id_persona = array[1];

          if (mensaje == "ok") {
            alertify.success('Hora Actualizada');
            cargar_tabla_datos(id_persona);
          } else if (mensaje == "igual") {} else if (mensaje = "verifica") {
            alertify.error('Verifica Hora');
          } else {
            alert(mensaje);
            alertify.error('Ha Ocurrido un Error');
          }
        }
      });
    }

    function activar_horafin(numero) {
      if ($('#input_horafin' + numero).hasClass('hidden')) {
        $('#input_horafin' + numero).removeClass('hidden');
      } else {
        $('#input_horafin' + numero).addClass('hidden');
      }
    }

    function actualizar_horafin(horafin, id, numero) {
      $.ajax({
        url: 'actualizar_horafin.php',
        data: '&id=' + id + '&horafin=' + horafin,
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);
          mensaje = array[0];
          id_persona = array[1];

          if (mensaje == "ok") {
            alertify.success('Hora Actualizada');
            cargar_tabla_datos(id_persona);
          } else if (mensaje == "igual") {
            activar_horafin(numero);
          } else if (mensaje = "verifica") {
            alertify.error('Verifica Hora');
          } else {
            alert(mensaje);
            alertify.error('Ha Ocurrido un Error');
          }
        }
      });
    }

    function activar_tipo(numero) {
      if ($('#input_tipo' + numero).hasClass('hidden')) {
        $('#input_tipo' + numero).removeClass('hidden');
      } else {
        $('#input_tipo' + numero).addClass('hidden');
      }
    }

    function actualizar_tipo(tipo, id, numero) {
      $.ajax({
        url: 'actualizar_tipo.php',
        data: '&id=' + id + '&tipo=' + tipo,
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);
          mensaje = array[0];
          id_persona = array[1];

          if (mensaje == "ok") {
            alertify.success('Registro Actualizado');
            cargar_tabla_datos(id_persona);
          } else if (mensaje == "igual") {
            activar_tipo(numero);
          } else {
            alert(mensaje);
            alertify.error('Ha Ocurrido un Error');
          }
        }
      });
    }

    function activar_comentario(numero) {
      if ($('#input_comentario' + numero).hasClass('hidden')) {
        $('#input_comentario' + numero).removeClass('hidden');
      } else {
        $('#input_comentario' + numero).addClass('hidden');
      }
    }

    function actualizar_comentario(comentario, id, numero) {
      $.ajax({
        url: 'actualizar_comentario.php',
        data: '&id=' + id + '&comentario=' + comentario,
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);
          mensaje = array[0];
          id_persona = array[1];

          if (mensaje == "ok") {
            alertify.success('Registro Actualizado');
            cargar_tabla_datos(id_persona);
          } else if (mensaje == "igual") {
            activar_comentario(numero);
          } else {
            alert(mensaje);
            alertify.error('Ha Ocurrido un Error');
          }
        }
      });
    }

    function datos_horas() {
      $.ajax({
        url: 'datos2.php',
        success: function(respuesta) {
          $('#datos2').html(respuesta);
        }
      });
    }
    datos_horas();
  </script>
  <script type="text/javascript">
    $(function() {
      $('#datetimepicker_inicio').datetimepicker();
      $('#datetimepicker_fin').datetimepicker();
    });
  </script>
  <script>
    function cargar_tabla() {
      $('#lista_tiempo').dataTable().fnDestroy();
      $('#lista_tiempo').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        "buttons": [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_tiempo.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "#"
          },
          {
            "data": "Usuario"
          },
          {
            "data": "Diferencia"
          },
        ]
      });
    }
    $(function() {
      cargar_tabla();
    })
    $.validator.setDefaults({
      submitHandler: function() {
        var url = "insertar_tiempo.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "ok") {
              datos_horas();
              $('#datos_usuarios').hide();
              limpiar();
            } else if (respuesta == "duplicado") {
              alertify.error("El registro ya existe");
            } else {
              alertify.error("Ha ocurrido un error");
            }
          }
        });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
    $(document).ready(function() {
      $("#form_datos").validate({
        rules: {
          nombre_usuario: "required",
          hora_inicio: "required",
          hora_final: "required",
          tipo_registro: "required",
          comentario: "required"
        },
        messages: {
          nombre_usuario: "Campo requerido",
          hora_inicio: "Campo requerido",
          hora_final: "Campo requerido",
          tipo_registro: "Campo requerido",
          comentario: "Campo requerido"
        },
        errorElement: "em",
        errorPlacement: function(error, element) {
          // Add the `help-block` class to the error element
          error.addClass("help-block");

          if (element.prop("type") === "checkbox") {
            error.insertAfter(element.parent("label"));
          } else {
            error.insertAfter(element);
          }
        },
        highlight: function(element, errorClass, validClass) {
          $(element).parents(".col-md-3").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-4").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-6").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).parents(".col-md-3").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-4").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-6").addClass("has-success").removeClass("has-error");
        }
      });
    });
  </script>
  <script>
    function guardar() {
      var url = "insertar_tiempo2.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: $("#form_datos_especial").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "ok") {
            datos_horas();
            limpiar();
            $('#datos_usuarios').hide();
          } else if (respuesta == "duplicado") {
            alertify.error("El registro ya existe");
          } else {
            alertify.error("Ha ocurrido un error");
          }
        }
      });
    }

    function limpiar() {
      let date = new Date();
      var fecha;

      let day = date.getDate();
      let month = date.getMonth() + 1;
      let year = date.getFullYear();

      if (month < 10) {
        fecha = `${year}-0${month}-${day}`;
      } else {
        c = `${year}-${month}-${day}`;
      }

      $("#nombre_usuario").select2("trigger", "select", {
        data: {
          id: '',
          text: ''
        }
      });

      $("#nombre_usuario_e").select2("trigger", "select", {
        data: {
          id: '',
          text: ''
        }
      });

      $('#fecha_inicio').val(fecha);
      $('#fecha_fin').val(fecha);
      $('#comentario').val("");
    }
    $('#modal-default').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data().id;
      var url = "consulta_datos_modal.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id: id
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);

          $('#nom_persona').html(array[0]);
          $('#horas_disponibles').val(array[1]);
          $('#horas_disp').val(array[2]);
          $('#id_pers').val(array[3]);
        }
      });
    });

    function verificar_horas(horas_pagar) {
      if (horas_pagar != "") {
        var horas_disponibles = $('#horas_disp').val();
        if (horas_pagar > horas_disponibles) {
          $('#btn-pagar').attr('disabled', 'true');
          alertify.error("Verifica horas a pagar");
        } else {
          $('#btn-pagar').removeAttr('disabled');
        }
      }
    }
    $("#btn-pagar").click(function() {
      var id_pers = $('#id_pers').val();
      var url = "pagar_nuevo.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: $('#form_datos_pagar').serialize(),
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Tiempo Pagado Correctamente");
            datos_horas();
            $('#modal-default').modal('hide');
            $('#h_pagar').val('');
            $('#comentario_modal').val('');
            cargar_tabla_datos(id_pers);
          } else if (respuesta == "1") {
            alertify.error("Verifica Campos");
          } else {
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
    });
    $('#h_pagar').inputmask('99:99');

    function cancelar_pago(id, numero) {
      var id_persona = $('#id_persona_' + numero).val();
      $.ajax({
        url: 'cancelar_pago.php',
        type: "POST",
        dateType: "html",
        data: {
          'id': id
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Pago Cancelado");
            cargar_tabla_datos(id_persona);
            datos_horas();
          } else {
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
    }
  </script>
</body>

</html>