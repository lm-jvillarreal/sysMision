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
        <div class="box box-danger" <?php echo $solo_lectura; ?>>
          <div class="box-header">
            <h3 class="box-title">Registro de Productos</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <input type="text" name="id_registro" id="id_registro" class="hidden">
                  <label for="clave_sat">*Clave SAT</label>
                  <input id="clave_sat" name="clave_sat" class="form-control" placeholder="Clave SAT">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="proveedor">*Proveedor</label>
                  <select id="proveedor" name="proveedor" class="form-control"></select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="comprador">*Comprador</label>
                  <select id="comprador" name="comprador" class="form-control"></select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                	<label for="costo">*Costo</label>
                	<div class="input-group">
	                  <div class="input-group-addon">$</div>
	                  <input type="text" name="costo" class="form-control" id="costo" placeholder="Costo" onchange="calcular()">
	                </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="ap_materno">*Impuestos</label>
                  <select name="impuesto[]" id="impuesto" class="select form-control" multiple>
                  	<option value="1">IVA</option>
                  	<option value="2">IEPS</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="ap_materno">*Descuento 1</label>
                  <div class="input-group">
                    <input type="text" name="descuento1" class="form-control" id="descuento1" placeholder="Descuento 1" onchange="calcular()">
                    <div class="input-group-addon">%</div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="ap_materno">*Descuento 2</label>
                  <div class="input-group">
                    <input type="text" name="descuento2" class="form-control" id="descuento2" placeholder="Descuento 2" onchange="calcular()">
                    <div class="input-group-addon">%</div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="ap_materno">*Costo Final</label>
                  <div class="input-group">
                    <div class="input-group-addon">$</div>
                    <input type="text" name="costo_final" class="form-control" id="costo_final" placeholder="Costo Final" readonly>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row" style="display: none" id="imagenes">
            	<div class="col-md-12">
                <div class="col-md-1"></div>
            		<div class="col-md-5">
		              <div class="form-group">
		               	<label for="IP">*Imagen Presentacion</label>
		               	<input type="file" name="IP" id="IP">
                    <br>
                    <img src="" id="imagen_presentacion" width="200px" class="img-rounded zoom">
				          </div>
		            </div>
		            <div class="col-md-5">
		              <div class="form-group">
		               	<label for="IC">*Imagen Codigo</label>
		               	<input type="file" name="IC" id="IC">
                    <br>
                    <img src="" id="imagen_codigo" width="200px" class="img-rounded zoom">
				          </div>
		            </div>
                <div class="col-md-1"></div>
            	</div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
          </div>
          </form>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Altas</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_altas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th width="5%">Clave SAT</th>
                        <th>Proveedor</th>
                        <th width="10%">Usuario Alta</th>
                        <th width="10%">Sucursal</th>
                        <th width="5%">Costo</th>
                        <th width="5%">Fecha</th>
                        <th width="5%">Editar</th>
                        <th width="5%">Eliminar</th>
                        <th width="5%">Enviar</th>
                      </tr>
                    </thead>
                    <tfoot>
	                  <tr>
	                   	<th width="5%">#</th>
                      <th width="5%">Clave SAT</th>
	                    <th>Proveedor</th>
                      <th width="10%">Usuario Alta</th>
                      <th width="10%">Sucursal</th>
	                    <th width="5%">Costo</th>
	                    <th width="5%">Fecha</th>
	                    <th width="5%">Edita</th>
	                    <th width="5%">Eliminar</th>
                      <th width="5%">Enviar</th>
	                  </tr>
                  	</tfoot>  
                  </table>
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
  $(function () {
    $('.select').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  })
