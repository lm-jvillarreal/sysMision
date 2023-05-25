<?php
  include '../global_seguridad/verificar_sesion.php';
  //$sucursal = $_GET['sucursal'];
  $cant_cajas ="SELECT COUNT(id) FROM cajas where id_sucursal ='$id_sede' and activo =1" ;
  $consulta_cajas = mysqli_query($conexion, $cant_cajas);
  $row = mysqli_fetch_array($consulta_cajas);

  $consulta_caja = "SELECT id FROM detalle_caja WHERE activo = '1'";
  $cadena_caja = mysqli_query($conexion, $consulta_caja);
  $row_caja= mysqli_fetch_array($cadena_caja);

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
            <div class="box box-danger" <?php echo $solo_lectura?>>
              <div class="box-header">
                <h3 class="box-title">Reporte Caja | Registro</h3>
              </div>
              <!-- tabla de quipos por caja -->
              <div class="box-body">
                <form method="POST" id="form_datos">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <input type="hidden" name="id_registro" id="id_registro" class="">
                        <input type="hidden" name="ide_caja" id="ide_caja" >
                        <input type="hidden" name="reporte" id="reporte" >
                      </div>
                    </div>
                  </div>
                </form>
                <div class="row">
                  <div id="contenedor" style="">
                    <div class="col-md-7" id="elementos">
                    </div>
                    <div class="col-md-4" id="equiposs" class="display:none;">
                    </div>
                  </div>
                </div>
                <div id="tabla" style="display:none" >
                  <form action="" id="form_equipos">
                    <div class="box box-danger">
                      <div class="box-header">
                        <h3 class="box-title">Lista de Equipos por Caja</h3>
                      </div>
                      <div class="box-body">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="table-responsive">
                              <table id="lista_partes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                  <tr>
                                    <th> Equipo</th>
                                    <th>Funciona</th>
                                    <th>Falla
                                    </th>
                                  </tr>
                                </thead>
                                <tfoot>
                                  <tr>
                                    <th>Equipo</th>
                                    <th>Funciona</th>
                                    <th>Falla</th>
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                  <!-- tabla de equipos por caja -->
              </div>
            </div>
          </section>
        
            <!-- /.row -->
              
          <!-- /.content -->
          <!-- </div> -->
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

      <?php include '../footer.php';?>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
        <!-- Page script -->
      <script>
        var ideCaja, ideEquipo, ideFalla;
        cajas();
        function cajas(){ 
          var cantidad = <?php echo $row[0]?>;  
          var url='tabla_reportesf2.php';
          $.ajax({
            data:{
            }, 
            url: url,
            type: "POST",
            dateType: "html",
            success:function(respuesta){
              var array = eval(respuesta);
              var array1 = eval(respuesta);
              for (var i = 0; i<cantidad; i++){ 
                if(i<cantidad){
                  var pruebaa = array1[i];
                  id_cajaa=array[i];
                }
                  var color ="background-color:rgb(144, 210, 93)";
                // var color ="background-color:rgb(144, 210, 93";
                var id_caja2 = id_cajaa.shift();
                var prueba2 = pruebaa.shift();
                var id_equipo = prueba2;
                nombre_caja = id_cajaa; 
                var button = document.createElement("button");
                var icono = document.createElement("I");
                icono.classList.add('fa','fa-tv');
                button.setAttribute("id",id_caja2);
                button.setAttribute("onclick","imprimir("+id_caja2+")");
                button.innerHTML = nombre_caja;
                button.appendChild(icono);
                button.classList.add('btn','btn-app');
                button.name = 'b'+nombre_caja;
                button.setAttribute("style","background-color:rgb(144, 210, 93)");
                button.value = nombre_caja;
                button.setAttribute("type","button");
                document.getElementById("elementos").appendChild(button);
              }
            }
          });
        }
    
        function imprimir(id_caja2){
        
          $('#ide_caja').val(id_caja2);
          var res = $('#ide_caja').val();
          $("#tabla").show();
          cargar_tabla_equipo();
        }
        function cargar_tabla_equipo(){ 
          var ide= $('#ide_caja').val();
          //    salert(ide);
          $('#lista_partes').dataTable().fnDestroy();
          $('#lista_partes').DataTable( {
            'language': {"url": "../plugins/DataTables/Spanish.json"},
            "paging":   false,
            "dom": 'Bfrtip',
            "order": ["0", "ASC"],
            buttons: [{
            extend: 'pageLength',
            text: 'Registros',
            className: 'btn btn-default'
            },
            {
              extend: 'excel',
              text: 'Exportar a Excel',
              className: 'btn btn-default',
              title: 'Control Equipos',
              exportOptions: {
                columns: ':visible'
              }
            },
            {
              extend: 'pdf',
              text: 'Exportar a PDF',
              className: 'btn btn-default',
              title: 'Control Equipos',
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
                "url": "tabla_elementos2.php?ide="+ide+"",
                "dataSrc": "",
              "data" :{ide:ide}
            },
            "columns": [
              { "data": "equipo" },
              { "data": "funciona" },
              { "data": "combo" }
            ]
          });
        }
        function funcional(caja, equipo ){
          ideCaja= $('#ide_caja').val();
          //ideCaja=caja;
          ideEquipo = equipo;
          var id_registro = caja; 
          $('#falla'+caja).select2(
          {
            placeholder: 'Seleccione una opcion',
            lenguage: 'es',
            //minimumResultsForSearch: Infinity
            ajax: { 
              data: {
                'equipo': equipo
              },
              url: "select_equipos.php?equipo="+equipo+"",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  searchTerm: params.term // search term
                };
              },
              processResults: function (response) {
                return {
                  results: response
                };
              },
              cache: true
            }
          })
        }
        function asignaValor(caja, numero){
          ideeCaja = ideCaja;
          ideeEquipo = ideEquipo;
          ideFalla=$('#falla'+caja).val();
          var url = 'insertar_reporte.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {
              ideeCaja:ideeCaja, ideeEquipo:ideeEquipo, ideFalla:ideFalla
            },
            success: function(respuesta) {
              if (respuesta == "ok") {
                alertify.success("Reporte Generado Correctamente");
                cargar_tabla_equipo();
                ideeCaja.background
              }
              else{
                alertify.error("Reporte Generado Anteriormente")
              }
            },
            error: function(xhr, status) {
              alert("error");
            },
          });
        }
        $.validator.setDefaults( {
          submitHandler: function () {
            $.ajax({
              type: "POST",
              url: 'guardar_reporte.php',
              data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
              success: function(respuesta)
              {
                if (respuesta=="ok") {
                  alertify.success("Registro guardado correctamente");
                  $('#form_datos')[0].reset();
                  cargar_tabla();
                  $("#id_equipo").select2("trigger", "select", {
                    data: { id: '', text:'' }
                  });
                  $("#id_caja").select2("trigger", "select", {
                    data: { id: '', text:'' }
                  });
                  $("#id_falla").select2("trigger", "select", {
                    data: { id: '', text:'' }
                  });
                  $('#descripcion').val("");
                  if($(".tipo").hasClass('btn-danger')){
                    $('#divinput').show();
                    $('#divselect').hide();
                    $('.tipo').removeClass('btn-danger');
                    $('.tipo').addClass('btn-warning');
                    $('.tipo').html('Otro:');
                    $('#tipo').val('2');
                    $("#id_falla").select2("trigger", "select", {
                      data: { id: '', text:'' }
                    });
                    $('#descripcion').val("");
                    llenar_notificaciones();
                  }
                }else if(respuesta=="duplicado"){
                  alertify.error("El registro ya existe");
                }else if(respuesta=="vacio"){
                  alertify.error("Verifica Campos");
                }else {
                  alertify.error("Ha ocurrido un error");
                }
              }
            });
            // Evitar ejecutar el submit del formulario.
            return false;
          }
        });
        $( document ).ready( function () {
          $( "#form_datos" ).validate( {
            rules: {
                id_caja: "required",
                id_equipo: "required"
            },
            messages: {
                id_caja: "Campo requerido",
                id_equipo: "Campo requerido"
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
        function eliminar(id){
          swal({
            title: "¿Está Seguro de Eliminar Reporte?",
            icon: "warning",
            buttons: ["No", "Si"],
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              $.ajax({
                url: 'eliminar_reporte.php',
                data: {'id':id} ,
                type: "POST",
                success: function(respuesta) {
                  if(respuesta == "ok"){
                    alertify.success('Registro Eliminado');
                    cargar_tabla();
                  }
                  else{
                    alertify.error('Ha Ocurrido un Error');
                  }
                }
              });
            }
          });
        }
        function editar(id){
          $.ajax({
            url: 'editar.php',
            data: {'id':id},
            type: "POST",
            success: function(respuesta) {
              var array = eval(respuesta);
              $('#id_registro').val(id);
              $("#id_caja").select2("trigger", "select", {
                data: { id: array[0], text:array[1] }
              });
              $("#id_equipo").select2("trigger", "select", {
                data: { id: array[2], text:array[3] }
              });
              if(array[6] == 1){
                $('#divinput').hide();
                $('#divselect').show();
                $('.tipo').removeClass('btn-warning');
                $('.tipo').addClass('btn-danger');
                $('.tipo').html('Lista de Fallas');

                $("#id_falla").select2("trigger", "select", {
                  data: { id: array[4], text:array[5] }
                });
              }else{
                $('#divinput').show();
                $('#divselect').hide();
                $('.tipo').removeClass('btn-danger');
                $('.tipo').addClass('btn-warning');
                $('.tipo').html('Otro:');
                $("#id_falla").select2("trigger", "select", {
                  data: { id: '', text:'' }
                });
                $('#descripcion').val(array[4]);
              }
              $('#tipo').val(array[6]);
            }
          });
        }
        $('.tipo').click(function(){
          if($(this).hasClass('btn-danger')){
            $('#divinput').show();
            $('#divselect').hide();
            $(this).removeClass('btn-danger');
            $(this).addClass('btn-warning');
            $(this).html('Otro:');
            $('#tipo').val('2');
            $("#id_falla").select2("trigger", "select", {
              data: { id: '', text:'' }
            });
            $('#descripcion').val("");
          }else{
            $('#divinput').hide();
            $('#divselect').show();
            $(this).removeClass('btn-warning');
            $(this).addClass('btn-danger');
            $(this).html('Lista de Fallas');
            $('#tipo').val('1');
          }
        });
</script>
</body>
</html>