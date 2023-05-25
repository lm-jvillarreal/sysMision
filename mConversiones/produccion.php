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
                <h3 class="box-title">Producción por Turno</h3>
              </div>
              <div class="box-body">
              <form method="POST" id="form-datos">
                <div class="row">
                <div class="col-md-3">
                      <div class="form-group">
                        <label for="">*Subreceta:</label>
                        <input type="hidden" id="id_registro" class= "form-control" name="id_registro">
                        <select name="subreceta" id="subreceta" class="form-control select2" style="width: 230px"  onchange="BultosKilos();">
                          <option value="SR MASA TORTILLA BLANCA">SR MASA TORTILLA BLANCA</option>
                          <option value="SR MASA TORTILLA TAQUERA">SR MASA TORTILLA TAQUERA</option>
                          <option value="SR MASA TORTILLA ROJA">SR MASA TORTILLA ROJA</option>
                          <option value="SR MASA TORTILLA HARINA">SR MASA TORTILLA HARINA</option>
                          <option value="SR MASA TORTILLA HARINA INTEGRAL">SR MASA TORTILLA HARINA INTEGRAL</option>
                        </select>
                      </div>
                    </div>
                </div>
              </form>
                <div id = "Bultos"class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">

                      <table id="lista_produccionBultos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th width="5%">ID</th>
                            <th width="5%">Turno</th>
                            <th width="">Subreceta</th>
                            <th width="">Harina Utilizada (Bultos)</th>
                            <th width="">Total Masa (KG.)</th>
                            <th width="">Merma Masa (KG.)</th>
                            <th width="">Masa Usable (KG.)</th>
                            <th width="">Producción Tortilla (KG.)</th>
                            <th width="">Merma Tortilla (KG.)</th>
                            <th width="">Producción Teórica (KG.)</th>
                            <th width="">Producción Real Diaria (KG.)</th>
                            <th width="">Diferencia de KG.</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                          <th width="5%">ID</th>
                          <th width="5%">Turno</th>
                            <th width="">Subreceta</th>
                            <th width="">Harina Utilizada (Bultos)</th>
                            <th width="">Total Masa (KG.)</th>
                            <th width="">Merma Masa (KG.)</th>
                            <th width="">Masa Usable (KG.)</th>
                            <th width="">Producción Tortilla (KG.)</th>
                            <th width="">Merma Tortilla (KG.)</th>
                            <th width="">Producción Teórica (KG.)</th>
                            <th width="">Producción Real Diaria (KG.)</th>
                            <th width="">Diferencia de KG.</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
                <div id = "Kilos"class="row" hidden>
                  <div class="col-md-12">
                    <div class="table-responsive">

                      <table id="lista_produccionKilos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th width="5%">ID</th>
                            <th width="5%">Turno</th>
                            <th width="">Subreceta</th>
                            <th width="">Harina Utilizada (KG.)</th>
                            <th width="">Total Masa (KG.)</th>
                            <th width="">Merma Masa (KG.)</th>
                            <th width="">Masa Usable (KG.)</th>
                            <th width="">Producción Tortilla (KG.)</th>
                            <th width="">Merma Tortilla (KG.)</th>
                            <th width="">Producción Teórica (KG.)</th>
                            <th width="">Producción Real Diaria (KG.)</th>
                            <th width="">Diferencia de KG.</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                          <th width="5%">ID</th>
                          <th width="5%">Turno</th>
                            <th width="">Subreceta</th>
                            <th width="">Harina Utilizada (KG.)</th>
                            <th width="">Total Masa (KG.)</th>
                            <th width="">Merma Masa (KG.)</th>
                            <th width="">Masa Usable (KG.)</th>
                            <th width="">Producción Tortilla (KG.)</th>
                            <th width="">Merma Tortilla (KG.)</th>
                            <th width="">Producción Teórica (KG.)</th>
                            <th width="">Producción Real Diaria (KG.)</th>
                            <th width="">Diferencia de KG.</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div> 
            </div>
          </section>
        </div>
            <!-- /.row -->
            <!-- /.content -->
            <!-- </div> -->
            <!-- /.content-wrapper -->
        <?php include '../footer2.php'; ?>
        <!-- Control Sidebar -->
        <!-- /.control-sidebar -->
        <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
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
        function BultosKilos(){
          var Medida = $('#subreceta').val();
          //alert(Medida);
          if((Medida == "SR MASA TORTILLA BLANCA")||(Medida == "SR MASA TORTILLA TAQUERA")||(Medida == "SR MASA TORTILLA ROJA")){
            $('#Bultos').show();
            $('#Kilos').hide();
            cargar_tablaBultos();
          }else{
            $('#Bultos').hide();
            $('#Kilos').show();
            cargar_tablaKilos();
          }
        }

        cargar_tablaBultos();
        function cargar_tablaBultos(){
          var UnidadM = $('#subreceta').val();
          $('#lista_produccionBultos').dataTable().fnDestroy();
          $('#lista_produccionBultos').DataTable( {
            'language': {"url": "../plugins/DataTables/Spanish.json"},
            "paging":   false,
            "dom": 'Bfrtip',
            buttons: [
              {
                extend: 'pageLength',
                text: 'Registros',
                className: 'btn btn-default'
              },
              {
                extend: 'excel',
                text: 'Exportar a Excel',
                className: 'btn btn-default',
                title: 'Control Equipos',
                exportOptions: 
                  {
                    format:{
                      body:function(inner, rowidx, colidx, node){
                      if ($(node).children("div").children("input").length > 0) {
                        return $(node).children("div").children("input").val()                         
                      }else{
                        return inner 
                      }
                    }
                  }
                    }
              },
              {
                extend: 'pdf',
                text: 'Exportar a PDF',
                className: 'btn btn-default',
                title: 'Control Equipos',
                exportOptions: 
                {
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
                "url": "tabla_produccionB.php?UM="+UnidadM+"",
                "dataSrc": "",
                "data":{UnidadM:UnidadM},
            },
            "columns": [
                { "data": "ID" },
                { "data": "turno" },
                { "data": "subreceta" },
                { "data": "harina" },
                { "data": "total_masa" },
                { "data": "merma_masa" },
                { "data": "masa_usable" },
                { "data": "produccion_tortilla" },
                { "data": "merma_tortilla" },
                { "data": "produccion_teorica" },
                { "data": "produccion_real" },
                { "data": "diferencia" }
            ]
          });
        }
        function cargar_tablaKilos(){
          var UMKilos = $('#subreceta').val();
          $('#lista_produccionKilos').dataTable().fnDestroy();
          $('#lista_produccionKilos').DataTable( {
            'language': {"url": "../plugins/DataTables/Spanish.json"},
            "paging":   false,
            "dom": 'Bfrtip',
            buttons: [
              {
                extend: 'pageLength',
                text: 'Registros',
                className: 'btn btn-default'
              },
              {
                extend: 'excel',
                text: 'Exportar a Excel',
                className: 'btn btn-default',
                title: 'Control Equipos',
                exportOptions: 
                  {
                    format:{
                      body:function(inner, rowidx, colidx, node){
                      if ($(node).children("div").children("input").length > 0) {
                        return $(node).children("div").children("input").val()                         
                      }else{
                        return inner 
                      }
                    }
                  }
                    }
              },
              {
                extend: 'pdf',
                text: 'Exportar a PDF',
                className: 'btn btn-default',
                title: 'Control Equipos',
                exportOptions: 
                {
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
                "url": "tabla_produccionK.php?UMKilos="+UMKilos+"",
                "dataSrc": "",
                "data":{UMKilos:UMKilos},
            },
            "columns": [
                { "data": "ID" },
                { "data": "turno" },
                { "data": "subreceta" },
                { "data": "harina" },
                { "data": "total_masa" },
                { "data": "merma_masa" },
                { "data": "masa_usable" },
                { "data": "produccion_tortilla" },
                { "data": "merma_tortilla" },
                { "data": "produccion_teorica" },
                { "data": "produccion_real" },
                { "data": "diferencia" }
            ]
          });
        }
        $.validator.setDefaults( {
          submitHandler: function () {
            var parametros = new FormData($("#form_datos")[0]);
            $.ajax({
              data: parametros, //datos que se envian a traves de ajax
              url: 'insertar_produccion.php', //archivo que recibe la peticion
              type: 'POST', //método de envio
              dateType: 'html',
              contentType: false,
              processData: false,
              success: function(respuesta)
              {
                if (respuesta=="ok_nuevo") {
                  alertify.success("Registro guardado correctamente");
                  cargar_tabla();
                  $(":text").val(''); //Limpiar los campos tipo Text
                } else if(respuesta == "ok_actualizado"){
                    alertify.success("Se ha actualizado el registro correctamente");
                    cargar_tabla();
                    $(":text").val('');
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
        $( document ).ready( function () {
          $( "#form_datos" ).validate( {
            rules: {
              nombre:    "required",
              gravedad:  "required",
              categoria: "required",
              accion:    "required",
              formato:   "required",
            },
            messages: {
              nombre:    "Campo requerido",
              gravedad:  "Campo requerido",
              categoria: "Campo requerido",
              accion:    "Campo requerido",
              formato:   "Campo requerido",
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
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
      </script>
      <script>
        $(function () {
          $('.select').select2({
            placeholder: 'Seleccione una opción',
            lenguage: 'es'
          })
        }) 
        function editar(id){
          var url = 'consulta_datos_editarConv.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {id: id},
            success: function(respuesta) {
              var array = eval(respuesta);
              $("#id_registro").val(array[0]);
              $("#medida").val(array[2]);
              $("#masa").val(array[3]);
              $("#tortillas").val(array[4]);
              $("#conversion").select2("trigger", "select", {
                data: {
                id: array[1],
                 text: array[1]
               }
               });
            },
          });
        }
        // acciones
        function estatus(registro){
          var id_registro = registro;
          var url = 'cambiar_estatusAcciones.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {id_registro: id_registro},
            success: function(respuesta) {
              if (respuesta=="ok") {
                alertify.success("Registro modificado correctamente");
                cargar_tablaAcciones();
              }
            },
            error: function(xhr, status) {
                alert("error");
            },
          });
        }
        $('#lista_produccion').on('change', 'input', function() {
			var val = $(this).val();

			var data = $('#lista_produccion').DataTable().row($(this).parents('tr')).data();
      var harina_utilizada = $('#lista_produccion').DataTable().cell($(this).parents('tr'), 3).nodes().to$().find('input').val();
			var merma_masa = $('#lista_produccion').DataTable().cell($(this).parents('tr'), 5).nodes().to$().find('input').val();
      var merma_tortilla = $('#lista_produccion').DataTable().cell($(this).parents('tr'), 8).nodes().to$().find('input').val();
      var produccion_teorica = $('#lista_produccion').DataTable().cell($(this).parents('tr'), 9).nodes().to$().find('input').val();

			if (val == "") {
				alertify.error("Existen campos vacíos");
			} else {
				var url = "insertar_produccion.php";
				$.ajax({
					url: url,
					type: "POST",
					dataType: "html",
					data: {
						articulo: data["subreceta"],
						id: data["ID"],
            HarinaUtilizada: harina_utilizada,
            MermaMasa: merma_masa,
            MermaTortilla: merma_tortilla,
            ProdTeorica: produccion_teorica
						// piezas: n_igual_cero
					},
					success: function(respuesta) {
						if (respuesta == "ok") {
							alertify.success("Proyección añadida correctamente");
						} else if (respuesta == "ok_modifica") {
							alertify.success("Proyeccion añadida correctamente");
						} else {
							alertify.error("Se produjo un error");
						}
						//cargar_tabla();
						$('#lista_produccion').DataTable().ajax.reload();
					},
					error: function(xhr, status) {
						alert("Error");
					}
				})
			}
		});
      </script>
    </body>
  </html>