</script>
<script>
  function calcular(){
    var costo      = $('#costo').val();
    var descuento1 = $('#descuento1').val();
    var descuento2 = $('#descuento2').val();
    var porcentaje  = 0;

    if(descuento1 != "" && descuento2 == ""){
      var porcentaje = Math.floor(costo * descuento1)/100;
    }else if(descuento1 == "" && descuento2 !=""){
      var porcentaje = Math.floor(costo * descuento2)/100;
    }else if (descuento1 != "" && descuento2 != ""){
      var porcentaje_total = parseInt(descuento1) + parseInt(descuento2);
      var porcentaje = Math.floor(costo * porcentaje_total)/100;
    }

    if(descuento1 == "" && descuento2 == ""){
      $('#costo_final').val(costo);
    }else{
      var resultado = costo - porcentaje;
      $('#costo_final').val(resultado);
    }
  }
  function estilo_tablas () {
   	$('#lista_altas').dataTable().fnDestroy();
    $('#lista_altas').DataTable( {'language': {"url": "../plugins/DataTables/Spanish.json"},
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
            "url": "tabla_altas.php",
            "dataSrc": "",
            "data":""
        },
        "columns": [
            { "data": "#" },
            { "data": "Clave SAT" },
            { "data": "Proveedor" },
            { "data": "Usuario Alta" },
            { "data": "Sucursal" },
            { "data": "Costo" },
            { "data": "Fecha" },
            { "data": "Editar" },
            { "data": "Eliminar" },
            { "data": "Liberar" }
        ]
    });
   }  
  $(function (){
   estilo_tablas();
  })
    $.validator.setDefaults( {
      submitHandler: function () {
        var f = $(this);
        var formData = new FormData(document.getElementById("form_datos"));
        formData.append("dato", "valor");
        //formData.append(f.attr("name"), $(this)[0].files[0]);
       	$.ajax({
          type: "POST",
          url: 'insertar_alta.php',
          dataType: "html",
          data: formData,
          cache: false,
          contentType: false,
  	     	processData: false
  		  })
        .done(function(res){
          if (res == "ok"){
            alertify.success("Registros Guardados Correctamente");
            $('#form_datos')[0].reset();
            estilo_tablas();
            $("#proveedor").select2("trigger", "select", {
              data: { id: '', text:'' }
            });
            $("#comprador").select2("trigger", "select", {
              data: { id: '', text:'' }
            });
            $('#imagenes').hide();
            $("#imagen_presentacion").attr("src",'');
            $("#imagen_codigo").attr("src",'');
            $('#impuesto').val('').change();
          }
          else if(res == "duplicado"){
            alertify.error("Ya Existe un Registro");
          }
          else{
            alertify.error("Ha Ocurrido un Error");
          }
        });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
    $( document ).ready( function () {
      $( "#form_datos" ).validate( {
        rules: {
          proveedor: "required",
          clave_sat: "required",
          comprador: "required",
          costo: "required"
        },
        messages: {
          proveedor: "Campo requerido",
          clave_sat: "Campo requerido",
          comprador: "Campo requerido",
          costo: "Campo requerido"
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
          $( element ).parents( ".col-md-4" ).addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
          $( element ).parents( ".col-md-4" ).addClass( "has-success" ).removeClass( "has-error" );
        }
      });
    });
  </script>
  <script>
  	$(function () {
	    $('#proveedor').select2({
	      placeholder: 'Seleccione una opcion',
	      lenguage: 'es',
	      //minimumResultsForSearch: Infinity
	      ajax: { 
	     url: "consulta_proveedores.php",
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
	 });
    $(function () {
      $('#comprador').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
       url: "consulta_compradores.php",
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
   });
  </script>
  <script type="text/javascript">
    function liberar(id_registro){
      $.ajax({
        url: 'procesar_registro.php',
        data: '&id_registro='+ id_registro,
        type: "POST",
        success: function(respuesta) {
         estilo_tablas();
         llenar_notificaciones();
        }
      });
    }
  function editar_registro(id_registro){
    $.ajax({
        url: 'editar_registro.php',
        data: '&id_registro='+ id_registro,
        type: "POST",
        success: function(respuesta) {
          var array    = eval(respuesta);
          id_comprador     = array[0];
          nombre_comprador = array[1];
          id_proveedor     = array[2];
          costo            = array[3];
          iva              = array[4];
          ieps             = array[5];
          imagen_p         = array[6];
          imagen_c         = array[7];
          nombre_proveedor = array[8];

          $('#id_registro').val(id_registro);

          if (iva == 1 && ieps == 2){
            $('select option').prop('selected',true);
          }
          else{
            if (iva == 1){
              $('#impuesto').val(iva).trigger('change.select2');
            }
            else{
              $('#impuesto').val(ieps).trigger('change.select2');
            }
          }

          $("#proveedor").select2("trigger", "select", {
            data: { id: id_proveedor, text:nombre_proveedor }
          });
          $("#comprador").select2("trigger", "select", {
            data: { id: id_comprador, text:nombre_comprador }
          });

          $('#costo').val(costo);
          $('#imagenes').show();

          if (imagen_p == null){
            $( "#imagen_presentacion" ).removeClass( "zoom" );
          }
          if (imagen_c == null){
            $( "#imagen_codigo" ).removeClass( "zoom" );
          }

          $("#imagen_presentacion").attr("src",imagen_p);
          $("#imagen_codigo").attr("src",imagen_c);

          $('#clave_sat').val(array[9]);
          $('#descuento1').val(array[10]);
          $('#descuento2').val(array[11]);
          $('#costo_final').val(array[12]);
        }
      });
  }
  function eliminar(id){
      swal({
        title: "¿Está seguro de eliminar registro?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: 'eliminar_registro.php',
            data: '&id='+id ,
            type: "POST",
            success: function(respuesta) {
              if(respuesta == "ok"){
                alertify.success('Registro Eliminado');
                estilo_tablas();
              }
              else{
                alertify.error('Ha Ocurrido un Error');
              }
             }
          });
        } else {
          swal("No se ha eliminado el registro.",{
            icon: "error",
          });
        }
      });
    }
    $(":file").filestyle('buttonText', 'Seleccionar');
    $(":file").filestyle('size', 'sm');
    $(":file").filestyle('input', true);
    $(":file").filestyle('disabled', false);
  </script>
  <script>
  $(document).ready(function(){
    $('.zoom').hover(function() {
      $(this).addClass('transition');
    }, function() {
      $(this).removeClass('transition');
    });
  });
</script>
</body>
</html>
