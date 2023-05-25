<?php
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion_oracle.php';
?>
<!DOCTYPE html>
  <html>
    <head>
      <?php include '../head.php'; ?>
      <link href="../plugins/bootstrap-fileinput-master/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
      <link rel="stylesheet" href="../plugins/VenoBox-master/venobox/venobox.css" type="text/css" media="screen" />
    </head>
    <body class="hold-transition skin-red sidebar-mini">
      <div class="wrapper">
        <header class="main-header">
          <?php include '../header1.php'; ?>
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
                <h3 class="box-title">Mensajería</h3>
              </div>
              <div class="box-body">
                <form method="POST" id="form_datos">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form_group">
                        <label for="mensaje">*Nuevo Mensaje: </label>
                        <input type="hidden" id="id_registro" class= "form-control" name="id_registro">
                        <textarea id="nuevo_mensaje" class="form-control" name="nuevo_mensaje" placeholder="Escriba su mensaje"></textarea>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="destinos">*Enviar a:</label>
                        <select id="destinos" name="destinos[]" multiple class="select" style="width:100%"></select>
                      </div>
                    </div>
                    <div class="col-md-4 ">
                      <div class="form_group">
                        <label for="area">*Área: </label>
                        <input type="text" id="area" class= "form-control" name="area" placeholder="Ejemplo: Abarrotes-Pasillo de Aceites">
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="box-footer text-right">
                    <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Mensajes Pendientes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_mensajes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="">#</th>
                        <th width="">Sucursal</th>
                        <th>Usuario</th>
                        <th width="">Destinatario</th>
                        <th width="">Área</th>
                        <th width="">Mensaje</th>
                        <th width="">Audio</th>
                        <th width="">Imágenes</th>
                        <th width="">Responder</th>
                      </tr>
                    </thead>
                    <tfoot>
	                  <tr>
                    <th width="">#</th>
                        <th width="">Sucursal</th>
                        <th>Usuario</th>
                        <th width="">Destinatario</th>
                        <th width="">Área</th>
                        <th width="">Mensaje</th>
                        <th width="">Audio</th>
                        <th width="">Imágenes</th>
                        <th width="">Responder</th>
	                  </tr>
                  	</tfoot>  
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
            
          </div>
            
        </div>
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
      <script src="../plugins/bootstrap-fileinput-master/js/plugins/piexif.js" type="text/javascript"></script>
      <script src="../plugins/bootstrap-fileinput-master/js/plugins/sortable.js" type="text/javascript"></script>
      <script src="../plugins/bootstrap-fileinput-master/js/fileinput.js" type="text/javascript"></script>
      <script src="../plugins/bootstrap-fileinput-master/js/locales/fr.js" type="text/javascript"></script>
      <script src="../plugins/bootstrap-fileinput-master/js/locales/es.js" type="text/javascript"></script>
      <script src="../plugins/bootstrap-fileinput-master/themes/fa/theme.js" type="text/javascript"></script>
      <script src="../plugins/bootstrap-fileinput-master/themes/explorer-fa/theme.js" type="text/javascript"></script>
      <script src='../plugins/VenoBox-master/venobox/venobox.min.js'></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

      <!-- Page script -->
      <script>
        function estilo_tablas () {
   	$('#lista_mensajes').dataTable().fnDestroy();
    $('#lista_mensajes').DataTable( {'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
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
              title: 'Lista Invitados',
              exportOptions: {
                columns: ':visible'
              }
            },
            {
              extend: 'pdf',
              text: 'Exportar a PDF',
              className: 'btn btn-default',
              title: 'Lista Invitados',
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
            "url": "tabla_mensajes.php",
            "dataSrc": "",
            "data":""
        },
        "columns": [
            { "data": "id"},
            { "data": "sucursal"},
            { "data": "usuario"},
            { "data": "destinatario"},
            { "data": "area"},
            { "data": "mensaje"},
            { "data": "audio"},
            { "data": "fotos"},
            { "data": "responder"}
        ]
    });
  }  
  estilo_tablas();
  //Inicia función que hace funcionar todos los select del módulo
        $(function () {
          $('.select').select2({
            placeholder: 'Seleccione una opcion',
            lenguage: 'es'
          })
        });
  //termina función que hace funcionar todos los select del módulo
  //var recorder = document.getElementById('recorder');

  // recorder.addEventListener('change', function(e) {
  // var file = e.target.files[0];
  // // Do something with the audio file.
  // player.src =  URL.createObjectURL(file);
  // });
  //inicia la fincion que llena el combo de los destinos del mensaje, en este caso compras/erick/gil
        function llenar_combo_destinos() {
          $.ajax({
            type: "POST",
            url: "combo_destinos.php",
            success: function(response)
            { 
              $('#destinos').html(response).fadeIn();
            }
          });
        }
  //termina la funcion que llena el combo de los destinos del mensaje, en este caso compras/erick/gil
        llenar_combo_destinos();
  //inicia funcion para llenar combo de destinatarios
        function llenar_combo_compras() {
          $.ajax({
            type: "POST",
            url: "combo_compras.php",
            success: function(response)
            { 
              $('#compras').html(response).fadeIn();
            }
          });
        }
  //termina funcion para llenar combo de destinatarios
        $.validator.setDefaults( {
          submitHandler: function () {
            var parametros = new FormData($("#form_datos")[0]);
            $.ajax({
              data: parametros, //datos que se envian a traves de ajax
              url: 'insertar_mensaje.php', //archivo que recibe la peticion
              type: 'POST', //método de envio
              dateType: 'html',
              contentType: false,
              processData: false,
              success: function(respuesta)
              {
                if (respuesta=="ok") {
                  alertify.success("Registro guardado correctamente");
                  estilo_tablas();
                  $('#nuevo_mensaje').val("");
                  $('#archivos').val("");
                $('#area').val("");
                  $('#destinos').val("").trigger('change.select2');
                }else if(respuesta=="Duplicado"){
                  alertify.error("El registro ya existe");
                }else {
                  alertify.error("Ha ocurrido un error");
                }
              }
            });
            // Evitar ejecutar el submit del formulario.
            return false;
          }
        });
        
        $(":file").filestyle('buttonText', 'Seleccionar');
        $(":file").filestyle('size', 'sm');
        $(":file").filestyle('input', true);
        $(":file").filestyle('disabled', false);
        
        $( document ).ready( function () {
          $( "#form_datos" ).validate( {
            rules: {
              id_persona:   "required",
              departamento: "required",
              incidencia:   "required",
	            comentario:   "required",
              sucursal:     "required",
              categoria:    "required",
            },
            messages: {
              id_persona:   "Campo requerido",
              departamento: "Campo requerido",
              incidencia:   "Campo requerido",
	            comentario:   "Campo Requerido",
              sucursal:     "Campo Requerido",
              categoria:    "Campo Requerido",
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
              // Add the `help-block` class to the error element
              error.addClass( "help-block" );
                if ( element.prop( "type" ) === "checkbox" ) {
                  error.insertAfter( element.parent( "label" ) );
                } else {
                  error.insertAfter( element );
                }
              },
              highlight: function ( element, errorClass, validClass ) {
                $( element ).parents( ".col-md-3" ).addClass( "has-error" ).removeClass( "has-success" );
                $( element ).parents( ".col-md-4" ).addClass( "has-error" ).removeClass( "has-success" );
                $( element ).parents( ".col-md-6" ).addClass( "has-error" ).removeClass( "has-success" );
              },
              unhighlight: function (element, errorClass, validClass) {
                $( element ).parents( ".col-md-3" ).addClass( "has-success" ).removeClass( "has-error" );
                $( element ).parents( ".col-md-4" ).addClass( "has-success" ).removeClass( "has-error" );
                $( element ).parents( ".col-md-6" ).addClass( "has-success" ).removeClass( "has-error" );
              }
            });
          });
          function autorizar(id, folio, numero){
            var tiempo_aut  = $('#'+id).val();
            var tiempo_disp = $('#tiempo'+numero).val();
            var url="autorizar.php";
            if(tiempo_aut > tiempo_disp){
              alertify.error("Verifica horas a Autorizar"); 
            }
            else{
              $.ajax({
                type:"POST",
                url: url,
                data:{id:id, tiempo_aut:tiempo_aut},
                success: function(respuesta){
                  if (respuesta=="ok") {
                    alertify.success("Tiempo Extra Autorizado");
                  }else{
                    alertify.error("Ha Ocurrido un Error");
                  }
                  }
              })
            }
            // alert(tiempo_aut);
            // alert(tiempo_disp);
          }
        </script>
        <script>
    </script>
  </body>
</html>